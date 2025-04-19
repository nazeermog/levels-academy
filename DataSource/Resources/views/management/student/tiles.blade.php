@extends('datasource::management.layout.master')

@section('content')

<div class="page-wrapper">
  <div class="page-content">

    <div class="row">
      <!-- Total Students -->
      <div class="col-md-4 mb-3">
        <a href="{{ route('admin.students.index') }}" class="text-decoration-none">
          <div class="card bg-primary text-white shadow rounded-4">
            <div class="card-body text-center">
              <h5>🎓 Total Students</h5>
              <h2>{{ $studentsCount }}</h2>
            </div>
          </div>
        </a>
      </div>

      <!-- Total Parents -->
      <div class="col-md-4 mb-3">
        <a href="{{ route('admin.parentts.index') }}" class="text-decoration-none">
          <div class="card bg-secondary text-white shadow rounded-4">
            <div class="card-body text-center">
              <h5>🧑‍🤝‍🧑 Total Parents</h5>
              <h2>{{ $parents }}</h2>
            </div>
          </div>
        </a>
      </div>

      <!-- Total Courses -->
      <div class="col-md-4 mb-3">
        <a href="{{ route('admin.courseContent.index') }}" class="text-decoration-none">
          <div class="card bg-success text-white shadow rounded-4">
            <div class="card-body text-center">
              <h5>📚 Total Courses</h5>
              <h2>{{ $coursesCount }}</h2>
            </div>
          </div>
        </a>
      </div>

      <!-- Total Enrollments -->
      <div class="col-md-6 mb-3">
        <a href="{{ route('admin.inrollments.index') }}" class="text-decoration-none">
          <div class="card bg-info text-white shadow rounded-4">
            <div class="card-body text-center">
              <h5>📝 Total Enrollments</h5>
              <h2>{{ $inrollmentsCount }}</h2>
            </div>
          </div>
        </a>
      </div>

      <!-- Completed Enrollments -->
      <div class="col-md-3 mb-3">
        <a href="{{ route('admin.inrollments.index') }}" class="text-decoration-none">
          <div class="card bg-warning text-dark shadow rounded-4">
            <div class="card-body text-center">
              <h5>✅ Completed</h5>
              <h2>{{ $completedEnrollments }}</h2>
            </div>
          </div>
        </a>
      </div>

      <!-- Ongoing Enrollments -->
      <div class="col-md-3 mb-3">
        <a href="{{ route('admin.inrollments.index') }}" class="text-decoration-none">
          <div class="card bg-danger text-white shadow rounded-4">
            <div class="card-body text-center">
              <h5>🔄 Ongoing</h5>
              <h2>{{ $ongoingEnrollments }}</h2>
            </div>
          </div>
        </a>
      </div>

    </div>

  </div>
</div>
@endsection