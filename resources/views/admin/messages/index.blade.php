@extends('layouts.main')

@section('maincontent')
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    @forelse($appartments as $appartment)
                
                    <table class="table">
                        <thead>
                          <tr>
                            <th class="text-center" scope="col">Nome</th>
                            <th class="text-center" scope="col">Cognome</th>
                            <th class="text-center" scope="col">Mail</th>
                            <th class="text-center" scope="col">Data di invio</th>
                            <th class="text-center" scope="col">Appartamento</th>
                            <th class="text-center" scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)

                              
                            <tr class="align-middle">
                              <td class="text-center">{{$message->first_name}}</td>
                              <td class="text-center">{{$message->last_name}}</td>
                              <td class="text-center">{{$message->mail}}</td>
                              <td class="text-center">{{$message->created_at}}</td>
                              <td class="text-center">{{$message->appartment_id}}</td>
                              <td class="text-end">
                                <div class="btn"><a class="btn" href="{{route('admin.messages.show', $message)}}"> <i class="fa-solid fa-eye text-warning"></i> </a></div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#delete-{{$message->id}}">
                                  <i class="fa-solid fa-trash text-danger"></i>
                                </button>

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

                              </td>

                            </tr>
                            
                            @empty
                            @endforelse
                        </tbody>
                      </table>
                      
                      {{$appartments->links()}}
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
@endsection

<style lang="scss" scoped>

</style>