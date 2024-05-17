@extends('layouts.main')
@section('title', 'I tuoi Appartamenti')


@section('maincontent')
  <div class="container">
    <div class="wrapper d-flex justify-content-between align-items-center">
      <h1 class="">I Tuoi Appartamenti</h1>
      <a href="{{ route('admin.appartments.create') }}" class="my_btn">Crea Appartamento</a>
    </div>
    <div class="row g-3">
      @forelse($appartments as $appartment)
        <div class="col-4 mb-5 my-col">
          {{-- link per la show degli appartamenti --}}

          <div class="my-card h-100  w-100">
            <a href="{{ route('admin.appartments.show', $appartment->slug) }}" class="my-card-link d-block h-100 w-100">
              <div class="my-card-header p-3 w-100">
                <div class="image-container w-100">
                  <img class="image w-100" src="{{ $appartment->imgUrl }}" alt="">
                  @if (!empty($appartment->isSponsored))
                    <div class="label">Sponsorizzato fino al {{ $appartment->expireSponsor }}</div>
                  @endif
                </div>
              </div>
              <div class="my-card-body p-3">
                <div class="title">{{ $appartment->title }}</div>
                <div class="address mt-1">{{ $appartment->address }}</div>
                <div class="published pt-3"><strong>Visibile: </strong><i @class([
                    $appartment->published ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash',
                    'ps-1',
                ])></i></div>
              </div>
            </a>

            {{-- link per vedere i messaggi relazionati all'appartamento --}}

            <div class="card-footer py-3">
              <div class="messages">
                <a class="my_btn" href="{{ route('admin.messages.appartment.index', ['appartment_slug' => $appartment->slug]) }}">Vedi messaggi</a>
              </div>
            </div>

            {{-- plan label --}}


          </div>
        </div>
      @empty
        <p class="text-center">Non ci sono appartamenti</p>
      @endforelse
    </div>
  </div>
@endsection

@push('assets')
  <style lang="scss">
    .my-col {
      padding: 20px;
      border-radius: 10px;

    }

    .my-card-link {
      color: black;
      text-decoration: none;
    }

    .my-card {
      transition: transform 0.5s;
      cursor: pointer;
      position: relative;

      .title {
        font-size: 1rem;
        font-weight: 500;
      }

      .image-container {
        position: relative;
      }

      .label {
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
    }

    .address {
      font-size: 0.8rem;
      opacity: 0.5;
    }

    .my-card:hover {
      transform: scale(1.1);
    }

    .image-container {
      border-radius: 10px;
      overflow: hidden;
    }

    .image {
      object-fit: cover;
      aspect-ratio: 16/9;
      object-position: center;
    }

    .my_btn {
      width: 200px;
    }
  </style>
@endpush
