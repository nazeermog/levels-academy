@extends('datasource::management.layout.master')

@section('content')
    <div class="container py-5">
        <div class="row">
            <label>Add {{$table_name}} </label>
        </div>
        <hr/>
        <form action="{{route('admin.'.$route_name.'.store')}}" method="POST">
            @csrf
            <div class="row">
                @foreach(localeSupported() as $locale)
                    <div class="col-md-3 m-1">
                        <label for="">Title {{ucwords($locale)}}</label>
                        <input class="form-control" name="title-{{$locale}}">
                    </div>
                @endforeach
            </div>
            <hr/>
            <div class="row">


                @foreach(localeSupported() as $locale)
                    <div class="col-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Desc {{ucwords($locale)}}</label>
                            <textarea type="text" class="form-control"
                                      name="desc-{{$locale}}"
                                      placeholder="Enter Desc {{ucwords($locale)}}"></textarea>
                        </div>
                    </div>

                @endforeach
            </div>

            <div class="row">
                <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
            </div>
        </form>
    </div>
@endsection





