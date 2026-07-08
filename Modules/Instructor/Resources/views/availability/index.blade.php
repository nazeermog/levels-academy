@extends('instructor.layouts.dashboard')

@section('content')
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
      <h3 class="card-title">Add Availability (Free Sessions)</h3>
    </div>
    <div class="card-body">
      <p class="text-muted">Add one or more time slots when you are available for free trial sessions. The admin will book these when scheduling a free session.</p>
      <form method="POST" action="{{ route('instructor.availability.store') }}">
        @csrf
        <input type="hidden" name="tz" id="tz">

        <div id="slots">
          <div class="form-row slot-row align-items-end mb-2">
            <div class="form-group col-md-5">
              <label>Start</label>
              <input type="datetime-local" name="slots[0][start]" class="form-control slot-start" required>
            </div>
            <div class="form-group col-md-5">
              <label>End</label>
              <input type="datetime-local" name="slots[0][end]" class="form-control slot-end" required>
            </div>
            <div class="form-group col-md-2">
              <button type="button" class="btn btn-danger btn-block remove-slot">Remove</button>
            </div>
          </div>
        </div>

        <button type="button" id="add-slot" class="btn btn-secondary mb-3">+ Add another slot</button>
        <br>
        <button type="submit" class="btn btn-primary">Save slots</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">My Availability Slots</h3>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>Start (your local time)</th>
            <th>End (your local time)</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($availabilities as $a)
            <tr>
              <td><span data-localtime="{{ $a->start_at->toIso8601String() }}">{{ $a->start_at->format('Y-m-d H:i') }} UTC</span></td>
              <td><span data-localtime="{{ $a->end_at->toIso8601String() }}">{{ $a->end_at->format('Y-m-d H:i') }} UTC</span></td>
              <td>
                @if($a->status === 'booked')
                  <span class="badge badge-secondary">Booked</span>
                @else
                  <span class="badge badge-success">Available</span>
                @endif
              </td>
              <td>
                @if($a->status !== 'booked')
                  <form method="POST" action="{{ route('instructor.availability.destroy', $a->id) }}" onsubmit="return confirm('Remove this slot?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="text-center">No availability slots yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  (function() {
    var tzInput = document.getElementById('tz');
    try {
      tzInput.value = Intl.DateTimeFormat().resolvedOptions().timeZone || 'UTC';
    } catch (e) {
      tzInput.value = 'UTC';
    }

    var slots = document.getElementById('slots');
    var index = 1;

    document.getElementById('add-slot').addEventListener('click', function() {
      var row = document.createElement('div');
      row.className = 'form-row slot-row align-items-end mb-2';
      row.innerHTML =
        '<div class="form-group col-md-5"><label>Start</label>' +
        '<input type="datetime-local" name="slots[' + index + '][start]" class="form-control slot-start" required></div>' +
        '<div class="form-group col-md-5"><label>End</label>' +
        '<input type="datetime-local" name="slots[' + index + '][end]" class="form-control slot-end" required></div>' +
        '<div class="form-group col-md-2">' +
        '<button type="button" class="btn btn-danger btn-block remove-slot">Remove</button></div>';
      slots.appendChild(row);
      index++;
    });

    // Remove a slot row (keep at least one).
    slots.addEventListener('click', function(e) {
      if (e.target.classList.contains('remove-slot')) {
        var rows = slots.querySelectorAll('.slot-row');
        if (rows.length > 1) {
          e.target.closest('.slot-row').remove();
        }
      }
    });

    // Auto-fill end = start + 1h when end is empty.
    slots.addEventListener('change', function(e) {
      if (e.target.classList.contains('slot-start')) {
        var row = e.target.closest('.slot-row');
        var end = row.querySelector('.slot-end');
        if (end && !end.value && e.target.value) {
          var d = new Date(e.target.value);
          if (!isNaN(d.getTime())) {
            d.setHours(d.getHours() + 1);
            var pad = function(n){ return String(n).padStart(2,'0'); };
            end.value = d.getFullYear() + '-' + pad(d.getMonth()+1) + '-' + pad(d.getDate()) +
              'T' + pad(d.getHours()) + ':' + pad(d.getMinutes());
          }
        }
      }
    });
  })();
</script>
@endsection
