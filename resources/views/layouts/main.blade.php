<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    {{ env('APP_NAME') }} | @yield('title', Route::currentRouteName())
  </title>
  @vite('resources/js/app.js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js" integrity="sha512-PJa3oQSLWRB7wHZ7GQ/g+qyv6r4mbuhmiDb8BjSFZ8NZ2a42oTtAq5n0ucWAwcQDlikAtkub+tPVCw4np27WCg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  @yield('assets')
</head>

<body>
  <div class="main-wrapper">
    @include('layouts.partials.header')
    <main>
      @yield('maincontent')
    </main>
    @include('layouts.partials.footer')
  </div>

</body>

</html>
