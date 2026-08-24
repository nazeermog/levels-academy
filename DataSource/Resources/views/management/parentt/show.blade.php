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
                        <form class="card" action="{{route('admin.'.$route_name.'.update',$item->user_id)}}" id="form-about" enctype="multipart/form-data" method="POST">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="card-header">
                                <h3 class="card-title">Update {{$table_name}}</h3>
                            </div>
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" value="{{$item->user_id}}" name="model_id">

                            <div class="row">
                                <div class="col-md-3 my-3 m-1">
                                    <label for="First_name"> First_name</label>
                                    <input class="form-control" type="text" name="first_name" value="{{$item->first_name}}">
                                </div>

                                <div class="col-md-3 my-3 m-1">
                                    <label for="Last_name"> Last_name</label>
                                    <input class="form-control" type="text" name="last_name" value="{{$item->last_name}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 my-3 m-1">
                                    <label for="password">Email</label>
                                    <input class="form-control" type="email" name="email" value="{{$item->user->email}}">
                                </div>

                                <div class="col-md-3 my-3 m-1">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="same old password, but you can change it.">
                                </div>

                                <div class="col-md-3 my-3 m-1">
                                    <label for="organization_id">Organization</label>
                                    <select class="form-control" name="organization_id" id="organization_id">
                                        <option value="">Select organization</option>
                                        @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}" {{ optional($item->user)->organization_id == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 m-1">
                                <label for="student">Students</label>

                                <select class="form-control" name="student_id[]" multiple>
                                    @foreach ($students as $student)
                                    <option value="{{ $student->user_id }}"
                                        @foreach ($item->students as $oldStudent)
                                        @if ($student->user_id == $oldStudent->user_id)
                                        selected
                                        @endif
                                        @endforeach>
                                        {{ $student->first_name.' '.$student->last_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <hr />

                            <div class="row">
                                <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
                            </div>


                        </form>

                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

@endsection