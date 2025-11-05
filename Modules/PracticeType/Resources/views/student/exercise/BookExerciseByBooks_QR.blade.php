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
        background-color: #f2f2f2;
    }

    .classLink {
        text-decoration: none;
    }

    .classCard {
        width: 35vw;
        margin: 10px;
        height: 50vh;
        overflow: hidden;
        position: relative;
        color: black;
        border-radius: 8px;
        background-color: var(--blue);
    }

    .classOverlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        width: 100%;
    }

    .classCol {
        padding: 8px;
    }

    .classTitle {
        color: black;
        font-size: 3em;
        margin-bottom: 8px;
    }

    .row {
        margin: 0;
    }
</style>
<div class="mdk-carousel__content row">
    @foreach ($books as $book)
    <div class="col-6 classCol">
        <a class="classLink" href="{{ route('student.index.Bookexercise.pages.bybook.qr', ['book' => $book]) }}">
            <div class="classCard">
                <div class="classOverlay">
                    <span class="classTitle">{{ $book }}</span>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

@endsection


