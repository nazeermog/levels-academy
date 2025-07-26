@extends('datasource::management.layout.master')
@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f9fafb;
    }

    /* توسيط كامل للصفحة */
    .page-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        /* أو center لو تريد وسط الصفحة عمودي */
        padding: 40px 15px;
        min-height: 100vh;
        box-sizing: border-box;
    }

    .page-content {
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
    }

    .filter-form {
        max-width: 1000px;
        margin: 30px auto 0 auto;
        padding: 25px 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgb(0 123 255 / 0.1);
        border: 1px solid #e3e6f0;
    }

    .filter-label {
        font-weight: 600;
        color: #333;
        display: block;
        margin-bottom: 6px;
    }

    .filter-block:hover {
        box-shadow: 0 0 12px rgb(0 123 255 / 0.2);
    }

    .timeline-item {
        background: #fff;
        box-shadow: 0 2px 10px rgb(0 0 0 / 0.08);
        padding: 20px;
        border-radius: 10px;
        border-left: 4px solid #007bff;
        margin: 30px auto;
        max-width: 800px;
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -14px;
        top: 30px;
        width: 14px;
        height: 14px;
        background-color: #007bff;
        border-radius: 50%;
        border: 3px solid #fff;
        z-index: 1;
    }

    .timeline-date {
        font-size: 14px;
        color: #777;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .timeline-content h4 {
        font-size: 20px;
        color: #007bff;
        margin-bottom: 10px;
    }

    .timeline-content ul {
        padding-left: 18px;
        color: #444;
        font-size: 15px;
    }

    .timeline-content ul li {
        margin-bottom: 6px;
    }

    .type-checkboxes {
        max-height: 120px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 6px;
        background: #fdfdfd;
    }

    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }

    .col-12.d-flex.justify-content-end.gap-3 {
        justify-content: center !important;
    }

    @media (max-width: 576px) {
        .filter-btns {
            flex-direction: column;
        }
    }
</style>

<div class="page-wrapper">
    <div class="page-content">

        <!-- Filter Form -->
        <form method="GET" class="filter-form">
            <div class="row g-4">

                <!-- User Filter -->
                <div class="col-md-4">
                    <div class="filter-block p-3 border rounded">
                        <label for="user_id" class="filter-label text-primary">Select User</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Role Filter -->
                <div class="col-md-4">
                    <div class="filter-block p-3 border rounded">
                        <label for="role" class="filter-label text-primary">Select Role</label>
                        <select name="role" id="role" class="form-select">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                            <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Type Filter (multi) -->
                <div class="col-md-4">
                    <div class="filter-block p-3 border rounded">
                        <label class="filter-label text-primary">Select Types</label>
                        <div class="type-checkboxes">
                            @foreach ($types as $type)
                            <div class="form-check form-check-inline me-3">
                                <input class="form-check-input" type="checkbox" name="type[]" value="{{ $type }}"
                                    id="type_{{ $type }}" {{ is_array(request('type')) && in_array($type, request('type')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_{{ $type }}">{{ $type }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="col-12 d-flex justify-content-center gap-3 mt-3">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">Filter</button>
                    <a href="{{ route('admin.userevents') }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold">Reset</a>
                </div>
            </div>
        </form>

        <!-- Timeline -->
        <div class="timeline mt-5">
            @forelse ($events as $event)
            <div class="timeline-item">
                <div class="timeline-date">{{ $event->created_at->format('Y-m-d') }}</div>
                <div class="timeline-content">
                    <h4>{{ $event->user->first_name ?? 'Unknown' }} {{ $event->user->last_name ?? '' }} - {{ $event->action }}</h4>
                    <ul>
                        <li><strong>Role:</strong> {{ $event->user->role ?? 'N/A' }}</li>
                        <li><strong>Type:</strong> {{ $event->type ?? 'N/A' }}</li>
                        <li><strong>Description:</strong> {{ $event->description }}</li>
                        <li><strong>Time:</strong> {{ $event->created_at->diffForHumans() }}</li>
                    </ul>
                </div>
            </div>
            @empty
            <div class="text-center text-muted fs-5 my-4">No events found.</div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($events instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-4">
            {!! $events->withQueryString()->links() !!}
        </div>
        @endif

    </div>
</div>
@endsection