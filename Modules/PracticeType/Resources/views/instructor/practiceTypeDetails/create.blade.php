@extends('instructor.layouts.dashboard')

@section('content')
@if($practiceLevels->count()>0)

<div class="container py-5">
    <div class="row">
        <label>
            @if(session('locale', config('app.locale')) == 'en')
            Add Practice Level
            @endif
            @if(session('locale', config('app.locale')) == 'ar')
            إضافة مستوى التمرين
            @endif
            @if(session('locale', config('app.locale')) == 'de')
            Übungsstufe hinzufügen
            @endif
        </label>
    </div>
    <hr />
    <form action="{{route('admin.practicesType.store')}}" method="POST">
        @csrf
        <div class="row">
            @foreach(localeSupported() as $locale)
            <div class="col-md-4 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    Title
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    الاسم
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Titel
                    @endif
                    {{ucwords($locale)}}</label>
                <input class="form-control" name="title-{{$locale}}">
            </div>
            @endforeach
        </div>
        <hr />
        <div class="row">

            <div class="col-md-4 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    Practice
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    التمرين
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Üben
                    @endif
                </label>
                <select class="form-control" name="practice_id">
                    @foreach($practices as $practice)
                    <option value="{{$practice->id}}">
                        {{$practice->title}}
                    </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-4 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    Levels
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    المستويات
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Ebenen
                    @endif
                </label>
                <select class="form-control" name="level_id">
                    @foreach($practiceLevels as $level)
                    <option value="{{ $level->id }}">{{ $level->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    Coins Taken
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    العملات المكتسبة
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Münzen genommen
                    @endif
                </label>
                <input class="form-control" name="coins_taken">
            </div>

        </div>
        <hr />

        <div class="row">

            <div class="col-md-6 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    seconds speed (for number_sum & math_game(1))
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    سرعة بالثواني (لـ number_sum و math_game(1))
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Sekundengeschwindigkeit (für number_sum & math_game(1))
                    @endif
                </label>
                <input class="form-control" name="seconds_speed">
            </div>
            <div class="col-md-6 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    cards number (for number_sum)
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    رقم البطاقات (لـ number_sum)
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Kartennummer (für number_sum)
                    @endif
                </label>
                <input class="form-control" name="card_number">
            </div>


        </div>
        <div class="row">
            <div class="col-md-6 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    range number from
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    رقم النطاق من
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Bereichsnummer von
                    @endif
                </label>
                <input class="form-control" name="range_number_from">
            </div>
            <div class="col-md-6 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    range number to
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    رقم النطاق الى
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Bereichsnummer bis
                    @endif
                </label>
                <input class="form-control" name="range_number_to">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    Column Count (for abacus)
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    عدد الأعمدة (للعداد)
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Spaltenanzahl (für Abakus)
                    @endif
                </label>
                <input class="form-control" name="col_count">
            </div>
            <div class="col-md-6 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    numbers To Sum (for abacus & math_game)
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    الأرقام إلى المجموع (للعبة العداد لألعاب الرياضيات)
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Zahlen zum Summieren (für Abakus und math_game)
                    @endif
                </label>
                <input class="form-control" name="numbers_to_sum">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    Timer (for math_games)
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    الموقت (لألعاب الرياضيات)
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Timer (für math_games)
                    @endif
                </label>
                <input class="form-control" name="timer">
            </div>
            <div class="col-md-6 ">
                <label for="">
                    @if(session('locale', config('app.locale')) == 'en')
                    Iterationen (für math_games)
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    التكرارات (لألعاب math_games)
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Iteration (für math_games)
                    @endif
                </label>
                <input class="form-control" name="turns">
            </div>
        </div>
        <hr />
        <div class="row">
            <button class="btn btn-primary col-md-2 m-2" id="submitForm">
                @if(session('locale', config('app.locale')) == 'en')
                SAVE
                @endif
                @if(session('locale', config('app.locale')) == 'ar')
                حفظ
                @endif
                @if(session('locale', config('app.locale')) == 'de')
                SPEICHERN
                @endif
            </button>
        </div>
    </form>
</div>
@else <div class="card border-top border-0 border-4 border-primary table-responsive">

    <div class="card-header">
        <h3 class="card-title float-left">
            @if(session('locale', config('app.locale')) == 'en')
            You should have some levels first.
            @endif
            @if(session('locale', config('app.locale')) == 'ar')
            يجب أن يكون لديك بعض المستويات أولا.
            @endif
            @if(session('locale', config('app.locale')) == 'de')
            Sie sollten zunächst einige Level haben.
            @endif
        </h3>
        <a href="{{route('admin.Practiceslevels.create')}}" class="btn btn-primary float-right">
            @if(session('locale', config('app.locale')) == 'en')
            + Add New
            @endif
            @if(session('locale', config('app.locale')) == 'ar')
            + إضافة جديد
            @endif
            @if(session('locale', config('app.locale')) == 'de')
            + Neu hinzufügen
            @endif
        </a>
    </div>
    @endif
    @endsection