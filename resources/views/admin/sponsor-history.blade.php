@extends('layouts.main')

@section('title')
Cronologia sponsorizzazioni per {{$appartment->title}}
@endsection

@section('maincontent')
<div class="container">
  <h1 class="mb-3 text-center">Cronologia sponsorizzazioni per {{$appartment->title}}</h1>


  <div class="row g-3 my-4">
    @foreach($appartment->plans as $plan)
    <div class="col-4">
      <div class="card text-center">

        @if ($plan->name == 'Base')
          <span class="card-header card-base">Sponsorizzazione: <strong>{{$plan->name}}</strong> </span>
        @elseif ($plan->name == 'Medium')
          <span class="card-header card-medium">Sponsorizzazione: <strong>{{$plan->name}}</strong> </span>
        @elseif ($plan->name == 'Premium')
          <span class="card-header card-premium">Sponsorizzazione: <strong>{{$plan->name}}</strong> </span>
        @endif

        @if ($plan->name == 'Base')
          <div class="card-body d-flex flex-column gap-3 card-base-body">
            <div>
              <i class="fa-solid fa-star fs-5"></i>
            </div>
            <span>Appartamento: <strong>{{$appartment->title}}</strong> </span>
            <span>Proprietario: <strong>{{$appartment->user->name}} {{$appartment->user->last_name}}</strong> </span>
            <span>Iniziato il: <strong>{{$plan->pivot->date_of_issue}}</strong> </span>
            <span>Scadenza il: <strong>{{$plan->pivot->expired_at}}</strong> </span>
          </div>
        @elseif ($plan->name == 'Medium')
          <div class="card-body d-flex flex-column gap-3 card-medium-body">
            <div>
              <i class="fa-solid fa-star fs-5"></i>
              <i class="fa-solid fa-star fs-5"></i>
            </div>
            <span>Appartamento: <strong>{{$appartment->title}}</strong> </span>
            <span>Proprietario: <strong>{{$appartment->user->name}} {{$appartment->user->last_name}}</strong> </span>
            <span>Iniziato il: <strong>{{$plan->pivot->date_of_issue}}</strong> </span>
            <span>Scadenza il: <strong>{{$plan->pivot->expired_at}}</strong> </span>
          </div>
        @elseif ($plan->name == 'Premium')
          <div class="card-body d-flex flex-column gap-3 card-premium-body">
            <div>
              <i class="fa-solid fa-star fs-5"></i>
              <i class="fa-solid fa-star fs-5"></i>
              <i class="fa-solid fa-star fs-5"></i>
            </div>
            <span>Appartamento: <strong>{{$appartment->title}}</strong> </span>
            <span>Proprietario: <strong>{{$appartment->user->name}} {{$appartment->user->last_name}}</strong> </span>
            <span>Iniziato il: <strong>{{$plan->pivot->date_of_issue}}</strong> </span>
            <span>Scadenza il: <strong>{{$plan->pivot->expired_at}}</strong> </span>
          </div>
        @endif

        @if ($plan->price == '2.99')
        <span class="card-footer card-base">Prezzo: <strong>{{$plan->price}}</strong> </span>
        @elseif ($plan->price == '5.99')
        <span class="card-footer card-medium">Prezzo: <strong>{{$plan->price}}</strong> </span>
        @elseif ($plan->price == '9.99')
        <span class="card-footer card-premium">Prezzo: <strong>{{$plan->price}}</strong> </span>
        @endif

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

  .card-base {
    background-color: #f3ddab !important;
  }

  .card-base-body {
    background-color: #f2e8d1 !important;
  }

  .card-medium {
    background-color: #ffb30e !important;
  }

  .card-medium-body {
    background-color: #f6d99a !important;
  }

  .card-premium {
    background-color: #f34e39 !important;
  }

  .card-premium-body {
    background-color: #f7a398 !important;
  }
</style>
@endpush