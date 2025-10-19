@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Classroom #{{ $classroom->id }} @if(isset($currentOrg) && $currentOrg) ({{ $currentOrg->name }}) @endif</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.org.classrooms.update', $classroom->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $classroom->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="repeats_per_week">Repeats per week</label>
                            <input type="number" class="form-control" id="repeats_per_week" name="repeats_per_week" min="1" max="14" value="{{ old('repeats_per_week', $classroom->repeats_per_week) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="instructor_id">Instructor</label>
                            <select class="form-control" id="instructor_id" name="instructor_id" required>
                                @foreach($instructors as $ins)
                                    <option value="{{ $ins->id }}" {{ (int)$classroom->instructor_id === (int)$ins->id ? 'selected' : '' }}>{{ $ins->first_name }} {{ $ins->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="student_ids">Students</label>
                            <select class="form-control" id="student_ids" name="student_ids[]" multiple>
                                @foreach($students as $stu)
                                    <option value="{{ $stu->id }}" {{ in_array($stu->id, $selectedStudents) ? 'selected' : '' }}>{{ $stu->first_name }} {{ $stu->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.org.classrooms.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


