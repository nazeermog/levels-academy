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
            <th>Child</th>
            <th>Classroom</th>
            <th>Instructor</th>
            <th>Session time</th>
            <th>Status</th>
            <th>What they learned</th>
          </tr>
        </thead>
        <tbody>
          @forelse($records as $r)
          @php($s = $r->session)
          <tr>
            <td>{{ optional($r->studentUser)->first_name }} {{ optional($r->studentUser)->last_name }}</td>
            <td>{{ optional(optional($s)->classroom)->name }}</td>
            <td>{{ optional(optional($s)->instructor)->first_name }} {{ optional(optional($s)->instructor)->last_name }}</td>
            <td>
              @if($s && $s->held_at)
                <span data-localtime="{{ $s->held_at->toIso8601String() }}">{{ $s->held_at->format('Y-m-d H:i') }} UTC</span>
              @endif
            </td>
            <td>
              @if($r->is_given)
                <span class="badge badge-success">Given</span>
              @else
                <span class="badge badge-warning">Pending</span>
              @endif
            </td>
            <td style="white-space:normal;max-width:280px;">{{ $r->notes ?: '—' }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center">No sessions found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if(method_exists($records, 'links'))
    <div class="card-footer clearfix">
      {{ $records->links() }}
    </div>
    @endif
  </div>
</div>
@endsection


