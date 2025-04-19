@extends('datasource::management.layout.master')

@section('content')
<div class="container py-5">
<form id="form-course" action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
      <label>Add student </label>
    </div>
    <hr />
    <div class="row">
      <div class="col-md-3 my-3 m-1">
        <label for="First_name"> First_name</label>
        <input class="form-control" type="text" name="first_name">
      </div>

      <div class="col-md-3 my-3 m-1">
        <label for="Last_name"> Last_name</label>
        <input class="form-control" type="text" name="last_name">
      </div>
    </div>

    <div class="row">
      <div class="col-md-3 my-3 m-1">
        <label for="city">City</label>
        <input class="form-control" type="text" name="city" id="city">
      </div>

      <div class="col-md-3 my-3 m-1">
        <label for="country">Country</label>
        <input class="form-control" type="text" name="country" id="country">
      </div>

      <div class="col-md-3 my-3 m-1">
        <label for="avatar">Avatar</label>
        <input class="form-control" type="file" name="avatar" id="avatar">
      </div>
    </div>

    <div class="row">
      <div class="col-md-3 my-3 m-1">
        <label for="email">Email</label>
        <input class="form-control" type="email" name="email">
      </div>

      <div class="col-md-3 my-3 m-1">
        <label for="password">Password</label>
        <input class="form-control" type="password" name="password">
      </div>
    </div>




    <hr />

    <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>


  </form>



</div>

@endsection



{{-- <head> --}}

{{-- <title>Parentt</title> --}}
{{-- --}}
{{-- </head> --}}