@extends('layouts.main')

@section('title')
  Sponsorizzazioni
@endsection

@section('maincontent')
  <div class="container">
    @if (!$sortedPlans->count())
      <h1 class="mb-3 text-center">Nessuna sponsorizzazione{{ $appartment ? " per $appartment->title" : '' }}</h1>
    @else
      <h1 class="mb-3 text-center">Cronologia sponsorizzazioni per {{ $appartment ? $appartment->title : 'i tuoi appartamenti' }}</h1>


      <div class="row flex-column g-3 my-4">
        @foreach ($sortedPlans as $plan)
          <div class="col">
            <div class="card text-center">
              <div class="card-header card-{{ $plan->name }} d-flex justify-content-between">
                <div>
                  Sponsorizzazione: <strong>{{ $plan->name }}</strong>
                  <span class="ms-2">
                    <i class="fa-solid fa-star fs-5"></i>
                    @if ($plan->name == 'Medium' || $plan->name == 'Premium')
                      <i class="fa-solid fa-star fs-5"></i>
                      @if ($plan->name == 'Premium')
                        <i class="fa-solid fa-star fs-5"></i>
                      @endif
                    @endif
                  </span>
                </div>
                <span>Appartamento: <strong>{{ $plan->appartment }}</strong> </span>
              </div>
              <div class="card-body d-flex flex-column gap-3 card-{{ $plan->name }}-body">
                <span>Creato il: <strong>{{ $plan->createdDate }} alle ore {{ $plan->createdHour }}</strong> </span>
                <div>
                  <div class="mb-1">Periodo della sponsorizzazione:</div>
                  <span>Dal <strong>{{ $plan->issueDate }} alle {{ $plan->issueHour }}</strong> al <strong>{{ $plan->expDate }} alle {{ $plan->expHour }}</strong></span>
                </div>
              </div>
              <span class="card-footer card-{{ $plan->name }}">Prezzo: <strong>€ {{ $plan->price }}</strong> </span>
            </div>
          </div>
        @endforeach
      </div>
    @endif
    <div class="text-center">
      @if ($appartment)
        <a href="{{ route('admin.appartments.show', $appartment->slug) }}" class="my_btn">Torna ai dettagli</a>
        <a href="{{ route('admin.plans.promotion', $appartment->slug) }}" class="my_btn">Sponsorizza appartamento</a>
      @else
        <a href="{{ route('admin.appartments.index') }}" class="my_btn">Torna agli appartamenti</a>
      @endif
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

    .card-Base {
      background-color: #f3ddab !important;
    }

    .card-Base-body {
      background-color: #f2e8d1 !important;
    }

    .card-Medium {
      background-color: #ffb30e !important;
    }

    .card-Medium-body {
      background-color: #f6d99a !important;
    }

    .card-Premium {
      background-color: #f34e39 !important;
    }

    .card-Premium-body {
      background-color: #f7a398 !important;
    }
  </style>
@endpush
