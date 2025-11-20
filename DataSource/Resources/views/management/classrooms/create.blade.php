@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Classroom @if(isset($currentOrg) && $currentOrg) ({{ $currentOrg->name }}) @endif</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.org.classrooms.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="repeats_per_week">Repeats per week</label>
                            <input type="number" class="form-control" id="repeats_per_week" name="repeats_per_week" min="1" max="14" value="{{ old('repeats_per_week', 1) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="instructor_id">Instructor</label>
                            <select class="form-control" id="instructor_id" name="instructor_id" required>
                                <option value="">Select Instructor</option>
                                @foreach($instructors as $ins)
                                    <option value="{{ $ins->id }}">{{ $ins->first_name }} {{ $ins->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="class_session_type_id">Default Session Type</label>
                            <select class="form-control" id="class_session_type_id" name="class_session_type_id" required>
                                <option value="">Select Session Type</option>
                                @foreach($types as $t)
                                    <option value="{{ $t->id }}" {{ old('class_session_type_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
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
                                        $dowOld = collect($oldDowInput ? explode(',', $oldDowInput) : [])->filter();
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
                            <input type="time" class="form-control" id="session_time" name="session_time" value="{{ old('session_time') }}">
                        </div>
                        <div class="form-group">
                            <label for="student_ids">Students (optional)</label>
                            <select class="form-control" id="student_ids" name="student_ids[]" multiple>
                                @foreach($students as $stu)
                                    <option value="{{ $stu->id }}">{{ $stu->first_name }} {{ $stu->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.org.classrooms.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


