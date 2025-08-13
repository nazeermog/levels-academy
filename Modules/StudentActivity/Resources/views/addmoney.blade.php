@extends('parentt.layouts.dashboard')

@section('title')
Add Money
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
      <h3 class="card-title mb-0"> {{$table_name}}</h3>
      <h5 class="mb-0 text-primary">Balance: <span class="fw-bold">{{ number_format($balance, 2) }} $</span></h5>
    </div>
    <div class="card-body">
      @if(session('success'))
      <div class="alert alert-success-edited">
        {{ session('success') }}
      </div>
      @endif

      @if(session('error'))
      <div class="alert alert-danger-edited">
        {{ session('error') }}
      </div>
      @endif

      <form action="{{ route('parentt.addmoney') }}" method="POST">
        @csrf
        <div class="row mb-3">
          <div class="col-md-4">
            <label>Amount</label>
            <input
              type="number"
              name="price"
              step="0.01"
              min="1"
              class="form-control"
              placeholder="Enter amount"
              required>
          </div>
          <div class="col-md-4">
            <label>Description</label>
            <input
              type="text"
              name="desc"
              class="form-control"
              placeholder="Description">
          </div>
          <div class="col-md-4 align-self-end">
            <button type="submit" class="btn btn-success">Add Money</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection