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
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
    <h3 class="mb-0">{{ $table_name }} Report</h3>
    <a href="{{ route('parentt.transactions.pdf') }}" class="btn btn-sm btn-primary">Download PDF</a>
  </div>

  {{-- Paid / charged / balance summary --}}
  <div class="row mb-4">
    <div class="col-md-4 mb-2">
      <div class="card border-0 shadow-sm"><div class="card-body">
        <div class="text-muted small">Total Charged</div>
        <div class="h4 mb-0">{{ number_format($totalCharged, 2) }} $</div>
      </div></div>
    </div>
    <div class="col-md-4 mb-2">
      <div class="card border-0 shadow-sm"><div class="card-body">
        <div class="text-muted small">Total Paid</div>
        <div class="h4 mb-0 text-success">{{ number_format($totalPaid, 2) }} $</div>
      </div></div>
    </div>
    <div class="col-md-4 mb-2">
      <div class="card border-0 shadow-sm"><div class="card-body">
        <div class="text-muted small">{{ $balance < 0 ? 'Outstanding (still owed)' : 'Balance (in credit)' }}</div>
        <div class="h4 mb-0 {{ $balance < 0 ? 'text-danger' : 'text-success' }}">{{ number_format(abs($balance), 2) }} $</div>
      </div></div>
    </div>
  </div>

  <div class="card border-top border-0 border-4 border-primary">
    <div class="card-body">
      @if(isset($list) && $list->count() > 0)
      <table class="table table-hover text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Student</th>
            <th>Course</th>
            <th>Amount</th>
            <th>Payment Type</th>
            <th>Description</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($list as $transaction)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ optional($transaction->created_at)->format('Y-m-d') }}</td>
            <td>{{ optional($transaction->student)->first_name ?? 'N/A' }} {{ optional($transaction->student)->last_name ?? '' }}</td>
            <td>{{ optional($transaction->course)->title ?? 'N/A' }}</td>
            <td>{{ number_format($transaction->price, 2) }} $</td>
            <td>{{ ucfirst($transaction->type ?? 'N/A') }}</td>
            <td>{{ $transaction->desc ?? 'N/A' }}</td>
            <td>
              @if($transaction->is_credit)
                <span class="badge badge-success">Paid</span>
              @else
                <span class="badge badge-danger">Charge</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <h5 class="p-3 mb-0">There are no {{ $table_name }} yet.</h5>
      @endif
    </div>
  </div>
</div>
@endsection