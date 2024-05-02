@extends('layouts.main')

@section('maincontent')
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Label</th>
                        </tr>
    
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                        <tr>
                            <td>{{$service->id}}</td>
    
                            <td>{{$service->label}}</td>
                        </tr>
                        @empty 
                        @endforelse
                    </tbody>
                </table>

                {{$services->links()}}


            </div>
        </div>
    </div>
@endsection