@extends('instructor.layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">My Free Sessions</h3>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>ID</th>
            <th>Attendee</th>
            <th>Email</th>
            <th>Start (UTC)</th>
            <th>End (UTC)</th>
            <th>Content</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sessions as $s)
            <tr>
              <td>{{ $s->id }}</td>
              <td>{{ optional($s->attendee)->first_name }} {{ optional($s->attendee)->last_name }}</td>
              <td>{{ optional($s->attendee)->email }}</td>
              <td>{{ optional($s->held_at)->format('Y-m-d H:i') }}</td>
              <td>{{ optional($s->end_at)->format('Y-m-d H:i') }}</td>
              <td>{{ $s->content }}</td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center">No free sessions assigned yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($sessions->hasPages())
      <div class="card-footer clearfix">
        {{ $sessions->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
