<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appartment;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    $appartments = $appartments->where('published', true)->with('user:id,name,last_name')->paginate()->setHidden(['plans', 'published', 'image', 'user_id']);

    // ritorno il json
    return response()->json($appartments);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  public function filtered(Request $request)
  {

    // requpero dati della request (lat long raggio)
    $data_req = $request->all();

    // recupero tutti gli appartamenti
    $appartments = Appartment::select('id', 'lat', 'long')->get();

    // definisco i parametri per la richiesta api a tomtom per filtrare gli appartamenti
    $params = [
      'key' => 'GkJjTzfTAB01jy6W7VUViPfOdDf7dx9I',
    ];

    $geometry_list = [[
      "type" => "CIRCLE",
      "position" => "45, 9",
      "radius" => 10000
    ]];

    $geometry_list_json_string = json_encode($geometry_list);

    $appartments_list = [[]];
    foreach ($appartments as $appartment) {
      $appartments_list[0][] = [
        'poi' => ['id' => $appartment->id],
        'position' => [
          'lat' => $appartment->lat,
          'long' => $appartment->long,
        ]
      ];
    }
    $appartments_list_json_string = json_encode($appartments_list);

    // creo url concatenando i parametri
    $url = 'https://api.tomtom.com/search/2/geometryFilter.json?key=' . $params['key'] . '&geometryList=' . $geometry_list_json_string . '&poiList=' . $appartments_list_json_string;

    $client = new \GuzzleHttp\Client();
    $request = new \GuzzleHttp\Psr7\Request('GET', $url);
    $promise = $client->sendAsync($request)->then(function ($response) {
      return response()->json($response->getBody());
    });
    $promise->wait();
  }
}
