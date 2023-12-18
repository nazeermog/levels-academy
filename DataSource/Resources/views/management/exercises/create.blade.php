@extends('datasource::management.layout.master')

@section('content')
<div class="container py-5">
    <div class="row">
        <label>Add Exercise</label>
    </div>
    <hr />
    <form action="{{route('admin.exercises.store')}}" method="POST">
        @csrf

        <div class="row">
            @foreach(localeSupported() as $locale)
            <div class="col-md-4 ">
                <label for="">Title {{ucwords($locale)}}</label>
                <input class="form-control" name="title-{{$locale}}">
            </div>
            @endforeach
        </div>
        <hr />
        <div class="row">

            <div class="col-md-4">
                <label for="">Practice</label>
                <select class="form-control" name="practice_id">
                    @foreach($practices as $practice)
                    <option value="{{$practice->id}}">{{$practice->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="numbers">Numbers</label>
                    <input type="text" class="form-control" name="numbers" id="numbers">
                    <small class="form-text text-muted">Enter numbers separated by commas (1, 2, 3, 4).</small>
                </div>
                <div class="col-md-4 ">
                    <label for="">Column Count (for abacus)</label>
                    <input class="form-control" name="col_count">
                </div>
                <div class="col-md-4 ">
                    <label for="">Code to call by</label>
                    <input class="form-control" name="code">
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
        </div>
    </form>
</div>


@endsection