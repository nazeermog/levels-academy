@extends('datasource::management.layout.master')

@section('content')
    <div class="container py-5">
        <form id="form-course" method="POST" action="{{route('admin.instructors.store')}}" enctype="multipart/form-data">
        @csrf

            <div class="row">
                <label>Add instructor </label>
            </div>
            <hr/>
            <div class="row">
                @foreach (localeSupported() as $locale)
                    <div class="col-md-3 m-1">
                        <label for="">Spec {{ ucwords($locale) }}</label>
                        <input class="form-control" name="spec-{{ $locale }}" id="spec-{{ $locale }}">
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach (localeSupported() as $locale)
                    <div class="col-md-3 m-1">
                        <label for="">About {{ ucwords($locale) }}</label>
                        <input class="form-control" name="about-{{ $locale }}" id="about-{{ $locale }}">
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach (localeSupported() as $locale)
                    <div class="col-md-3 m-1">
                        <label for="">Country {{ ucwords($locale) }}</label>
                        <input class="form-control" name="country-{{ $locale }}" id="country-{{ $locale }}">
                    </div>
                @endforeach
            </div>
            <div class="row">
            <div class="col-md-3 m-1">
            <label for="user">User</label>
            <select class="form-control" name="user_id">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->first_name.' '.$user->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 m-1">
            <label for="avatar">avatar</label>
            <input class="form-control-file" type="file" name="avatar" id="avatar">
        </div>   
        </div>
                <hr/>

                <div class="row">
                    <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
                </div>


        </form>


 
    </div>
 



@endsection



{{-- <head> --}}

{{--    <title>Course Content</title> --}}
{{--   --}}
{{-- </head> --}}
