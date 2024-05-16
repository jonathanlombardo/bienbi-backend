<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
  public function dashboard()
  {
    $appartments = Appartment::whereBelongsTo(Auth::user())->get();

    $appartments_views = [];
    $appartments_messages = [];

    foreach ($appartments as $appartment) {
      $views = json_decode($appartment->jsonViews());
      $title = $appartment->title;
      $id = $appartment->id;
      $appartments_views[] = [
        'views' => $views,
        'title' => $title,
        'id' => $id
      ];
    }
    $appartments_views = json_encode($appartments_views);

    foreach ($appartments as $appartment) {
      $messages = json_decode($appartment->jsonMessages());
      $title = $appartment->title;
      $id = $appartment->id;
      $appartments_messages[] = [
        'messages' => $messages,
        'title' => $title,
        'id' => $id
      ];
    }

    $appartments_messages = json_encode($appartments_messages);


    return view('admin.dashboard', compact('appartments_views', 'appartments_messages'));
  }
}
