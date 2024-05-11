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


    //--

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

    // session()->flash('planId', $planId);
    // session()->flash('clientToken', $clientToken);
    session()->flash('appartmentId', $appartmentId);
    session()->flash('gateway', $gateway);

    //--





    return view('admin.sponsor-form', compact('plans', 'appartment', 'clientToken'));
  }

  // public function generatePaymentToken(Request $request)
  // {
  //   $data = $request->all();
  //   $appartmentId = $data['appartmentId'];
  //   $planId = $data['planId'];

  //   if (!Appartment::find($appartmentId) || Appartment::find($appartmentId)->user_id != Auth::id())
  //     abort(404);

  //   $customerId = Auth::id();

  //   $gateway = new Gateway([
  //     'environment' => 'sandbox',
  //     'merchantId' => 'qct7jcqp9gwbbzmx',
  //     'publicKey' => 'cswn5swkxd5thvf9',
  //     'privateKey' => 'bbc3393ddc3ce8c92a05a9894febd18f'
  //   ]);

  //   $clientToken = $gateway->clientToken()->generate(
  //     // [
  //     // "customerId" => $data['userId']
  //     //  ]
  //   );

  //   session()->flash('appartmentId', $appartmentId);
  //   session()->flash('planId', $planId);
  //   session()->flash('clientToken', $clientToken);
  //   session()->flash('gateway', $gateway);
  //   // session()->put(['appartmentId' => $appartmentId, 'planId' => $planId, 'clientToken' => $clientToken, 'gateway' => $gateway]);

  //   return redirect()->route('admin.plans.payment');
  // }

  // public function payment()
  // {

  //   $appartmentId = session('appartmentId');
  //   $planId = session('planId');
  //   $clientToken = session('clientToken');
  //   $gateway = session('gateway');

  //   if (!$appartmentId || !$planId || !$clientToken || !$gateway)
  //     abort(404);

  //   session()->reflash();

  //   return view('admin.payment', compact('appartmentId', 'planId', 'clientToken', 'gateway'));
  // }

  public function generateTransaction(Request $request)
  {
    $data = $request->all();

    // $appartmentId = $data['appartmentId'];
    // $planId = $data['planId'];
    // $gateway = $data['gateway'];
    // $clientToken = $data['clientToken'];

    $paymentNonce = $data['paymentNonce'];
    $deviceDataFromTheClient = $data['deviceDataFromTheClient'];
    $planId = $data['planId'];

    // $clientToken = session('clientToken');
    $appartmentId = session('appartmentId');
    $gateway = session('gateway');



    if (!Appartment::find($appartmentId) || Appartment::find($appartmentId)->user_id != Auth::id())
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

    dd($result);
  }
}
