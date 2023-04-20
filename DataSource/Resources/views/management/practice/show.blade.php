@extends('admin.layout.master')
@push('css')
    <link href="{{asset('admin/plugins/imageuploadify/imageuploadify.min.css')}}" rel="stylesheet"/>
    <style>
        .imageuploadify-show .imageuploadify-images-list-show .imageuploadify-container-show {
            width: 100px;
            height: 100px;
            position: relative;
            overflow: hidden;
            margin-bottom: 1em;
            float: left;
            border-radius: 12px;
            box-shadow: 0 0 4px 0 #888;
        }

        .imageuploadify-show .imageuploadify-images-list-show .imageuploadify-container-show button.btn-danger {
            position: absolute;
            top: 3px;
            right: 3px;
            width: 20px;
            height: 20px;
            border-radius: 15px;
            font-size: 10px;
            line-height: 1.42;
            padding: 2px 0;
            text-align: center;
            z-index: 3;
        }

        .imageuploadify-show .imageuploadify-images-list-show .imageuploadify-container-show .imageuploadify-details-show {
            position: absolute;
            top: 0;
            padding-top: 20px;
            width: 100%;
            height: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            background: rgba(255, 255, 255, .5);
            z-index: 2;
            opacity: 1;
        }

    </style>
@endpush
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
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.'.$route_name.'.index')}}"> {{$table_name}}</a></li>

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

                            <form class="card" action="{{route('admin.'.$route_name.'.update')}}"
                                  id="form-about"
                                  enctype="multipart/form-data"
                                  method="POST">
                                @csrf

{{--                                {{ method_field('PUT') }}--}}
{{--                                <input type="hidden" name="_method" value="PUT">--}}
                                <input type="hidden" value="{{$item->id}}" name="model_id">
                                <div class="card-header">
                                    <h3 class="card-title">Update {{$table_name}}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Title</label>
                                                <input type="text" class="form-control"
                                                       name="title"
                                                       value="{{old('title',$item->title)}}"
                                                       placeholder="Enter Title">
                                            </div>
                                        </div>
{{--                                        <div class="col-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="exampleInputEmail1">Name En</label>--}}
{{--                                                <input type="text" class="form-control"--}}
{{--                                                       name="title-en"--}}
{{--                                                       value="{{old('title-en',$item->translate('en')->title)}}"--}}
{{--                                                       placeholder="Enter Name En">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                    </div>

                                        <div class="row">

                                            <label for="inputProductDescription" class="form-label">Badge Icon</label>
                                            <input id="image-uploadify-show" type="file" accept="image/*" multiple/>

                                        </div>
                                        <div class="hidden-input-images"></div>
                                        <div class="row">
                                            <hr/>
                                            <div class="imageuploadify-show row  g-2 justify-content-center mt-3">
                                                <div class="imageuploadify-images-list-show text-center">
                                                    <span class="mb-3 imageuploadify-message-show "> Badge Old Image</span>
                                                    <br/>
                                                    <div id="old_images">
                                                        @php($image_ids = [])
                                                        @foreach ($item->getMediaObject() as $image)

                                                            @php(array_push($image_ids, $image->id))
                                                            <div class="col imageuploadify-container-show" style="
                                                            margin: 3px;
                                                            background-image: url({{$image->image}});
                                                            background-size: cover; "
                                                                 id="image_old{{ $image->id }}">

                                                                <button type="button" class="btn btn-danger"
                                                                        onclick="remove_old_image('{{ $image->id }}')">X
                                                                </button>
                                                                <div class="imageuploadify-details--show">
                                                                    <img src="{{ $image->src}}"
                                                                         data-id="{{ $image->id }}" width="100">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>

                                        </div>

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
@push('js')
    <script src="{{asset('admin/plugins/imageuploadify/imageuploadify.min.js')}}"></script>
    <script>
        var images_list = [];
        $('#image-uploadify-show').imageuploadify();
        $('#submit-form').on('click', function (e) {

            e.preventDefault();
            $(this).prop("disabled", true);
            // add spinner to button
            $(this).html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
            );
            $('.imageuploadify-container img').each(function () {
                $('.hidden-input-images').html(
                    '<input type="hidden" name="image" value="' + $(this).attr('src') + '">'
                )
            });
            for (i = 0; i < images_list.length; i++) {
                $('#form-about').append('<input type="hidden" name="images_old_deleted[]" value="' + images_list[i] + '">')
            }

            document.getElementById('form-about').submit();
        })

        function remove_old_image(id) {
            $('#image_old' + id).remove();
            images_list.push(id)

        }
    </script>


@endpush
