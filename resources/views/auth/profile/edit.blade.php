@extends('layouts.main')
@section('maincontent')
    <div class="container">
        {{-- <h2 class="fs-4 text-secondary my-4">
            {{ __('I tuoi messaggi') }}
        </h2> --}}

        <h2 class="fs-4 text-secondary my-4">
            {{ __('Profilo') }}
        </h2>
        <div class="card p-4 mb-4 bg-white shadow rounded-lg">

            @include('auth.profile.partials.update-profile-information-form')

        </div>

        <div class="card p-4 mb-4 bg-white shadow rounded-lg">


            @include('auth.profile.partials.update-password-form')

        </div>

        <div class="card p-4 mb-4 bg-white shadow rounded-lg">


            @include('auth.profile.partials.delete-user-form')

        </div>
    </div>
@endsection

@push("assets")
<style>
    .my_btn {
      font-size: 0.9rem;
      background-color: #ffb30e;
      padding: 6px 10px;
      border: none;
      border-radius: 10px;
      transition-duration: 0.5s;
      font-weight: bold;
      text-decoration: none;
      color: inherit;
      display: block;
      width: 15%;
      text-align: center;
      margin-bottom: 5px;
    }

    .my_btn:hover {
      background-color: #f34e39;
      box-shadow: 2px 3px 12px #f34e39;
    }
</style>
@endpush
