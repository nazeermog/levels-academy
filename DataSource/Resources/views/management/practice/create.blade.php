@extends('datasource::management.layout.master')

@section('content')
    <div class="container py-5">
        <div class="row">
            <label>Add Practice </label>
        </div>
        <hr/>
        <form action="{{route('admin.practices.store')}}" method="POST">
            @csrf
            <div class="row">
                @foreach(localeSupported() as $locale)
                    <div class="col-md-4 m-1">
                        <label for="">Title {{ucwords($locale)}}</label>
                        <input class="form-control" name="title-{{$locale}}">
                    </div>
                @endforeach
            </div>
            <hr/>


            <div class="row">
                <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
            </div>
        </form>
    </div>
@endsection





