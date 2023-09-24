@extends('datasource::management.layout.master')

@section('content')

<div class="page-wrapper">
    <div class="page-content">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update {{$table_name}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href=#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.'.$route_name.'.index')}}"> {{$table_name}}</a></li>

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
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" value="{{$item->id}}" name="model_id">
                            <div class="card-header">
                                <h3 class="card-title">Update {{$table_name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach(localeSupported() as $locale)
                                    <div class="col-md-4 ">
                                        <label for="">Title {{ucwords($locale)}}</label>
                                        <input type="text" class="form-control" name="title-{{$locale}}" value="{{old('title-'.$locale,$item->translateOrDefault($locale)->title)}}" placeholder="Enter Title {{ucwords($locale)}}">
                                    </div>
                                    @endforeach
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Practice</label>
                                        <select class="form-control" name="practice_id">
                                            @foreach ($practices as $practice)
                                            <option value="{{ $practice->id }}" 
                                            @if ($item->practice_id==$practice->id) 
                                            selected 
                                            @endif>
                                                {{ $practice->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Levels</label>
                                        <select class="form-control" name="level_id">
                                            @foreach ($practiceLevels as $level)
                                            <option value="{{ $level->id }}" 
                                            @if ($item->level_id==$level->id) 
                                            selected 
                                            @endif>
                                                {{ $level->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 ">
                                        <label for="">Coins Taken</label>
                                        <input class="form-control" name="coins_taken" value="{{$item->coins_taken}}">
                                    </div>

                                </div>
                                <hr />

                                <div class="row">

                                    <div class="col-md-6 ">
                                        <label for="">seconds speed (for number_sum & math game(1)) </label>
                                        <input class="form-control" name="seconds_speed" value="{{$item->seconds_speed}}">
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="">card number (for number_sum)</label>
                                        <input class="form-control" name="card_number" value="{{$item->card_number}}">
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <label for="">range number from </label>
                                        <input class="form-control" name="range_number_from" value="{{$item->range_number_from}}">
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="">range number to </label>
                                        <input class="form-control" name="range_number_to" value="{{$item->range_number_to}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <label for="">Column Count (for abacus)</label>
                                        <input class="form-control" name="col_count" value="{{$item->col_count}}">
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="">numbers To Sum (for abacus & math game)</label>
                                        <input class="form-control" name="numbers_to_sum" value="{{$item->numbers_to_sum}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 ">
                                        <label for="">Timer (for math games)</label>
                                        <input class="form-control" name="timer" value="{{$item->timer}}">
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="">Turns (for math games)</label>
                                        <input class="form-control" name="turns" value="{{$item->turns}}">
                                    </div>
                                </div>
                                <hr />
                            </div>


                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submit-form">Submit</button>
                            </div>
                            <!-- /.card-footer-->
                        </form>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection