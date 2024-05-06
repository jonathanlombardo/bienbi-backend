<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AppartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appartment_plans = Plan::all();
        $appartments = Appartment::select(['id', 'title', 'image', 'user_id', 'slug', ])->with('user:id,name,last_name')->whereBelongsTo(Auth::user())->get();
        return view('admin.appartments.index', compact('appartments', 'appartment_plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appartment  $appartment
     * @return \Illuminate\Http\Response
     */
    public function show(Appartment $appartment)
    {
        return view('admin.appartments.show', compact('appartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appartment  $appartment
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appartment $appartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appartment  $appartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appartment $appartment)
    {
        //
    }
}
