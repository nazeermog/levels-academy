@extends('datasource::management.layout.master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Progress — {{ $course->title }}</h3>
                <a href="{{ route('admin.course-progress.index') }}" class="btn btn-sm btn-secondary float-right">Back</a>
            </div>
            <div class="card-body">
                @forelse($studentIds as $sid)
                    @php($student = $students->get($sid))
                    <div class="border rounded p-3 mb-3">
                        <strong>{{ optional($student)->first_name }} {{ optional($student)->last_name }}</strong>
                        <div class="mt-2">
                            @include('progress._report', ['report' => $reports[$sid] ?? null, 'open' => true])
                        </div>
                    </div>
                @empty
                    <p class="text-center mb-0">No students enrolled in this course yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
