@extends('layouts.main')
@section('title', 'Aquista una sponsorizzazione')

@section('maincontent')
  <section class="py-5">
    <div id="dropin-container"></div>
    <button id="submit-button" class="button button--small button--green d-none">Purchase</button>
    <form id="transaction-form" action="{{ route('admin.plans.generateTransaction') }}" class="d-none" method="POST">
      @csrf
      @method('POST')
    </form>
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
@endpush
