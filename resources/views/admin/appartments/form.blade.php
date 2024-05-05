@extends('layouts.main')

@push('assets')
  <style lang="scss">
    form .image-preview {
      max-width: 200px;
    }
  </style>
@endpush

@section('maincontent')
  <div class="container">
    <h1>Crea un appartamento</h1>
    <form action="{{ route('admin.appartments.store') }}" method="POST" class="row g-4" id="edit-form">
      @csrf
      <div class="col-12">
        @include('layouts.partials.tomtomSearchbox')
      </div>

      <div class="col-12">
        <label for="image" class="form-label">Immagine</label>
        <input type="file" class="form-control custom-input image-preview-input" id="image" name="image" value="{{ $appartment->id ? $appartment->image : '' }}">
        <div class="mt-3">
          <img class="image-preview" src="{{ $appartment->imgUrl }}" alt="" class="proj-img">
          <button class="reset-img btn btn-link" type="button">Reset immagine</button>
        </div>
        <div class="invalid-feedback input-feedback img-fb">errore</div>
      </div>

      <div class="col-12">
        <label for="title" class="form-label">Titolo descrittivo</label>
        <input type="text" class="form-control custom-input" id="title" name="title" placeholder="Appartamento da mario, villetta con terrazzo" value="{{ $appartment->id ? $appartment->title : '' }}">
        <div class="invalid-feedback input-feedback">errore</div>
      </div>
      <div class="col-12">
        <label for="rooms" class="form-label">Numero di stanze</label>
        <input type="number" class="form-control custom-input" id="rooms" name="rooms" placeholder="2" value="{{ $appartment->id ? $appartment->rooms : '' }}">
        <div class="invalid-feedback input-feedback">errore</div>
      </div>
      <div class="col-12">
        <label for="beds" class="form-label">Numero di posti letto</label>
        <input type="number" class="form-control custom-input" id="beds" name="beds" placeholder="2" value="{{ $appartment->id ? $appartment->beds : '' }}">
        <div class="invalid-feedback input-feedback">errore</div>
      </div>
      <div class="col-12">
        <label for="bathrooms" class="form-label">Numero di bagni</label>
        <input type="number" class="form-control custom-input" id="bathrooms" name="bathrooms" placeholder="2" value="{{ $appartment->id ? $appartment->bathrooms : '' }}">
        <div class="invalid-feedback input-feedback">errore</div>
      </div>
      <div class="col-12">
        <label for="square_meters" class="form-label">Superfice (metri quadri)</label>
        <input type="number" class="form-control custom-input" id="square_meters" name="square_meters" placeholder="2" value="{{ $appartment->id ? $appartment->square_meters : '' }}">
        <div class="invalid-feedback input-feedback">errore</div>
      </div>

      <div class="col-12 row g-3">
        <div class="col-12">Servizi offerti</div>
        @foreach ($services as $service)
          <div class="col-12 col-md-6 col-xl-4">
            <input type="checkbox" class="form-check-input" name="services[]" id="service{{ $service->id }}" value="{{ $service->id }}" {{ $appartment->id ? (in_array($service->id, $appartmentServices) ? 'checked' : '') : '' }}>
            <label class="form-check-label ms-2" for="service{{ $service->id }}">{{ $service->label }}</label>
          </div>
        @endforeach
      </div>

      <div class="col-12">
        <span>Pubblica:</span>
        <label class="switch">
          <input type="checkbox" name="published">
          <span class="slider round"></span>
        </label>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">{{ $appartment->id ? 'Modifica Appartamento' : 'Crea Appartamento' }}</button>
      </div>
    </form>

  </div>
@endsection

@push('scripts')
  <script>
    const inputs = document.querySelectorAll('input');

    inputs.forEach((input) => {
      input.addEventListener("input", function() {
        this.classList.remove('is-invalid')
        if (errorAlertEl) errorAlertEl.classList.add('d-none')
      })
    })

    const appImg = document.querySelector('.image-preview');
    const appImgInput = document.querySelector('.image-preview-input');
    const fbImgEl = document.querySelector('.img-fb');
    const resetImgBtn = document.querySelector('.reset-img');
    const originalSrc = appImg.src;

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

    resetImgBtn.addEventListener('click', function() {
      appImg.src = originalSrc
      appImgInput.value = null;
      appImgInput.classList.remove('is-invalid')
    })
  </script>
@endpush
