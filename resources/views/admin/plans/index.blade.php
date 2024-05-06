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
                        <td class="text-end d-flex justify-content-end">
                            <div class="my_btn"><a class="text-black text-decoration-none" href="{{route('admin.plans.show', $plan)}}">Vedi Piano</a></div>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>


        </div>
    </div>
</div>
@endsection

@push('assets')
<style lang="scss">
.my_btn {
    font-size: 0.9rem;
    background-color: #ffb30e;
    padding: 6px 10px;
    border: none;
    width: 100px;
    border-radius: 10px;
    transition: transform 0.5s;
}

.my_btn:hover {
    box-shadow: 2px 3px 12px rgba(255, 179, 14, 1);
    transform: scale(1.1);
}

</style>
@endpush