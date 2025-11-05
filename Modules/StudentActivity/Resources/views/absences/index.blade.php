@extends('parentt.layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Absence Requests</h3>
      <a class="btn btn-primary" href="{{ route('parentt.absences.create') }}">New Request</a>
    </div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Session</th>
            <th>Requested At</th>
            <th>Status</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          @foreach($absences as $a)
          <tr>
            <td>{{ $a->id }}</td>
            <td>#{{ $a->class_session_id }} @if($a->session) ({{ $a->session->held_at }}) @endif</td>
            <td>{{ $a->requested_at }}</td>
            <td>{{ ucfirst($a->status) }}</td>
            <td>{{ $a->notes }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $absences->links() }}
    </div>
  </div>
</div>
@endsection


