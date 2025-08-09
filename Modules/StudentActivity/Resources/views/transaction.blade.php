@extends('parentt.layouts.dashboard')

@section('title')
  {{ $table_name }}
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
  .table td,
  .table th {
    vertical-align: middle;
  }
</style>
@endpush

@section('content')
<div class="container py-5">
  <div class="card border-top border-0 border-4 border-primary table-responsive">
    <div class="card-header">
      <h3 class="card-title float-left">List of {{ $table_name }}</h3>
    </div>
    <div class="card-body">
      @if(isset($list) && $list->count() > 0)
      <div class="row form-group mb-3">
        <div class="col-md-6">
          <label for="search-text">Text Search</label>
          <input id="search-text" type="text" class="form-control" placeholder="Search...">
        </div>
        <div class="col-md-6">
          <label for="student-name-filter">Student Name</label>
          <select id="student-name-filter" class="form-control">
            <option value="">All Students</option>
            <!-- Add student options here if needed -->
          </select>
        </div>
      </div>

      <div class="row form-group mb-3">
        <div class="col-md-6">
          <label for="from-date">From</label>
          <input id="from-date" type="date" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="to-date">To</label>
          <input id="to-date" type="date" class="form-control">
        </div>
      </div>

      <button class="btn btn-primary form-group mb-4">Search</button>

      <table class="table table-hover text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Student</th>
            <th>Course</th>
            <th>Price</th>
            <th>Payment Type</th>
            <th>Is Credit</th>
          </tr>
        </thead>
        <tbody>
          @foreach($list as $transaction)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
            <td>{{ optional($transaction->student)->first_name ?? 'N/A' }} {{ optional($transaction->student)->last_name ?? '' }}</td>
            <td>{{ optional($transaction->course)->title ?? 'N/A' }}</td>
            <td>{{ number_format($transaction->price, 2) }}</td>
            <td>{{ ucfirst($transaction->type ?? 'N/A') }}</td>
            <td>{{ $transaction->is_credit ? 'Yes' : 'No' }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      @else
      <h2>There are no {{ $table_name }} yet.</h2>
      @endif
    </div>
  </div>
</div>
@endsection
