@extends('datasource::management.layout.master')

@section('content')
    <div class="container py-5">
        <form id="form-course">
            <div class="row">
                <label>Add Course </label>
            </div>
            <hr />
            <div class="row">
                @foreach (localeSupported() as $locale)
                    <div class="col-md-4 m-1">
                        <label for="">Title {{ ucwords($locale) }}</label>
                        <input class="form-control" name="title-{{ $locale }}" id="title-{{ $locale }}">
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach (localeSupported() as $locale)
                    <div class="col-md-4 m-1">
                        <label for="">Slug {{ ucwords($locale) }}</label>
                        <input class="form-control" name="slug-{{ $locale }}" id="slug-{{ $locale }}">
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-4 m-1">
                    <label for="">Price </label>
                    <input class="form-control" name="price" id="price">
                </div>
            </div>
            <hr />
        </form>


        <div class="row">
            <label>Steps Course Content</label>
        </div>

        @include('datasource::management.courseContent.partials.steps')
        <hr />
        <div class="row">
            <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
        </div>
    </div>
@endsection



{{-- <head> --}}

{{--    <title>Course Content</title> --}}
{{--   --}}
{{-- </head> --}}
