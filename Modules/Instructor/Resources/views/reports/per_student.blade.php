@extends('instructor.layouts.dashboard')
@section('title')
{{$table_name}}
@endsection
@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-10">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">{{ $table_name }}</h3>
            <div class="d-flex align-items-center">
              <form method="GET" action="{{ route('instructor.reports.per_student') }}" class="form-inline flex-wrap justify-content-end mr-2 d-print-none">
              <div class="form-inline flex-wrap">
                <div class="form-group mb-2 mr-2">
                  <label for="month" class="sr-only">Month</label>
                  <input type="month" id="month" name="month" value="{{ $month ?? '' }}" class="form-control form-control-sm" />
                </div>
                <div class="form-group mb-2 mr-2">
                  <label for="student_id" class="sr-only">Student</label>
                  <select id="student_id" name="student_id" class="form-control form-control-sm">
                    <option value="">All</option>
                    @if(isset($studentsForFilter) && $studentsForFilter->count())
                      @foreach($studentsForFilter as $sid => $stud)
                        <option value="{{ $sid }}" {{ (string)($studentFilterId ?? '') === (string)$sid ? 'selected' : '' }}>
                          {{ $stud->first_name }} {{ $stud->last_name }}
                        </option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group mb-2 mr-2">
                  <label for="classroom_id" class="sr-only">Classroom</label>
                  <select id="classroom_id" name="classroom_id" class="form-control form-control-sm">
                    <option value="">All</option>
                    @if(isset($classroomsForFilter) && $classroomsForFilter->count())
                      @foreach($classroomsForFilter as $cid => $cls)
                        <option value="{{ $cid }}" {{ (string)($classroomFilterId ?? '') === (string)$cid ? 'selected' : '' }}>
                          {{ $cls->name }}
                        </option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group mb-2 mr-2">
                  <label for="class_session_type_id" class="sr-only">Type</label>
                  <select id="class_session_type_id" name="class_session_type_id" class="form-control form-control-sm">
                    <option value="">All</option>
                    @if(isset($typesForFilter) && $typesForFilter->count())
                      @foreach($typesForFilter as $tid => $tp)
                        <option value="{{ $tid }}" {{ (string)($typeFilterId ?? '') === (string)$tid ? 'selected' : '' }}>
                          {{ $tp->name }}
                        </option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <button type="submit" class="btn btn-sm btn-primary mb-2">Apply</button>
                <a href="{{ route('instructor.reports.per_student') }}" class="btn btn-sm btn-outline-secondary mb-2 ml-2">Reset</a>
              </div>
              </form>
              <form method="GET" action="{{ route('instructor.reports.per_student.pdf') }}" class="d-print-none">
                <input type="hidden" name="month" value="{{ $month ?? '' }}">
                <input type="hidden" name="student_id" value="{{ $studentFilterId ?? '' }}">
                <input type="hidden" name="classroom_id" value="{{ $classroomFilterId ?? '' }}">
                <input type="hidden" name="class_session_type_id" value="{{ $typeFilterId ?? '' }}">
                <button type="submit" class="btn btn-sm btn-danger ml-2">Export as PDF</button>
              </form>
            </div>
          </div>
      <div class="card-body table p-0">
        <style>
          @media print {
            .d-print-none { display: none !important; }
            .card, .card-body { border: none !important; box-shadow: none !important; }
            .table th, .table td { padding: 6px 8px !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
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
          <p class="p-3 mb-0">No data found for the selected month.</p>
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
            <p class="p-3 mb-0">No sessions found for the selected month.</p>
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
    </div>
  </div>
</div>
@endsection



 

