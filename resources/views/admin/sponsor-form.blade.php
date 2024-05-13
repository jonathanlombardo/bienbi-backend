@extends('layouts.main')
@section('title', 'Aquista una sponsorizzazione')

@section('maincontent')
  <section class="">
    <div class="container">
      <h1 class="mb-4">Scegli il piano che fa per il tuo appartamento {{ $appartment->title }}</h1>
      @include('layouts.partials.alert_message')
      @include('layouts.partials.error_message')
      <div class="row flex-column g-3" id="accordion-row">
        @foreach ($plans as $plan)
          <div class="col">
            <div class="card p-0 border-0">
              <div class="card-body p-0">
                <div class="accordion accordion-flush" id="accordionPlan{{ $plan->id }}">
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="p-0 accordion-button custom-acc-btn py-1 d-flex align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlan{{ $plan->id }}" aria-expanded="false" aria-controls="collapsePlan{{ $plan->id }}">
                        <h3 class="mb-0 input-wrapper d-flex align-items-center gap-3">
                          <input class="form-check-input fs-6" type="radio" id="plans{{ $plan->id }}" name="plans" class="btn btn-primary" value="{{ $plan->id }}">
                          <div class="form-check-label">Pacchetto {{ $plan->name }}</div>
                        </h3>
                        <div class="details-wrapper d-flex align-items-center gap-3 ms-auto me-3">
                          <p class="mb-0"><i class="fa-regular fa-clock"></i> {{ $plan->getTime() }}</p>
                          <p class="mb-0">€ {{ $plan->price }}</p>
                        </div>
                      </button>
                    </h2>
                    <div id="collapsePlan{{ $plan->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion-row">
                      <div class="accordion-body">
                        {{ config('plans')[$plan->id - 1]['description'] }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
        <div class="col">
          <div id="dropin-container"></div>
          <div id="submit-button-wrapper">
            <button id="submit-button" class="button button--small button--green d-none">Acquista</button>
            <a href="{{ route('admin.appartments.show', $appartment->slug) }}" class="button button--small button--yellow">Annulla</a>
          </div>
          <div id="payment-loader" class="text-center d-none">Pagamento in corso...</div>

          <form id="transaction-form" action="{{ route('admin.plans.generateTransaction') }}" class="d-none" method="POST">
            @csrf
            @method('POST')
            <input type="number" id="planId" name="planId" value="-1">
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('assets')
  <style lang="scss">
    [data-braintree-id="methods"] {
      display: none !important;
    }

    [data-braintree-id="choose-a-way-to-pay"] {
      display: none !important;
    }

    [data-braintree-id="toggle"] {
      display: none !important;
    }

    [data-braintree-id="methods-label"] {
      display: none !important;
    }

    button.custom-acc-btn::after {
      margin-left: 0;
    }

    button.custom-acc-btn:not(.collapsed) {
      background-color: transparent;
    }

    button.custom-acc-btn:focus {
      box-shadow: none;
    }

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

    .button--yellow {
      outline: none;
      background-color: #FDB61D;
      border-color: #FDB61D;
      color: rgb(0, 0, 0);
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
    const buttonWrap = document.querySelector('#submit-button-wrapper');
    const paymentLoaderEl = document.querySelector('#payment-loader');
    braintree.dropin.create({
        authorization: {{ Illuminate\Support\Js::from($clientToken) }},
        selector: '#dropin-container',
        dataCollector: true,
        locale: "it_IT",
        card: {
          cardholderName: {
            required: true
          }
        }
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

            buttonWrap.style.display = 'none';
            paymentLoaderEl.classList.remove('d-none');


          });
        });
      }
    );

    // if (dropinInstance.isPaymentMethodRequestable()) {
    //   // This will be true if you generated the client token
    //   // with a customer ID and there is a saved payment method
    //   // available to tokenize with that customer.
    //   submitButton.removeAttribute('disabled');
    // }

    // dropinInstance.on('paymentMethodRequestable', function(event) {
    //   console.log(event.type); // The type of Payment Method, e.g 'CreditCard', 'PayPalAccount'.
    //   console.log(event.paymentMethodIsSelected); // True if a customer has selected a payment method when paymentMethodRequestable fires.

    //   submitButton.removeAttribute('disabled');
    // });

    // dropinInstance.on('noPaymentMethodRequestable', function() {
    //   submitButton.setAttribute('disabled', true);
    // });
  </script>
  <script>
    const planIdInput = document.querySelector('input#planId');
    const planRadios = document.querySelectorAll('input[name="plans"]');
    const accItems = document.querySelectorAll('.accordion-item');
    const accCollapses = document.querySelectorAll('[id*="collapsePlan"]');
    // const accButtons = document.querySelectorAll('.accordion-button');

    accItems.forEach((acc, i) => {


      acc.addEventListener('click', function() {
        planRadios[i].checked = true;
        planIdInput.value = planRadios[i].value;
      })
    })

    planRadios.forEach((radio, i) => {
      radio.addEventListener('change', function() {
        planIdInput.value = this.value;
      })
    });
  </script>
@endpush
