@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Classrooms @if(isset($currentOrg) && $currentOrg) ({{ $currentOrg->name }}) @endif</h3>
                    <a href="{{ route('admin.org.classrooms.create') }}" class="btn btn-primary">Create Classroom</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Repeats/Week</th>
                            <th>Instructor</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($classrooms as $classroom)
                            <tr>
                                <td>{{ $classroom->id }}</td>
                                <td>{{ $classroom->name }}</td>
                                <td>{{ $classroom->repeats_per_week }}</td>
                                <td>{{ optional($classroom->instructor)->first_name }} {{ optional($classroom->instructor)->last_name }}</td>
                                <td>
                                    <a href="{{ route('admin.org.classrooms.edit', $classroom->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.org.classrooms.destroy', $classroom->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No classrooms found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if(method_exists($classrooms, 'links'))
                    <div class="card-footer clearfix">
                        {{ $classrooms->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection


