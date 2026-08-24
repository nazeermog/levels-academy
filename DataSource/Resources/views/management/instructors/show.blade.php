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
                        <form class="card" action="{{route('admin.'.$route_name.'.update',$item->id)}}" id="form-about" enctype="multipart/form-data" method="POST">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="card-header">
                                <h3 class="card-title">Update {{$table_name}}</h3>
                            </div>
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" value="{{$item->id}}" name="model_id">

                            <div class="row">
                                @foreach (localeSupported() as $locale)
                                <div class="col-md-3 m-1">
                                    <label for="">Spec {{ ucwords($locale) }}</label>
                                    <input type="text" class="form-control" name="spec-{{$locale}}" value="{{ old('spec-'.$locale, optional($item->translateOrDefault($locale))->spec) }}" placeholder="Enter Spec {{ucwords($locale)}}">
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                @foreach (localeSupported() as $locale)
                                <div class="col-md-3 m-1">
                                    <label for="">About {{ ucwords($locale) }}</label>
                                    <input type="text" class="form-control" name="about-{{$locale}}" value="{{ old('about-'.$locale, optional($item->translateOrDefault($locale))->about) }}" placeholder="Enter About {{ucwords($locale)}}">
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                @foreach (localeSupported() as $locale)
                                <div class="col-md-3 m-1">
                                    <label for="">Country {{ ucwords($locale) }}</label>
                                    <input type="text" class="form-control" name="country-{{$locale}}" value="{{ old('country-'.$locale, optional($item->translateOrDefault($locale))->country) }}" placeholder="Enter Country {{ucwords($locale)}}">
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-3 m-1">
                                    <label for="user">User</label>
                                    <select class="form-control" name="user_id">
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if ($item->user_id==$user->id)
                                            selected
                                            @endif>
                                            {{ $user->first_name.' '.$user->last_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 m-1">
                                    <label for="organization_id">Organization</label>
                                    <select class="form-control" name="organization_id" id="organization_id">
                                        <option value="">Select organization</option>
                                        @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}" {{ optional($item->user)->organization_id == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 m-1">
                                    <label for="avatar">avatar</label>
                                    <input type="file" class="form-control-file" name="avatar" value="{{$item->avatar}}">
                                </div>
                                @if($item->avatar)
                                <div>
                                    <img src="{{ $item->avatar }}" alt="Current avatar" style="max-width: 100px;">
                                </div>
                                @endif
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