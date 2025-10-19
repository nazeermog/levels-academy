@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Instructor Session Totals @if(isset($currentOrg) && $currentOrg) ({{ $currentOrg->name }}) @endif</h3>
                    <form method="GET" action="" class="form-inline">
                        <div class="form-group mb-0">
                            <label for="month" class="mr-2">Month</label>
                            <input type="month" id="month" name="month" value="{{ $month ?? '' }}" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-primary ml-2">Filter</button>
                    </form>
                </div>
                <div class="card-body table-responsive p-0">
                    <h5 class="p-3">All Sessions</h5>
                    <table class="table table-striped table-hover text-nowrap align-middle">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Held At</th>
                            <th>Classroom</th>
                            <th>Instructor</th>
                            <th>Type</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sessions as $s)
                            <tr>
                                <td>{{ $s->id }}</td>
                                <td>{{ $s->held_at }}</td>
                                <td>{{ optional($s->classroom)->name }}</td>
                                <td>{{ optional($s->instructor)->first_name }} {{ optional($s->instructor)->last_name }}</td>
                                <td>{{ optional($s->type)->name }}</td>
                                <td>{{ number_format(optional($s->type)->price ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No sessions found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @if(method_exists($sessions, 'links'))
                        <div class="p-3">
                            {{ $sessions->links() }}
                        </div>
                    @endif

                    <h5 class="p-3">Totals By Instructor</h5>
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Instructor</th>
                            <th>Sessions</th>
                            <th>Total Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($totals as $row)
                            <tr>
                                <td>{{ optional($row['instructor'])->first_name }} {{ optional($row['instructor'])->last_name }}</td>
                                <td>{{ $row['sessions_count'] }}</td>
                                <td>{{ number_format($row['amount'], 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No data found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                        @if(!empty($totals) && count($totals) > 0)
                            <tr>
                                <td><strong>Total</strong></td>
                                <td><strong>{{ collect($totals)->sum('sessions_count') }}</strong></td>
                                <td><strong>{{ number_format($grandTotal ?? 0, 2) }}</strong></td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection


