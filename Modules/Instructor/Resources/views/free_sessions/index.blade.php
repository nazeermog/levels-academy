@extends('instructor.layouts.dashboard')

@section('content')
<div class="container-fluid">

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

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
            <th>Status</th>
            <th>My Note</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sessions as $req)
            @php($given = $req->status === \DataSource\Entities\FreeSession\FreeSessionRequest::STATUS_GIVEN)
            <tr>
              <td>{{ $req->id }}</td>
              <td>{{ optional($req->user)->first_name }} {{ optional($req->user)->last_name }}</td>
              <td>{{ optional($req->user)->email }}</td>
              @php($whenUtc = optional($req->session)->held_at ?? $req->scheduled_at)
              <td>
                @if($whenUtc)
                  <span data-localtime="{{ $whenUtc->toIso8601String() }}">{{ $whenUtc->format('Y-m-d H:i') }} UTC</span>
                @endif
              </td>
              <td>{{ optional(optional($req->session)->end_at)->format('Y-m-d H:i') }}</td>
              <td style="white-space:normal;max-width:240px;">{{ optional($req->session)->content }}</td>
              <td>
                @if($given)
                  <span class="badge badge-success">Given</span>
                  @if($req->given_at)
                    <br><small class="text-muted">{{ $req->given_at->format('Y-m-d H:i') }}</small>
                  @endif
                @else
                  <span class="badge badge-warning">Scheduled</span>
                @endif
              </td>
              <td style="white-space:normal;max-width:240px;">{{ $req->instructor_note }}</td>
              <td>
                <details>
                  <summary class="btn btn-sm {{ $given ? 'btn-outline-secondary' : 'btn-success' }}" style="cursor:pointer;list-style:none;">
                    {{ $given ? 'Update Note' : 'Mark as Given' }}
                  </summary>
                  <form method="POST" action="{{ route('instructor.free-sessions.given', $req->id) }}" style="margin-top:8px;min-width:240px;">
                    @csrf
                    <textarea name="instructor_note" class="form-control" rows="3" placeholder="Note about this session (optional)">{{ old('instructor_note', $req->instructor_note) }}</textarea>
                    <button type="submit" class="btn btn-sm btn-success mt-2">
                      {{ $given ? 'Save Note' : 'Confirm Given' }}
                    </button>
                  </form>
                </details>
              </td>
            </tr>
          @empty
            <tr><td colspan="9" class="text-center">No free sessions assigned yet.</td></tr>
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
