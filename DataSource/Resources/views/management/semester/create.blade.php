@extends('datasource::management.layout.master')

@section('content')
<div class="container py-5">
    <form id="form-course" method="POST" action="{{route('admin.semesters.store')}}">
        @csrf

        <div class="row">
            <label>Add semester </label>
        </div>
        <hr />
        <div class="row">
            @foreach (localeSupported() as $locale)
            <div class="col-md-3 m-1">
                <label for="">Title {{ ucwords($locale) }}</label>
                <input class="form-control" name="title-{{ $locale }}" id="title-{{ $locale }}">
            </div>
            @endforeach
        </div>
        <div class="row">
            @foreach (localeSupported() as $locale)
            <div class="col-md-3 m-1">
                <label for="">Desc {{ ucwords($locale) }}</label>
                <textarea class="form-control" name="desc-{{ $locale }}" id="desc-{{ $locale }}"></textarea>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-3 mt-3">
                <label for="start_date">Start Date</label>
                <input class="form-select col-12" type="date" name="start_date" id="start_date">
            </div>

            <div class="col-md-3 mt-3">
                <label for="end_date">End Date</label>
                <input class="form-select col-12" type="date" name="end_date" id="end_date">
            </div>
        
        </div>

        <hr />

        <div class="row">
            <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
        </div>


    </form>



</div>


    @endsection



    {{-- <head> --}}
    {{-- <title> Semester </title> --}}
    {{-- --}}
    {{-- </head> --}}