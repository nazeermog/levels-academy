@extends('instructor.layouts.dashboard')

@section('title')
{{ __('Edit Note') }}
@endsection

@push('css')
<style>
  .star-rating {
    display: inline-flex;
    flex-direction: row-reverse;
    gap: 4px;
  }

  .star-rating input {
    display: none;
  }

  .star-rating label {
    color: #c7c7c7;
    cursor: pointer;
    margin-bottom: 0;
  }

  .star-rating label .material-icons {
    font-size: 28px;
  }

  .star-rating label:hover,
  .star-rating label:hover ~ label,
  .star-rating input:checked ~ label {
    color: #f5b301;
  }
</style>
@endpush

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

        <div class="form-group mb-3">
          <label for="rating">{{ __('Rating') }}</label>
          <div class="star-rating">
            @for($i = 5; $i >= 1; $i--)
              <input
                type="radio"
                id="rating-{{ $i }}"
                name="rating"
                value="{{ $i }}"
                {{ (int) old('rating', $note->rating) === $i ? 'checked' : '' }}
                required
              >
              <label for="rating-{{ $i }}" title="{{ $i }}">
                <span class="material-icons">star</span>
              </label>
            @endfor
          </div>
        </div>

        <button type="submit" class="btn btn-warning">{{ __('Update Note') }}</button>
      </form>
    </div>
  </div>
</div>
@endsection