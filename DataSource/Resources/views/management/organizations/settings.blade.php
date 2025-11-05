@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Organization Settings</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.org.settings.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="absence_free_hours">Absence Free Hours</label>
                            <input type="number" min="0" max="168" id="absence_free_hours" name="absence_free_hours" class="form-control" value="{{ old('absence_free_hours', $organization->absence_free_hours ?? 24) }}" required>
                            <small class="form-text text-muted">Number of hours before session start where an absence incurs no charge.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


