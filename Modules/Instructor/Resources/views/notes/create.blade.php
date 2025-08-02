@extends('instructor.layouts.dashboard')

@section('title')
  {{ __('Add Note') }}
@endsection

@section('content')
<div class="container py-5">
  <div class="card border-top border-0 border-4 border-primary">
    <div class="card-header">
      <h4>{{ __('Add Note for Student') }}</h4>
    </div>
    <div class="card-body">
      @if($errors->any())
        <div class="alert alert-danger-edited">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if(session('success'))
        <div class="alert alert-success-edited">
          {{ session('success') }}
        </div>
      @endif

      <form action="{{ route('instructor.notes.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
          <label for="student_id">{{ __('Student') }}</label>
          <select name="student_id" id="student_id" class="form-control" required>
            <option value="">{{ __('Select Student') }}</option>
            @foreach($students as $student)
              <option value="{{ $student->user_id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="note">{{ __('Note') }}</label>
          <textarea name="note" id="note" rows="5" class="form-control" required>{{ old('note') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save Note') }}</button>
      </form>
    </div>
  </div>
</div>
@endsection
