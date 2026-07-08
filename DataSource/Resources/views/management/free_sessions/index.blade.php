@extends('datasource::management.layout.master')

@section('content')
<section class="content">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Free Session Waiting List</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Note</th>
                            <th>Requested</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pending as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>{{ optional($req->user)->first_name }} {{ optional($req->user)->last_name }}</td>
                                <td>{{ optional($req->user)->email }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($req->note, 60) }}</td>
                                <td>{{ $req->created_at?->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.free-sessions.assign.form', $req->id) }}" class="btn btn-sm btn-primary">Assign</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">No pending free-session requests.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Scheduled &amp; Given</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Instructor</th>
                            <th>Scheduled (UTC)</th>
                            <th>Status</th>
                            <th>Given (UTC)</th>
                            <th>Instructor Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($scheduled as $req)
                            @php($given = $req->status === \DataSource\Entities\FreeSession\FreeSessionRequest::STATUS_GIVEN)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>{{ optional($req->user)->first_name }} {{ optional($req->user)->last_name }}</td>
                                <td>{{ optional($req->instructor)->first_name }} {{ optional($req->instructor)->last_name }}</td>
                                <td>@if($req->scheduled_at)<span data-localtime="{{ $req->scheduled_at->toIso8601String() }}">{{ $req->scheduled_at->format('Y-m-d H:i') }} UTC</span>@endif</td>
                                <td>
                                    @if($given)
                                        <span class="badge badge-success">Given</span>
                                    @else
                                        <span class="badge badge-warning">Scheduled</span>
                                    @endif
                                </td>
                                <td>{{ optional($req->given_at)->format('Y-m-d H:i') }}</td>
                                <td style="white-space:normal;max-width:280px;">{{ $req->instructor_note }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">Nothing scheduled yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>
@endsection
