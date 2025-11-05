@extends('parentt.layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">New Absence Request</h3>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('parentt.absences.store') }}">
        @csrf
        <div class="form-group">
          <label for="student_id">Select Child</label>
          <select id="student_id" name="student_id" class="form-control" required>
            <option value="">Choose a child</option>
            @foreach(($children ?? []) as $child)
              <option value="{{ $child->user_id }}">{{ optional($child->user)->first_name }} {{ optional($child->user)->last_name }} (ID: {{ $child->user_id }})</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="class_session_id">Select Upcoming Session</label>
          <select id="class_session_id" name="class_session_id" class="form-control" required>
            <option value="">Choose a session</option>
            @foreach(($sessions ?? []) as $s)
              <option value="{{ $s->id }}">Session #{{ $s->id }} - {{ optional($s->type)->name }} - {{ $s->held_at }} @if($s->classroom) ({{ $s->classroom->name }}) @endif</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="notes">Notes</label>
          <textarea id="notes" name="notes" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('parentt.absences.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection


