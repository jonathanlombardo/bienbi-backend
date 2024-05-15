<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Appartment;
use App\Models\Plan;
use Braintree\Gateway;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
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

    $clientToken = $gateway->clientToken()->generate();


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
    $appartmentId = $data['appartmentId'];


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

    $appartment->addSponsor($plan);

    if ($result->success)
      return redirect()->route('admin.appartments.show', $appartment->slug)->with('messageClass', 'alert-success')->with('message', 'Appartamento sponsorizzato');

    return redirect()->back()->with('messageClass', 'alert-danger')->with('message', 'La transazione non è andata a buon fine. Riprova.');
  }


  public function sponsorHistory($slug = null)
  {
    $appartments = $slug ? collect([Appartment::fromSlugToAppartment($slug)]) : Appartment::whereHas('plans')->whereBelongsTo(Auth::user())->get();

    if ($slug && (!$appartments[0] || $appartments[0]->user_id != Auth::id()))
      abort(404);

    $sortedPlans = collect([]);

    foreach ($appartments as $appartment) {
      foreach ($appartment->plans as $plan) {
        $sortedPlans->push($plan);
      }
    }

    $appartment = $slug ? $appartments[0] : null;

    $sortedPlans = $sortedPlans->sortByDesc(function ($plan) {
      return $plan->pivot->created_at;
    });

    foreach ($sortedPlans as $plan) {
      $plan->appartment = Appartment::find($plan->pivot->appartment_id)->title;

      $dt = Carbon::createFromFormat('Y-m-d H:i:s', $plan->pivot->expired_at)->tz('Europe/Rome');
      $day = $dt->day < 10 ? "0$dt->day" : $dt->day;
      $month = $dt->month < 10 ? "0$dt->month" : $dt->month;
      $hour = $dt->hour < 10 ? "0$dt->hour" : $dt->hour;
      $plan->expDate = "$day/$month/$dt->year";
      $plan->expHour = "$hour:$dt->minute";

      $dt = Carbon::createFromFormat('Y-m-d H:i:s', $plan->pivot->date_of_issue)->tz('Europe/Rome');
      $day = $dt->day < 10 ? "0$dt->day" : $dt->day;
      $month = $dt->month < 10 ? "0$dt->month" : $dt->month;
      $hour = $dt->hour < 10 ? "0$dt->hour" : $dt->hour;
      $plan->issueDate = "$day/$month/$dt->year";
      $plan->issueHour = "$hour:$dt->minute";


      $dt = Carbon::createFromFormat('Y-m-d H:i:s', $plan->pivot->created_at)->tz('Europe/Rome');
      $day = $dt->day < 10 ? "0$dt->day" : $dt->day;
      $month = $dt->month < 10 ? "0$dt->month" : $dt->month;
      $hour = $dt->hour < 10 ? "0$dt->hour" : $dt->hour;
      $plan->createdDate = "$day/$month/$dt->year";
      $plan->createdHour = "$hour:$dt->minute";
    }

    return view('admin.sponsor-history', compact('appartment', 'sortedPlans'));
  }
}
