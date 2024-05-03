@extends('layouts.main')

@section('assets')
  <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css" />
  <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js"></script>
  <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js"></script>
@endsection

@section('maincontent')
  <div class="container">
    <h1>Crea un appartamento</h1>
    <form action="{{ route('admin.appartments.store') }}" method="POST" class="row">
      @csrf
      <div class="col-6">
        <div id="tomtom-searchbox"></div>
        <input type="text" name="address" id="address" class="d-none">
        <input type="number" name="lat" id="lat" class="d-none">
        <input type="number" name="lng" id="lng" class="d-none">
      </div>
      <div class="col-6">
        <button class="btn btn-primary">Go</button>
      </div>
    </form>

  </div>
  <script>
    // tomtom - searchbox
    const options = {
      searchOptions: {
        key: "GkJjTzfTAB01jy6W7VUViPfOdDf7dx9I",
        language: "it-IT",
        limit: 5,
      },
      autocompleteOptions: {
        key: "GkJjTzfTAB01jy6W7VUViPfOdDf7dx9I",
        language: "it-IT",
      },
    }
    const ttSearchBox = new tt.plugins.SearchBox(tt.services, options)
    const searchBoxHTML = ttSearchBox.getSearchBoxHTML()
    const searchBoxEl = document.querySelector('#tomtom-searchbox');
    searchBoxEl.append(searchBoxHTML)

    let clock;

    const searchBoxInput = document.querySelector('input.tt-search-box-input');
    searchBoxInput.addEventListener('input', function() {
      clearTimeout(clock);

      clock = setTimeout(() => {
        const query = searchBoxInput.value;
        axios.get(`https://api.tomtom.com/search/2/search/${query}.json?key=GkJjTzfTAB01jy6W7VUViPfOdDf7dx9I&typeahead=true&countrySet=IT&language=it-IT&idxSet=Geo,PAD,Addr,Str,XStr`).then((res) => {
          console.log(res.data);
        })
      }, 500);

    })
    // searchBoxInput.setAttribute('name', 'tt')
  </script>
@endsection


{{-- 
<!DOCTYPE html>
<html class="use-all-space">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
  <title>SearchBox</title>

</head>

<body>
  <script></script>
</body>

</html> --}}
