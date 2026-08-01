@extends('datasource::management.layout.master')

@section('content')
<section class="content">
    <div class="container-fluid">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Links</h3>
                <a href="{{ route('admin.links.create') }}" class="btn btn-primary float-right">+ Add Link</a>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($links as $link)
                        <tr>
                            <td>{{ $link->id }}</td>
                            <td>{{ $link->title }}</td>
                            <td style="max-width:420px;overflow:hidden;text-overflow:ellipsis;">
                                <a href="{{ $link->url }}" target="_blank" rel="noopener">{{ $link->url }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.links.edit', $link->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.links.destroy', $link->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this link?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">No links yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($links->hasPages())
            <div class="card-footer clearfix">{{ $links->links() }}</div>
            @endif
        </div>
    </div>
</section>
@endsection
