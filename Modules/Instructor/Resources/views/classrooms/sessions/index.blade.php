@extends('instructor.layouts.dashboard')

@push('css')
<style>
  #sessions-calendar { max-width: 1100px; margin: 0 auto; }
  /* Make day cells look clickable. */
  #sessions-calendar .fc-daygrid-day { cursor: pointer; }
  #sessions-calendar .fc-daygrid-day:hover { background: rgba(253, 126, 20, .08); }
  .session-legend { font-size: .9rem; }
  .session-legend .dot {
    display: inline-block; width: 12px; height: 12px;
    border-radius: 2px; margin-right: 4px; vertical-align: middle;
  }
  .session-legend .dot-given { background: #28a745; }
  .session-legend .dot-todo { background: #fd7e14; }
</style>
@endpush

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">My Class Sessions</h3>
      <div class="d-flex align-items-center">
        <span class="session-legend mr-3">
          <span class="dot dot-given"></span> Given
          &nbsp;
          <span class="dot dot-todo"></span> To give
        </span>
        <a href="{{ route('instructor.sessions.create') }}" class="btn btn-primary">Add Session</a>
      </div>
    </div>
    <div class="card-body">
      <p class="text-muted mb-3">Click a day to add a session for that date, or click a session to edit it.</p>
      <div id="sessions-calendar"></div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('sessions-calendar');
    if (!calendarEl || typeof FullCalendar === 'undefined') { return; }

    var createUrl = @json(route('instructor.sessions.create'));
    var eventsUrl = @json(route('instructor.sessions.events'));

    // Open the Add Session form prefilled with the given day (YYYY-MM-DD).
    function openCreateForDate(dateStr) {
      window.location.href = createUrl + '?date=' + encodeURIComponent(dateStr);
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      height: 'auto',
      // navLinks off so the date number doesn't hijack the click — the whole box creates a session.
      navLinks: false,
      nowIndicator: true,
      selectable: true,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      events: eventsUrl,
      // Click anywhere in a day box -> open the Add Session form prefilled with that date.
      dateClick: function (info) {
        openCreateForDate(info.dateStr);
      },
      // Drag-select one or more days -> create on the first selected day.
      select: function (info) {
        openCreateForDate(info.startStr.substring(0, 10));
      }
      // Clicking an event navigates to its edit page via the event's `url`.
    });

    calendar.render();
  });
</script>
@endpush
