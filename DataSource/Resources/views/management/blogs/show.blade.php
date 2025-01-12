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
                            <li class="breadcrumb-item"><a href=#>Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.'.$route_name.'.index')}}"> {{$table_name}}</a></li>

                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @php
        function getWatchUrlFromEmbedUrl($embedUrl)
        {
        preg_match('/embed\/([^?]+)/', $embedUrl, $matches);
        if (isset($matches[1])) {
        $videoId = $matches[1];
        return 'https://www.youtube.com/watch?v=' . $videoId;
        }
        return null;
        }
        @endphp
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
                                <div class="col-md-3 m-1 ml-2">
                                    <label for="">Title {{ ucwords($locale) }}</label>
                                    <input type="text" class="form-control" name="title-{{$locale}}" value="{{old('title-'.$locale,$item->translateOrDefault($locale)->title)}}" placeholder="Enter Title {{ucwords($locale)}}">
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                @foreach (localeSupported() as $locale)
                                <div class="col-md-3 m-1 ml-2">
                                    <label for="">Description {{ ucwords($locale) }}</label>
                                    <input type="text" class="form-control" name="desc-{{$locale}}" value="{{old('desc-'.$locale,$item->translateOrDefault($locale)->desc)}}" placeholder="Enter Desc {{ucwords($locale)}}">
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-3 mt-3 m-1 ml-2">
                                    <label for="uploadOption">Choose an option:</label>
                                    <select class="form-control" id="uploadOption" name="uploadOption">
                                        <option value="file" @if(old('uploadOption', $item->uploadOption) === 'file') selected @endif>Upload Video File</option>
                                        <option value="url" @if(old('uploadOption', $item->uploadOption) === 'url') selected @endif>Provide YouTube or Vimeo URL</option>
                                    </select>
                                </div>

                                <div id="fileUploadField" class="col-md-3 mt-3 m-1 ml-2" style="display: none;">
                                    <div class="form-group">
                                        <label for="videoFile">Upload Video File:</label>
                                        <input type="file" class="form-control-file" id="url" name="url">
                                        <span id="old-file-name">{{ $item->url }}</span>

                                    </div>
                                </div>

                                <div id="urlField" class="col-md-3 mt-3 m-1 ml-2" style="display: none;">
                                    <div class="form-group">
                                        <label for="url">URL:</label>
                                        <input type="text" class="form-control" id="url" name="url" placeholder="Enter The URL" value="{{getWatchUrlFromEmbedUrl($item->url)}}">
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3 m-1 ml-2">
                                    <label for="time">Time (minutes)</label>
                                    <input class="form-control" type="number" name="time" id="time" step="0.01" value="{{$item->time}}">
                                </div>
                            </div>
                            <div class="row">
                                @foreach (localeSupported() as $locale)
                                <div class="col-md-3 m-1 ml-2">
                                    <label for="">Attachment Name {{ ucwords($locale) }}</label>
                                    <input type="text" class="form-control" name="attachment_name-{{$locale}}" value="{{old('attachment_name-'.$locale,$item->translateOrDefault($locale)->attachment_name)}}" placeholder="Enter attachment_name {{ucwords($locale)}}">
                                </div>
                                @endforeach
                                <div class="col-md-3 mt-3 m-1 ml-2">
                                    <label for="attachmentType">Attachment Type</label>
                                    <select class="form-control" name="attachmentType" id="attachmentType">
                                        <option value="pdf" @if(old('attachmentType')=='pdf' ) selected @endif>PDF</option>
                                        <option value="text" @if(old('attachmentType')=='text' ) selected @endif>Text Note</option>
                                    </select>

                                </div>
                                <div class="col-md-3 mt-3 m-1 ml-2" id="pdfAttachment">
                                    <!-- PDF attachment field -->
                                    <label for="pdfFile">PDF Attachment</label>
                                    <input class="form-control" type="file" name="attachment" id="pdfFile" value="{{ old('attachment', $item->attachment) }}">
                                    <span id="old-file-name">{{ $item->attachment }}</span>
                                </div>
                                <div class="col-md-3 mt-3 m-1 ml-2" id="textAttachment">
                                    <label for="textNote">Text Note</label>
                                    <input class="form-control" name="attachment" id="textNote" value="{{ (strpos($item->attachment, '/storage') == true) ? $item->attachment : '' }}">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Check if the user's choice is saved in local storage
        const selectedOption = localStorage.getItem('uploadOption');

        // If the user's choice is saved, set the select option and toggle fields accordingly
        if (selectedOption) {
            $('#uploadOption').val(selectedOption);
            toggleFields(selectedOption);
        }

        // Handle change event of the uploadOption select
        $('#uploadOption').change(function() {
            const selectedValue = $(this).val();
            toggleFields(selectedValue);

            // Save the user's choice in local storage
            localStorage.setItem('uploadOption', selectedValue);
        });

        // Function to toggle visibility of fields based on selected value
        function toggleFields(selectedValue) {
            if (selectedValue === 'file') {
                $('#fileUploadField').show();
                $('#urlField').hide();
                $('#url').attr('accept', '.mp4');
            } else if (selectedValue === 'url') {
                $('#fileUploadField').hide();
                $('#urlField').show();
                $('#url').removeAttr('accept');

            }
        }

        // Check the selected option on page load and toggle fields accordingly
        const selectedOptionOnLoad = $('#uploadOption').val();
        toggleFields(selectedOptionOnLoad);
    });
</script>
<script>
    $(document).ready(function() {
        // Check if the user's choice is saved in local storage
        const selectedOption = localStorage.getItem('attachmentType');

        // If the user's choice is saved, set the select option and toggle fields accordingly
        if (selectedOption) {
            $('#attachmentType').val(selectedOption);
            toggleFields(selectedOption);
        }

        // Handle change event of the attachmentType select
        $('#attachmentType').change(function() {
            const selectedValue = $(this).val();
            toggleFields(selectedValue);

            // Save the user's choice in local storage
            localStorage.setItem('attachmentType', selectedValue);
        });

        // Function to toggle visibility of fields based on selected value
        function toggleFields(selectedValue) {
            if (selectedValue === 'pdf') {
                $('#pdfAttachment').show();
                $('#textAttachment').hide();
                $('#pdfFile').attr('accept', '.pdf');
            } else if (selectedValue === 'text') {
                $('#pdfAttachment').hide();
                $('#textAttachment').show();
                $('#pdfFile').removeAttr('accept');

            }
        }

        // Check the selected option on page load and toggle fields accordingly
        const selectedOptionOnLoad = $('#attachmentType').val();
        toggleFields(selectedOptionOnLoad);
    });
</script>

@endsection