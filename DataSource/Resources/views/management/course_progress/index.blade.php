@extends('datasource::management.layout.master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Course Progress</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Enrolled students</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                            <tr>
                                <td>{{ $course->title }}</td>
                                <td>{{ $course->inrollments_count }}</td>
                                <td>
                                    <a href="{{ route('admin.course-progress.show', $course->id) }}" class="btn btn-sm btn-primary">View progress</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center">No courses yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
