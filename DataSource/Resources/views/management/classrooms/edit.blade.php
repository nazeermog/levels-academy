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
                            <label for="class_session_type_id">Default Session Type</label>
                            <select class="form-control" id="class_session_type_id" name="class_session_type_id" required>
                                <option value="">Select Session Type</option>
                                @foreach($types as $t)
                                    <option value="{{ $t->id }}" {{ (int)old('class_session_type_id', $classroom->class_session_type_id) === (int)$t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Days of week (for auto-sessions)</label>
                            <div class="d-flex flex-wrap">
                                @php
                                    $oldDowInput = old('days_of_week', null);
                                    if (is_array($oldDowInput)) {
                                        $dowOld = collect($oldDowInput)->map(function($v){ return (string)$v; });
                                    } else {
                                        $source = $oldDowInput !== null ? $oldDowInput : $classroom->days_of_week;
                                        $dowOld = collect($source ? explode(',', $source) : [])->filter();
                                    }
                                @endphp
                                @foreach([1=>'Mon',2=>'Tue',3=>'Wed',4=>'Thu',5=>'Fri',6=>'Sat',7=>'Sun'] as $num=>$label)
                                    <div class="form-check mr-3 mb-2">
                                        <input class="form-check-input" type="checkbox" id="dow_{{ $num }}" name="days_of_week[]" value="{{ $num }}" {{ $dowOld->contains((string)$num) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="dow_{{ $num }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="session_time">Session time (HH:MM)</label>
                            @php
                                $sessionTimeOld = old('session_time', null);
                                $sessionTimeValue = $sessionTimeOld !== null
                                    ? $sessionTimeOld
                                    : ($classroom->session_time ? substr($classroom->session_time, 0, 5) : '');
                            @endphp
                            <input type="time" class="form-control" id="session_time" name="session_time" value="{{ $sessionTimeValue }}">
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


