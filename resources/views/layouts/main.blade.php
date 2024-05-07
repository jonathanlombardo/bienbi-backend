<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- libreria animation -->
  <link rel="stylesheet" href="magic.css">
  {{-- font awesome cdn --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>
    {{ env('APP_NAME') }} | @yield('title', Route::currentRouteName())
  </title>
  @vite('resources/js/app.js')
  @stack('assets')
</head>

<body>
  <div class="main-wrapper">
    @include('layouts.partials.header')
    <main>
      @yield('maincontent')
    </main>
    @include('layouts.partials.footer')
  </div>


  @stack('scripts')
</body>

</html>
