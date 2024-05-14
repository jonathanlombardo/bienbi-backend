@extends('layouts.main')

@section('title')
Cronologia sponsorizzazioni per {{$appartment->title}}
@endsection

@section('maincontent')
<div class="container">
  <h1 class="mb-3">Cronologia sponsorizzazioni per {{$appartment->title}}</h1>


  <div class="row g-3 my-4 flex-column">
    @foreach($appartment->plans as $plan)
    <div class="col-12">
      <div class="my-card">
        <span>Sponsorizzazione: <strong>{{$plan->name}}</strong> </span><br>
        <span>Prezzo: <strong>{{$plan->price}}</strong> </span><br>
        <span>Appartamento: <strong>{{$appartment->title}}</strong> </span><br>
        <span>Proprietario: <strong>{{$appartment->user->name}} {{$appartment->user->last_name}}</strong> </span><br>
        <span>Iniziato il: <strong>{{$plan->pivot->date_of_issue}}</strong> </span><br>
        <span>Scadenza il: <strong>{{$plan->pivot->expired_at}}</strong> </span><br>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection


@push('assets')
<style>
  .title {
    color: #e8620c;
    font-size: 3rem;
    font-weight: bold;
  }

  .my-card {
    padding: 10px 20px;
    border: 0.1px solid rgb(255, 255, 255);
    position: relative;
    background: #f3c665;
    cursor: pointer;
  }

  .my-card:hover {
    filter: brightness(1.05);
  }
</style>
@endpush