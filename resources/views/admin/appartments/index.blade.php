@extends('layouts.main')

@section('maincontent')
  <div class="container">
    <h1 class="my-3">I Tuoi Appartamenti</h1>
    <div class="row g-3">
      @forelse($appartments as $appartment)
        <div class="col-4 mb-5 my-col">
        {{-- link per la show degli appartamenti --}}

          <a href="{{ route('admin.appartments.show', $appartment) }}" class="my-card-link d-block h-100">
            <div class="my-card">
              <div class="my-card-header p-3">
                <div class="image-container">
                  <img src="{{ $appartment->imgUrl }}" alt="">
                </div>
              </div>
              <div class="my-card-body p-3">
                <div class="title mt-3">
                  <span class="title">{{ $appartment->title }}</span>
                </div>
              </div>
            </div>
          </a>    
              {{-- link per vedere i messaggi relazionati all'appartamento --}}
              
          <div class="card-footer p-3">
            <div class="messages">
              <button class="my_btn">
                <a class="nav-link" href="{{ route('admin.messages.appartment.index', ['appartment_slug' => $appartment->slug]) }}">Vedi messaggi</a>
              </button>
            </div>
          </div>
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
      font-size: 1rem;
      font-weight: 500;
    }
  }

  .my-card:hover {
    transform: scale(1.1);
  }

  .image-container {
    border-radius: 10px;
    overflow: hidden;
  }

  .my_btn {
    font-size: 0.9rem;
    background-color: #ffb30e;
    padding: 6px 10px;
    border: none;
    border-radius: 10px;
    transition-duration: 0.5s;
    transition: transform 0.5s;
  }

  .my_btn:hover {
    background-color: #f34e39;
    transform: scale(1.1);
  }

</style>
