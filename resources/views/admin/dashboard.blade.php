@extends('layouts.main')

@section('maincontent')
  <div class="container">
    <h2 class="fs-4 text-secondary my-4">
      {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
      <div class="col">
        <div class="card">
          <div class="card-header">{{ __('User Dashboard') }}</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            {{ __('You are logged in!') }}
          </div>
        </div>
      </div>
    </div>
    @include('admin.appartments.partials.statistics-graph')
  </div>
@endsection

@push('scripts')
  <script>
    let views_time = {{ Illuminate\Support\Js::from($appartments_views) }};
    views_time = JSON.parse(views_time);
    console.log(
      views_time
    )
  </script>
@endpush
