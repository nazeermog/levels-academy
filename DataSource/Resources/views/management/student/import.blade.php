@extends('datasource::management.layout.master')

@section('title')
Import Students
@endsection

@section('content')
<div class="page-wrapper">
  <div class="page-content">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Students</div>
      <div class="ps-3">
        <span class="text-muted"> / Import</span>
      </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Card -->
    <div class="card border-top border-0 border-4 border-primary">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Import Students via CSV</h3>
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">+ Add Manually</a>
      </div>

      <div class="card-body">

        {{-- Alerts --}}
        @if(session('success'))
        <div class="alert alert-success">
          ✅ {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
          ⚠️ {{ session('error') }}
        </div>
        @endif

        {{-- Upload Form --}}
        <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" class="mt-3">
          @csrf
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Upload CSV File</label>
              <input type="file" name="file" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold" for="organization_id">Organization</label>
              <select name="organization_id" id="organization_id" class="form-control">
                <option value="">Select organization</option>
                @foreach($organizations as $organization)
                <option value="{{ $organization->id }}" {{ request()->attributes->get('currentOrganization') && auth()->user()->role !== 'super_admin' && request()->attributes->get('currentOrganization')->id == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <button type="submit" class="btn btn-success">Import Students</button>
        </form>

        {{-- Previous Imports --}}
        @if(Storage::exists('imports'))
        <div class="mt-5">
          <h5 class="fw-bold">Previous Import Files</h5>
          <ul class="list-group">
            @foreach(Storage::files('imports') as $file)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              {{ basename($file) }}
              <a href="{{ route('admin.download.csv', basename($file)) }}" class="btn btn-sm btn-outline-secondary">
                Download
              </a>
            </li>
            @endforeach
          </ul>
        </div>
        @endif

      </div>
    </div>
    <!-- End Card -->

  </div>
</div>
@endsection