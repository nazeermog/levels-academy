@extends('datasource::management.layout.master')

@section('content')
@if($taxonomies->count()>0)
    <div class="container py-5">
        <form id="form-course" method="POST" action="{{route('admin.courseContent.store')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="boxArr" id="boxArr">

            <div class="row">
                <label>Add Course </label>
            </div>
            <hr/>
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
                <label for="price">Price</label>
                  <input class="form-control" type="number" name="price" id="price">
                </div>
                <div class="col-md-4 mt-3">
                <select class="btn btn-outline my-3 col-12" name="taxonomy_id" style="background-color: transparent; border: 1px solid #ced4da; border-radius: 0; ">
                                @foreach($taxonomies as $taxonomy)
                                  <option value="{{ $taxonomy->id }}">{{ $taxonomy->title }}</option>
                                @endforeach
                </select>
                </div>
                <div class="col-md-4 m-1">
                <label for="photo">Photo</label>
                  <input class="form-control" type="file" name="photo" id="photo">
                </div>  
            </div>
            <hr/>
            <div class="row">
          
            <label>Steps Course Content</label>
        </div>


        @include('datasource::management.courseContent.partials.steps')

                <hr/>

                <div class="row">
                    <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
                </div>


        </form>


 
    </div>
    @else <div class="card border-top border-0 border-4 border-primary table-responsive">

<div class="card-header">
    <h3 class="card-title float-left">You should have some categories first.</h3>
    <a href="{{route('admin.taxonomies.create')}}"
       class="btn btn-primary float-right">+ Add New</a>
   
     
    </div>

@endif

@endsection



{{-- <head> --}}

{{--    <title>Course Content</title> --}}
{{--   --}}
{{-- </head> --}}
