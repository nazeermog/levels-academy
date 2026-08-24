<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { color: #222; font-size: 12px; }
        h1 { font-size: 18px; margin: 0 0 2px; }
        .muted { color: #777; font-size: 11px; }
        .summary { width: 100%; margin: 14px 0; border-collapse: collapse; }
        .summary td { width: 33%; border: 1px solid #e0e0e0; padding: 8px 10px; }
        .summary .label { color: #777; font-size: 10px; text-transform: uppercase; }
        .summary .val { font-size: 15px; font-weight: bold; }
        .green { color: #1f7a50; }
        .red { color: #c0392b; }
        table.tx { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.tx th, table.tx td { border: 1px solid #ddd; padding: 6px 8px; font-size: 11px; }
        table.tx th { background: #f3f3f3; text-align: left; }
        table.tx td.num { text-align: right; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 10px; color: #fff; }
        .badge-paid { background: #1f7a50; }
        .badge-charge { background: #c0392b; }
    </style>
</head>
<body>
    <h1>{{ $appName }} — Transactions Report</h1>
    <div class="muted">
        @if($parentName){{ $parentName }} · @endif
        Generated {{ $generatedAt->format('Y-m-d H:i') }}
    </div>

    <table class="summary">
        <tr>
            <td>
                <div class="label">Total Charged</div>
                <div class="val">{{ number_format($totalCharged, 2) }} $</div>
            </td>
            <td>
                <div class="label">Total Paid</div>
                <div class="val green">{{ number_format($totalPaid, 2) }} $</div>
            </td>
            <td>
                <div class="label">{{ $balance < 0 ? 'Outstanding (owed)' : 'Balance (credit)' }}</div>
                <div class="val {{ $balance < 0 ? 'red' : 'green' }}">{{ number_format(abs($balance), 2) }} $</div>
            </td>
        </tr>
    </table>

    @if($list->count() > 0)
    <table class="tx">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Student</th>
                <th>Course</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $i => $transaction)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ optional($transaction->created_at)->format('Y-m-d') }}</td>
                <td>{{ optional($transaction->student)->first_name ?? 'N/A' }} {{ optional($transaction->student)->last_name ?? '' }}</td>
                <td>{{ optional($transaction->course)->title ?? 'N/A' }}</td>
                <td class="num">{{ number_format($transaction->price, 2) }} $</td>
                <td>{{ ucfirst($transaction->type ?? 'N/A') }}</td>
                <td>{{ $transaction->desc ?? 'N/A' }}</td>
                <td>
                    @if($transaction->is_credit)
                        <span class="badge badge-paid">Paid</span>
                    @else
                        <span class="badge badge-charge">Charge</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p>There are no transactions yet.</p>
    @endif
</body>
</html>
