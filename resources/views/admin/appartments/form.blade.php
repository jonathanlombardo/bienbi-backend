@extends('layouts.main')
@section('title')
@if(Route::currentRouteName()=='admin.appartments.create')
Nuovo Appartamento
@else
Modifica Appartamento
@endif
@endsection
@push('assets')
<style lang="scss">
  form .image-preview {
    max-width: 200px;
  }

  .icon-container{
    width: 40px;
    text-align: center;
    display: inline-block;
  }

  .service-container {
    height: 650px;
  }

  .form-check-input:checked {
    background-color: #f34e39 !important;
    border-color: #f34e39 !important;
  }

  label.switch input:checked + .slider {
    background-color: #f34e39 !important;
  }
  
  .reset-img {
    color: #f34e39 !important;
    padding-left: 0 !important;
  }
  </style>
@endpush

@section('maincontent')
  <div class="container">
    <h1>{{ $appartment->id ? 'Modifica Appartamento' : 'Crea Appartamento' }}</h1>
    <p>Tutti i campi contrassegnati con '*' sono obbligatori</p>

    <div class="error-alert alert alert-danger alert-dismissible fade show {{ !$errors->any() ? 'd-none' : '' }}" role="alert">
      <strong>Check and correct fields on error!</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <form action="{{ $appartment->id ? route('admin.appartments.update', $appartment->slug) : route('admin.appartments.store') }}" method="POST" enctype="multipart/form-data" class="row g-4" id="edit-form">
      @csrf
      @method($appartment->id ? 'PATCH' : 'POST')

      <div class="col-12">
        @include('layouts.partials.tomtomSearchbox')
      </div>

      <div class="col-12">
        <label for="image" class="form-label">Immagine</label>
        <input type="file" class="@error('image') is-invalid @enderror form-control custom-input image-preview-input" id="image" name="image" value="{{ $appartment->id ? ($errors->any() ? old('image') : $appartment->image) : old('image') }}">
        <div class="mt-3">
          <img class="image-preview" src="{{ $appartment->imgUrl }}" alt="" class="proj-img">
          <button class="reset-img btn btn-link" type="button">Reset immagine</button>
        </div>
        <div class="invalid-feedback input-feedback">
          @error('image')
            {{ $message }}
          @enderror
        </div>
      </div>
      <div class="col-12">
        <label for="title" class="form-label">Titolo descrittivo*</label>
        <input type="text" class="@error('title') is-invalid @enderror form-control custom-input" id="title" name="title" placeholder="Appartamento da mario, villetta con terrazzo" value="{{ $appartment->id ? ($errors->any() ? old('title') : $appartment->title) : old('title') }}">
        <div class="invalid-feedback input-feedback">
          @error('title')
            {{ $message }}
          @enderror
        </div>
      </div>
      <div class="col-12">
        <label for="rooms" class="form-label">Numero di stanze*</label>
        <input type="number" class="@error('rooms') is-invalid @enderror form-control custom-input" id="rooms" name="rooms" placeholder="2" value="{{ $appartment->id ? ($errors->any() ? old('rooms') : $appartment->rooms) : old('rooms') }}">
        <div class="invalid-feedback input-feedback">
          @error('rooms')
            {{ $message }}
          @enderror
        </div>
      </div>
      <div class="col-12">
        <label for="beds" class="form-label">Numero di posti letto*</label>
        <input type="number" class="@error('beds') is-invalid @enderror form-control custom-input" id="beds" name="beds" placeholder="2" value="{{ $appartment->id ? ($errors->any() ? old('beds') : $appartment->beds) : old('beds') }}">
        <div class="invalid-feedback input-feedback">
          @error('beds')
            {{ $message }}
          @enderror
        </div>
      </div>
      <div class="col-12">
        <label for="bathrooms" class="form-label">Numero di bagni*</label>
        <input type="number" class="@error('bathrooms') is-invalid @enderror form-control custom-input" id="bathrooms" name="bathrooms" placeholder="2" value="{{ $appartment->id ? ($errors->any() ? old('bathrooms') : $appartment->bathrooms) : old('bathrooms') }}">
        <div class="invalid-feedback input-feedback">
          @error('bathrooms')
            {{ $message }}
          @enderror
        </div>
      </div>
      <div class="col-12">
        <label for="square_meters" class="form-label">Superfice* (metri quadri)</label>
        <input type="number" class="@error('square_meters') is-invalid @enderror form-control custom-input" id="square_meters" name="square_meters" placeholder="2" value="{{ $appartment->id ? ($errors->any() ? old('square_meters') : $appartment->square_meters) : old('square_meters') }}">
        <div class="invalid-feedback input-feedback">
          @error('square_meters')
            {{ $message }}
          @enderror
        </div>
      </div>
      <div class="col-12 col-md-6 mt-5">Servizi offerti*</div>
      <div class="col-12 row d-flex flex-column service-container g-4 m-0">
        @foreach ($services as $service)
          <div class="col-12 col-md-6 col-xl-4">
            <input type="checkbox" class="@error('services') is-invalid @enderror form-check-input" name="services[]" id="service {{ $service->id }}" value="{{ $service->id }}" {{ in_array($service->id, old('services', $appartment->id ? $appartmentServices : [])) ? 'checked' : '' }}>
            <div class="invalid-feedback input-feedback">
              @error('services')
                {{ $message }}
              @enderror
            </div>
            <label class="form-check-label ms-2" for="service{{ $service->id }}"><div class="icon-container"><i class="{{ $service->faIconClass }}"></i></div>{{ $service->label }}</label>
          </div>
        @endforeach
      </div>
      <div class="col-12">
        <span>Pubblica:</span>
        <label class="switch">
          <input type="checkbox" name="published" id="published" {{ old('published', $appartment->id ? $appartment->published : null) ? 'checked' : '' }}>
          <span class="slider round"></span>
        </label>
        @error('published')
          <div class="invalid-feedback input-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-12">
        <button type="submit" class="btn my_btn">{{ $appartment->id ? 'Modifica Appartamento' : 'Crea Appartamento' }}</button>
      </div>
    </form>

  </div>
