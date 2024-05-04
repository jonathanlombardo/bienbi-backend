@extends('layouts.main')

@section('maincontent')

        <div class="container">
            <div class="row mt-5 g-3">
                @forelse($appartments as $appartment)

                <div class="col-4 mb-5">

                    <div class="my-card">

                        <div class="image-container">
                            <img src="{{asset($appartment->image)}}" alt="">
                        </div>

                        <div class="my-card-body">

                          <div class="title mt-3">
                            <span class="title">{{$appartment->title}}</span>
                          </div>
                          <div class="messages">
                            <a class="nav-link nav_link" href="{{route('admin.messages.index',['appartment_slug' => $appartment->slug])}}">Vedi messaggi</a>
                          </div>

                        </div>

                    </div>

                </div>
                
                @empty
                @endforelse
            </div>
            
        </div>
@endsection

<style lang="scss" scoped>

  .my-card{
    /* border: 0.1px solid rgb(205, 205, 205); */

  

    .title{
      font-size: 1rem,
      font-weight: 500,
    }
  }

  .image-container{
    border-radius: 10px;
    overflow: hidden;
  }

</style>