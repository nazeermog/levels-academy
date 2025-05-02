@extends('datasource::management.layout.master')
@section('title')
{{$table_name}}
@endsection

@push('css')
<style>
    .alert-danger-edited {
        color: #000;
        background-color: #dc35457a;
        border-color: #dc35457a;
    }
    .alert-success-edited {
        color: #000;
        background-color: #28a7457a;
        border-color: #28a7457a;
    }
    .stats-card {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .stats-value {
        font-size: 1.5rem;
        font-weight: bold;
    }
    .progress-text {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        font-weight: bold;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3);
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{$table_name}}</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$table_name}}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-header">
                <h3 class="card-title float-left">List of {{$table_name}}</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route($route_name . '.index') }}">
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label>Student</label>
                            <select name="student_id" class="form-control">
                                <option value="">All Students</option>
                                @foreach($students as $student)
                                <option value="{{ $student->user_id }}" {{ request('student_id') == $student->user_id ? 'selected' : '' }}>
                                    {{ $student->first_name . ' ' . $student->last_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Practice Type</label>
                            <select name="practice_id" class="form-control">
                                <option value="">All Practices</option>
                                @foreach($practices as $practice)
                                <option value="{{ $practice->id }}" {{ request('practice_id') == $practice->id ? 'selected' : '' }}>
                                    {{ $practice->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Practice Level</label>
                            <select name="level_id" class="form-control">
                                <option value="">All Levels</option>
                                @foreach($practiceLevels as $level)
                                <option value="{{ $level->id }}" {{ request('level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>From Date</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label>To Date</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="is_true" class="form-control">
                                <option value="">All</option>
                                <option value="1" {{ request('is_true') === '1' ? 'selected' : '' }}>Correct</option>
                                <option value="0" {{ request('is_true') === '0' ? 'selected' : '' }}>Incorrect</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route($route_name . '.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="stats-card bg-light">
                            <h5>Total Attempts</h5>
                            <div class="stats-value">{{ $totalAttempts }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card bg-light">
                            <h5>Correct Answers</h5>
                            <div class="stats-value">{{ $correctAnswers }}</div>
                            <div class="progress mt-2" style="height: 20px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $correctPercentage }}%">
                                    <span class="progress-text">{{ number_format($correctPercentage, 1) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card bg-light">
                            <h5>Incorrect Answers</h5>
                            <div class="stats-value">{{ $incorrectAnswers }}</div>
                            <div class="progress mt-2" style="height: 20px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $incorrectPercentage }}%">
                                    <span class="progress-text">{{ number_format($incorrectPercentage, 1) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($list->count() > 0)
                <div class="table-responsive mt-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Practice</th>
                                <th>Level</th>
                                <th>Correct Answer</th>
                                <th>Student Answer</th>
                                <th>Duration</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $item->student->first_name . ' ' . $item->student->last_name }}</td>
                                <td>{{ $item->practice->title ?? '-' }}</td>
                                <td>{{ $item->practiceLevel->title ?? $item->level_title }}</td>
                                <td>{{ $item->result_true }}</td>
                                <td>{{ $item->result_student }}</td>
                                <td>{{ $item->resultsType->seconds_speed ?? '-' }} sec</td>
                                <td class="{{ $item->is_true ? 'alert-success-edited' : 'alert-danger-edited' }}">
                                    @if($item->is_true)
                                    <i class="fas fa-check text-success"></i> Correct
                                    @else
                                    <i class="fas fa-ban text-danger"></i> Incorrect
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3 mb-3 mx-3">
                        {{ $list->appends(request()->query())->links('datasource::management.partials.pagination') }}
                    </div>
                </div>
                @else
                <div class="alert alert-info mt-4">
                    There are no results matching your criteria.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection