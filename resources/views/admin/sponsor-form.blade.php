@extends('layouts.main')
@section('title', 'Aquista una sponsorizzazione')

@section('maincontent')
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
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
              @else
                <p>Il pacchetto premium è il massimo livello di sponsorizzazione disponibile sul nostro sito. Con questo pacchetto, otterrai tutti i vantaggi dei pacchetti base e medium, oltre a una serie di privilegi esclusivi. Questo include posizionamenti privilegiati, contenuti personalizzati e supporto dedicato per massimizzare il tuo impatto. Perfetto per aziende che cercano una visibilità di alto livello e un coinvolgimento mirato.</p>
              @endif
              <p><i class="fa-regular fa-clock"></i> {{ $plan->time }}</p>
              <p>€ {{ $plan->price }}</p>
              <div class="form-check">

                <input class="form-check-input" type="radio" id="plans{{ $plan->id }}" name="plans" class="btn btn-primary" value="{{ $plan->id }}">
                <label class="form-check-label" for="plans{{ $plan->id }}">Acquista questo</label>
              </div>



            </div>
          </div>
        @endforeach

        <section class="py-5">
          <div id="dropin-container"></div>
          <button id="submit-button" class="button button--small button--green d-none">Purchase</button>
          <form id="transaction-form" action="{{ route('admin.plans.generateTransaction') }}" class="d-none" method="POST">
            @csrf
            @method('POST')
            <input type="number" id="planId" name="planId" value="-1">
          </form>
        </section>

      </div>
      <a href="#" class="btn btn-warning">Annulla</a>
    </div>
  </section>
@endsection

@push('assets')
  <style lang="scss">
    .button {
      cursor: pointer;
      font-weight: 500;
      left: 3px;
      line-height: inherit;
      position: relative;
      text-decoration: none;
      text-align: center;
      border-style: solid;
      border-width: 1px;
      border-radius: 3px;
      -webkit-appearance: none;
      -moz-appearance: none;
      display: inline-block;
    }

    .button--small {
      padding: 10px 20px;
      font-size: 0.875rem;
    }

    .button--green {
      outline: none;
      background-color: #64d18a;
      border-color: #64d18a;
      color: white;
      transition: all 200ms ease;
    }

    .button--green:hover {
      background-color: #8bdda8;
      color: white;
    }
  </style>
@endpush

@push('scripts')
  <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.js"></script>
  <script>
    const button = document.querySelector('#submit-button');
    braintree.dropin.create({
        authorization: {{ Illuminate\Support\Js::from($clientToken) }},
        selector: '#dropin-container',
        dataCollector: true,
      },
      function(err, instance) {
        button.classList.remove('d-none')
        button.addEventListener('click', function() {
          instance.requestPaymentMethod(function(err, payload) {
            // Submit payload.nonce to your server

            const form = document.querySelector('#transaction-form');
            form.action += '?paymentNonce=' + payload.nonce;
            form.action += '&deviceDataFromTheClient=' + payload.deviceData;
            form.submit();


          });
        });
      }
    );
  </script>
  <script>
    const planIdInput = document.querySelector('input#planId');
    const planRadios = document.querySelectorAll('input[name="plans"]');

    planRadios.forEach((radio) => {
      radio.addEventListener('change', function() {
        planIdInput.value = this.value;
      })
    });
  </script>
@endpush
