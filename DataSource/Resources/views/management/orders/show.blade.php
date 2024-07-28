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
                        <!-- Form to Update Order Status -->
                        <form class="card" action="{{ route('admin.orders.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-header">
                                <h3 class="card-title">Update Order</h3>
                            </div>

                            <div class="card-body">
                                <!-- Display Product Name -->
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" id="product_name" class="form-control" value="{{ $item->product->name }}" readonly>
                                </div>

                                <!-- Display Student Name -->
                                <div class="form-group">
                                    <label for="student_name">Student Name</label>
                                    <input type="text" id="student_name" class="form-control" value="{{ $item->user->first_name . ' ' . $item->user->last_name }}" readonly>
                                </div>

                                <!-- Display Product Price -->
                                <div class="form-group">
                                    <label for="product_price">Product Price</label>
                                    <input type="text" id="product_price" class="form-control" value="{{ $item->product->price }}" readonly>
                                </div>

                                <!-- Order Status -->
                                <div class="form-group">
                                    <label for="status">Order Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $item->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
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