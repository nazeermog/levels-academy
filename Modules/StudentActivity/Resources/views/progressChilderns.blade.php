@extends('parentt.layouts.dashboard')
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
            @if(session('locale', config('app.locale')) == 'ar')
            <th>#</th>
            <th>الطالب</th>
            <th>الدورة التدريبية</th>
            <th>التقدم</th>
            @elseif(session('locale', config('app.locale')) == 'de')
            <th>#</th>
            <th>Student</th>
            <th>Kurs</th>
            <th>Fortschritt</th>
            @else
            <th>#</th>
            <th>Student</th>
            <th>Course</th>
            <th>Progress</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @foreach($list as $item)
          <tr>
            <td>{{ $item->id}}</td>
            <td>
              {{ optional($item->student)->first_name .' '. optional($item->student)->last_name }}
            </td>
            <td>
              {{ optional($item->course)->title ?? '—' }}
            </td>
            <td style="min-width:280px;">
              @include('progress._report', ['report' => $reports[$item->id] ?? null])
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

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