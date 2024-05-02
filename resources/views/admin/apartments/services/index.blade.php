@extends('layouts.main')

@section('maincontent')
    <div class="container">
        <div class="row">
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
        </div>
    </div>
@endsection