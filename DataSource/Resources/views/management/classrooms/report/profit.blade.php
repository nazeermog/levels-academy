@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 d-flex align-items-center">
                            <h3 class="card-title mb-0">Profit Summary @if(isset($currentOrg) && $currentOrg) ({{ $currentOrg->name }}) @endif</h3>
                            <button type="button" onclick="window.print()" class="btn btn-sm btn-outline-primary d-print-none ml-3">Save as PDF</button>
                        </div>
                        <div class="col-12 col-md-6">
                            <form method="GET" action="" class="d-flex flex-wrap justify-content-end">
                                <div class="form-group mb-2 mr-2 d-flex align-items-center" style="min-width:140px;">
                                    <label for="month" class="mr-2 mb-0">Month</label>
                                    <input type="month" id="month" name="month" value="{{ $month ?? '' }}" class="form-control form-control-sm" />
                                </div>
                                <div class="form-group mb-2 mr-2 d-flex align-items-center" style="min-width:160px;">
                                    <label for="instructor_id" class="mr-2 mb-0">Instructor</label>
                                    <select id="instructor_id" name="instructor_id" class="form-control form-control-sm">
                                        <option value="">All</option>
                                        @foreach(($instructors ?? collect()) as $ins)
                                            <option value="{{ $ins->id }}" {{ (string)($instructorId ?? '') === (string)$ins->id ? 'selected' : '' }}>
                                                {{ $ins->first_name }} {{ $ins->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-2 mr-2 d-flex align-items-center" style="min-width:160px;">
                                    <label for="classroom_id" class="mr-2 mb-0">Classroom</label>
                                    <select id="classroom_id" name="classroom_id" class="form-control form-control-sm">
                                        <option value="">All</option>
                                        @foreach(($classrooms ?? collect()) as $cls)
                                            <option value="{{ $cls->id }}" {{ (string)($classroomId ?? '') === (string)$cls->id ? 'selected' : '' }}>
                                                {{ $cls->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-2 mr-2 d-flex align-items-center" style="min-width:160px;">
                                    <label for="class_session_type_id" class="mr-2 mb-0">Type</label>
                                    <select id="class_session_type_id" name="class_session_type_id" class="form-control form-control-sm">
                                        <option value="">All</option>
                                        @foreach(($types ?? collect()) as $tp)
                                            <option value="{{ $tp->id }}" {{ (string)($typeId ?? '') === (string)$tp->id ? 'selected' : '' }}>
                                                {{ $tp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2 d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="alert alert-info">
                                <strong>Total Revenue (Session Charges):</strong> {{ number_format($revenue, 2) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning">
                                <strong>Total Instructor Payouts:</strong> {{ number_format($payouts, 2) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-success">
                                <strong>Profit:</strong> {{ number_format($profit, 2) }}
                            </div>
                        </div>
                    </div>

                    <h5 class="p-1">By Classroom</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-nowrap align-middle">
                            <thead>
                            <tr>
                                <th>Classroom</th>
                                <th>Sessions</th>
                                <th>Revenue</th>
                                <th>Payouts</th>
                                <th>Profit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($byClassroom as $row)
                                <tr>
                                    <td>{{ optional($row['classroom'])->name ?? '—' }}</td>
                                    <td>{{ $row['sessions_count'] }}</td>
                                    <td>{{ number_format($row['revenue'], 2) }}</td>
                                    <td>{{ number_format($row['payouts'], 2) }}</td>
                                    <td>{{ number_format($row['profit'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">No data.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h5 class="p-1 mt-4">By Type</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-nowrap align-middle">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Sessions</th>
                                <th>Revenue</th>
                                <th>Payouts</th>
                                <th>Profit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($byType as $row)
                                <tr>
                                    <td>{{ optional($row['type'])->name ?? '—' }}</td>
                                    <td>{{ $row['sessions_count'] }}</td>
                                    <td>{{ number_format($row['revenue'], 2) }}</td>
                                    <td>{{ number_format($row['payouts'], 2) }}</td>
                                    <td>{{ number_format($row['profit'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">No data.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



