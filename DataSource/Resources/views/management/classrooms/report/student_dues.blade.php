@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 d-flex align-items-center">
                            <h3 class="card-title mb-0">Student Dues @if(isset($currentOrg) && $currentOrg) ({{ $currentOrg->name }}) @endif</h3>
                            <button type="button" onclick="window.print()" class="btn btn-sm btn-outline-primary d-print-none ml-3">Save as PDF</button>
                        </div>
                        <div class="col-12 col-md-6">
                            <form method="GET" action="" class="d-flex flex-wrap justify-content-end">
                                <div class="form-group mb-2 mr-2 d-flex align-items-center" style="min-width:140px;">
                                    <label for="month" class="mr-2 mb-0">Month</label>
                                    <input type="month" id="month" name="month" value="{{ $month ?? '' }}" class="form-control form-control-sm" />
                                </div>
                                <div class="form-group mb-2 mr-2 d-flex align-items-center" style="min-width:160px;">
                                    <label for="student_id" class="mr-2 mb-0">Student</label>
                                    <select id="student_id" name="student_id" class="form-control form-control-sm">
                                        <option value="">All</option>
                                        @foreach(($studentsList ?? collect()) as $s)
                                            <option value="{{ $s->user_id }}" {{ (string)($studentId ?? '') === (string)$s->user_id ? 'selected' : '' }}>
                                                {{ $s->first_name }} {{ $s->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-2 mr-2 d-flex align-items-center" style="min-width:160px;">
                                    <label for="parent_id" class="mr-2 mb-0">Parent</label>
                                    <select id="parent_id" name="parent_id" class="form-control form-control-sm">
                                        <option value="">All</option>
                                        @foreach(($parentsList ?? collect()) as $p)
                                            <option value="{{ $p->user_id }}" {{ (string)($parentId ?? '') === (string)$p->user_id ? 'selected' : '' }}>
                                                {{ $p->first_name }} {{ $p->last_name }}
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
                    <table class="table table-striped table-hover text-nowrap align-middle">
                        <thead>
                        <tr>
                            <th>Student</th>
                            <th>Parent</th>
                            <th>Transactions</th>
                            <th>Charges</th>
                            <th>Credits</th>
                            <th>Net Due</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($rows as $row)
                            <tr>
                                <td>{{ optional($row['student'])->first_name }} {{ optional($row['student'])->last_name }}</td>
                                <td>{{ optional($row['parent'])->first_name }} {{ optional($row['parent'])->last_name }}</td>
                                <td>{{ $row['transactions_count'] }}</td>
                                <td>{{ number_format($row['charges'], 2) }}</td>
                                <td>{{ number_format($row['credits'], 2) }}</td>
                                <td><strong>{{ number_format($row['net'], 2) }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No data found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                        @if(isset($rows) && count($rows) > 0)
                            <tfoot>
                            <tr>
                                <th colspan="3">Totals</th>
                                <th>{{ number_format(collect($rows)->sum('charges'), 2) }}</th>
                                <th>{{ number_format(collect($rows)->sum('credits'), 2) }}</th>
                                <th>{{ number_format(collect($rows)->sum('net'), 2) }}</th>
                            </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection



