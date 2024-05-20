<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appartment;
use App\Models\User;
use App\Models\View;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function datasets(Request $request)
  {
    $data = $request->all();
    $dtStart = Carbon::createFromFormat('Y-m-d H:i:s', $data['dtStart']);
    $dtEnd = Carbon::createFromFormat('Y-m-d H:i:s', $data['dtEnd']);
    $period = $data['period'];

    $datasets = [];

    $period = CarbonPeriod::create($dtStart, "1 $period", $dtEnd);

    return response()->json([$period]);

    $appartments = Appartment::whereBelongsTo(Auth::user())->get();
    $appartmentsIds = $appartments->pluck('id')->toArray();
    $views = View::whereIn('appartment_id', $appartmentsIds)->get();
    $messages = View::whereIn('appartment_id', $appartmentsIds)->get();

    return response()->json([$appartments, $views, $messages]);
  }
}
