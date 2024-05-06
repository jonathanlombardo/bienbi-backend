<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppartmentFormRequest;
use App\Models\Appartment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AppartmentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   */
  public function create()
  {
    $appartment = new Appartment;
    $services = Service::all();
    $appartmentServices = $appartment->services->pluck('id')->toArray();
    return view('admin.appartments.form', compact('appartment', 'services', 'appartmentServices'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(AppartmentFormRequest $request)
  {

    $request->validated();

    $datas = $request->all();
    $appartment = new Appartment;
    $appartment->fill($datas);
    $appartment->setSlug();
    $appartment->published = isset($datas['published']);
    $appartment->user_id = Auth::id();

    if (isset($datas['image'])) {
      $img_path = Storage::put('appartments/uploads', $datas['image']);
      $appartment->image = $img_path;
    }

    $appartment->save();

    if (isset($request['services']))
      $appartment->services()->sync($request['services']);

    return redirect()->route('admin.appartments.show', $appartment->slug)->with('messageClass', 'alert-success')->with('message', 'Appartamento creato');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Appartment  $appartment
   */
  public function show($slug)
  {
    dd(Appartment::fromSlugToAppartment($slug));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Appartment  $appartment
   */
  public function edit($slug)
  {
    $appartment = Appartment::fromSlugToAppartment($slug);

    if (!$appartment)
      abort(404);
    if ($appartment->user_id != Auth::id())
      abort(403);

    $services = Service::all();
    $appartmentServices = $appartment->services->pluck('id')->toArray();
    return view('admin.appartments.form', compact('appartment', 'services', 'appartmentServices'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Appartment  $appartment
   */
  public function update(AppartmentFormRequest $request, $slug)
  {
    $request->validated();
    $datas = $request->all();
    $appartment = Appartment::fromSlugToAppartment($slug);

    if (!$appartment)
      abort(404);
    if ($appartment->user_id != Auth::id())
      abort(403);

    $appartment->fill($datas);
    $appartment->setSlug();
    $appartment->published = isset($datas['published']);

    if (isset($datas['image'])) {
      if ($appartment->image)
        Storage::delete($appartment->image);
      $img_path = Storage::put('appartments/uploads', $datas['image']);
      $appartment->image = $img_path;
    }

    $appartment->save();

    if (isset($request['services']))
      $appartment->services()->sync($request['services']);

    return redirect()->route('admin.appartments.show', $appartment->slug)->with('messageClass', 'alert-success')->with('message', 'Appartamento modificato');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Appartment  $appartment
   */
  public function destroy(Appartment $appartment)
  {
    if ($appartment->user_id != Auth::id())
      abort(403);
    if ($appartment->image)
      Storage::delete($appartment->image);
    $appartment->image = null;
    $appartment->save();
    return redirect()->route('admin.appartments.index')->with('messageClass', 'alert-success')->with('message', 'Appartamento eliminato');
  }
}
