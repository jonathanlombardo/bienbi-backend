@extends('layouts.main')

@section('maincontent')
  <div class="container">
    <h1>Crea un appartamento</h1>
    <form action="{{ route('admin.appartments.store') }}" method="POST" class="row" id="edit-form">
      @csrf
      <div class="col-6">
        @include('layouts.partials.tomtomSearchbox')
      </div>
      <div class="col-6">
        <button type="submit" class="btn btn-primary">Go</button>
      </div>
    </form>

  </div>
@endsection


{{-- 
<!DOCTYPE html>
<html class="use-all-space">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
  <title>SearchBox</title>

</head>

<body>
  <script></script>
</body>

</html> --}}
