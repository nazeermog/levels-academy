@extends('instructor.layouts.dashboard')

@section('title', 'Instructor Notes')

@push('css')
<style>
  .alert-danger-edited {
    color: #000;
    background-color: #dc35457a;
    border-color: #dc35457a;
  }

  .alert-success-edited {
    color: #000;
    background-color: #28a7457a;
    border-color: #28a7457a;
  }

  .table td,
  .table th {
    vertical-align: middle;
  }
</style>
@endpush

@section('content')
<div class="container py-5">
  <div class="card border-top border-0 border-4 border-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title m-0">Instructor Notes</h3>
      <a href="{{ route('instructor.notes.create') }}" class="btn btn-primary">+ Add New Note</a>
    </div>

    <div class="card-body">
      @if($notes->isEmpty())
      <div class="alert alert-warning text-center">No notes available yet.</div>
      @else
      <div class="table-responsive">
        <table class="table table-hover table-bordered text-center">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Student</th>
              <th>Note</th>
              <th>Is Read</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($notes as $index => $note)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $note->student->first_name }} {{ $note->student->last_name }}</td>
              <td class="text-left">{{ Str::limit($note->note, 100) }}</td>
              <td>{{ $note->is_read ? 'true' : 'false' }}</td>
              <td>{{ $note->created_at->format('Y-m-d') }}</td>
              <td>
                <a href="{{ route('instructor.notes.edit', $note->id) }}" class="btn btn-sm btn-outline-primary">
                  Edit
                </a>
                <form action="{{ route('instructor.notes.destroy', $note->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this note?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection