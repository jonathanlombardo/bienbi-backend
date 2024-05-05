<div id="tomtom-searchbox-wrapper">
  <div id="tomtom-searchbox">
    <input type="text" name="address" id="tomtom-searchbox-address" class="d-none" value="{{ $appartment->id ? htmlspecialchars($appartment->address) : '' }}">
    <input type="number" name="lng" id="tomtom-searchbox-lng" class="d-none" step="any" value="{{ $appartment->id ? $appartment->lng : '' }}">
    <input type="number" name="lat" id="tomtom-searchbox-lat" class="d-none" step="any" value="{{ $appartment->id ? $appartment->lat : '' }}">
  </div>
  <div id="search-box-feedback" class="d-none text-danger pt-1" style="position: absolute">Seleziona un indirizzo tra quelli suggeriti</div>
</div>

@push('scripts')
  <script>
    // Svuota i campi relativi all'indirizzo
    function clearAddress() {
      addressInput.value = null;
      latInput.value = null;
      lngInput.value = null;
      console.log('address cleared');
    }

    // Popola i campi relativi all'indirizzo
    function fillAddress(event) {
      // Popolo i campi
      const res = event.data.result;
      addressInput.value = res.address.freeformAddress;
      latInput.value = res.position.lat;
      lngInput.value = res.position.lng;

      // elimino classi d'errore
      searchBoxInputContainer.classList.remove('border-danger');
      searchBoxFeedbackEl.classList.add('d-none')
      console.log('address filled');
    }

    // Prevengo l'invio del form se indirizzo assente
    function handleSubmitClick(event) {
      if (!addressInput.value || !latInput.value || !lngInput.value) {
        event.preventDefault();
        console.log(searchBoxInputContainer)

        // aggiungo classi d'errore
        searchBoxInputContainer.classList.add('border-danger');
        searchBoxFeedbackEl.classList.remove('d-none')
      }
    }

    // setto opzioni tom tom searchbox
    const options = {
      searchOptions: {
        key: "GkJjTzfTAB01jy6W7VUViPfOdDf7dx9I",
        language: "it-IT",
        limit: 5,
        countrySet: 'IT',
        idxSet: 'Geo,PAD,Addr,Str,XStr',
      }
    }

    // creo tom tom searchbox e la appendo in  pagina
    const ttSearchBox = new tt.plugins.SearchBox(tt.services, options)
    const searchBoxHTML = ttSearchBox.getSearchBoxHTML()
    const searchBoxEl = document.querySelector('#tomtom-searchbox');
    searchBoxEl.append(searchBoxHTML)

    // recupero input, input container e feedback della search box
    const searchBoxInputContainer = document.querySelector('.tt-search-box-input-container');
    const searchBoxInput = document.querySelector('input.tt-search-box-input');
    const searchBoxFeedbackEl = document.querySelector('#search-box-feedback');

    // stilizzo search box
    const searchBoxContainer = document.querySelector('.tt-search-box');
    searchBoxContainer.style.marginTop = 0;

    // recupero input nascosti
    const addressInput = document.querySelector('#tomtom-searchbox-address');
    const latInput = document.querySelector('#tomtom-searchbox-lat');
    const lngInput = document.querySelector('#tomtom-searchbox-lng');

    // inizializzo il valore dell'input
    searchBoxInput.value = addressInput.value;

    // recupero il bottone per il submit
    const subBtn = document.querySelector('button[type="submit"]');

    // popolo l'indirizzo alla selezione di un indirizzo
    ttSearchBox.on("tomtom.searchbox.resultselected", fillAddress)

    // svuoto l'indirizzo al clear dell'input
    ttSearchBox.on("tomtom.searchbox.resultscleared", clearAddress)

    // svuoto l'indirizzo all'input della search box
    searchBoxInput.addEventListener('input', clearAddress);

    // Invio il form solo se l'indirizzo è popolato
    subBtn.addEventListener('click', handleSubmitClick);
  </script>
@endpush
