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
    let messages_time = {{ Illuminate\Support\Js::from($appartments_messages) }};
    messages_time = JSON.parse(messages_time);
    console.log(
      messages_time
    )
  </script>
@endpush
