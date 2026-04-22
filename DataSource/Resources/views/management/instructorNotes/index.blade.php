@extends('datasource::management.layout.master')
@section('title')
    {{ $table_name }}
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{ $table_name }}</div>
            </div>

            <div class="card border-top border-0 border-4 border-primary table-responsive">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title m-0">List of {{ $table_name }}</h3>
                </div>
                <div class="card-body">
                    @if ($notes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student</th>
                                    <th>Instructor</th>
                                    <th>Note</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($notes as $note)
                                    <tr>
                                        <td>{{ $note->id }}</td>
                                        <td>{{ trim((optional($note->student->user)->first_name ?? '').' '.(optional($note->student->user)->last_name ?? '')) ?: '—' }}</td>
                                        <td>{{ trim((optional($note->instructor)->first_name ?? '').' '.(optional($note->instructor)->last_name ?? '')) ?: '—' }}</td>
                                        <td style="white-space: pre-wrap; max-width: 600px;">{{ $note->note }}</td>
                                        <td>
                                            <div class="d-inline-flex" style="font-size: 16px; color: #f5b301; letter-spacing: 1px;">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= (int) $note->rating)
                                                        <span>★</span>
                                                    @else
                                                        <span style="color: #c7c7c7;">☆</span>
                                                    @endif
                                                @endfor
                                            </div>
                                        </td>
                                        <td>
                                            @if($note->is_read)
                                                <span class="badge badge-success">Read</span>
                                            @else
                                                <span class="badge badge-warning">Unread</span>
                                            @endif
                                        </td>
                                        <td>{{ $note->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3 mb-3 mx-3">
                                {{ $notes->links('datasource::management.partials.pagination',['paginator'=>$notes]) }}
                            </div>
                        </div>
                    @else
                        <h5>No notes found.</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


