@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Organization Users @if($currentOrg) ({{ $currentOrg->name }}) @endif</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No users found for this organization.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if(method_exists($users, 'links'))
                    <div class="card-footer clearfix">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection


