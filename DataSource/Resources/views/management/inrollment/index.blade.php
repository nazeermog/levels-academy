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
                {{-- Old progress system — hidden from admin panel (kept for reference)
                <th>Progress Practice (%)</th>
                <th>Progress Lesson (%)</th>
                <th>Progress Quiz (%)</th>
                --}}
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
                {{-- Old progress system — hidden from admin panel (kept for reference)
                <td>
                  <div class="progress" style="height: 25px;">
                    <div class="progress-bar bg-{{ $item->progress_practice >= 80 ? 'success' : ($item->progress_practice >= 50 ? 'warning' : 'danger') }}"
                      role="progressbar"
                      style="width: {{ $item->progress_practice ?? 0 }}%"
                      aria-valuenow="{{ $item->progress_practice ?? 0 }}"
                      aria-valuemin="0"
                      aria-valuemax="100">
                      <span class="progress-text">{{ $item->progress_practice ?? 0 }}%</span>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="progress" style="height: 25px;">
                    <div class="progress-bar bg-{{ $item->progress_lesson >= 80 ? 'success' : ($item->progress_lesson >= 50 ? 'warning' : 'danger') }}"
                      role="progressbar"
                      style="width: {{ $item->progress_lesson ?? 0 }}%"
                      aria-valuenow="{{ $item->progress_lesson ?? 0 }}"
                      aria-valuemin="0"
                      aria-valuemax="100">
                      <span class="progress-text">{{ $item->progress_lesson ?? 0 }}%</span>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="progress" style="height: 25px;">
                    <div class="progress-bar bg-{{ $item->progress_quiz >= 80 ? 'success' : ($item->progress_quiz >= 50 ? 'warning' : 'danger') }}"
                      role="progressbar"
                      style="width: {{ $item->progress_quiz ?? 0 }}%"
                      aria-valuenow="{{ $item->progress_quiz ?? 0 }}"
                      aria-valuemin="0"
                      aria-valuemax="100">
                      <span class="progress-text">{{ $item->progress_quiz ?? 0 }}%</span>
                    </div>
                  </div>
                </td>
                --}}
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

  <style>
    .progress {
      position: relative;
      border-radius: 4px;
      background-color: #f5f5f5;
    }

    .progress-bar {
      position: relative;
      border-radius: 4px;
      transition: width 0.6s ease;
    }

    .progress-text {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      color: white;
      font-weight: bold;
      text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3);
    }
  </style>