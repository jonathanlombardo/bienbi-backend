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

    @yield('assets')
</head>

<body>
    <div class="main-wrapper">
        @include('layouts.partials.header')
        <main>
            @yield('maincontent')

            {{-- TEMPORARY CODE  --}}

            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col d-flex justify-content-center align-items-center">

                        <button class="btn btn-primary">
                            <a href="{{route('admin.services.index')}}">services</a>
                        </button>

                    </div>
                </div>
            </div>

            {{-- TEMPORARY CODE --}}

        </main>
        @include('layouts.partials.footer')
    </div>

</body>

</html>

{{-- TEMPORARY CODE --}}

<style lang="scss" scoped>

    .col{
        height: 500px
    }

</style>

{{-- TEMPORARY CODE --}}
