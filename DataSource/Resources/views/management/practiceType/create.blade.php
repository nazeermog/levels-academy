@extends('datasource::management.layout.master')

@section('content')
    <div class="container py-5">
        <div class="row">
            <label>Add Practice Level</label>
        </div>
        <hr/>
        <form action="{{route('admin.practicesType.store')}}" method="POST">
            @csrf
            <div class="row">
                @foreach(localeSupported() as $locale)
                    <div class="col-md-4 ">
                        <label for="">Title {{ucwords($locale)}}</label>
                        <input class="form-control" name="title-{{$locale}}">
                    </div>
                @endforeach
            </div>
            <hr/>
            <div class="row">

                <div class="col-md-6 ">
                    <label for="">seconds speed </label>
                    <input class="form-control" name="seconds_speed">
                </div>
                <div class="col-md-6 ">
                    <label for="">card number </label>
                    <input class="form-control" name="card_number">
                </div>


            </div>
            <div class="row">
                <div class="col-md-6 ">
                    <label for="">range number from </label>
                    <input class="form-control" name="range_number_from">
                </div>
                <div class="col-md-6 ">
                    <label for="">range number to </label>
                    <input class="form-control" name="range_number_to">
                </div>
            </div>
            <hr/>
            <div class="row">
                <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
            </div>
        </form>
    </div>
@endsection





