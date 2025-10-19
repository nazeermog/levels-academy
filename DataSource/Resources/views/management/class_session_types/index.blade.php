@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Class Session Types @if(isset($currentOrg) && $currentOrg) ({{ $currentOrg->name }}) @endif</h3>
                    <a href="{{ route('admin.org.class_session_types.create') }}" class="btn btn-primary">Create Type</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($types as $type)
                            <tr>
                                <td>{{ $type->id }}</td>
                                <td>{{ $type->name }}</td>
                                <td>{{ number_format($type->price, 2) }}</td>
                                <td>
                                    <a href="{{ route('admin.org.class_session_types.edit', $type->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.org.class_session_types.destroy', $type->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No types found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if(method_exists($types, 'links'))
                    <div class="card-footer clearfix">
                        {{ $types->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection


