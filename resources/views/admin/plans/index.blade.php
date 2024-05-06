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
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                        <tr>
                            <td>{{$plan->id}}</td>

                            <td>{{$plan->name}}</td>
                            <td class="text-end"><div class="btn btn-primary"><a href="{{route('admin.plans.show', $plan)}}">Vedi Piano</a></div></td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>
    </div>
@endsection
