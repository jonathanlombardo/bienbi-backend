<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appartment;
use App\Models\View;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class ViewsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function setView(Request $request)
  {
    $interval = 30; // Valid interval in minutes
    $data = $request->all();
    $ip = $data['ip'] ?? false;
    $id = $data['id'] ?? false;

    $appartment = Appartment::find($id);

    if (!$ip || !$appartment)
      return response()->json(false);

    $appartmentLastView = View::whereBelongsTo($appartment)->where('ip_address', '=', $ip)->max('date');
    ;

    if ($appartmentLastView) {
      $dt = Carbon::createFromFormat('Y-m-d H:i:s', $appartmentLastView);
      if ($dt->greaterThan(now()->subMinutes($interval))) {
        return response()->json(false);
      }
    }

    $view = new View;
    $view->ip_address = $ip;
    $view->appartment_id = $id;
    $view->date = now();
    $view->save();

    return response()->json(true);
  }
}
