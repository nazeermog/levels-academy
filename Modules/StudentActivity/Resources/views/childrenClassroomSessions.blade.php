@extends('parentt.layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Children Classroom Sessions</h3>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>ID</th>
            <th>Classroom</th>
            <th>Instructor</th>
            <th>Held At</th>
            <th>Content</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sessions as $s)
          <tr>
            <td>{{ $s->id }}</td>
            <td>{{ optional($s->classroom)->name }}</td>
            <td>{{ optional($s->instructor)->first_name }} {{ optional($s->instructor)->last_name }}</td>
            <td>{{ $s->held_at }}</td>
            <td>{{ Str::limit($s->content, 120) }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center">No sessions found.</td>
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
</div>
@endsection


