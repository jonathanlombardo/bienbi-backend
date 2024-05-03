@extends('layouts.main')

@section('maincontent')
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    @forelse($appartments as $appartment)
                
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Cognome</th>
                            <th scope="col">Mail</th>
                            <th scope="col">Messaggio</th>
                            <th scope="col">Data di invio</th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                            <tr>
                              <td>{{$message->first_name}}</td>
                              <td>{{$message->last_name}}</td>
                              <td>{{$message->mail}}</td>
                              <td>{{$message->body}}</td>
                              <td>{{$message->created_at}}</td>
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