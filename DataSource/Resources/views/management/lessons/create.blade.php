@extends('datasource::management.layout.master')

@section('content')
    <div class="container py-5">
        <form id="form-course" method="POST" action="{{route('admin.lessons.store')}}" enctype="multipart/form-data">
        @csrf

            <div class="row">
                <label>Add Lesson </label>
            </div>
            <hr/>
            <div class="row">
                @foreach (localeSupported() as $locale)
                    <div class="col-md-3 m-1">
                        <label for="">Title {{ ucwords($locale) }}</label>
                        <input class="form-control" name="title-{{ $locale }}" id="title-{{ $locale }}">
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach (localeSupported() as $locale)
                    <div class="col-md-3 m-1">
                        <label for="">Description {{ ucwords($locale) }}</label>
                        <input class="form-control" name="desc-{{ $locale }}" id="desc-{{ $locale }}">
                    </div>
                @endforeach
            </div>
            <div class="row">  
    <div class="col-md-3 mt-3 m-1">
        <label for="uploadOption">Choose an option:</label>
        <select class="form-control" id="uploadOption" name="uploadOption">
            <option value="file">Upload Video File</option>
            <option value="url">Provide YouTube or vimeo URL</option>
        </select>
    </div>

    <div id="fileUploadField" class="col-md-3 mt-3 m-1" style="display: none;">
        <div class="form-group">
            <label for="videoFile">Upload Video File:</label>
            <input type="file" class="form-control-file" id="url" name="url">
        </div>
    </div>

    <div id="urlField" class="col-md-3 mt-3 m-1" style="display: none;">
        <div class="form-group">
            <label for="url">URL:</label>
            <input type="text" class="form-control" id="url" name="url" placeholder="Enter The URL">
        </div>
    </div>
    <div class="col-md-3 mt-3 m-1">
                <label for="time">Time (minutes)</label>
                <input class="form-control" type="number" name="time" id="time" >
    </div>
        </div>
        <div class="row">
                @foreach (localeSupported() as $locale)
                    <div class="col-md-3 m-1">
                        <label for="">Attachment Name {{ ucwords($locale) }}</label>
                        <input class="form-control" name="attachment_name-{{ $locale }}" id="attachment_name-{{ $locale }}">
                    </div>
                @endforeach
        <div class="col-md-3 mt-3 m-1">
        <label for="attachmentType">Attachment Type</label>
        <select class="form-control" name="attachmentType" id="attachmentType">
            <option value="pdf">PDF</option>
            <option value="text">Text Note</option>
        </select>
    </div>
    <div class="col-md-3 mt-3 m-1" id="pdfAttachment">
        <!-- PDF attachment field -->
        <label for="pdfFile">PDF Attachment</label>
        <input class="form-control-file" type="file" name="attachment" id="pdfFile">
    </div>
    <div class="col-md-3 mt-3 m-1" id="textAttachment">
        <!-- Text note field (Initially hidden, shown when "Text Note" is selected) -->
        <label for="textNote">Text Note</label>
        <textarea class="form-control" name="attachment" id="textNote"></textarea>
    </div>
    </div>
                <hr/>

                <div class="row">
                    <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
                </div>


        </form>


 
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
            } else if (selectedValue === 'url') {
                $('#fileUploadField').hide();
                $('#urlField').show();
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
            } else if (selectedValue === 'text') {
                $('#pdfAttachment').hide();
                $('#textAttachment').show();
            }
        }

        // Check the selected option on page load and toggle fields accordingly
        const selectedOptionOnLoad = $('#attachmentType').val();
        toggleFields(selectedOptionOnLoad);
    });
</script>


@endsection



{{-- <head> --}}

{{--    <title>Course Content</title> --}}
{{--   --}}
{{-- </head> --}}
