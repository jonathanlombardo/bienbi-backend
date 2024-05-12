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
      'environment' => config('gatewayInfo')['environment'],
      'merchantId' => config('gatewayInfo')['merchantId'],
      'publicKey' => config('gatewayInfo')['publicKey'],
      'privateKey' => config('gatewayInfo')['privateKey']
    ]);

    $clientToken = $gateway->clientToken()->generate(
      // [
      // "customerId" => $data['userId']
      //  ]
    );

    session()->flash('appartmentId', $appartmentId);

    return view('admin.sponsor-form', compact('plans', 'appartment', 'clientToken'));
  }

  public function generateTransaction(PaymentRequest $request)
  {
    $request->validated();
    $data = $request->all();

    $gateway = new Gateway([
      'environment' => config('gatewayInfo')['environment'],
      'merchantId' => config('gatewayInfo')['merchantId'],
      'publicKey' => config('gatewayInfo')['publicKey'],
      'privateKey' => config('gatewayInfo')['privateKey']
    ]);

    $paymentNonce = $data['paymentNonce'];
    $deviceDataFromTheClient = $data['deviceDataFromTheClient'];
    $planId = $data['planId'];

    $appartmentId = session('appartmentId');

    $appartment = Appartment::find($appartmentId);
    $plan = Plan::find($planId);

    if (!$appartment || $appartment->user_id != Auth::id())
      abort(404);
    if (!$plan)
      abort(404);

    $nonceFromTheClient = $paymentNonce;

    $result = $gateway->transaction()->sale([
      'amount' => Plan::find($planId)->price,
      // 'amount' => 3000.00, // card 4000111111111115
      'paymentMethodNonce' => $nonceFromTheClient,
      // 'paymentMethodNonce' => 'fake--nonce', // card all
      'deviceData' => $deviceDataFromTheClient,
      'options' => [
        'submitForSettlement' => True
      ]
    ]);

    session()->forget(['appartmentId']);

    // dd($result);

    $appartment->addSponsor($plan);

    if ($result->success)
      return redirect()->route('admin.appartments.show', $appartment->slug)->with('messageClass', 'alert-success')->with('message', 'Appartamento sponsorizzato');

    return redirect()->back()->with('messageClass', 'alert-danger')->with('message', 'La transazione non è andata a buon fine. Riprova.');
  }
}
