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

    .mdk-carousel__content {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .classLink {
        text-decoration: none;
    }

    .classCard {
        width: 280px;
        margin: 0;
        height: 280px;
        overflow: hidden;
        position: relative;
        color: black;
        border-radius: 12px;
        background-color: var(--blue);
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
    }

    .classCol {
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }

    .classTitle {
        color: black;
        font-size: 2.2em;
        margin-bottom: 8px;
        font-weight: 600;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        letter-spacing: 0.5px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        display: block;
        line-height: 1.2;
    }

    .row {
        margin: 0;
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 20px);
        width: 100%;
        box-sizing: border-box;
    }
</style>
<div class="mdk-carousel__content row">
    @foreach ($books as $book)
    <div class="col-4 classCol">
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


