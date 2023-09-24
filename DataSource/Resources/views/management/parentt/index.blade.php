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
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($list as $item)
              <tr>
                <td>{{ $item->user_id}}</td>
                <td>{{$item->first_name .' '.$item->last_name}}</td>
                <td>
                  <input type="checkbox" name="my-checkbox" data-bootstrap-switch {{($item->is_active)?'checked':''}} value="{{$item->id}}" data-off-color="danger" data-on-color="success">
                </td>
                <td>
                  <div class="row">

                    <div class="ml-1">
                      <a href="{{route('admin.'.$route_name.'.show',$item->user_id)}}" class="btn btn-outline-primary ">Edit</a>
                      <button class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal{{$item->id}}">
                        Delete
                      </button>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$item->user_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete
                              Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">

                            Are You Sure You Wont
                            Delete {{$item->title}}?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                            </button>
                            <form action="{{route('admin.'.$route_name.'.destroy',$item->user_id)}}" method="POST">
                              @csrf
                              @method("DELETE")
                              <button type="submit" class="btn btn-danger">
                                Delete
                              </button>
                            </form>

                          </div>
                        </div>
                      </div>
                    </div>

                  </div>

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