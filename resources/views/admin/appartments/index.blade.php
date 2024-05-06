@extends('layouts.main')

@section('maincontent')
  <div class="container">
    <h1 class="my-3">I Tuoi Appartamenti</h1>
    <div class="row g-3">
      @forelse($appartments as $appartment)
        {{-- link per la show degli appartamenti --}}
        <div class="col-4 mb-5 my-col">
          <a href="{{ route('admin.appartments.show', $appartment) }}" class="my-card-link">
            <div class="my-card">
              <div class="my-card-header p-3">
                <div class="image-container ">
                  {{-- <img src="{{ $appartment->imgUrl }}" alt=""> --}}
                  <img src="{{ asset($appartment->image) }}" alt="">
                </div>
              </div>
              <div class="my-card-body p-3">
                <div class="title mt-3">
                  <span class="title">{{ $appartment->title }}</span>
                </div>
                <div class="messages">
                  <a class="nav-link page-link" href="{{ route('admin.messages.index', ['appartment_slug' => $appartment->slug]) }}">Vedi messaggi</a>
                </div>
              </div>
            </div>
          </a>
        </div>
      @empty
      @endforelse
    </div>
  </div>
@endsection

<style lang="scss" scoped>
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

    .title {
      font-size: 1rem,
        font-weight: 500,
    }
  }

  .my-card:hover {
    transform: scale(1.1);

  }

  .image-container {
    border-radius: 10px;
    overflow: hidden;
  }
</style>
