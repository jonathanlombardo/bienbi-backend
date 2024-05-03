@extends('layouts.main')

@section('maincontent')
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Cognome</th>
                            <th scope="col">Mail</th>
                            <th scope="col">Corpo</th>
                            <th scope="col">Data di invio</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>

                              
                            <tr>
                              <td>{{$message->first_name}}</td>
                              <td>{{$message->last_name}}</td>
                              <td>{{$message->mail}}</td>
                              <td>{{$message->body}}</td>
                              <td>{{$message->created_at}}</td>
                              <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-{{$message->id}}">
                                    Elimina
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
                            
                        </tbody>
                      </table>
                      
                </div>
            </div>
        </div>
@endsection

