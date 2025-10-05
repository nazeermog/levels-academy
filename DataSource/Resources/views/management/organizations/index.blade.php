@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb-3">
                <h3>Organizations</h3>
                <a href="{{ route('admin.organizations.create') }}" class="btn btn-primary">Create</a>
            </div>
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Subdomain</th>
                            <th>Theme CSS</th>
                            <th>Active</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($organizations as $org)
                            <tr>
                                <td>{{ $org->id }}</td>
                                <td>{{ $org->name }}</td>
                                <td>{{ $org->subdomain }}</td>
                                <td>{{ $org->theme_css }}</td>
                                <td>{{ $org->is_active ? 'Yes' : 'No' }}</td>
                                <td class="text-right">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('admin.organizations.edit', $org->id) }}">Edit</a>
                                    <form action="{{ route('admin.organizations.destroy', $org->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this organization?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $organizations->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection


