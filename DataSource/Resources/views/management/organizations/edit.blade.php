@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <h3>Edit Organization</h3>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.organizations.update', $organization->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Name</label>
                            <input name="name" class="form-control" value="{{ $organization->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Subdomain</label>
                            <input name="subdomain" class="form-control" value="{{ $organization->subdomain }}" required>
                        </div>
                        <div class="form-group">
                            <label>Theme CSS</label>
                            <input name="theme_css" class="form-control" value="{{ $organization->theme_css }}" placeholder="css/app.css">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ $organization->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Active</label>
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-secondary" href="{{ route('admin.organizations.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


