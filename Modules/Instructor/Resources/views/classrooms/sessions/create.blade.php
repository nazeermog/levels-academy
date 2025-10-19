@extends('instructor.layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Add Class Session</h3>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('instructor.sessions.store') }}">
        @csrf
        <div class="form-group">
          <label for="classroom_id">Classroom</label>
          <select id="classroom_id" name="classroom_id" class="form-control" required>
            <option value="">Select Classroom</option>
            @foreach($classrooms as $c)
              <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="held_at">Held At</label>
          <input type="datetime-local" id="held_at" name="held_at" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="class_session_type_id">Session Type</label>
          <select id="class_session_type_id" name="class_session_type_id" class="form-control" required>
            <option value="">Select Type</option>
            @foreach($types as $t)
              <option value="{{ $t->id }}">{{ $t->name }} ({{ number_format($t->price, 2) }})</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="content">Content Presented</label>
          <textarea id="content" name="content" class="form-control" rows="5" placeholder="What did you present?"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('instructor.sessions.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection


