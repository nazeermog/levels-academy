@extends("student.layouts.dashboard")
@section("content")

<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #f2f2f2;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    .container {
        width: 100%;
        padding: 20px;
    }

    .classLink {
        text-decoration: none;
        color: inherit;
        /* Ensure link text color inherits from the parent */
    }

    .classCard {
        width: 100%;
        /* Ensure card fits column width */
        margin: 5px;
        /* Add margin for spacing */
        height: auto;
        /* Adjust height to fit content */
        overflow: hidden;
        position: relative;
        color: black;
        border-radius: 8px;
        background-color: var(--blue);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }

    .classOverlay {
        text-align: center;
        margin-bottom: 10px;
        /* Space between title and QR code */
    }

    .classTitle {
        color: black;
        font-size: 1em;
        /* Adjust font size for better fit */
        margin-bottom: 8px;
    }

    .row {
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .col {
        flex: 0 0 14.28%;
        /* Approx 1/7 of the row width */
        max-width: 14.28%;
        /* Ensure 7 items per row */
        padding: 5px;
        /* Add padding around each column */
        box-sizing: border-box;
    }
</style>

<div class="container">
    <div class="row">
        @foreach ($exercises as $exercise)
        <div class="col">
            <a class="classLink" href="{{ route('student.show.exercise', ['id' => $exercise->code, 'type' => 'abacus']) }}">
                <div class="classCard">
                    <div class="classOverlay">
                        <div class="classTitle">{{ $exercise->title }}</div>
                    </div>
                    <!-- {!! $exercise->qrCode !!} -->
                    <div class="classTitle"> @foreach (explode(',', $exercise->numbers) as $number)
                        {{ $number }}<br>
                        @endforeach
                    </div>

                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection