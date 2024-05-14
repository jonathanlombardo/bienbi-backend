@extends('layouts.main')

@section('title')
Cronologia sponsorizzazioni per {{$appartment->title}}
@endsection

@section('maincontent')
<div class="container">
  <h1>Cronologia sponsorizzazioni per {{$appartment->title}}</h1>
  <div class="row">
    @foreach($appartment->plans as $plan)
    <div class="col-12">
      <div class="card">

        <span>Appartamento: <strong>{{$appartment->title}}</strong> </span><br>
        <span>Proprietario: <strong>{{$appartment->user->name}} {{$appartment->user->last_name}}</strong> </span><br>
        <span>Sponsorizzazione: <strong>{{$plan->name}}</strong> </span><br>
        <span>Prezzo: <strong>{{$plan->price}}</strong> </span><br>
        <span>Iniziato il: <strong>{{$plan->pivot->date_of_issue}}</strong> </span><br>
        <span>Scadenza il: <strong>{{$plan->pivot->expired_at}}</strong> </span><br>

      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection