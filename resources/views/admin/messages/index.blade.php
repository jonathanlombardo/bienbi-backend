@extends('layouts.main')
@section('title', 'Messaggi')

@section('maincontent')
  <div class="container">
    <div>
      <h2 class="title my-3">MESSAGGI</h2>
    </div>

    <div class="row g-2 mt-5 flex-column">
      @forelse($messages as $message)
        <div class="col-12 position-relative">
          <a href="{{ route('admin.messages.show', $message) }}" class="my-card-link">
            <div class="my-card">
              <div class="my-card-header d-flex justify-content-between">
                <div>
                  <div class="appartment">{{ $message->appartment->title }}</div>

                  <div class="name">{{ $message->first_name }} {{ $message->last_name }}</div>
                  <div class="mail">{{ $message->mail }}</div>
                </div>
              </div>

              <div class="my-card-body d-flex justify-content-between">
                <div class="message">{{ $message->getAbstract(135) }}</div>
                <div class="created">{{ $message->created_at }}</div>
              </div>

            </div>
          </a>

          <div class="dropdown my-dropdown position-absolute">
            <button class="btn option-btn align-middle position-absolute top-100 start-100 translate-middle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu p-0">
              <li class="text-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn delete-btn text-start text-danger" data-bs-toggle="modal" data-bs-target="#delete-{{ $message->id }}">
                  Elimina Messaggio
                </button>


              </li>
            </ul>
          </div>
          {{-- modal --}}

          <div class="modal fade" id="delete-{{ $message->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminare da {{ $message->first_name }} {{ $message->last_name }}?</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Se elimini questo messaggio non potrai più recuperarlo.
                </div>
                <div class="modal-footer">

                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                  <form action="{{ route('admin.messages.destroy', $message) }}" method='POST'>
                    @csrf
                    @method('DELETE')
                    <button class='btn btn-danger'>Elimina</button>
                  </form>

                </div>
              </div>
            </div>
          </div>

        </div>
      @empty
        <p class="text-center">Non ci sono messaggi</p>
      @endforelse

      @if ($messages)
        <div class="my-5">
          {{ $messages->links() }}
        </div>
      @endif

    </div>
  </div>
@endsection

<style lang="scss" scoped>
  .title {
    color: #e8620c;
    font-size: 3rem;
    font-weight: bold;
  }

  .my-card-link {
    color: black;
    text-decoration: none;
  }

  .my-card {
    padding: 10px 20px;
    border: 0.1px solid rgb(255, 255, 255);
    position: relative;
    background: #f3c665;
    cursor: pointer;


    .appartment {
      font-size: 1rem;
      font-weight: bold;
      font-weight: bold;
    }

    .name {
      font-size: 0.9rem;

    }

    .mail {
      font-size: 0.8rem;
    }

    .option-btn {
      background-color: rgba(255, 235, 205, 0);
      border: none;
      position: absolute;
    }

    .delete-btn {
      padding: 0;
      border: none;
    }

    ul {
      background-color: rgb(193, 193, 193)
    }

    .created {
      font-size: 0.7rem;
    }
  }

  .my-card:hover {
    filter: brightness(1.05);
  }


  .my-dropdown {
    right: 5%;
    top: 20%;
  }
</style>
