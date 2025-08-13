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
  <div class="card border-top border-0 border-4 border-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title mb-0">List of {{$table_name}}</h3>
      <h5 class="mb-0 text-primary">Balance: <span class="fw-bold">{{ number_format($balance, 2) }} $</span></h5>

    </div>
    <div class="card-body">
      @if(isset($list) && $list->count() > 0)
      <table class="table table-hover text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Student</th>
            <th>Course</th>
            <th>Price</th>
            <th>Payment Type</th>
            <th>description</th>
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
            <td>{{ ucfirst($transaction->desc ?? 'N/A') }}</td>

            <td>{{ $transaction->is_credit }}</td>
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