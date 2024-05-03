@extends('layouts.main')

@section('maincontent')
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Label</th>
                        </tr>
    
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                        <tr>
                            <td>{{$service->id}}</td>
    
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon_container pe-2 text-center">
                                        <i class="{{config('service_icon_class')[$service->label]}}"></i>
                                    </div>  
                                    <div>
                                        {{$service->label}}
                                    </div>
                                </div>
                            </td>
                                    


                        </tr>
                        @empty 
                        @endforelse
                    </tbody>
                </table>

                {{$services->links()}}


            </div>
        </div>
    </div>
@endsection

<style lang="scss" scoped>

    .icon_container {
        width: 40px;
    }

</style>