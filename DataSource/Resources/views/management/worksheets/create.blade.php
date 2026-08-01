@extends('datasource::management.layout.master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Upload Worksheet</h3>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.worksheets.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control"
                               value="{{ old('title') }}" placeholder="e.g. Letter A worksheet" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description (optional)</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="file">File (PDF or Word)</label>
                        <input type="file" id="file" name="file" class="form-control-file"
                               accept=".pdf,.doc,.docx" required>
                        <small class="form-text text-muted">Accepted: PDF, DOC, DOCX — max 20 MB.</small>
                    </div>

                    <div class="form-group">
                        <label for="is_active">Active</label>
                        <select id="is_active" name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Upload</button>
                    <a href="{{ route('admin.worksheets.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
