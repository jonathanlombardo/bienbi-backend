<section>
    <header>
        <h2 class="text-secondary">
            {{ __('Informazioni del Profilo') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __("Modifica le informazione e la mail del tuo profilo") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('auth.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-2">
            <label for="name">{{ __('Nome') }}</label>
            <input class="form-control" type="text" name="name" id="name" autocomplete="name" value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->get('name') }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-2">
            <label for="last_name">{{ __('Cognome') }}</label>
            <input class="form-control" type="text" name="last_name" id="last_name" autocomplete="last_name" value="{{ old('last_name', $user->last_name) }}" required>
            @error('last_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->get('last_name') }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-2">
            <label for="birthday">{{ __('Data di Nascita') }}</label>
            <input class="form-control" type="date" name="birthday" id="birthday" value="{{ old('birthday', $user->birthday) }}">
            @error('birthday')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->get('birthday') }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-2">
            <label for="email">
                {{ __('Email') }}
            </label>

            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />

            @error('email')
            <span class="alert alert-danger mt-2" role="alert">
                <strong>{{ $errors->get('email') }}</strong>
            </span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-muted">
                    {{ __('La tua mail non è verificata') }}

                    <button form="send-verification" class="btn btn-outline-dark">
                        {{ __('Clicca qui per inviare un altro link di verifica.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 text-success">
                    {{ __('Un altro link di verifica è stato inviato alla tua mail.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-4">
            <button class="btn btn-primary" type="submit">{{ __('Salva Modifiche') }}</button>

            @if (session('status') === 'profile-updated')
            <script>
                const show = true;
                setTimeout(() => show = false, 2000)
                const el = document.getElementById('profile-status')
                if (show) {
                    el.style.display = 'block';
                }
            </script>
            <p id='profile-status' class="fs-5 text-muted">{{ __('Modifiche Salvate.') }}</p>
            @endif
        </div>
    </form>
</section>