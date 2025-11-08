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
        width: 280px;
        margin: 0;
        /* Adjusted to 45% of viewport width to leave some space between cards */
        height: 280px;
        /* Set height to 50% of viewport height */
        overflow: hidden;
        position: relative;
        color: black;
        border-radius: 12px;
        /* Add a border-radius for rounded corners */
        background-color: var(--blue);
        /* Set a background color for the class card */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .classCard:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15), 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .classOverlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
        /* Remove transition property for opacity */
    }

    .classCol {
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        /* Add padding to each column */
    }

    .classTitle {
        color: black;
        font-size: 2.2em;
        /* Adjusted font size for title */
        margin-bottom: 8px;
        font-weight: 600;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        letter-spacing: 0.5px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        display: block;
        line-height: 1.2;
    }

    .classDate {
        font-size: 1em;
    }

    .row {
        margin: 0;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 40px);
        /* Remove default margin of the row */
    }
</style>
<div class="mdk-carousel__content row">
    @foreach ($pagesWithQrCodes as $pageWithQrCode)
    <div class="col-4 classCol">
        <a class="classLink" href="{{ route('student.index.Bookexercise.qr', ['page' => $pageWithQrCode['page']]) }}">
            <div class="classCard class{{ strtoupper($pageWithQrCode['page']) }}">
                <div class="classOverlay">
                    <span class="classTitle"> Page: {{ $pageWithQrCode['page'] }}</span>
                </div>
                {!! $pageWithQrCode['qrCode'] !!}

            </div>
        </a>
    </div>
    @endforeach
</div>

@endsection