<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use App\Models\Plan;
use Braintree\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   */
  public function index()
  {

    $plans = Plan::all();

    return view('admin.plans.index', compact('plans'));
  }

  /**
   * Show the form for creating a new resource.
   *
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
//  * @param  int  $id
//  * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $plan = Plan::find($id);

    return view('admin.plans.show', compact('plan'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Plan  $plan
   */
  public function edit(Plan $plan)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Plan  $plan
   */
  public function update(Request $request, Plan $plan)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Plan  $plan
   */
  public function destroy(Plan $plan)
  {
    //
  }

  public function promotion($appartmentId)
  {
    $appartment = Appartment::find($appartmentId);

    if (!$appartment || $appartment->user_id != Auth::id())
      abort(404);

    $plans = Plan::all();

    $customerId = Auth::id();

    $gateway = new Gateway([
      'environment' => 'sandbox',
      'merchantId' => 'qct7jcqp9gwbbzmx',
      'publicKey' => 'cswn5swkxd5thvf9',
      'privateKey' => 'bbc3393ddc3ce8c92a05a9894febd18f'
    ]);

    $clientToken = $gateway->clientToken()->generate(
      // [
      // "customerId" => $data['userId']
      //  ]
    );

    session()->flash('appartmentId', $appartmentId);
    session()->flash('gateway', $gateway);

    return view('admin.sponsor-form', compact('plans', 'appartment', 'clientToken'));
  }

  public function generateTransaction(Request $request)
  {
    $data = $request->all();

    $paymentNonce = $data['paymentNonce'];
    $deviceDataFromTheClient = $data['deviceDataFromTheClient'];
    $planId = $data['planId'];

    $appartmentId = session('appartmentId');
    $gateway = session('gateway');

    $appartment = Appartment::find($appartmentId);
    $plan = Plan::find($planId);

    if (!$appartment || $appartment->user_id != Auth::id())
      abort(404);

    $nonceFromTheClient = $paymentNonce;

    $result = $gateway->transaction()->sale([
      'amount' => Plan::find($planId)->price,
      'paymentMethodNonce' => $nonceFromTheClient,
      'deviceData' => $deviceDataFromTheClient,
      'options' => [
        'submitForSettlement' => True
      ]
    ]);

    session()->forget(['appartmentId', 'planId', 'clientToken', 'gateway']);

    $appartment->addSponsor($plan);

    return redirect()->route('admin.appartments.show', $appartment->slug)->with('messageClass', 'alert-success')->with('message', 'Appartamento sponsorizzato');
  }
}
