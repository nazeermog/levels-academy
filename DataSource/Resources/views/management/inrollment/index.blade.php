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


      </div>
      <div class="card-body ">
        @if (isset($list)&&$list->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>student id</th>
                <th>Student Name</th>
                <th>Course Name</th>
                <th>Semester Name</th>
                <th>Semester start</th>
                <th>Semester end</th>
                <th>Progress Practice (%)</th>
                <th>Progress Lesson (%)</th>
                <th>Progress Quiz (%)</th>
                <th>created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($list as $item)
              <tr>
                <td>{{ $item->student->user_id }}</td>
                <td>{{ $item->student->first_name . ' ' . $item->student->last_name }}</td>
                <td>{{ $item->course->title ?? '-' }}</td>
                <td>{{ $item->semester->title ?? '-' }}</td>
                <td>{{ $item->semester->start_date ?? '-' }}</td>
                <td>{{ $item->semester->end_date ?? '-' }}</td>
                <td>{{ $item->progress_practice ?? 0 }}%</td>
                <td>{{ $item->progress_lesson ?? 0 }}%</td>
                <td>{{ $item->progress_quiz ?? 0 }}%</td>
                <td>{{ $item->created_at ? $item->created_at->format('Y-m-d') : '-' }}</td>
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