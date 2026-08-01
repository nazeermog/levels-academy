@extends('datasource::management.layout.master')

@section('content')
<section class="content">
    <div class="container-fluid">

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Worksheets</h3>
                <a href="{{ route('admin.worksheets.create') }}" class="btn btn-primary float-right">+ Upload Worksheet</a>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>File</th>
                            <th>Active</th>
                            <th>Uploaded</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($worksheets as $w)
                        <tr>
                            <td>{{ $w->id }}</td>
                            <td>{{ $w->title }}</td>
                            <td>
                                @if($w->file)
                                <a href="{{ asset($w->file) }}" target="_blank" rel="noopener">
                                    {{ $w->original_name ?: 'Open file' }}
                                </a>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($w->is_active)
                                <span class="badge badge-success">Yes</span>
                                @else
                                <span class="badge badge-secondary">No</span>
                                @endif
                            </td>
                            <td>{{ optional($w->created_at)->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.worksheets.edit', $w->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.worksheets.destroy', $w->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this worksheet?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">No worksheets uploaded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($worksheets->hasPages())
            <div class="card-footer clearfix">{{ $worksheets->links() }}</div>
            @endif
        </div>
    </div>
</section>
@endsection
