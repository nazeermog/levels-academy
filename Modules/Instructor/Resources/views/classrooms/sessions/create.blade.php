@extends('instructor.layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Add Class Session</h3>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('instructor.sessions.store') }}">
        @csrf
        <input type="hidden" name="tz" id="tz">
        <div class="form-group">
          <label for="classroom_id">Classroom</label>
          <select id="classroom_id" name="classroom_id" class="form-control" required>
            <option value="">Select Classroom</option>
            @foreach($classrooms as $c)
              <option value="{{ $c->id }}" data-session-time="{{ $c->session_time }}">{{ $c->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="held_at">Held At</label>
          <input type="datetime-local" id="held_at" name="held_at" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="end_at">End At</label>
          <input type="datetime-local" id="end_at" name="end_at" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="class_session_type_id">Session Type</label>
          <select id="class_session_type_id" name="class_session_type_id" class="form-control" required>
            <option value="">Select Type</option>
            @foreach($types as $t)
              <option value="{{ $t->id }}">{{ $t->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="zoom_url">Meeting Link (Zoom)</label>
          <input type="url" id="zoom_url" name="zoom_url" class="form-control" placeholder="https://zoom.us/j/..." value="{{ old('zoom_url') }}">
          <small class="form-text text-muted">Students enrolled in this classroom can join from their course.</small>
        </div>
        <div class="form-group">
          <label for="content">Content Presented</label>
          <textarea id="content" name="content" class="form-control" rows="5" placeholder="What did you present?"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('instructor.sessions.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
<script>
  (function() {
    var held = document.getElementById('held_at');
    var endAt = document.getElementById('end_at');
    var tzInput = document.getElementById('tz');
    if (!held || !endAt) { return; }

    // Detect browser timezone and set hidden input
    try {
      var tz = Intl.DateTimeFormat().resolvedOptions().timeZone || 'UTC';
      if (tzInput) tzInput.value = tz;
      console.log('[TZ] detected browser time zone:', tz);
    } catch (e) {
      if (tzInput) tzInput.value = 'UTC';
      console.log('[TZ] timezone detection failed; defaulting to UTC');
    }

    var endTouched = false;
    endAt.addEventListener('input', function() { endTouched = true; logTimes(); });

    function toLocalDatetimeValue(d) {
      var pad = function(n) { return String(n).padStart(2, '0'); };
      return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()) +
        'T' + pad(d.getHours()) + ':' + pad(d.getMinutes());
    }

    function logTimes() {
      var hv = held.value ? new Date(held.value) : null;
      var ev = endAt.value ? new Date(endAt.value) : null;
      if (hv) console.log('[TZ] held_at local:', held.value, '→ ISO:', hv.toISOString());
      if (ev) console.log('[TZ] end_at  local:', endAt.value,  '→ ISO:', ev.toISOString());
    }

    function updateEnd() {
      if (endTouched) { return; }
      if (!held.value) { return; }
      var start = new Date(held.value);
      if (isNaN(start.getTime())) { return; }
      start.setHours(start.getHours() + 1);
      endAt.value = toLocalDatetimeValue(start);
      logTimes();
    }

    held.addEventListener('change', updateEnd);
    held.addEventListener('input', function(){ updateEnd(); logTimes(); });

    var classroomSelect = document.getElementById('classroom_id');
    var DEFAULT_TIME = '10:00';

    // The selected classroom's configured start time (HH:mm), if any.
    function selectedSessionTime() {
      if (!classroomSelect) { return ''; }
      var opt = classroomSelect.options[classroomSelect.selectedIndex];
      var t = opt ? (opt.getAttribute('data-session-time') || '') : '';
      return t ? t.substring(0, 5) : '';
    }

    function currentDatePart() {
      return (held.value && held.value.length >= 10) ? held.value.substring(0, 10) : '';
    }

    // Set held_at to <date>T<classroom time | default>, keeping the chosen date.
    // The instructor can still freely edit the time afterwards.
    function applySessionTime(forceDate) {
      var datePart = forceDate || currentDatePart();
      if (!datePart) { return; }
      held.value = datePart + 'T' + (selectedSessionTime() || DEFAULT_TIME);
      updateEnd();
      logTimes();
    }

    // When a classroom is picked, snap the time to that classroom's session_time.
    if (classroomSelect) {
      classroomSelect.addEventListener('change', function () { applySessionTime(); });
    }

    // Prefill the date when arriving from a calendar day click (?date=YYYY-MM-DD).
    try {
      var params = new URLSearchParams(window.location.search);
      var presetDate = params.get('date');
      if (presetDate && !held.value) {
        var datePart = presetDate.length >= 10 ? presetDate.substring(0, 10) : presetDate;
        applySessionTime(datePart);
      }
    } catch (e) {}

    if (held.value && !endAt.value) {
      updateEnd();
    }

    // Log on submit to verify values being sent
    var form = held.closest('form');
    if (form) {
      form.addEventListener('submit', function() {
        console.log('[TZ] submitting',
          { tz: (tzInput && tzInput.value) || '', held_at: held.value, end_at: endAt.value });
      });
    }
  })();
  </script>
@endsection


