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
                                    <label for="">Title {{ ucwords($locale) }}</label>
                                    <input type="text" class="form-control" name="title-{{$locale}}" value="{{old('title-'.$locale,$item->translateOrDefault($locale)->title)}}" placeholder="Enter Title {{ucwords($locale)}}">
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                @foreach (localeSupported() as $locale)
                                <div class="col-md-3 m-1">
                                    <label for="">Desc {{ ucwords($locale) }}</label>
                                    <input type="text" class="form-control" name="desc-{{$locale}}" value="{{old('desc-'.$locale,$item->translateOrDefault($locale)->desc)}}" placeholder="Enter Desc {{ucwords($locale)}}">
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                @foreach (localeSupported() as $locale)
                                <div class="col-md-3 m-1">
                                    <label for="">About {{ ucwords($locale) }}</label>
                                    <input type="text" class="form-control" name="about-{{$locale}}" value="{{old('about-'.$locale,$item->translateOrDefault($locale)->about)}}" placeholder="Enter About {{ucwords($locale)}}">
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                @foreach (localeSupported() as $locale)
                                <div class="col-md-3 m-1">
                                    <label for="">Benefit {{ ucwords($locale) }}</label>
                                    <textarea class="form-control" name="benefit-{{ $locale }}" id="benefit-{{ $locale }}">{{old('benefit-'.$locale,$item->translateOrDefault($locale)->benefit)}}</textarea>
                                </div>
                                @endforeach
                            </div>

                            <div class="row">
                                <div class="col-md-3 mt-3">
                                    <label for="taxonomies">Categories</label>
                                    <select class="btn btn-outline col-12" name="taxonomy_id" style="background-color: transparent; border: 1px solid #ced4da; border-radius: 0; ">
                                        @foreach($taxonomies as $taxonomy)
                                        <option value="{{ $taxonomy->id }}" @if ($item->taxonomy_id==$taxonomy->id )
                                            selected
                                            @endif>
                                            {{ $taxonomy->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <label for="photo">Photo</label>
                                    <input type="file" class="form-control-file" name="photo" value="{{$item->photo}}">
                                    @if($item->photo)
                                    <div class="m-2">
                                        <img src="{{ $item->photo }}" alt="Current Photo" style="max-width: 100px;">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="courses">Select Courses:</label>
                                <div class="form-check">
                                    @php
                                    $index = 1;
                                    @endphp

                                    @foreach ($courses as $course)
                                    <div class="row mb-2">
                                    @if ($course->course_path_id==$item->id)
                                        <div>
                                            <span class="badge bg-primary">{{ $index }}</span>
                                        </div>
                                    @endif
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="course_id[{{ $index }}]" value="{{ $course->id }}" id="course_{{ $course->id }}"
                                               @if ($course->course_path_id==$item->id)
                                               checked
                                               @endif
                                                >
                                                <label class="form-check-label" for="course_{{ $course->id }}">{{ $course->title }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($course->course_path_id==$item->id)
                                    <div hidden>{{$index++;}}</div>
                                    @endif
                                    @endforeach
                                </div>

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