@extends('layouts.main')

@section('maincontent')
  <div class="container">
    <h1 class="my-3">I Tuoi Appartamenti</h1>
    <div class="row g-3">
      @forelse($appartments as $appartment)
        <div class="col-4 mb-5 my-col">
          {{-- link per la show degli appartamenti --}}

          <div class="my-card h-100">
            <a href="{{ route('admin.appartments.show', $appartment) }}" class="my-card-link d-block h-100">
              <div class="my-card-header p-3">
                <div class="image-container">
                  <img src="{{ $appartment->imgUrl }}" alt="">
                </div>
              </div>
              <div class="my-card-body p-3">
                <div class="title">{{ $appartment->title }}</div>
                <div class="address mt-1">{{ $appartment->address }}</div>
                <div class="published pt-3"><strong>Visibile: </strong><i @class([$appartment->published ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash', 'ps-1'])></i></div>
              </div>
            </a>

            {{-- link per vedere i messaggi relazionati all'appartamento --}}

            <div class="card-footer py-3">
              <div class="messages">
                <button class="my_btn">
                  <a class="nav-link" href="{{ route('admin.messages.appartment.index', ['appartment_slug' => $appartment->slug]) }}">Vedi messaggi</a>
                </button>
              </div>
            </div>

            {{-- plan label --}}

            <div class="label">
              @if(!empty($appartment->plans))
              @foreach($appartment->plans as $plan)
                <span>{{ $plan->name }}</span>
              @endforeach
              @endif
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
    position: relative;

    .title {
      font-size: 1rem;
      font-weight: 500;
    }

    .label{
      position: absolute;
      top: 10%;
      left: 0;

      span{
        background-color: #e9d09a;
        border-radius: 0 10px 10px 0;
        padding: 5px 10px;
      }
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
