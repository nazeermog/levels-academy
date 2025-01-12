@extends('datasource::management.layout.master')

@section('content')
<div class="container py-5">
    <form id="form-course" method="POST" action="{{route('admin.blogs.store')}}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <label>Add Blog </label>
        </div>
        <hr />
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
                <textarea class="form-control" name="desc-{{ $locale }}" id="desc-{{ $locale }}"></textarea>
            </div>
            @endforeach
        </div>
        <div class="col-md-3 m-1">
            <label for="photo">photo</label>
            <input class="form-control-file" type="file" name="photo" id="photo">
        </div>
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

        <hr />

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



{{-- <head> --}}

{{-- <title>Course Content</title> --}}
{{-- --}}
{{-- </head> --}}