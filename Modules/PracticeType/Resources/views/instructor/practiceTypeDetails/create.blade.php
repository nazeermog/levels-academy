@extends('instructor.layouts.dashboard')

@section('content')
    <div class="container py-5">
        <div class="row">
            <label>
                إضافة تفاصيل الحساب الذهني
            </label>
        </div>
        <hr/>
        <form action="{{route('instructor.'.$route_name.'.store')}}" method="POST">
            @csrf
            <div class="row">
                @foreach(localeSupported() as $locale)
                    <div class="col-md-4 ">
                        <label for="">
                            الاسم
                           {{$locale=='ar'?'بالعربي':'بالانكليزي'}}</label>
                        <input class="form-control" name="title-{{$locale}}">
                    </div>
                @endforeach
            </div>
            <hr/>
            <div class="row">

                    <div class="col-md-4 ">
                        <label for="">
                            التمرين
                        </label>
                        <select class="form-control" name="practice_id">
                            @foreach($practices as $practice)
                                <option value="{{$practice->id}}">
                                    {{$practice->title}}
                                </option>
                            @endforeach
                        </select>
                    </div>

            </div>
            <hr/>
            <div class="row">

                <div class="col-md-6 ">
                    <label for="">
                    السرعة بالثواني
                    </label>
                    <input class="form-control" name="seconds_speed">
                </div>
                <div class="col-md-6 ">
                    <label for="">
                    عدد البطاقات
                    </label>
                    <input class="form-control" name="card_number">
                </div>


            </div>
            <div class="row">
                <div class="col-md-6 ">
                    <label for="">
                    مجال بداية الأرقام
                    </label>
                    <input class="form-control" name="range_number_from">
                </div>
                <div class="col-md-6 ">
                    <label for="">

                        مجال نهاية الأرقام
                    </label>
                    <input class="form-control" name="range_number_to">
                </div>
            </div>
            <hr/>
            <div class="row">
                <button class="btn btn-primary col-md-2 m-2" id="submitForm">
                    حفظ
                </button>
            </div>
        </form>
    </div>
@endsection





