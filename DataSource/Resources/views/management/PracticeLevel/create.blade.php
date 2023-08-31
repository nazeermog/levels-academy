@extends('datasource::management.layout.master')

@section('content')
    <div class="container py-5">
        <form id="form-course" method="POST" action="{{route('admin.Practiceslevels.store')}}" enctype="multipart/form-data">
        @csrf

            <div class="row">
                <label>Add level </label>
            </div>
            <hr/>
            <div class="row">
                @foreach (localeSupported() as $locale)
                    <div class="col-md-3 m-1">
                        <label for="">title {{ ucwords($locale) }}</label>
                        <input class="form-control" name="title-{{ $locale }}" id="title-{{ $locale }}">
                    </div>
                @endforeach
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
