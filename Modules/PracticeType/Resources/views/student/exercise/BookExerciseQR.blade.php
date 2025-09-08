@extends("student.layouts.dashboard")
@section("content")

<style>
    .exercise-card {
        background: #fff;
        border: 3px solid var(--blue); /* #009688 */
        border-radius: 6px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s;
        height: 100%;
    }

    .exercise-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
    }

    .exercise-title {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 10px;
        color: #333;
    }

    .exercise-numbers {
        font-size: 0.9rem;
        line-height: 1.4;
        color: #444;
    }

    .exercise-row {
        display: flex;
        flex-wrap: wrap;
        margin: -10px;
    }

    .exercise-col {
        flex: 0 0 25%;
        /* 4 per row (desktop) */
        max-width: 25%;
        padding: 10px;
        box-sizing: border-box;
    }

    /* Tablet */
    @media (max-width: 992px) {
        .exercise-col {
            flex: 0 0 33.33%;
            max-width: 33.33%;
        }
    }

    /* Mobile landscape */
    @media (max-width: 768px) {
        .exercise-col {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    /* Mobile portrait */
    @media (max-width: 480px) {
        .exercise-col {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Title Styling */
    .page-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--blue);
        margin-bottom: 20px;
        text-align: left;
    }
</style>

<div class="container">
    <h3 class="page-title">Exercises for Page {{ $page }}</h3>

    <div class="exercise-row">
        @forelse ($grouped as $row => $exercises)
        @foreach ($exercises as $exercise)
        <div class="exercise-col">
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
        @empty
        <p class="text-center">No exercises found for this page.</p>
        @endforelse
    </div>
</div>
@endsection