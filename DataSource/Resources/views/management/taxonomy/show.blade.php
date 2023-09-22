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
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Title {{ucwords($locale)}}</label>
                                            <input type="text" class="form-control" name="title-{{$locale}}" value="{{old('title-'.$locale,$item->translateOrDefault($locale)->title)}}" placeholder="Enter Title {{ucwords($locale)}}">
                                        </div>
                                    </div>

                                    @endforeach

                                </div>

                                <hr />
                                <div class="row">


                                    @foreach(localeSupported() as $locale)
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Desc {{ucwords($locale)}}</label>
                                            <textarea type="text" class="form-control" name="desc-{{$locale}}" placeholder="Enter Desc {{ucwords($locale)}}">{{old('desc-'.$locale,$item->translateOrDefault($locale)->desc)}}</textarea>
                                        </div>
                                    </div>

                                    @endforeach
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