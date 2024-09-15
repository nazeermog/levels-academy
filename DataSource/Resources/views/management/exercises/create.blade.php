@extends('datasource::management.layout.master')
@section('content')
<div class="page-wrapper">
    <div class="page-content">

        <div class="row">
            <label>Add Exercise</label>
        </div>
        <hr />


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <form action="{{route('admin.exercises.store')}}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    @foreach (localeSupported() as $locale)
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Title {{ ucwords($locale) }}</label>
                                            <input type="text" class="form-control" name="title-{{ $locale }}" placeholder="Enter Title {{ ucwords($locale) }}">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Include relevant fields for updating here -->

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Practice</label>
                                        <select class="form-control" name="practice_id">
                                            @foreach($practices as $practice)
                                            <option value="{{$practice->id}}">{{$practice->title}}</option>                                            @endforeach
                                        </select>
                                    </div>
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
                                    <div class="col-md-4 ">
                                        <label for="">Book_id</label>
                                        <input class="form-control" name="book_id">
                                    </div>
                                    <div class="col-md-4 ">
                                        <label for="">Page</label>
                                        <input class="form-control" name="page">
                                    </div><div class="col-md-4 ">
                                        <label for="">row</label>
                                        <input class="form-control" name="row">
                                    </div>
                                    <!-- Include other fields for updating here -->
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection