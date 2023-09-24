@extends('instructor.layouts.dashboard')

@section('content')

<div class="page-wrapper">
    <div class="page-content">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href=#>Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('instructor.'.$route_name.'.index')}}"> {{$table_name}}</a></li>

                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->

                        <form class="card" action="{{route('instructor.'.$route_name.'.update',$item->id)}}" id="form-about" enctype="multipart/form-data" method="POST">
                            @csrf

                            {{ method_field('PUT') }}
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" value="{{$item->id}}" name="model_id">
                            <div class="card-header">
                                <h3 class="card-title">
                                    @if(session('locale', config('app.locale')) == 'en')
                                    Update Practice Level
                                    @endif
                                    @if(session('locale', config('app.locale')) == 'ar')
                                    تعديل مستوى التمرين
                                    @endif
                                    @if(session('locale', config('app.locale')) == 'de')
                                    Übungsniveau aktualisieren
                                    @endif
                                </h3>
                            </div>
                            <div class="card-body">
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
                                        <input type="text" class="form-control" name="title-{{$locale}}" value="{{old('title-'.$locale,$item->translateOrDefault($locale)->title)}}" placeholder="Enter Title {{ucwords($locale)}}">
                                    </div>
                                    @endforeach
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-4">
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
                                        </label> <select class="form-control" name="practice_id">
                                            @foreach ($practices as $practice)
                                            <option value="{{ $practice->id }}" @if ($item->practice_id==$practice->id)
                                                selected
                                                @endif>
                                                {{ $practice->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
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
                                            @foreach ($practiceLevels as $level)
                                            <option value="{{ $level->id }}" @if ($item->level_id==$level->id)
                                                selected
                                                @endif>
                                                {{ $level->title }}
                                            </option>
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
                                        </label> <input class="form-control" name="coins_taken" value="{{$item->coins_taken}}">
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
                                        <input class="form-control" name="seconds_speed" value="{{$item->seconds_speed}}">
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
                                        </label> <input class="form-control" name="card_number" value="{{$item->card_number}}">
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
                                        </label> <input class="form-control" name="range_number_from" value="{{$item->range_number_from}}">
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
                                        </label> <input class="form-control" name="range_number_to" value="{{$item->range_number_to}}">
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
                                        </label> <input class="form-control" name="col_count" value="{{$item->col_count}}">
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="">
                                            @if(session('locale', config('app.locale')) == 'en')
                                            numbers To Sum (for abacus & math_game)
                                            @endif
                                            @if(session('locale', config('app.locale')) == 'ar')
                                            الأرقام إلى المجموع (للعبة العداد و لألعاب الرياضيات)
                                            @endif
                                            @if(session('locale', config('app.locale')) == 'de')
                                            Zahlen zum Summieren (für Abakus und math_game)
                                            @endif
                                        </label> <input class="form-control" name="numbers_to_sum" value="{{$item->numbers_to_sum}}">
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
                                        </label> <input class="form-control" name="timer" value="{{$item->timer}}">
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
                                        </label> <input class="form-control" name="turns" value="{{$item->turns}}">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submit-form">Submit</button>
                            </div>
                            <!-- /.card-footer-->
                        </form>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection