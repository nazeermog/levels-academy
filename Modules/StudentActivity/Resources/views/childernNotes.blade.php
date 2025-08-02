@extends('parentt.layouts.dashboard')

@section('title', 'Student Notes')

@push('css')
<style>
  .table td, .table th {
    vertical-align: middle;
  }
</style>
@endpush

@section('content')
<div class="container py-5">
  <div class="card border-top border-0 border-4 border-success">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title m-0">Notes From Instructor</h3>
    </div>

    <div class="card-body">
      @if($notes->isEmpty())
      <div class="alert alert-warning text-center">No notes available for your child.</div>
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
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($notes as $index => $note)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $note->student->first_name }} {{ $note->student->last_name }}</td>
              <td class="text-left">{{ Str::limit($note->note, 100) }}</td>
              <td>
                <span class="badge {{ $note->is_read ? 'bg-success' : 'bg-warning' }}">
                  {{ $note->is_read ? 'true' : 'false' }}
                </span>
              </td>
              <td>{{ $note->created_at->format('Y-m-d') }}</td>
              <td>
                @if(!$note->is_read)
                <form action="{{ route('parentt.notes.check', $note->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-outline-success">
                    Mark as Read
                  </button>
                </form>
                @else
                <span class="text-muted">Already Read</span>
                @endif
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
