<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use App\Models\Service;
use Illuminate\Http\Request;

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
    // $appartment = new Appartment;
    $appartment = Appartment::find(1);
    $services = Service::all();
    $appartmentServices = $appartment->services->pluck('id')->toArray();
    return view('admin.appartments.form', compact('appartment', 'services', 'appartmentServices'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(Request $request)
  {
    dump($request->all());
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Appartment  $appartment
   */
  public function show(Appartment $appartment)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Appartment  $appartment
   */
  public function edit(Appartment $appartment)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Appartment  $appartment
   */
  public function update(Request $request, Appartment $appartment)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Appartment  $appartment
   */
  public function destroy(Appartment $appartment)
  {
    //
  }
}
