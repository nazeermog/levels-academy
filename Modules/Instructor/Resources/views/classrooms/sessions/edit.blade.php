@extends('instructor.layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Edit Session #{{ $session->id }}</h3>
    </div>
    <div class="card-body">
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
          <input type="text" class="form-control" value="{{ optional($session->type)->name }}" disabled>
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


