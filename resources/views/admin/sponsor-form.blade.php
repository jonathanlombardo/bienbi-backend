@extends('layouts.main')
@section('title', 'Aquista una sponsorizzazione')

@section('maincontent')
  <section class="py-5">
    <div class="container">
      <h1 class="my-4">Scegli il piano che fa per il tuo appartamento {{ $appartment->title }}</h1>
      {{-- @dump($appartment) --}}
      <div class="row justify-content-center">
        @foreach ($plans as $plan)
          <div class="col-3">
            <div class="card">
              <h3>Paccheto {{ $plan->name }}</h3>
              @if ($plan->name === 'base')
                <p>Il pacchetto base offre una solida base per la tua sponsorizzazione. Con questo pacchetto, avrai visibilità sul nostro sito e potrai raggiungere una vasta audience di poten
                  ziali clienti. Ottimo per coloro che vogliono testare le acque della sponsorizzazione online e iniziare a far crescere la loro presenza online.</p>
              @elseif($plan->name === 'medium')
                <p> Il pacchetto medium è progettato per chi cerca di ottenere una maggiore visibilità e coinvolgimento. Oltre ai vantaggi del pacchetto base, avrai accesso a funzionalità aggiuntive come pubblicità mirata e presenza sui social media. Ideale per coloro che vogliono espandere la propria presenza online e raggiungere un pubblico più ampio.</p>
              @else($plan->name === 'premium')
                <p>Il pacchetto premium è il massimo livello di sponsorizzazione disponibile sul nostro sito. Con questo pacchetto, otterrai tutti i vantaggi dei pacchetti base e medium, oltre a una serie di privilegi esclusivi. Questo include posizionamenti privilegiati, contenuti personalizzati e supporto dedicato per massimizzare il tuo impatto. Perfetto per aziende che cercano una visibilità di alto livello e un coinvolgimento mirato.</p>
              @endif
              <p><i class="fa-regular fa-clock"></i> {{ $plan->time }}</p>
              <p>€ {{ $plan->price }}</p>


              <!-- con questi volevamo magari personalizzare la vista della card aggiungendoci qualche icon per tipo di sponsorizzazione
                                  <i class="fa-regular fa-flag"></i>
                                <i class="fa-solid fa-crown"></i>
                                <i class="fa-solid fa-award"></i>
                                <i class="fa-regular fa-flag"></i>
                                <i class="fa-solid fa-euro-sign"></i> -->
              <form action="{{ route('admin.plans.generatePaymentToken', ['appartmentId' => $appartment->id, 'planId' => $plan->id]) }}" method="POST">
                @csrf
                @method('POST')
                <button class="btn btn-primary">Acquista</button>
              </form>

            </div>
          </div>
        @endforeach


      </div>
      <a href="#" class="btn btn-warning">Annulla</a>
    </div>
  </section>
@endsection
