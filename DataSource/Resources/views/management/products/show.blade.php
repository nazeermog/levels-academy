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
                                    <label for="">Name {{ ucwords($locale) }}</label>
                                    <input type="text" class="form-control" name="name-{{$locale}}" value="{{old('name-'.$locale,$item->translateOrDefault($locale)->name)}}" placeholder="Enter Name {{ucwords($locale)}}">
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
                            <div class="row g-3 mt-3">
                                <div class="col-md-3 m-1">
                                    <label for="categoryProducts">Categories</label>
                                    <select class="btn btn-outline col-12" name="category_product_id" style="background-color: transparent; border: 1px solid #ced4da; border-radius: 0; ">
                                        @foreach($categoryProducts as $category)
                                        <option value="{{ $category->id }}" {{ $item->category_product_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" step="0.01" class="form-control" name="price" id="price" value="{{ old('price', $item->price) }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input type="text" class="form-control" name="unit" id="unit" value="{{ old('unit', $item->unit) }}">
                                </div>
                            </div>

                            <!-- Photo Upload Field -->
                            <div class="row g-3 mt-3">
                                <div class="col-md-4">
                                    <label for="photo" class="form-label">Photo</label>
                                    <input type="file" class="form-control" name="photo" id="photo" value="{{$item->photo}}">
                                </div>
                                @if($item->photo)
                                <img src="{{ asset($item->photo) }}" alt="Current Photo" class="img-thumbnail mt-2" width="100">
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