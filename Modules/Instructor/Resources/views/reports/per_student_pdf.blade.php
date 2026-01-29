<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{ $table_name }} - {{ $month }}</title>
  <style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #222; }
    h1 { font-size: 18px; margin: 0 0 10px; }
    .meta { margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
    th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
    th { background: #f2f2f2; }
    .right { text-align: right; }
  </style>
</head>
<body>
  <h1>{{ $table_name }}</h1>
  <div class="meta">
    @if(!empty($monthLabel))
      <div><strong>Month:</strong> {{ $monthLabel }}</div>
    @endif
    @if(!empty($studentName))
      <div><strong>Student:</strong> {{ $studentName }}</div>
    @endif
    @if(!empty($classroomName))
      <div><strong>Classroom:</strong> {{ $classroomName }}</div>
    @endif
    @if(!empty($typeName))
      <div><strong>Type:</strong> {{ $typeName }}</div>
    @endif
    <div><strong>Total Sessions:</strong> {{ $sessionsCount }}</div>
    <div><strong>Total Payout:</strong> {{ number_format($grandTotal, 2) }} $</div>
  </div>

  @if(isset($rows) && $rows->count())
  <table>
    <thead>
      <tr>
        <th>Student</th>
        <th class="right">Sessions</th>
        <th class="right">Instructor Due ($)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $row)
      <tr>
        <td>{{ optional($row['student'])->first_name }} {{ optional($row['student'])->last_name }}</td>
        <td class="right">{{ $row['sessions_count'] }}</td>
        <td class="right">{{ number_format($row['amount'], 2) }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th>Total</th>
        <th class="right">{{ $rows->sum('sessions_count') }}</th>
        <th class="right">{{ number_format($rows->sum('amount'), 2) }}</th>
      </tr>
    </tfoot>
  </table>
  @else
    <p>No data for the selected month.</p>
  @endif

  @if(isset($sessionsDetailed) && $sessionsDetailed->count())
  <h2>Sessions</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Held At</th>
        <th>Classroom</th>
        <th>Type</th>
        <th class="right">Payout ($)</th>
        <th class="right">Participants</th>
        <th class="right">Per Student ($)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($sessionsDetailed as $s)
      <tr>
        <td>{{ $s['id'] }}</td>
        <td>{{ $s['held_at'] }}</td>
        <td>{{ $s['classroom'] ?? '—' }}</td>
        <td>{{ $s['type'] ?? '—' }}</td>
        <td class="right">{{ number_format($s['teacher_payout'], 2) }}</td>
        <td class="right">{{ $s['participants_count'] }}</td>
        <td class="right">{{ number_format($s['per_student_share'], 2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endif
</body>
</html>
