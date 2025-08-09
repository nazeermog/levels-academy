@extends('datasource::management.layout.master')

@section('content')
@if($taxonomies->count()>0)
@if($instructors->count()>0)

<div class="container py-5">
    <form id="form-course" method="POST" action="{{route('admin.courseContent.store')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="boxArr" id="boxArr">

        <div class="row">
            <label>Add Course </label>
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
                <label for="">Slug {{ ucwords($locale) }}</label>
                <input class="form-control" name="slug-{{ $locale }}" id="slug-{{ $locale }}">
            </div>
            @endforeach
        </div>
        <div class="row">
            @foreach (localeSupported() as $locale)
            <div class="col-md-3 m-1">
                <label for="">Description {{ ucwords($locale) }}</label>
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
            @php
            $options = [
            'en' => ['Beginner', 'Intermediate', 'Expert'],
            'ar' => ['مبتدئ', 'متوسط', 'خبير'],
            'de' => ['Anfänger', 'Mittelstufe', 'Experte'],
            ];
            @endphp

            @foreach (localeSupported() as $locale)
            <div class="col-md-3 m-1">
                <label for="Level">{{ ucfirst($locale) }} Level</label>
                <select class="form-select" data-locale="{{ $locale }}" name="level-{{ $locale }}" id="level-{{ $locale }}">
                    @foreach ($options[$locale] as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            @endforeach

        </div>

        <div class="row">
            <div class="col-md-3 my-3 m-1">
                <label for="price">Price</label>
                <input class="form-control" type="number" name="price" id="price">
            </div>
            <div class="col-md-3 my-3 m-1">
                <label for="payment_type">Payment Type</label>
                <select class="form-control" name="payment_type" id="payment_type">
                    <option value="once">Once</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>
            <div class="col-md-3 my-3 m-1">
                <label for="taxonomy">Category</label>
                <select class="form-select" name="taxonomy_id">
                    @foreach($taxonomies as $taxonomy)
                    <option value="{{ $taxonomy->id }}">{{ $taxonomy->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 my-3 m-1">
                <label for="instructor">Instructor</label>
                <select class="form-select" name="instructor_id">
                    @foreach($instructors as $instructor)
                    <option value="{{ $instructor->user_id }}">{{ $instructor->first_name .' '.$instructor->last_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 my-3 m-1">
                <label for="photo">Photo</label>
                <input class="form-control-file" type="file" name="photo" id="photo">
            </div>
        </div>


        <hr />
        <div class="row">

            <label>Steps Course Content</label>
        </div>


        @include('datasource::management.courseContent.partials.steps')

        <hr />

        <div class="row">
            <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
        </div>


    </form>



</div>
@else <div class="card border-top border-0 border-4 border-primary table-responsive">

    <div class="card-header">
        <h3 class="card-title float-left">You should have some instructors first.</h3>
        <a href="{{route('admin.instructors.create')}}"
            class="btn btn-primary float-right">+ Add New</a>


    </div>

    @endif
    @else <div class="card border-top border-0 border-4 border-primary table-responsive">

        <div class="card-header">
            <h3 class="card-title float-left">You should have some categories first.</h3>
            <a href="{{route('admin.taxonomies.create')}}"
                class="btn btn-primary float-right">+ Add New</a>


        </div>

        @endif
        @endsection



        {{-- <head> --}}

        {{-- <title>Course Content</title> --}}
        {{-- --}}
        {{-- </head> --}}