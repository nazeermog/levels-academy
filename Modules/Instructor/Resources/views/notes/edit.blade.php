@extends('instructor.layouts.dashboard')

@section('title')
{{ __('Edit Note') }}
@endsection

@section('content')
<div class="container py-5">
  <div class="card border-top border-0 border-4 border-warning">
    <div class="card-header">
      <h4>{{ __('Edit Note') }}</h4>
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

      <form action="{{ route('instructor.notes.update', $note->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="student_id" value="{{ $note->student->user_id }}">

        <div class="form-group mb-3">
          <label for="student_id">{{ __('Student') }}</label>
          <select name="student_id" id="student_id" class="form-control" required disabled>
            <option value="{{ $note->student->user_id }}">
              {{ $note->student->first_name }} {{ $note->student->last_name }}
            </option>
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="note">{{ __('Note') }}</label>
          <textarea name="note" id="note" rows="5" class="form-control" required>{{ old('note', $note->note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning">{{ __('Update Note') }}</button>
      </form>
    </div>
  </div>
</div>
@endsection