@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Expected Earnings @if(isset($currentOrg) && $currentOrg) ({{ $currentOrg->name }}) @endif</h3>
                    <form method="GET" action="" class="form-inline">
                        <div class="form-group mb-0 mr-2">
                            <label for="month" class="mr-2">Month</label>
                            <input type="month" id="month" name="month" value="{{ $month ?? '' }}" class="form-control" />
                        </div>
                        <div class="form-group mb-0 mr-2">
                            <label for="instructor_id" class="mr-2">Instructor</label>
                            <select id="instructor_id" name="instructor_id" class="form-control">
                                <option value="">All</option>
                                @foreach(($instructors ?? collect()) as $ins)
                                    <option value="{{ $ins->id }}" {{ (string)($instructorId ?? '') === (string)$ins->id ? 'selected' : '' }}>
                                        {{ $ins->first_name }} {{ $ins->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-0 mr-2">
                            <label for="classroom_id" class="mr-2">Classroom</label>
                            <select id="classroom_id" name="classroom_id" class="form-control">
                                <option value="">All</option>
                                @foreach(($classroomsForFilter ?? collect()) as $cls)
                                    <option value="{{ $cls->id }}" {{ (string)($classroomId ?? '') === (string)$cls->id ? 'selected' : '' }}>
                                        {{ $cls->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-0 mr-2">
                            <label for="class_session_type_id" class="mr-2">Type</label>
                            <select id="class_session_type_id" name="class_session_type_id" class="form-control">
                                <option value="">All</option>
                                @foreach(($types ?? collect()) as $tp)
                                    <option value="{{ $tp->id }}" {{ (string)($typeId ?? '') === (string)$tp->id ? 'selected' : '' }}>
                                        {{ $tp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary ml-2">Filter</button>
                    </form>
                </div>
                <div class="card-body">

                    {{-- ── Summary Cards ── --}}
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="alert alert-info">
                                <strong>Projected Sessions:</strong> {{ $totalSessions }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-warning">
                                <strong>Expected Revenue:</strong> {{ number_format($totalRevenue, 2) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-danger">
                                <strong>Expected Payouts:</strong> {{ number_format($totalPayout, 2) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-success">
                                <strong>Expected Profit:</strong> {{ number_format($totalProfit, 2) }}
                            </div>
                        </div>
                    </div>

                    {{-- ── By Classroom ── --}}
                    <h5 class="p-1">By Classroom</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-nowrap align-middle">
                            <thead>
                            <tr>
                                <th>Classroom</th>
                                <th>Instructor</th>
                                <th>Type</th>
                                <th>Students</th>
                                <th>Sessions</th>
                                <th>Price / Student</th>
                                <th>Revenue</th>
                                <th>Payout</th>
                                <th>Profit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($rows as $row)
                                <tr>
                                    <td>{{ optional($row['classroom'])->name ?? '—' }}</td>
                                    <td>{{ optional($row['instructor'])->first_name }} {{ optional($row['instructor'])->last_name }}</td>
                                    <td>{{ optional($row['session_type'])->name ?? '—' }}</td>
                                    <td>{{ $row['enrolled_students'] }}</td>
                                    <td>{{ $row['sessions_count'] }}</td>
                                    <td>{{ number_format($row['price_per_session'], 2) }}</td>
                                    <td>{{ number_format($row['expected_revenue'], 2) }}</td>
                                    <td>{{ number_format($row['expected_payout'], 2) }}</td>
                                    <td>{{ number_format($row['expected_profit'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center">No data.</td></tr>
                            @endforelse
                            </tbody>
                            @if($rows->count())
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th>{{ $totalSessions }}</th>
                                    <th></th>
                                    <th>{{ number_format($totalRevenue, 2) }}</th>
                                    <th>{{ number_format($totalPayout, 2) }}</th>
                                    <th>{{ number_format($totalProfit, 2) }}</th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>

                    {{-- ── Per Student Breakdown ── --}}
                    <h5 class="p-1 mt-4">Per Student</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-nowrap align-middle">
                            <thead>
                            <tr>
                                <th>Student</th>
                                <th>Classrooms</th>
                                <th>Expected Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($studentRows as $sRow)
                                <tr>
                                    <td>{{ optional($sRow['student'])->first_name ?? optional($sRow['student_user'])->first_name }} {{ optional($sRow['student'])->last_name ?? optional($sRow['student_user'])->last_name }}</td>
                                    <td>{{ $sRow['classrooms_count'] }}</td>
                                    <td>{{ number_format($sRow['expected_amount'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">No students enrolled.</td></tr>
                            @endforelse
                            </tbody>
                            @if($studentRows->count())
                            <tfoot>
                                <tr>
                                    <th>Total ({{ $studentRows->count() }} students)</th>
                                    <th></th>
                                    <th>{{ number_format($studentRows->sum('expected_amount'), 2) }}</th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
