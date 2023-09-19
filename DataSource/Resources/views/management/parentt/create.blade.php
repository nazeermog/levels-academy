@extends('datasource::management.layout.master')

@section('content')
<div class="container py-5">
  <form id="form-course" method="POST" action="{{route('admin.parentts.store')}}">
    @csrf

    <div class="row">
      <label>Add Parent </label>
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
        <label for="password">Email</label>
        <input class="form-control" type="email" name="email">
      </div>

      <div class="col-md-3 my-3 m-1">
        <label for="password">Password</label>
        <input class="form-control" type="password" name="password">
      </div>
    </div>

    <div class="col-md-3 m-1">
      <label for="student">Students</label>
      <select class="form-control" name="student_id[]" multiple>
        @foreach($students as $student)
        <option value="{{ $student->user_id }}">{{ $student->first_name.' '.$student->last_name }}</option>
        @endforeach
      </select>
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