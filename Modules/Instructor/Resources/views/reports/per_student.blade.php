@extends('instructor.layouts.dashboard')
@section('title')
{{$table_name}}
@endsection
@section('content')
<div class="container-fluid">
  <div class="row justify-content-center mt-3">
    <div class="col-lg-10">
      <div class="card">
        <div class="card-header payout-report-header">
          <div class="payout-report-titlebar">
            <h3 class="card-title mb-0">{{ $table_name }}</h3>
            <form method="GET" action="{{ route('instructor.reports.per_student.pdf') }}" class="d-print-none">
              <input type="hidden" name="month" value="{{ $month ?? '' }}">
              <input type="hidden" name="student_id" value="{{ $studentFilterId ?? '' }}">
              <input type="hidden" name="classroom_id" value="{{ $classroomFilterId ?? '' }}">
              <input type="hidden" name="class_session_type_id" value="{{ $typeFilterId ?? '' }}">
              <button type="submit" class="btn btn-sm btn-danger">Export as PDF</button>
            </form>
          </div>
          <form method="GET" action="{{ route('instructor.reports.per_student') }}" class="payout-report-filters d-print-none">
            <div class="payout-report-field">
              <label for="month">Month</label>
              <input type="month" id="month" name="month" value="{{ $month ?? '' }}" class="form-control form-control-sm" />
            </div>
            <div class="payout-report-field">
              <label for="student_id">Student</label>
              <select id="student_id" name="student_id" class="form-control form-control-sm">
                <option value="">All students</option>
                @if(isset($studentsForFilter) && $studentsForFilter->count())
                @foreach($studentsForFilter as $sid => $stud)
                <option value="{{ $sid }}" {{ (string)($studentFilterId ?? '') === (string)$sid ? 'selected' : '' }}>
                  {{ $stud->first_name }} {{ $stud->last_name }}
                </option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="payout-report-field">
              <label for="classroom_id">Classroom</label>
              <select id="classroom_id" name="classroom_id" class="form-control form-control-sm">
                <option value="">All classrooms</option>
                @if(isset($classroomsForFilter) && $classroomsForFilter->count())
                @foreach($classroomsForFilter as $cid => $cls)
                <option value="{{ $cid }}" {{ (string)($classroomFilterId ?? '') === (string)$cid ? 'selected' : '' }}>
                  {{ $cls->name }}
                </option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="payout-report-field">
              <label for="class_session_type_id">Session type</label>
              <select id="class_session_type_id" name="class_session_type_id" class="form-control form-control-sm">
                <option value="">All types</option>
                @if(isset($typesForFilter) && $typesForFilter->count())
                @foreach($typesForFilter as $tid => $tp)
                <option value="{{ $tid }}" {{ (string)($typeFilterId ?? '') === (string)$tid ? 'selected' : '' }}>
                  {{ $tp->name }}
                </option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="payout-report-actions">
              <button type="submit" class="btn btn-sm btn-primary">Apply filters</button>
              <button type="button" class="btn btn-sm btn-outline-primary" onclick="var f=this.closest('form'); f.month.value=''; f.submit();">All time</button>
              <a href="{{ route('instructor.reports.per_student') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
          </form>
          <style>
            .payout-report-header {
              padding: 1rem 1.25rem;
            }

            .payout-report-titlebar {
              display: flex;
              align-items: center;
              justify-content: space-between;
              gap: 1rem;
              margin-bottom: 1rem;
            }

            .payout-report-filters {
              display: grid;
              grid-template-columns: repeat(4, minmax(0, 1fr));
              gap: .75rem;
              align-items: end;
            }

            .payout-report-field label {
              display: block;
              margin-bottom: .35rem;
              color: #6c757d;
              font-size: .75rem;
              font-weight: 600;
              text-transform: uppercase;
              letter-spacing: .03em;
            }

            .payout-report-actions {
              display: flex;
              flex-wrap: wrap;
              gap: .5rem;
            }

            .payout-report-actions .btn {
              margin: 0;
            }

            @media (max-width: 767.98px) {
              .payout-report-titlebar {
                align-items: flex-start;
                flex-direction: column;
                gap: .75rem;
              }

              .payout-report-titlebar .btn {
                width: 100%;
              }

              .payout-report-filters {
                grid-template-columns: 1fr;
              }

              .payout-report-actions,
              .payout-report-actions .btn {
                width: 100%;
              }
            }
          </style>
        </div>
        <div class="card-body table p-0">
          <style>
            @media print {
              .d-print-none {
                display: none !important;
              }

              .card,
              .card-body {
                border: none !important;
                box-shadow: none !important;
              }

              .table th,
              .table td {
                padding: 6px 8px !important;
              }

              body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
              }
            }
          </style>
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="alert alert-info">
                <strong>Total Sessions:</strong> {{ $sessionsCount }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="alert alert-success">
                <strong>Total Payout (All Students):</strong> {{ number_format($grandTotal, 2) }} $
              </div>
            </div>
          </div>
          @if(isset($rows) && $rows->count())
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>Student</th>
                <th>Sessions</th>
                <th>Instructor Due</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rows as $row)
              <tr>
                <td>{{ optional($row['student'])->first_name }} {{ optional($row['student'])->last_name }}</td>
                <td>{{ $row['sessions_count'] }}</td>
                <td>{{ number_format($row['amount'], 2) }}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Total</th>
                <th>{{ $rows->sum('sessions_count') }}</th>
                <th>{{ number_format($rows->sum('amount'), 2) }}</th>
              </tr>
            </tfoot>
          </table>
          @else
          <p class="p-3 mb-0">No data found for the selected filters.</p>
          @endif
        </div>
      </div>
      <!-- Sessions card (same width as above) -->
      <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Sessions</h5>
        </div>
        <div class="card-body table-responsive p-0">
          @if(isset($sessionsDetailed) && $sessionsDetailed->count())
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Held At</th>
                <th>Classroom</th>
                <th>Type</th>
                <th>Payout</th>
                <th>Participants</th>
                <th>Per Student Share</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sessionsDetailed as $s)
              <tr>
                <td>{{ $s['id'] }}</td>
                <td>
                  <time class="utc-dt"
                    data-utc="{{ !empty($s['held_at']) ? \Illuminate\Support\Carbon::parse($s['held_at'])->toIso8601String() : '' }}">
                    —
                  </time>
                </td>
                <td>{{ $s['classroom'] ?? '—' }}</td>
                <td>{{ $s['type'] ?? '—' }}</td>
                <td>{{ number_format($s['teacher_payout'], 2) }}</td>
                <td>{{ $s['participants_count'] }}</td>
                <td>{{ number_format($s['per_student_share'], 2) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
          <p class="p-3 mb-0">No sessions found for the selected filters.</p>
          @endif
        </div>
        <script>
          (function() {
            var nodes = document.querySelectorAll('.utc-dt[data-utc]');
            nodes.forEach(function(el) {
              var iso = el.getAttribute('data-utc');
              var d = new Date(iso);
              if (!isNaN(d)) {
                el.textContent = d.toLocaleString([], {
                  year: 'numeric',
                  month: '2-digit',
                  day: '2-digit',
                  hour: '2-digit',
                  minute: '2-digit'
                });
              }
            });
          })();
        </script>
      </div>
    </div>
  </div>
</div>
@endsection