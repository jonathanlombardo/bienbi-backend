<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appartment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder;

class AppartmentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    // recupero tutti gli appartamenti
    $appartments = Appartment::all();
    $sponsoredAppartments = [];

    // recupero gli id dei soli sponsorizzati
    foreach ($appartments as $appartment) {
      if ($appartment->isSponsored)
        $sponsoredAppartments[] = $appartment->id;
    }

    // recupero una paginazione degli appartamenti sponsorizzati
    $appartments = Appartment::select();
    foreach ($sponsoredAppartments as $appartmentId) {
      $appartments->orWhere('id', $appartmentId);
    }
    $appartments = $appartments->where('published', true)->with('user:id,name,last_name', 'services:id,label')->paginate()->setHidden(['plans', 'published', 'image', 'user_id']);

    // ritorno il json
    return response()->json($appartments);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(string $slug)
  {
    $appartment = Appartment::where('slug', '=', $slug)
      ->where('published', '=', true)->first();

    if ($appartment)
      $appartment->setHidden(['plans', 'published', 'image', 'user_id']);

    return response()->json($appartment);
  }

  public function filtered(Request $request)
  {
    function distance($lat1, $lon1, $lat2, $lon2)
    {
      if (($lat1 === $lat2) && ($lon1 === $lon2)) {
        return 0;
      } else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return ($miles * 1.609344 * 1000);
      }
    }

    // requpero e valido i dati della request
    $data_req = $request->all();
    $rooms = false;
    $beds = false;
    $bathrooms = false;
    $square_meters = false;
    $services = Service::all();


    if (isset($data_req['rooms']) && is_numeric($data_req['rooms']) && $data_req['rooms'] > 0) {
      $rooms = (int) $data_req['rooms'];
    }
    if (isset($data_req['beds']) && is_numeric($data_req['beds']) && $data_req['beds'] > 0) {
      $beds = (int) $data_req['beds'];
    }
    if (isset($data_req['bathrooms']) && is_numeric($data_req['bathrooms']) && $data_req['bathrooms'] > 0) {
      $bathrooms = (int) $data_req['bathrooms'];
    }
    if (isset($data_req['square_meters']) && is_numeric($data_req['square_meters']) && $data_req['square_meters'] > 0) {
      $square_meters = (int) $data_req['square_meters'];
    }

    // recupero tutti gli appartamenti
    $appartments = Appartment::select('id', 'lat', 'long')->get();

    // definisco i parametri per la richiesta api a tomtom per filtrare gli appartamenti
    $params = [
      'key' => 'GkJjTzfTAB01jy6W7VUViPfOdDf7dx9I',
    ];
    $geometry_list = [
      [
        "type" => "CIRCLE",
        "position" => $data_req['lat'] . "," . $data_req['long'],
        "radius" => $data_req['radius']
      ]
    ];
    $geometry_list_json_string = json_encode($geometry_list);
    $appartments_list = [];
    foreach ($appartments as $appartment) {
      $appartments_list[] = [
        'poi' => ['id' => $appartment->id],
        'position' => [
          'lat' => $appartment->lat,
          'lon' => $appartment->long,
        ]
      ];
    }
    $appartments_list_json_string = json_encode($appartments_list);
    $url = 'https://api.tomtom.com/search/2/geometryFilter.json';


    // invio la richiesta
    $response = Http::get($url, [
      'key' => $params['key'],
      'geometryList' => $geometry_list_json_string,
      'poiList' => $appartments_list_json_string
    ]);

    // --recupero solo gli appartamenti pubblicati che corrispondono ai risultati
    $resIds = array_map(fn($res) => $res->poi->id, $response->object()->results);
    $appartments = Appartment::with('user:id,name,last_name', 'services:id,label')
      ->whereIn('id', $resIds)
      ->where('published', true);
    if ($rooms)
      $appartments->where('rooms', '>=', $rooms);
    if ($beds)
      $appartments->where('beds', '>=', $beds);
    if ($bathrooms)
      $appartments->where('bathrooms', '>=', $bathrooms);
    if ($square_meters)
      $appartments->where('square_meters', '>=', $square_meters);

    foreach ($services as $service) {
      $dataService = $data_req["service$service->id"] ?? null;
      if ($dataService === 'true') {
        $appartments->whereHas('services', function (Builder $query) use ($service) {
          $query->where('services.id', '=', $service->id);
        });
      }
    }

    $appartments = $appartments->paginate()
      ->setHidden(['plans', 'published', 'image', 'user_id']);
    //---------------------------------------------------------------------------

    // aggiungo la distanza
    foreach ($appartments as $appartment) {
      $appartment->distance = round(distance($data_req['lat'], $data_req['long'], $appartment->lat, $appartment->long));
    }

    // ordino per sponsorizzati e distanza
    $appartments = $appartments->toArray();
    usort($appartments, function ($a, $b) {
      if ($a['isSponsored'] && $b['isSponsored']) {
        return $a['distance'] < $b['distance'] ? -1 : 1;
      } elseif ($a['isSponsored'] && !$b['isSponsored']) {
        return -1;
      } elseif (!$a['isSponsored'] && $b['isSponsored']) {
        return 1;
      } elseif (!$a['isSponsored'] && !$b['isSponsored']) {
        return $a['distance'] < $b['distance'] ? -1 : 1;
      }
    });


    // restituisco il json
    return response()->json($appartments);
  }
}
