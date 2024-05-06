@extends('layouts.main')

@section('maincontent')
  <div class="container appartment-wrapper">
    <h1 class="my-3">{{ $appartment->title }}</h1>
    <div class="row g-5">
      <div class="col-12 col-lg-6">
        <div class="image-container ">
          {{-- <img src="{{ $appartment->imgUrl }}" alt=""> --}}
          <img src="{{ asset($appartment->image) }}" alt="">
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <ul class="h-100 p-0">
          <li>
            <strong>Stanze</strong>
            <span>{{ $appartment->rooms > 1 ? $appartment->rooms : 'Una' }} {{ $appartment->rooms > 1 ? ' stanze' : ' stanza' }}</span>
          </li>
          <li>
            <strong>Letti</strong>
            <span>{{ $appartment->beds > 1 ? $appartment->beds : 'Un' }} {{ $appartment->beds > 1 ? ' letti' : ' letto' }}</span>
          </li>
          <li>
            <strong>Bagni</strong>
            <span>{{ $appartment->bathrooms > 1 ? $appartment->bathrooms : 'Un' }} {{ $appartment->bathrooms > 1 ? ' bagni' : ' bagno' }}</span>
          </li>
          <li>
            <strong>Metri Quadri</strong>
            <span>{{ $appartment->square_meters }} m2</span>
          </li>
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
            <a class="nav-link page-link" href="{{ route('admin.messages.index', ['appartment_slug' => $appartment->slug]) }}">Vedi messaggi</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
@endsection

@push('assets')
  <style lang="scss">
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
  </style>
@endpush
