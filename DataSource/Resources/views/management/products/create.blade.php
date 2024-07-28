@extends('datasource::management.layout.master')

@section('content')
<div class="container py-5">
    <form id="form-course" method="POST" action="{{route('admin.products.store')}}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <label>Add Product </label>
        </div>
        <hr />
        <div class="row">
            @foreach (localeSupported() as $locale)
            <div class="col-md-3 m-1">
                <label for="">Name {{ ucwords($locale) }}</label>
                <input class="form-control" name="name-{{ $locale }}" id="name-{{ $locale }}">
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
            <div class="col-md-3 m-1">
                <label for="categoryProducts">Categories</label>
                <select class="btn btn-outline col-12" name="category_product_id" style="background-color: transparent; border: 1px solid #ced4da; border-radius: 0; ">
                    @foreach($categoryProducts as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 m-1">
                <label for="price">Price</label>
                <input type="number" step="0.01" class="form-control" name="price" id="price">
            </div>
            <div class="col-md-3 m-1">
                <label for="unit">unit</label>
                <input type="text" class="form-control" name="unit" id="unit">
            </div>
        </div>
        <div class="col-md-3 m-1">
            <label for="photo">Photo</label>
            <input type="file" class="form-control" name="photo" id="photo">
        </div>
        <hr />

        <div class="row">
            <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
        </div>


    </form>



</div>


@endsection



{{-- <head> --}}

{{-- <title>Course Content</title> --}}
{{-- --}}
{{-- </head> --}}