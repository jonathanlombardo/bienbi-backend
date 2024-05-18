<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appartment;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function datasets()
  {

    $appartments = Appartment::whereBelongsTo(Auth::user())->get();
    $appartmentsIds = $appartments->pluck('id')->toArray();
    $views = View::whereIn('appartment_id', $appartmentsIds)->get();
    $messages = View::whereIn('appartment_id', $appartmentsIds)->get();

    return response()->json(['appartments', 'views', 'messages']);
  }
}
