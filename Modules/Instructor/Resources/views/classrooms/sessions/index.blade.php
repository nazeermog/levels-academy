@extends('instructor.layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">My Class Sessions</h3>
      <a href="{{ route('instructor.sessions.create') }}" class="btn btn-primary">Add Session</a>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>ID</th>
            <th>Classroom</th>
            <th>Held At</th>
            <th>Price</th>
            <th>Content</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sessions as $session)
          <tr>
            <td>{{ $session->id }}</td>
            <td>{{ optional($session->classroom)->name }}</td>
            <td><time class="utc-dt" data-utc="{{ $session->held_at->toIso8601String() }}">—</time></td>
            <td>{{ optional($session->type)->name ?? '-' }}</td>
            <td>{{ Str::limit($session->content, 120) }}</td>
            <td>
              <a href="{{ route('instructor.sessions.edit', $session->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center">No sessions found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if(method_exists($sessions, 'links'))
    <div class="card-footer clearfix">
      {{ $sessions->links() }}
    </div>
    @endif
  </div>
  <script>
    (function () {
      var nodes = document.querySelectorAll('.utc-dt[data-utc]');
      nodes.forEach(function(el){
        var iso = el.getAttribute('data-utc');
        var d = new Date(iso);
        if (!isNaN(d)) {
          el.textContent = d.toLocaleString([], {
            year:'numeric', month:'2-digit', day:'2-digit',
            hour:'2-digit', minute:'2-digit'
          });
        }
      });
    })();
  </script>
</div>
@endsection