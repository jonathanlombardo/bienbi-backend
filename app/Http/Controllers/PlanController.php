<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Appartment;
use App\Models\Plan;
use Braintree\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
  public function promotion($slug)
  {
    $appartment = Appartment::fromSlugToAppartment($slug);

    if (!$appartment || $appartment->user_id != Auth::id())
      abort(404);

    $appartmentId = $appartment->id;

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

  public function generateTransaction(PaymentRequest $request)
  {
    $request->validated();
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
    if (!$plan)
      abort(404);

    $nonceFromTheClient = $paymentNonce;

    $result = $gateway->transaction()->sale([
      'amount' => Plan::find($planId)->price,
      'paymentMethodNonce' => $nonceFromTheClient,
      // 'paymentMethodNonce' => 'fake--nonce',
      'deviceData' => $deviceDataFromTheClient,
      'options' => [
        'submitForSettlement' => True
      ]
    ]);

    session()->forget(['appartmentId', 'planId', 'clientToken', 'gateway']);

    // dd($result);

    $appartment->addSponsor($plan);

    if ($result->success)
      return redirect()->route('admin.appartments.show', $appartment->slug)->with('messageClass', 'alert-success')->with('message', 'Appartamento sponsorizzato');

    return redirect()->back()->with('messageClass', 'alert-danger')->with('message', 'La transazione non è andata a buon fine. Riprova.');
  }
}
