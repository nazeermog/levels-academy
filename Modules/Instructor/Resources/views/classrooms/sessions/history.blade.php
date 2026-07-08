@extends('instructor.layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h3 class="card-title mb-0">Given Sessions — History</h3>
      <span class="badge badge-success" style="font-size:1rem;">Total earned: {{ number_format($totalEarned, 2) }}</span>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>Given at (your local time)</th>
            <th>Student</th>
            <th>Classroom</th>
            <th>Session time</th>
            <th>Note</th>
            <th class="text-right">Earned</th>
          </tr>
        </thead>
        <tbody>
          @forelse($rows as $r)
            @php($s = $r->session)
            @php($payout = optional(optional($s)->sessionType)->teacher_payout)
            <tr>
              <td>
                @if($r->given_at)
                  <span data-localtime="{{ $r->given_at->toIso8601String() }}">{{ $r->given_at->format('Y-m-d H:i') }} UTC</span>
                @endif
              </td>
              <td>{{ optional($r->studentUser)->first_name }} {{ optional($r->studentUser)->last_name }}</td>
              <td>{{ optional(optional($s)->classroom)->name ?? '—' }}</td>
              <td>
                @if($s && $s->held_at)
                  <span data-localtime="{{ $s->held_at->toIso8601String() }}">{{ $s->held_at->format('Y-m-d H:i') }} UTC</span>
                @endif
              </td>
              <td style="white-space:normal;max-width:280px;">{{ $r->notes ?: '—' }}</td>
              <td class="text-right">{{ $payout !== null ? number_format($payout, 2) : '—' }}</td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center">You haven't marked any sessions as given yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($rows->hasPages())
      <div class="card-footer clearfix">{{ $rows->links() }}</div>
    @endif
  </div>
</div>
@endsection
