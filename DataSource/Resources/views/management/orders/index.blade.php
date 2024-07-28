@extends('datasource::management.layout.master')
@section('title')
{{$table_name}}
@endsection

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!-- page-header-->
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"> {{$table_name}}</div>

        </div>
        <!--end breadcrumb-->
        <!--EN FOR  page-header-->
        <div class="card border-top border-0 border-4 border-primary table-responsive">

            <div class="card-header">
                <h3 class="card-title float-left">List of {{$table_name}}</h3>

                <a href="{{route('admin.'.$route_name.'.create')}}" class="btn btn-primary float-right">+ Add New</a>


            </div>
            <div class="card-body ">
                @if (isset($list)&&$list->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> Title</th>
                                <th> Student</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->user->first_name . ' ' . $item->user->last_name }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    @if($item->status == 'pending')

                                    <div class="row">
                                        <div class="ml-1">
                                            <!-- Accept Order Form -->
                                            <form action="{{ route('admin.orders.accept', ['orderId'=> $item->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary">Accept</button>
                                            </form>

                                            <!-- Reject Order Form -->
                                            <form action="{{ route('admin.orders.reject', ['orderId'=> $item->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger">Reject</button>
                                            </form>
                                        </div>


                                        <!-- Modal -->

                                    </div>
                                    @else
                                    <a href="{{route('admin.'.$route_name.'.show',$item->id)}}" class="btn btn-outline-primary ">Edit</a>

                                    @endif

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3 mb-3 mx-3">
                        {{$list->links('datasource::management.partials.pagination',['paginator'=>$list])}}
                    </div>
                    @else
                    <h2>
                        There is no {{$table_name}} Yet
                    </h2>
                    @endif
                </div>
            </div>
        </div>
    </div>


    @endsection