@extends('layouts.main')

@section('maincontent')
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card_header_bg text-center">{{ __('Registrazione') }}</div>
          <div class="container my-4">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <div class="card">
                  <div class="card-header">{{ __('Registrazione') }}</div>
                  <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                      @csrf

                      <div class="mb-4 row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome*') }}</label>
                        <div class="col-md-6">
                          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                          @error('name')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="mb-4 row">
                        <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Cognome*') }}</label>

                        <div class="col-md-6">
                          <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" required>

                          @error('last_name')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="mb-4 row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail*') }}</label>

                        <div class="col-md-6">
                          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                          @error('email')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="mb-4 row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password*') }}</label>
                        <div class="col-md-6">
                          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                          @error('password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="mb-4 row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password*') }}</label>
                        <div class="col-md-6">
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                          <span class="invalid-feedback" role="alert">
                            <strong>La password non corrispone</strong>
                          </span>
                        </div>
                      </div>

                      <div class="mb-4 row">
                        <label for="birthday" class="col-md-4 col-form-label text-md-right">{{ __('Data di nascita') }}</label>

                        <div class="col-md-6">
                          <input id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday">

                          @error('birthday')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-md-6 offset-md-4">
                        <button type="submit" class="my_btn">
                          {{ __('Registrati') }}
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('assets')
  <style lang="scss">
    .my_btn {
      background-color: #ffb30e;
      padding: 6px 10px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
    }

    .my_btn:hover {
      opacity: 0.9;
      box-shadow: 2px 3px 12px rgb(205, 45, 24);
      background: linear-gradient(90deg, rgba(233, 214, 171, 1) 10%, rgba(255, 179, 14, 1) 48%, rgba(243, 78, 57, 1) 97%);
    }
  </style>
@endpush
@push('scripts')
  <script>
    function handleConfirmInput() {
      if (confirmPswdInput.value != pswdInput.value) {
        confirmPswdInput.classList.add('is-invalid')
      } else {
        confirmPswdInput.classList.remove('is-invalid')
      }
    }

    function handlePasswordInput() {
      confirmPswdInput.classList.remove('is-invalid')
    }

    function handleSubmitClick(event) {
      if (confirmPswdInput.value != pswdInput.value) {
        event.preventDefault();
        confirmPswdInput.classList.add('is-invalid');
      }
    }

    const subBtn = document.querySelector('button[type="submit"]');
    const pswdInput = document.querySelector('input#password');
    const confirmPswdInput = document.querySelector('input#password-confirm');

    confirmPswdInput.addEventListener('input', handleConfirmInput)
    pswdInput.addEventListener('input', handlePasswordInput)
    subBtn.addEventListener('click', handleSubmitClick)
  </script>
@endpush
