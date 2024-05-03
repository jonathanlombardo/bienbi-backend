@extends('layouts.main')


@section('maincontent')

    <div id="container">
        <div class="d-flex flex-column align-items-center justify-content-center mb-5">
            <h1>Bien-Bì</h1>
            <h2>Bed and Breakfast</h2>
        </div>

        <!--Element for spinner made with HTML + CSS-->
        <div id="html-spinner"></div>
  </div>
@endsection

<style lang="scss" scoped>
#html-spinner{
  width:40px;
  height:40px;
  border:4px solid #fcd779;
  border-top:4px solid white;
  border-radius:50%;
}

#html-spinner{
  -webkit-transition-property: -webkit-transform;
  -webkit-transition-duration: 1.2s;
  -webkit-animation-name: rotate;
  -webkit-animation-iteration-count: infinite;
  -webkit-animation-timing-function: linear;
  
  -moz-transition-property: -moz-transform;
  -moz-animation-name: rotate; 
  -moz-animation-duration: 1.2s; 
  -moz-animation-iteration-count: infinite;
  -moz-animation-timing-function: linear;
  
  transition-property: transform;
  animation-name: rotate; 
  animation-duration: 1.2s; 
  animation-iteration-count: infinite;
  animation-timing-function: linear;
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

#container{
  max-width:700px;
  margin:6rem auto;
  position:relative;
  display: flex;
  flex-direction: column;
  align-items: center;
}

</style>