@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 d-flex align-items-center">
                            <h3 class="card-title mb-0">Instructor Session Totals @if(isset($currentOrg) && $currentOrg) ({{ $currentOrg->name }}) @endif</h3>
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
                <div class="card-body table-responsive p-0">
                    <div class="p-3">
                        <span class="badge badge-info mr-2">Sessions: {{ method_exists($sessions, 'total') ? $sessions->total() : (is_countable($sessions) ? count($sessions) : 0) }}</span>
                        <span class="badge badge-success">Total Payout: {{ number_format($grandTotal ?? 0, 2) }}</span>
                    </div>
                    <h5 class="p-3">All Sessions</h5>
                    <table class="table table-striped table-hover text-nowrap align-middle">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Held At</th>
                            <th>Classroom</th>
                            <th>Instructor</th>
                            <th>Type</th>
                            <th>Payout</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sessions as $s)
                            <tr>
                                <td>{{ $s->id }}</td>
                                <td>{{ $s->held_at }}</td>
                                <td>{{ optional($s->classroom)->name }}</td>
                                <td>{{ optional($s->instructor)->first_name }} {{ optional($s->instructor)->last_name }}</td>
                                <td>{{ optional($s->sessionType)->name }}</td>
                                <td>{{ number_format($s->session_payout ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No sessions found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @if(method_exists($sessions, 'links'))
                        <div class="p-3">
                            {{ $sessions->links() }}
                        </div>
                    @endif

                    <h5 class="p-3">Totals By Instructor</h5>
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Instructor</th>
                            <th>Sessions</th>
                            <th>Total Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($totals as $row)
                            <tr>
                                <td>{{ optional($row['instructor'])->first_name }} {{ optional($row['instructor'])->last_name }}</td>
                                <td>{{ $row['sessions_count'] }}</td>
                                <td>{{ number_format($row['amount'], 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No data found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                        @if(!empty($totals) && count($totals) > 0)
                            <tr>
                                <td><strong>Total</strong></td>
                                <td><strong>{{ collect($totals)->sum('sessions_count') }}</strong></td>
                                <td><strong>{{ number_format($grandTotal ?? 0, 2) }}</strong></td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection


