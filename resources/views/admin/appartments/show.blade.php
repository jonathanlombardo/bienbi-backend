@extends('layouts.main')

@section('maincontent')

        <div class="container">
          <h1 class="my-3">{{$appartment->title}}</h1>
            <div class="row g-3">

                <div class="my-card d-flex">
                    <div class="my-card-header p-3">
                        <div class="image-container ">
                            <img src="{{asset($appartment->image)}}" alt="">
                        </div>

                    </div>

                    <div class="my-card-body p-3">

                        <ul>
                            <li>
                                <strong>Stanze</strong>
                                <div>{{$appartment->rooms>1 ? $appartment->rooms : 'Una'}} {{$appartment->rooms>1 ? ' stanze' : ' stanza'}}</div>
                            </li>
                            <li>
                                <strong>Letti</strong>
                                <div>{{$appartment->beds>1 ? $appartment->beds : 'Un'}} {{$appartment->beds>1 ? ' letti' : ' letto'}}</div>
                            </li>
                            <li>
                                <strong>Bagni</strong>
                                <div>{{$appartment->bathrooms>1 ? $appartment->bathrooms : 'Un'}} {{$appartment->bathrooms>1 ? ' bagni' : ' bagno'}}</div>
                            </li>
                            <li>
                                <strong>Metri Quadri</strong>
                                <div>{{$appartment->square_meters}} m2</div>
                            </li>
                            <li>
                                <strong>Indirizzo</strong>
                                <div>{{$appartment->address}}</div>
                            </li>
                            <li>
                                <strong>{{$appartment->published ? 'Gli utenti possono vedere questo appartamento' : 'Gli utenti non possono vedere questo appartamento'}}</strong>
                            </li>
                            <li class="d-flex align-items-end">

                                <div class="messages">
                                  <a class="nav-link nav_link" href="{{route('admin.messages.index',['appartment_slug' => $appartment->slug])}}">Vedi messaggi</a>
                                </div>

                            </li>
                        </ul>

                    </div>
                </div>

            </div>
            
        </div>
@endsection

<style lang="scss" scoped>

.my-col{
  padding: 20px;
  border-radius: 10px;

}

.my-card-link{
    color: black;
    text-decoration: none;
  }


  .my-card{
    .title{
      font-size: 1rem,
      font-weight: 500,
    }

    li{
        margin: 10px 0;
    }

    li:last-child{
        height: 150px;
    }
  }


  .image-container{
    border-radius: 10px;
    overflow: hidden;
  }

</style>