@endsection

@push('scripts')
  <script>
    // invalida un input
    function invalidInput(el, fbText) {
      const elId = el.getAttribute('id');
      const elLabel = document.querySelector(`label[for=${elId}]`)
      const fb = document.querySelector(`input#${elId} + .input-feedback`)
      el.classList.add('is-invalid');
      if (fb) {
        fb.classList.remove('d-none');
        fb.innerText = fbText;
      }
      elLabel.scrollIntoView();
    }

    // verifica la validità degli input prima dell'invio del form
    function handleSubmitClick(event) {
      if (ttHandleSubmitClick(event)) return;
      if (!titleInput.value) {
        event.preventDefault();
        invalidInput(titleInput, 'inserisci il titolo dell\' appartamento')
        return;
      }
      if (titleInput.value.length < 10) {
        event.preventDefault();
        invalidInput(titleInput, 'inserisci un titolo di almeno 10 caratteri')
        return;
      }
      if (roomsInput.value <= 0 || parseInt(roomsInput.value) != roomsInput.value) {
        event.preventDefault();
        invalidInput(roomsInput, 'il numero di stanze deve essere un intero > 0')
        return;
      }
      if (bedsInput.value <= 0 || parseInt(bedsInput.value) != bedsInput.value) {
        event.preventDefault();
        invalidInput(bedsInput, 'il numero di posti letto deve essere un intero > 0')
        return;
      }
      if (bathroomsInput.value <= 0 || parseInt(bathroomsInput.value) != bathroomsInput.value) {
        event.preventDefault();
        invalidInput(bathroomsInput, 'il numero di bagni deve essere un intero > 0')
        return;
      }
      if (square_metersInput.value <= 10 || parseInt(square_metersInput.value) != square_metersInput.value) {
        event.preventDefault();
        invalidInput(square_metersInput, 'il numero di bagni deve essere un intero > 10')
        return;
      }

      let serviceCheck = false;
      serviceInputs.forEach((service) => {
        if (service.checked) serviceCheck = true;
      })

      if (!serviceCheck) {
        event.preventDefault();
        serviceInputs.forEach((service) => {
          invalidInput(service, 'selezionane almeno uno')
        })
        return;
      }


    }

    // recupero input e alert d'errore
    const inputs = document.querySelectorAll('input');
    const errorAlertEl = document.querySelector('.error-alert');
    const titleInput = document.querySelector('input#title');
    const roomsInput = document.querySelector('input#rooms');
    const bedsInput = document.querySelector('input#beds');
    const bathroomsInput = document.querySelector('input#bathrooms');
    const square_metersInput = document.querySelector('input#square_meters');
    const serviceInputs = document.querySelectorAll('input[id*="service"]');

    // rimuovo le classi di errore se vengono modificati gli input
    inputs.forEach((input) => {
      input.addEventListener("input", function() {
        this.classList.remove('is-invalid')
        if (errorAlertEl) errorAlertEl.classList.add('d-none')
      })

      input.addEventListener("change", function() {
        if (this.getAttribute('id').includes("service")) {
          serviceInputs.forEach((service) => {
            service.classList.remove('is-invalid')
            if (errorAlertEl) errorAlertEl.classList.add('d-none')
          })
          return;
        }
        this.classList.remove('is-invalid')
        if (errorAlertEl) errorAlertEl.classList.add('d-none')
      })
    })

    // recupero elementi dell'immagine e della preview
    const appImg = document.querySelector('.image-preview');
    const appImgInput = document.querySelector('.image-preview-input');
    const fbImgEl = document.querySelector('.img-fb');
    const resetImgBtn = document.querySelector('.reset-img');
    const originalSrc = appImg.src;

    // setto la preview al cambio di immagine e prevengo file non validi
    appImgInput.addEventListener("change", function() {
      const file = this.files[0];

      if (file.type.startsWith('image')) {
        const reader = new FileReader();
        console.log(this.files[0].type);
        reader.onloadend = function() {
          appImg.src = reader.result;
        }
        if (file) {
          reader.readAsDataURL(file);
        } else {
          appImg.src = originalSrc;
        }
      } else {
        appImg.src = originalSrc
        appImgInput.value = null;
        appImgInput.classList.add('is-invalid')
        fbImgEl.innerText = "Il file caricato non è un immagine"
      }

    })

    // al click del bottone resetto la preview
    resetImgBtn.addEventListener('click', function() {
      appImg.src = originalSrc
      appImgInput.value = null;
      appImgInput.classList.remove('is-invalid')
    })

    // recupero il bottone per il submit
    const subBtn = document.querySelector('button[type="submit"]');

    // Invio il form solo se i campi sono validi
    subBtn.addEventListener('click', handleSubmitClick);
  </script>
@endpush
