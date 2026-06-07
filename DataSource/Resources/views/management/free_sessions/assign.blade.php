@extends('datasource::management.layout.master')

@section('content')
<section class="content">
    <div class="container-fluid">

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
                <h3 class="card-title">Assign Free Session</h3>
            </div>
            <div class="card-body">
                <p>
                    <strong>User:</strong>
                    {{ optional($freeSession->user)->first_name }} {{ optional($freeSession->user)->last_name }}
                    ({{ optional($freeSession->user)->email }})
                </p>
                @if($freeSession->note)
                    <p><strong>Note:</strong> {{ $freeSession->note }}</p>
                @endif

                @if($slots->isEmpty())
                    <div class="alert alert-warning">
                        No instructor availability slots are open. Ask instructors to add availability first.
                    </div>
                    <a href="{{ route('admin.free-sessions.index') }}" class="btn btn-secondary">Back</a>
                @else
                    <form method="POST" action="{{ route('admin.free-sessions.assign', $freeSession->id) }}">
                        @csrf
                        <div class="form-group">
                            <label>Choose an instructor &amp; time slot</label>
                            <div class="list-group">
                                @foreach($slots as $slot)
                                    <label class="list-group-item d-flex align-items-center">
                                        <input type="radio" name="availability_id" value="{{ $slot->id }}" class="mr-2" required>
                                        <span>
                                            <strong>{{ optional($slot->instructor)->first_name }} {{ optional($slot->instructor)->last_name }}</strong>
                                            &mdash;
                                            {{ $slot->start_at->format('Y-m-d H:i') }} to {{ $slot->end_at->format('H:i') }} (UTC)
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="content">Note for the session (optional)</label>
                            <textarea id="content" name="content" class="form-control" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Schedule &amp; email user</button>
                        <a href="{{ route('admin.free-sessions.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                @endif
            </div>
        </div>

    </div>
</section>
@endsection
