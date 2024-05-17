@extends('layouts.main')
@section('title', 'Aquista una sponsorizzazione')

@section('maincontent')
  <section class="">
    <div class="container">
      <h1 class="mb-4">Scegli il piano che fa per il tuo appartamento {{ $appartment->title }}</h1>
      @include('layouts.partials.alert_message')
      @include('layouts.partials.error_message')
      <p class="plans-fb mb-1 text-danger d-none">Seleziona un piano:</p>
      <div class="row flex-column g-3" id="accordion-row">
        @foreach ($plans as $plan)
          <div class="col card card-{{ $plan->name }}">
            <div>
              <div class="card-body p-0">
                <div class="accordion accordion-flush" id="accordionPlan{{ $plan->id }}">
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="card-{{ $plan->name }} p-0 accordion-button custom-acc-btn py-1 d-flex align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlan{{ $plan->id }}" aria-expanded="false" aria-controls="collapsePlan{{ $plan->id }}">
                        <h3 class="mb-0 input-wrapper d-flex align-items-center gap-3">
                          <input class="form-check-input fs-6" type="radio" id="plans{{ $plan->id }}" name="plans" class="btn btn-primary" value="{{ $plan->id }}">
                          <div class="form-check-label d-flex align-items-center">Pacchetto {{ $plan->name }}
                          @if ($plan->name == 'Base')
                            <i class="fa-solid fa-star fs-5 ms-3"></i>
                          @elseif ($plan->name == 'Medium')  
                            <i class="fa-solid fa-star fs-5 ms-3"></i>
                            <i class="fa-solid fa-star fs-5"></i>
                          @elseif ($plan->name == 'Premium')
                            <i class="fa-solid fa-star fs-5 ms-3"></i>
                            <i class="fa-solid fa-star fs-5"></i>
                            <i class="fa-solid fa-star fs-5"></i>
                            @endif
                          </div>
                        </h3>
                        <div class="details-wrapper d-flex align-items-center gap-3 ms-auto me-3">
                          <p class="mb-0"><i class="fa-regular fa-clock me-2"></i><strong>{{ $plan->getTime() }}</strong></p>
                          <p class="mb-0"><strong>€ {{ $plan->price }}</strong></p>
                        </div>
                      </button>
                    </h2>
                    <div id="collapsePlan{{ $plan->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion-row">
                      <div class="accordion-body card-{{ $plan->name }}-body mb-2">
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
            <input type="number" id="appartmentId" name="appartmentId" value="{{ $appartment->id }}">
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

    .accordion-button:not(.collapsed) {
      color: #212529 !important;
    }

    .card-Base {
      background-color: #f3ddab !important;
    }

    .card-Base-body {
      background-color: #f2e8d1 !important;
    }

    .card-Medium {
      background-color: #ffb30e !important;
    }

    .card-Medium-body {
      background-color: #f6d99a !important;
    }

    .card-Premium {
      background-color: #f34e39 !important;
    }

    .card-Premium-body {
      background-color: #f7a398 !important;
    }

    .form-check-input:checked {
      background-color: #000000 !important;
      border-color: #000000 !important;
    }

    .form-check-input:focus {
      box-shadow:  0 0 0 0.25rem rgba(67, 67, 67, 0.319) !important;
    }
  </style>
@endpush

@push('scripts')
  <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.js"></script>
  <script>
    const button = document.querySelector('#submit-button');
    const buttonWrap = document.querySelector('#submit-button-wrapper');
    const paymentLoaderEl = document.querySelector('#payment-loader');
    const alertEl = document.querySelector('.alert');
    const planIdInput = document.querySelector('input#planId');
    const accItems = document.querySelectorAll('.accordion-item');
    const planRadios = document.querySelectorAll('input[name="plans"]');
    const planFbEl = document.querySelector('.plans-fb');

    function setPlansInvalid(bool = true) {
      if (bool) {
        planFbEl.classList.remove('d-none')
        accItems.forEach((acc) => {
          acc.classList.add('border', 'border-danger')
        })
      } else {
        planFbEl.classList.add('d-none')
        accItems.forEach((acc) => {
          acc.classList.remove('border', 'border-danger')
        })
      }
    }

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
          if (planIdInput.value <= 0) {
            setPlansInvalid();
            return
          }
          instance.requestPaymentMethod(function(err, payload) {
            // Submit payload.nonce to your server

            const form = document.querySelector('#transaction-form');
            if (alertEl) alertEl.classList.add('d-none');

            form.action += '?paymentNonce=' + payload.nonce;
            form.action += '&deviceDataFromTheClient=' + payload.deviceData;
            form.submit();

            buttonWrap.style.display = 'none';
            paymentLoaderEl.classList.remove('d-none');


          });
        });
      }
    );



    accItems.forEach((acc, i) => {
      acc.addEventListener('click', function() {
        planRadios[i].checked = true;
        planIdInput.value = planRadios[i].value;
        setPlansInvalid(false);
      })
    })

    planRadios.forEach((radio, i) => {
      radio.addEventListener('change', function() {
        planIdInput.value = this.value;
        setPlansInvalid(false);
      })
    });
  </script>
@endpush
