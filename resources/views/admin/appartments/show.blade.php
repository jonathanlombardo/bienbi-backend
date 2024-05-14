@extends('layouts.main')
@section('title')
  {{ $appartment->title }}
@endsection


@section('maincontent')
  <div class="container appartment-wrapper">
    <h1 class="mb-4">{{ $appartment->title }}</h1>
    {{-- <h1>{{ $appartment->expireSponsor }}</h1> --}}
    @include('layouts.partials.alert_message')
    <div class="row g-5">
      <div class="col-12 col-lg-6">
        <div class="image-container ">
          <img class="image-preview" src="{{ $appartment->imgUrl }}" alt="">
          @if ($appartment->expireSponsor)
            <div class="sponsor-label">Sponsorizzato fino al {{ $appartment->expireSponsor }}</div>
          @endif
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <ul class="h-100 p-0">
          <li class="row justify-content-center g-2">
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
              <div class="my-card">
                <img class='img-services d-inline-block me-2' src="{{ asset('/storage/stanze.png') }}">
                <strong>Stanze</strong>
                <span>{{ $appartment->rooms > 1 ? $appartment->rooms : 'Una' }} {{ $appartment->rooms > 1 ? ' stanze' : ' stanza' }}</span>
              </div>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
              <div class="my-card">
                <img class='img-services d-inline-block me-2' src="{{ asset('/storage/letti.png') }}">
                <strong>Letti</strong>
                <span>{{ $appartment->beds > 1 ? $appartment->beds : 'Un' }} {{ $appartment->beds > 1 ? ' letti' : ' letto' }}</span>
              </div>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
              <div class="my-card">
                <img class='img-services d-inline-block me-2' src="{{ asset('/storage/bagni.png') }}">
                <strong>Bagni</strong>
                <span>{{ $appartment->bathrooms > 1 ? $appartment->bathrooms : 'Un' }} {{ $appartment->bathrooms > 1 ? ' bagni' : ' bagno' }}</span>
              </div>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
              <div class="my-card">
                <img class='img-services d-inline-block me-2' src="{{ asset('/storage/mq.png') }}">
                <strong>Metri Quadri</strong>
                <span>{{ $appartment->square_meters }} m2</span>
              </div>
            </div>
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
            <a class="my_btn" href="{{ route('admin.appartments.index') }}">Torna agli appartamenti</a>
            <a class="my_btn" href="{{ route('admin.appartments.edit', $appartment->slug) }}">Modifica Appartamento</a>
            <a class="my_btn" href="{{ route('admin.messages.appartment.index', ['appartment_slug' => $appartment->slug]) }}">Vedi messaggi</a>
            <a class="my_btn" href="{{ route('admin.plans.promotion', $appartment->slug) }}">Sponsorizza questo appartamento</a>
            <button type="button" class="my_btn" data-bs-toggle="modal" data-bs-target="#destroy-modal">
              Elimina appartamento
            </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
@endsection

@push('assets')
  <style lang="scss">
    .image-container {
      position: relative;
    }

    .sponsor-label {
      padding: 4px 0;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      text-align: center;
      background-color: rgba(244, 84, 56, 0.605);
      color: white;
      font-weight: bold;
    }

    .my-card {
      border: 1px solid #c85f5f;
      /* width: 150px; */
      margin-left: auto;
      margin-right: auto;
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
      transition-duration: 0.5s;
      font-weight: bold;
      text-decoration: none;
      color: inherit;
      display: block;
      width: 100%;
      text-align: center;
      margin-bottom: 5px;
    }

    .my_btn:hover {
      background-color: #f34e39;
      transform: scale(1.1);
      box-shadow: 2px 3px 12px #f34e39;
    }

    .image-preview{
      width: 100%;
      aspect-ratio: 16/9;
      object-fit: cover;
      object-position: center;
    }
  </style>
@endpush

@push('scripts')
  <div class="modal fade" id="destroy-modal" tabindex="-1" aria-labelledby="destroy-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Elimina appartamento</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Sei sicuro di voler eliminare definitivamente l'appartamento {{ $appartment->title }}?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
          <form action="{{ route('admin.appartments.destroy', $appartment) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Elimina</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endpush
