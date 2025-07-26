@extends('instructor.layouts.dashboard')

@section('content')
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f9fafb;
  }

  .filter-form {
    max-width: 900px;
    margin: 30px auto;
    padding: 25px 30px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgb(0 123 255 / 0.15);
    border: 1px solid #e3e6f0;
  }

  .filter-form label {
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
    color: #333;
  }

  .form-check-label {
    user-select: none;
  }

  .filter-btns {
    display: flex;
    gap: 12px;
  }

  .btn-primary,
  .btn-secondary {
    border-radius: 6px;
    padding: 10px 18px;
    font-weight: 600;
    transition: background-color 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #0056b3;
  }

  .btn-secondary:hover {
    background-color: #6c757d;
    color: #fff;
  }

  /* Timeline card improvements */
  .timeline-item {
    background: #fff;
    box-shadow: 0 2px 10px rgb(0 0 0 / 0.1);
    padding: 18px 25px;
    border-radius: 10px;
    border-left: 5px solid #007bff;
    margin: 25px auto;
    max-width: 700px;
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
    letter-spacing: 0.05em;
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

  /* Responsive tweaks */
  @media (max-width: 576px) {
    .filter-btns {
      flex-direction: column;
    }
  }

  .filter-block {
    transition: box-shadow 0.3s ease;
  }

  .filter-block:hover {
    box-shadow: 0 0 12px rgb(0 123 255 / 0.3);
  }

  .filter-label {
    font-size: 1.1rem;
  }

  .type-checkboxes::-webkit-scrollbar {
    width: 6px;
  }

  .type-checkboxes::-webkit-scrollbar-thumb {
    background-color: rgba(0, 123, 255, 0.5);
    border-radius: 10px;
  }
</style>

<div class="page-wrapper">
  <div class="page-content">

    <!-- Filter Form -->
    <form method="GET" class="filter-form">
      <div class="row g-4">

        <!-- Student Filter -->
        <div class="col-md-4">
          <div class="filter-block p-3 bg-white rounded shadow-sm border">
            <label for="studentSelect" class="filter-label mb-2 d-block fw-semibold text-primary">Select Student</label>
            <select id="studentSelect" name="student_id" class="form-select">
              <option value="">All Students</option>
              @foreach ($students as $student)
              <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                {{ $student->first_name ?? '' }} {{ $student->last_name ?? '' }}
              </option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Type Filter -->
        <div class="col-md-5">
          <div class="filter-block p-3 bg-white rounded shadow-sm border">
            <span class="filter-label mb-2 d-block fw-semibold text-primary">Select Types</span>
            <div class="type-checkboxes d-flex flex-wrap gap-3" style="max-height:130px; overflow-y:auto; border:1px solid #ddd; padding: 10px 15px; border-radius:6px; background:#fafafa;">
              @foreach ($types as $type)
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="checkbox"
                  name="type[]"
                  value="{{ $type }}"
                  id="type_{{ $type }}"
                  {{ is_array(request('type')) && in_array($type, request('type')) ? 'checked' : '' }}>
                <label class="form-check-label text-capitalize" for="type_{{ $type }}">{{ $type }}</label>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Role Filter -->
        <div class="col-md-3">
          <div class="filter-block p-3 bg-white rounded shadow-sm border">
            <label for="roleSelect" class="filter-label mb-2 d-block fw-semibold text-primary">Select Role</label>
            <select id="roleSelect" name="role" class="form-select">
              <option value="">All Roles</option>
              @foreach ($roles as $role)
              <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                {{ ucfirst($role) }}
              </option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Buttons -->
        <div class="col-12 d-flex justify-content-end gap-3 mt-3">
          <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">Filter</button>
          <a href="{{ route('instructor.student.events') }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold">Reset</a>
        </div>

      </div>
    </form>
    <!-- Timeline -->
    <div class="timeline">
      @forelse ($events as $event)
      <div class="timeline-item">
        <div class="timeline-date">{{ $event->created_at->format('Y-m-d') }}</div>
        <div class="timeline-content">
          <h4>{{ $event->user->first_name ?? 'Unknown' }} {{ $event->user->last_name ?? '' }} - {{ $event->action }}</h4>
          <ul>
            <li><strong>Role:</strong> {{ $event->role }}</li>
            <li><strong>Type:</strong> {{ $event->type ?? 'N/A' }}</li>
            <li><strong>Description:</strong> {{ $event->description }}</li>
            <li><strong>Time:</strong> {{ $event->created_at->diffForHumans() }}</li>
          </ul>
        </div>
      </div>
      @empty
      <div class="text-center fs-5 text-muted my-4">No events found.</div>
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