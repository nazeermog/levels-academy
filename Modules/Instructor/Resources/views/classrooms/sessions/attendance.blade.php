@extends('instructor.layouts.dashboard')

@section('content')
<div class="container-fluid">

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
  @endif

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Session Attendance — {{ optional($session->classroom)->name ?? 'Session' }}
      </h3>
      <a href="{{ route('instructor.sessions.index') }}" class="btn btn-sm btn-secondary float-right">Back to calendar</a>
    </div>
    <div class="card-body">
      <p class="mb-1">
        <strong>When:</strong>
        @if($session->held_at)
          <span data-localtime="{{ $session->held_at->toIso8601String() }}">{{ $session->held_at->format('Y-m-d H:i') }} UTC</span>
        @endif
        &nbsp;|&nbsp;
        <strong>Type:</strong> {{ optional($session->sessionType)->name ?? '—' }}
        @if($session->sessionType)
          &nbsp;|&nbsp;
          <strong>You earn per student:</strong>
          <span class="badge badge-success" style="font-size:.9rem;">{{ $session->sessionType->teacher_payout }}</span>
        @endif
      </p>
      <p class="text-muted" style="font-size:.85rem;">
        Marking a student <em>given</em> charges that student's parent and credits you for this session. It happens once per student.
      </p>

      <table class="table table-hover">
        <thead>
          <tr>
            <th>Student</th>
            <th>Status</th>
            <th>Given (your local time)</th>
            <th>Note (what they learned)</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($rows as $row)
            @php($u = $students->get($row->student_id))
            <tr>
              <td>{{ optional($u)->first_name }} {{ optional($u)->last_name }}</td>
              <td>
                @if($row->is_given)
                  <span class="badge badge-success">Given</span>
                  @if($row->charged)<span class="badge badge-info">Charged</span>@endif
                @else
                  <span class="badge badge-warning">Pending</span>
                @endif
              </td>
              <td>
                @if($row->given_at)
                  <span data-localtime="{{ $row->given_at->toIso8601String() }}">{{ $row->given_at->format('Y-m-d H:i') }} UTC</span>
                @endif
              </td>
              <td style="white-space:normal;max-width:260px;">{{ $row->notes }}</td>
              <td>
                <button type="button"
                  class="btn btn-sm {{ $row->is_given ? 'btn-outline-secondary' : 'btn-success' }}"
                  data-toggle="modal" data-target="#attendanceModal"
                  data-action="{{ route('instructor.sessions.student.given', ['session' => $session->id, 'student' => $row->student_id]) }}"
                  data-name="{{ trim(optional($u)->first_name . ' ' . optional($u)->last_name) }}"
                  data-notes="{{ $row->notes }}"
                  data-given="{{ $row->is_given ? '1' : '0' }}">
                  <i class="material-icons" style="font-size:1rem;vertical-align:middle;">{{ $row->is_given ? 'edit_note' : 'check_circle' }}</i>
                  {{ $row->is_given ? 'Update note' : 'Mark given' }}
                </button>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center">No students enrolled in this classroom yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Shared note modal (populated per row via data-* attributes) --}}
<div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="attTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="attForm" method="POST" action="">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="attTitle">Mark given</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <p class="mb-2">Student: <strong id="attStudent"></strong></p>
          <div class="form-group mb-1">
            <label for="attNotes">Note — what did this student learn?</label>
            <textarea id="attNotes" name="notes" class="form-control" rows="4"
              placeholder="e.g. Practiced letter A; needs review on numbers 1–10"></textarea>
          </div>
          <small class="text-muted">Confirming charges the parent and credits you for this session (once per student).</small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" id="attSubmit" class="btn btn-success">Confirm given</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('js')
<script>
  (function () {
    var $modal = window.jQuery ? jQuery('#attendanceModal') : null;
    if (!$modal || !$modal.length) { return; }
    $modal.on('show.bs.modal', function (event) {
      var btn = event.relatedTarget;
      if (!btn) { return; }
      var given = btn.getAttribute('data-given') === '1';
      document.getElementById('attForm').setAttribute('action', btn.getAttribute('data-action'));
      document.getElementById('attStudent').textContent = btn.getAttribute('data-name') || '';
      document.getElementById('attNotes').value = btn.getAttribute('data-notes') || '';
      document.getElementById('attTitle').textContent = given ? 'Update note' : 'Mark given';
      document.getElementById('attSubmit').textContent = given ? 'Save note' : 'Confirm given';
    });
  })();
</script>
@endpush
