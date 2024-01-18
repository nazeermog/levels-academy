@extends('datasource::management.layout.master')
@section('content')
<div class="page-wrapper">
    <div class="page-content">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update {{ $table_name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href=#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.'.$route_name.'.index') }}">{{ $table_name }}</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->

                        <form class="card" action="{{route('admin.'.$route_name.'.update',$item->id)}}" id="form-about" enctype="multipart/form-data" method="POST">
                            @csrf
                            {{ method_field('PUT') }}

                            <div class="card-header">
                                <h3 class="card-title">Update {{ $table_name }}</h3>
                            </div>

                            <input type="hidden" value="{{ $item->id }}" name="model_id">

                            <div class="card-body">
                                <div class="row">
                                    @foreach (localeSupported() as $locale)
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Title {{ ucwords($locale) }}</label>
                                            <input type="text" class="form-control" name="title-{{ $locale }}" value="{{ old('title-'.$locale, $item->translateOrDefault($locale)->title) }}" placeholder="Enter Title {{ ucwords($locale) }}">
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
                                            <option value="{{ $practice->id }}" {{ $item->practice_id == $practice->id ? 'selected' : '' }}>{{ $practice->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="numbers">Numbers</label>
                                        <input type="text" class="form-control" name="numbers" id="numbers" value="{{ old('numbers', $item->numbers) }}">
                                        <small class="form-text text-muted">Enter numbers separated by commas (1, 2, 3, 4).</small>
                                    </div>
                                    <div class="col-md-4 ">
                                        <label for="">Column Count (for abacus)</label>
                                        <input class="form-control" name="col_count" value="{{ $item->col_count }}">
                                    </div>
                                    <div class="col-md-4 ">
                                        <label for="">Code to call by</label>
                                        <input class="form-control" name="code" value="{{ $item->code }}"> 
                                    </div>
                                    <div class="col-md-4 ">
                                        <label for="">Book_id</label>
                                        <input class="form-control" name="book_id" value="{{ $item->book_id }}">
                                    </div>
                                    <!-- Include other fields for updating here -->
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submit-form">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection