<div id="tomtom-searchbox-wrapper">
  <div id="tomtom-searchbox">
    <input type="text" name="address" id="tomtom-searchbox-address" class="d-none" value="{{ $appartment->id ? htmlspecialchars($appartment->address) : '' }}">
    <input type="number" name="lng" id="tomtom-searchbox-lng" class="d-none" step="any" value="{{ $appartment->id ? $appartment->lng : '' }}">
    <input type="number" name="lat" id="tomtom-searchbox-lat" class="d-none" step="any" value="{{ $appartment->id ? $appartment->lat : '' }}">
    <label for="tt-search-box-input" class="form-label">Indirizzo</label>
  </div>
  <div id="search-box-feedback" class="input-feedback d-none text-danger pt-1">Seleziona un indirizzo tra quelli suggeriti</div>
</div>

@push('assets')
  <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css" />
  <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js"></script>
  <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js"></script>
@endpush

@push('scripts')
  <script>
    // verifica se l'indirizzo è popolato
    function isAddressEmpty() {
      return !addressInput.value || !latInput.value || !lngInput.value;
    }

    // Svuota i campi relativi all'indirizzo
    function clearAddress() {
      if (!isAddressEmpty()) {
        addressInput.value = null;
        latInput.value = null;
        lngInput.value = null;
        console.log('address cleared');
      }
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
    function ttHandleSubmitClick(event) {
      if (isAddressEmpty()) {
        event.preventDefault();
        console.log(searchBoxInputContainer)

        // aggiungo classi d'errore
        searchBoxInputContainer.classList.add('border-danger');
        searchBoxFeedbackEl.classList.remove('d-none')
        searchBoxInput.scrollIntoView();

        return true;
      }
      return false;
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

    // setto un id per l'input della search box
    searchBoxInput.setAttribute('id', 'tt-search-box-input')

    // stilizzo search box
    const searchBoxContainer = document.querySelector('.tt-search-box');
    searchBoxContainer.style.marginTop = 0;

    // recupero input nascosti
    const addressInput = document.querySelector('#tomtom-searchbox-address');
    const latInput = document.querySelector('#tomtom-searchbox-lat');
    const lngInput = document.querySelector('#tomtom-searchbox-lng');

    // inizializzo il valore dell'input
    searchBoxInput.value = addressInput.value;


    // popolo l'indirizzo alla selezione di un indirizzo
    ttSearchBox.on("tomtom.searchbox.resultselected", fillAddress)

    // svuoto l'indirizzo al clear dell'input
    ttSearchBox.on("tomtom.searchbox.resultscleared", clearAddress)

    // svuoto l'indirizzo all'input della search box
    searchBoxInput.addEventListener('input', clearAddress);
  </script>
@endpush
