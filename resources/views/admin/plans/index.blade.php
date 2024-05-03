@extends('layouts.main')

@section('maincontent')
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Time</th>
                            <th>Price</th>
                        </tr>

                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                        <tr>
                            <td>{{$plan->id}}</td>

                            <td>{{$plan->name}}</td>

                            <td>{{$plan->time}}</td>

                            <td>{{$plan->price}}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>
    </div>
@endsection
