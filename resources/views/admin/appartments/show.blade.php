@extends('layouts.main')

@section('maincontent')
  <div class="container appartment-wrapper">
    <h1 class="my-3">{{ $appartment->title }}</h1>
    <div class="row g-5">
      <div class="col-12 col-lg-6">
        <div class="image-container ">
          <img src="{{ $appartment->imgUrl }}" alt="">
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <ul class="h-100 p-0">
          <div class="d-flex gap-2">
            <li class="my-card">
              <img class='img-services d-inline-block me-2' src="{{ asset('/storage/stanze.png') }}">
              <strong>Stanze</strong>
              <span>{{ $appartment->rooms > 1 ? $appartment->rooms : 'Una' }} {{ $appartment->rooms > 1 ? ' stanze' : ' stanza' }}</span>
            </li>
            <li class="my-card">
              <img class='img-services d-inline-block me-2' src="{{ asset('/storage/letti.png') }}">
              <strong>Letti</strong>
              <span>{{ $appartment->beds > 1 ? $appartment->beds : 'Un' }} {{ $appartment->beds > 1 ? ' letti' : ' letto' }}</span>
            </li>
            <li class="my-card">
              <img class='img-services d-inline-block me-2' src="{{ asset('/storage/bagni.png') }}">
              <strong>Bagni</strong>
              <span>{{ $appartment->bathrooms > 1 ? $appartment->bathrooms : 'Un' }} {{ $appartment->bathrooms > 1 ? ' bagni' : ' bagno' }}</span>
            </li>
            <li class="my-card">
              <img class='img-services d-inline-block me-2' src="{{ asset('/storage/mq.png') }}">
              <strong>Metri Quadri</strong>
              <span>{{ $appartment->square_meters }} m2</span>
            </li>
          </div>
          <li>
            <strong>Indirizzo</strong>
            <span>{{ $appartment->address }}</span>
          </li>
          <li>
            <strong>{{ $appartment->published ? 'Gli utenti possono vedere questo appartamento' : 'Gli utenti non possono vedere questo appartamento' }}</strong>
          </li>
          <li class="row appartment-services">
            <strong>Servizi offerti</strong>
            @foreach ($appartment->services as $service)
              <div class="col-6 d-flex align-items-center">
                <i class="{{ $service->faIconClass }}"></i>
                <div>{{ $service->label }}</div>
              </div>
            @endforeach
          </li>
          <li class="mt-auto">
            <button class="my_btn">
              <a class="nav-link" href="{{ route('admin.messages.appartment.index', ['appartment_slug' => $appartment->slug]) }}">Vedi messaggi</a>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
@endsection

@push('assets')
  <style lang="scss">
    .my-card {
      border: 1px solid #c85f5f;
      width: 150px;
      padding: 0.5rem;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .col-line {
      border-bottom: 1px solid gray;
      height: 400px;
    }

    .img-services {
      width: 35px;
      aspect-ratio: 1;
    }

    .appartment-wrapper {
      ul {
        display: flex;
        flex-direction: column;
        gap: 10px;
      }

      .image-container {
        border-radius: 10px;
        overflow: hidden;
      }

      .appartment-services {
        i {
          width: 30px;
        }
      }
    }

    .my_btn {
      font-size: 0.9rem;
      background-color: #ffb30e;
      padding: 6px 10px;
      border: none;
      border-radius: 10px;
      transition: transform 0.5s;
    }

    .my_btn:hover {
      background-color: #f34e39;
      transform: scale(1.1);
      box-shadow: 2px 3px 12px #f34e39;
    }
  </style>
@endpush
