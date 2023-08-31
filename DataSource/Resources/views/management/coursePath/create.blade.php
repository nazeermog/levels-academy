@extends('datasource::management.layout.master')

@section('content')
@if($taxonomies->count()>0)
<div class="container py-5">
    <form id="form-course" method="POST" action="{{route('admin.coursePath.store')}}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <label>Add Path </label>
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
                <input class="form-control" name="desc-{{ $locale }}" id="desc-{{ $locale }}">
            </div>
            @endforeach
        </div>
        <div class="row">
            @foreach (localeSupported() as $locale)
            <div class="col-md-3 m-1">
                <label for="">About {{ ucwords($locale) }}</label>
                <textarea class="form-control" name="about-{{ $locale }}" id="about-{{ $locale }}"></textarea>
            </div>
            @endforeach
        </div>
        <div class="row">
            @foreach (localeSupported() as $locale)
            <div class="col-md-3 m-1">
                <label for="">Benefit {{ ucwords($locale) }}</label>
                <textarea class="form-control" name="benefit-{{ $locale }}" id="benefit-{{ $locale }}"></textarea>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-3 mt-3">
                <label for="taxonomies">Categories</label>
                <select class="btn btn-outline col-12" name="taxonomy_id" style="background-color: transparent; border: 1px solid #ced4da; border-radius: 0; ">
                    @foreach($taxonomies as $taxonomy)
                    <option value="{{ $taxonomy->id }}">{{ $taxonomy->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mt-3">
                <label for="photo">Photo</label>
                <input class="form-select col-12" type="file" name="photo" id="photo">
            </div>
        </div>
        <div class="form-group">
            <label for="courses">Select Courses:</label>
            <div class="form-check">
                @php
                $index = 1;
                @endphp

                @foreach ($courses as $course)
                <div class="row mb-2">
                    <div>
                        <span class="badge bg-primary">{{ $index }}</span>
                    </div>
                    <div class="col-md-9">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="course_id[{{ $index }}]" value="{{ $course->id }}" id="course_{{ $course->id }}">
                            <label class="form-check-label" for="course_{{ $course->id }}">{{ $course->title }}</label>
                        </div>
                    </div>
                </div>
                <div hidden>{{$index++;}}</div>
                @endforeach
            </div>

        </div>





        <hr />

        <div class="row">
            <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
        </div>


    </form>



</div>
@else <div class="card border-top border-0 border-4 border-primary table-responsive">

    <div class="card-header">
        <h3 class="card-title float-left">You should have some categories first.</h3>
        <a href="{{route('admin.taxonomies.create')}}" class="btn btn-primary float-right">+ Add New</a>


    </div>

    @endif

    @endsection



    {{-- <head> --}}

    {{-- <title>Course Content</title> --}}
    {{-- --}}
    {{-- </head> --}}