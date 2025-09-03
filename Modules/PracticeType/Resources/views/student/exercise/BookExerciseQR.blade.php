@extends("student.layouts.dashboard")
@section("content")

<style>
    .exercise-card {
        background: #aad8ce;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        transition: transform 0.2s ease-in-out;
        height: 100%;
    }

    .exercise-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .exercise-title {
        font-weight: bold;
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .exercise-numbers {
        font-size: 0.85rem;
        line-height: 1.3;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 20px;
    }

    .col {
        flex: 0 0 11.11%;   /* 9 per row */
        max-width: 11.11%;
        padding: 5px;
        box-sizing: border-box;
    }
</style>

<div class="container">
    <h3 class="mb-4 text-center">Exercises for Page {{ $page }}</h3>

    @forelse ($grouped as $row => $exercises)
        <div class="row">
            @foreach ($exercises as $exercise)
                <div class="col">
                    <a class="classLink" href="{{ route('student.show.exercise', ['id' => $exercise->code, 'type' => 'abacus']) }}">
                        <div class="exercise-card">
                            <div class="exercise-title">{{ $exercise->title }}</div>
                            <div class="exercise-numbers">
                                @foreach (explode(',', $exercise->numbers) as $number)
                                    {{ $number }}<br>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @empty
        <p class="text-center">No exercises found for this page.</p>
    @endforelse
</div>
@endsection
