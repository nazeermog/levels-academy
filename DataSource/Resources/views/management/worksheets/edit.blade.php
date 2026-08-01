@extends('datasource::management.layout.master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Worksheet #{{ $worksheet->id }}</h3>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.worksheets.update', $worksheet->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control"
                               value="{{ old('title', $worksheet->title) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description (optional)</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $worksheet->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Current file</label>
                        <div>
                            @if($worksheet->file)
                            <a href="{{ asset($worksheet->file) }}" target="_blank" rel="noopener">
                                {{ $worksheet->original_name ?: 'Open current file' }}
                            </a>
                            @else
                            <span class="text-muted">No file</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="file">Replace file (optional)</label>
                        <input type="file" id="file" name="file" class="form-control-file" accept=".pdf,.doc,.docx">
                        <small class="form-text text-muted">Leave empty to keep the current file. PDF, DOC, DOCX — max 20 MB.</small>
                    </div>

                    <div class="form-group">
                        <label for="is_active">Active</label>
                        @php($activeDefault = $worksheet->is_active ? '1' : '0')
                        <select id="is_active" name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', $activeDefault) == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_active', $activeDefault) == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.worksheets.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
