@extends("student.layouts.dashboard")
@section("content")

<style>
    body {
        margin: 0;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        /* Set minimum height to 100% of viewport height */
        background-color: #f2f2f2;
        /* Set a background color for the body */
    }

    .classLink {
        text-decoration: none;
    }

    .classCard {
        width: 35vw;
        margin: 10px;
        /* Adjusted to 45% of viewport width to leave some space between cards */
        height: 50vh;
        /* Set height to 50% of viewport height */
        overflow: hidden;
        position: relative;
        color: black;
        border-radius: 8px;
        /* Add a border-radius for rounded corners */
        background-color: var(--blue);
        /* Set a background color for the class card */
    }

    .classOverlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        width: 100%;
        /* Remove transition property for opacity */
    }

    .classCol {
        padding: 8px;
        /* Add padding to each column */
    }

    .classTitle {
        color: black;
        font-size: 3em;
        /* Adjusted font size for title */
        margin-bottom: 8px;
    }

    .classDate {
        font-size: 1em;
    }

    .row {
        margin: 0;
    }
</style>

<div class="mdk-carousel__content row">
    @foreach ($exercises as $exercise)
        <div class="col-6 classCol">
            <a class="classLink"  href="{{ route('student.show.exercise', ['id' => $exercise->code ,'type'=>'abacus']) }}">
                <div class="classCard ">
                    <div class="classOverlay">
                        <div class="classTitle">{{ $exercise->title }}</div>
                        <div class="">{{ $exercise->numbers }}</div>
                       code to call by: <span class="">{{ $exercise->code }}</span>
                    </div>
                    {!! $exercise->qrCode !!}

                </div>
            </a>
        </div>
    @endforeach
</div>

@endsection
