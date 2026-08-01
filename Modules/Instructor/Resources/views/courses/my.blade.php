@extends('instructor.layouts.dashboard')

@section('content')
<div class="container-fluid">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">My Courses</h3>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>#</th>
            <th>Course</th>
            <th>Level</th>
            <th>Price</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($courses as $course)
            <tr>
              <td>{{ $course->id }}</td>
              <td>{{ $course->title }}</td>
              <td>{{ $course->level }}</td>
              <td>{{ $course->price }}</td>
              <td>
                <a href="{{ route('instructor.mycourses.edit', $course->id) }}" class="btn btn-sm btn-primary">Edit course</a>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center">You don't teach any courses yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
