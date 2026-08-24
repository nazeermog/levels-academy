@extends('instructor.layouts.dashboard')
@section('title')
Expected Earnings
@endsection
@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-10">

      {{-- ── Filter Card ── --}}
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-12 col-md-6 d-flex align-items-center">
              <h3 class="card-title mb-0">Expected Earnings</h3>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-end align-items-center">
              <form method="GET" action="{{ route('instructor.reports.expected_earnings') }}" class="d-flex flex-wrap justify-content-end">
                <div class="form-group mb-2 mr-2 d-flex align-items-center" style="min-width:140px;">
                  <label for="month" class="sr-only mb-0 mr-2">Month</label>
                  <input type="month" id="month" name="month" value="{{ $month ?? '' }}" class="form-control form-control-sm" />
                </div>
                <div class="form-group mb-2 mr-2 d-flex align-items-center" style="min-width:160px;">
                  <label for="classroom_id" class="sr-only mb-0 mr-2">Classroom</label>
                  <select id="classroom_id" name="classroom_id" class="form-control form-control-sm">
                    <option value="">All Classrooms</option>
                    @foreach($classrooms as $cls)
                      <option value="{{ $cls->id }}" {{ (string)($classroomId ?? '') === (string)$cls->id ? 'selected' : '' }}>
                        {{ $cls->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <button type="submit" class="btn btn-sm btn-primary mb-2">Apply</button>
                <a href="{{ route('instructor.reports.expected_earnings') }}" class="btn btn-sm btn-outline-secondary mb-2 ml-2">Reset</a>
              </form>
            </div>
          </div>
        </div>

        {{-- ── Summary Cards ── --}}
        <div class="card-body">
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="alert alert-info">
                <strong>Projected Sessions:</strong> {{ $totalSessions }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="alert alert-success">
                <strong>Total Expected Payout:</strong> {{ number_format($totalPayout, 2) }} $
              </div>
            </div>
          </div>

          {{-- ── Classroom Table ── --}}
          @if($rows->count())
            <div class="table-responsive">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Classroom</th>
                    <th>Session Type</th>
                    <th>Enrolled Students</th>
                    <th>Projected Sessions</th>
                    <th>Payout / Student</th>
                    <th>Expected Payout</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($rows as $row)
                  <tr>
                    <td>{{ optional($row['classroom'])->name ?? '—' }}</td>
                    <td>{{ optional($row['session_type'])->name ?? '—' }}</td>
                    <td>{{ $row['enrolled_students'] }}</td>
                    <td>{{ $row['sessions_count'] }}</td>
                    <td>{{ number_format($row['payout_per_session'], 2) }}</td>
                    <td>{{ number_format($row['expected_payout'], 2) }}</td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="3">Total</th>
                    <th>{{ $totalSessions }}</th>
                    <th></th>
                    <th>{{ number_format($totalPayout, 2) }}</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          @else
            <p class="mb-0">No classrooms found for the selected month.</p>
          @endif
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
