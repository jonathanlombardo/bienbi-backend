@extends('layouts.main')

@section('maincontent')
  <div class="container">
    <div>
      <h2 class="title my-3">MESSAGGI</h2>
    </div>

    <div class="row mt-5">
      <div class="col">
        <div class="container">
          <div class="row g-2">
            @forelse($messages as $message)
              <div class="col-6 position-relative">
                <a href="{{route('admin.messages.show', $message)}}" class="my-card-link">
                  <div class="my-card">
                    <div class="my-card-header d-flex justify-content-between">
                      <div>
                        <div class="name">{{$message->first_name}} {{$message->last_name}}</div>
                        <div class="mail">{{$message->mail}}</div>
                      </div>    
                    </div>
  
                    <div class="my-card-body d-flex justify-content-between">
                      <div class="message">{{$message->body}}</div>
                      <div class="created">{{$message->created_at}}</div>
                    </div>
                  </div>
                </a>

                <div class="dropdown my-dropdown position-absolute">
                  <button class="btn option-btn align-middle position-absolute top-100 start-100 translate-middle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                  </button>
                  <ul class="dropdown-menu p-1 ">
                    <li class="text-center ">
                      <!-- Button trigger modal -->
                      <button type="button" class="btn delete-btn" data-bs-toggle="modal" data-bs-target="#delete-{{$message->id}}">
                        Elimina Messaggio
                      </button>    
                    </li>
                  </ul>
                </div>
                {{-- modal --}}
                            
                <div class="modal fade" id="delete-{{$message->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminare da {{ $message->first_name }} {{ $message->last_name}}?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        Se elimini questo messaggio non potrai più recuperarlo.
                      </div>
                              
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <form action="{{ route('admin.messages.destroy', $message)}}" method='POST'>
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
            @endforelse
          </div>
        </div>       
      </div>
    </div>   
  </div>
@endsection

<style lang="scss" scoped>

   .title{
    color: #e8620c;
    font-size: 3rem;
    font-weight: bold;
  }

  .my-card-link{
    color: black;
    text-decoration: none;
  }

  .my-card{
    padding: 10px 20px;
    border: 0.1px solid rgb(255, 255, 255);
    position: relative;
    opacity: 0.6;
    background: #f3c665;
    cursor: pointer;

    .name{
      font-size: 1rem;
    }

    .mail{
      font-size: 0.8rem;
    }

    .option-btn{
      background-color: rgba(255, 235, 205, 0);
      border: none;
      position: absolute;
    }

    .delete-btn{
      padding: 0;
      border: none;
    }

    ul{
      background-color: rgb(193, 193, 193)
    }

    .created{
      font-size: 0.7rem;
    }
  }

  .my-card:hover{
    border: 0.1px solid rgb(236, 236, 236);
    opacity: 1;
  }

  .my-dropdown{
    right: 5%;
    top: 20%;
  }
</style>