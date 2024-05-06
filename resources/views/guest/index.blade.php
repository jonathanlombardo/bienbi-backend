@extends('layouts.main')


@section('maincontent')
  <div class="container">
      <div class="d-flex flex-column align-items-center mb-5">
          <h1>Bien-Bì</h1>
          <h2>Bed and Breakfast</h2>
      </div>
      <div class="row">
        <div class="col d-flex flex-column justify-content-center">
          <div class="buttons-wrapper d-flex justify-content-center">

            {{-- link per login --}}
            <a class="nav_link" href="{{ route('login') }}">
              <div class="button d-flex justify-content-center align-items-center">
                <span>Login</span>
              </div>
            </a>
            {{-- link per la registrazione --}}
            <a class="nav_link" href="{{ route('register') }}">
              <div class="button d-flex justify-content-center align-items-center">
                <span>Registrati</span>
              </div>
            </a>
          </div>
        </div>
      </div>
  </div>
@endsection

<style lang="scss" scoped>

.button{
  width: 200px;
  aspect-ratio: 1;
  background-color: #FABC20;
  margin: 0 20px;
  border-radius: 10px;
  transition: transform 0.5s;

  color: white;
  span{
    font-size: 1.5rem;
  }
}

.button:hover{
    transform: scale(1.1);
    opacity: 0.9;
    box-shadow: 2px 3px 12px  rgb(205, 45, 24);
    background: linear-gradient(90deg, rgba(233,214,171,1) 10%, rgba(255,179,14,1) 48%, rgba(243,78,57,1) 97%);
  }


@-webkit-keyframes rotate {
    from {-webkit-transform: rotate(0deg);}
    to {-webkit-transform: rotate(360deg);}
}

@-moz-keyframes rotate {
    from {-moz-transform: rotate(0deg);}
    to {-moz-transform: rotate(360deg);}
}

@keyframes rotate {
    from {transform: rotate(0deg);}
    to {transform: rotate(360deg);}
}


/* Rest of page style*/
body{
  background:#FABC20;
  font-family: 'Open Sans', sans-serif;
  -webkit-font-smoothing: antialiased;
  color:#393D3D;
}



</style>