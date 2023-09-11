@extends('instructor.layouts.dashboard')
@section('title')
{{$table_name}}
@endsection
@push('css')
<style>
  .alert-danger-edited {
    color: #000;
    background-color: #dc35457a;
    border-color: #dc35457a;
  }

  .alert-success-edited {
    color: #000;
    background-color: #28a7457a;
    border-color: #28a7457a;
  }
</style>
@endpush
@section('content')
<div class="container py-5">

  <!-- page-header-->
  <!--breadcrumb-->
  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    {{-- <div class="breadcrumb-title pe-3">   {{$table_name}}
  </div>--}}

</div>
<!--end breadcrumb-->
<!--EN FOR  page-header-->
<div class="card border-top border-0 border-4 border-primary table-responsive">
  <div class="card-header">
    <h3 class="card-title float-left">List of {{$table_name}}</h3>
  </div>
  <div class="card-body ">
    @if (isset($list)&&$list->count() > 0)
    <div class="row form-group">
      <div class="col-md-6">
        <label for="">Text Search</label>
        <input type="text" class="form-control" placeholder="search">
      </div>
      <div class="col-md-6">
        <label for="">Student Name</label>
        <select class="form-control">
          <option>Student Name</option>
        </select>
      </div>


    </div>
    <div class="row form-group">
      <div class="col-md-6">
        <label for="">From </label>
        <input type="date" class="form-control" placeholder="search">
      </div>
      <div class="col-md-6">
        <label for="">To </label>
        <input type="date" class="form-control" placeholder="search">
      </div>


    </div>
    <button class="btn btn-primary form-group">Search</button>

    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Student</th>

            <th>Level</th>
            <th>Result Real</th>
            <th>Result Student</th>
            <th>Duration</th>
            <th>Card Number</th>
            <th>Range Number</th>
            <th>Winner</th>
          </tr>
        </thead>
        <tbody>
          @foreach($list as $item)
          <tr>
            <td>{{ $item->id}}</td>
            <td>{{ $item->created_at->format('Y-m-d h:m')}}</td>
            <td>
              {{$item->student->first_name .' '.$item->student->last_name}}
            </td>

            <td>
              {{$item->level_title}}
            </td>
            <td>
              {{$item->result_true}}
            </td>
            <td>
              {{$item->result_student}}
            </td>
            <td>
              {{ $item->resultsType->seconds_speed ? $item->resultsType->seconds_speed . ' Second' : '/n' }}
            </td>
            <td>
              {{ $item->resultsType->card_number ?? '/n' }}
            </td>

            <td>
              [ {{$item->resultsType->range_number_from.' ,'.$item->resultsType->range_number_to}}
              ]

            </td>
            <td class="{{$item->is_true?'alert-success-edited':'alert-danger-edited'}}">
              @if($item->is_true)
              <i class="fas fa-check text-success " style="padding-left: 2rem!important;"></i>

              @else
              <i class=" fas fa-ban text-danger " style="padding-left: 2rem!important;"></i>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="mt-3 mb-3 mx-3">
        {{$list->links('datasource::management.partials.pagination',['paginator'=>$list])}}
      </div>

    </div>
    @else
    <h2>
      There is no {{$table_name}} Yet
    </h2>
    @endif
  </div>
</div>
</div>

@endsection