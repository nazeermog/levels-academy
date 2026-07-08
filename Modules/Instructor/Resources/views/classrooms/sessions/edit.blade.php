@extends('instructor.layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Edit Session #{{ $session->id }}</h3>
    </div>
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between p-3 mb-3 rounded"
           style="background:#eafaf1; border:1px solid #b7e4c7;">
        <span>
          <strong>Attendance</strong> — mark each student <em>given</em> &amp; add notes
          <span class="text-muted">(charges the parent and credits you).</span>
        </span>
        <a href="{{ route('instructor.sessions.attendance', $session->id) }}" class="btn btn-success btn-lg">
          <i class="material-icons" style="font-size:1.1rem;vertical-align:middle;">how_to_reg</i>
          Manage attendance
        </a>
      </div>
      <form method="POST" action="{{ route('instructor.sessions.update', $session->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label>Held At</label>
          <input type="text" class="form-control" value="{{ $session->held_at }}" disabled>
        </div>
        <div class="form-group">
          <label>Classroom</label>
          <input type="text" class="form-control" value="{{ optional($session->classroom)->name }}" disabled>
        </div>
        <div class="form-group">
          <label>Session Type</label>
          <input type="text" class="form-control" value="{{ optional($session->sessionType)->name }}" disabled>
        </div>
        <div class="form-group">
          <label for="is_given">Session Given</label>
          @php($givenDefault = $session->is_given ? '1' : '0')
          <select id="is_given" name="is_given" class="form-control">
            <option value="1" {{ old('is_given', $givenDefault) == '1' ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('is_given', $givenDefault) == '0' ? 'selected' : '' }}>No</option>
          </select>
        </div>
        <div class="form-group">
          <label for="zoom_url">Meeting Link (Zoom)</label>
          <input type="url" id="zoom_url" name="zoom_url" class="form-control" placeholder="https://zoom.us/j/..." value="{{ old('zoom_url', $session->zoom_url) }}">
          <small class="form-text text-muted">Students enrolled in this classroom can join from their course.</small>
        </div>
        <div class="form-group">
          <label for="content">Content Presented</label>
          <textarea id="content" name="content" class="form-control" rows="6" placeholder="What did you present?">{{ old('content', $session->content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('instructor.sessions.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection


