@extends('layouts.main')

@section('title')
Cronologia sponsorizzazioni per {{$appartment->title}}
@endsection

@section('maincontent')
<div class="container">
  <h1>Cronologia sponsorizzazioni per {{$appartment->title}}</h1>
  <div class="row">
    @foreach($appartment->plans as $plan)
    <div class="col-12">
      <div class="card">

        nome appartamento: {{$appartment->title}} <br>
        proprietario appartamento: {{$appartment->user->name}} {{$appartment->user->last_name}} <br>
        titolo plan sponsor: {{$plan->name}} <br>
        prezzo: {{$plan->price}} <br>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection