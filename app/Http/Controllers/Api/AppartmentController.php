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
    //
  }
}
