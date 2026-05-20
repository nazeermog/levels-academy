@extends("student.layouts.dashboard")
@push('css')
    <style>
        #sortable {
            width: 700px;
            height: 35px;
            padding: 0.1em;
        }

        #sortable > div {
            float: right;
        }

        div {
            font-size: 18px;
        }
    </style>
@endpush
@section("content")
    <div class="navbar navbar-list navbar-light bg-white border-bottom-2 border-bottom navbar-expand-sm"
         style="white-space: nowrap;">
        <div class="container page__container">
            <nav class="nav navbar-nav">
                <div class="nav-item navbar-list__item">
                    <a href="#"
                       class="nav-link h-auto"><i class="material-icons icon--left">keyboard_backspace</i>
                        العودة إلى الدرس
                    </a>
                </div>
                <div class="nav-item navbar-list__item">
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="mr-16pt">
                            {{--                            <a href="#"><img src="../../public/images/paths/angular_64x64.png"--}}
                            {{--                                                                    width="40"--}}
                            {{--                                                                    alt="Angular"--}}
                            {{--                                                                    class="rounded"></a>--}}
                        </div>
                        <div class="flex">
                            <a href="#"
                               class="card-title text-body mb-0">
                                الاختبار الأول
                            </a>
                            {{--                            <p class="lh-1 d-flex align-items-center mb-0">--}}
                            {{--                                <span class="text-50 small font-weight-bold mr-8pt">Elijah Murray</span>--}}
                            {{--                                <span class="text-50 small">Software Engineer and Developer</span>--}}
                            {{--                            </p>--}}
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    {{--    <div class="bg-primary pb-lg-64pt py-32pt">--}}
    {{--        <div class="container page__container">--}}
    {{--            <nav class="course-nav">--}}
    {{--                <a href="student-take-lesson.html"--}}
    {{--                   data-toggle="tooltip"--}}
    {{--                   data-placement="bottom"--}}
    {{--                   data-title="Getting Started with Angular: Introduction"><span--}}
    {{--                        class="material-icons">check_circle</span></a>--}}
    {{--                <a data-toggle="tooltip"--}}
    {{--                   data-placement="bottom"--}}
    {{--                   data-title="Getting Started with Angular: Introduction to TypeScript"--}}
    {{--                   href="student-take-lesson.html"><span class="material-icons">check_circle</span></a>--}}
    {{--                <a data-toggle="tooltip"--}}
    {{--                   data-placement="bottom"--}}
    {{--                   data-title="Getting Started with Angular: Comparing Angular to AngularJS"--}}
    {{--                   href="student-take-lesson.html"><span class="material-icons">check_circle</span></a>--}}
    {{--                <a href="student-take-quiz.html"--}}
    {{--                   data-toggle="tooltip"--}}
    {{--                   data-placement="bottom"--}}
    {{--                   data-title="Quiz: Getting Started with Angular"><span class="material-icons text-primary">account_circle</span></a>--}}
    {{--            </nav>--}}

    {{--            <div class="d-flex flex-wrap align-items-end justify-content-end mb-16pt">--}}
    {{--                <h1 class="text-white flex m-0">Question 1 of 5</h1>--}}
    {{--                <p class="h1 text-white-50 font-weight-light m-0">00:14</p>--}}
    {{--            </div>--}}

    {{--            <p class="hero__lead measure-hero-lead text-white-50">An angular 2 project written in typescript is*--}}
    {{--                transpiled to javascript duri*ng the build process. Which of the following additional features are--}}
    {{--                provided to the developer while programming on typescript over javascript?</p>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    @foreach($questions as $qu)
        <div class="navbar navbar-expand-md navbar-list navbar-light bg-white border-bottom-2 "
             style="white-space: nowrap;">
            <div class="container page__container">
                <ul class="nav navbar-nav flex navbar-list__item">
                    <li class="nav-item">
                        <i class="material-icons text-50 mr-8pt">help</i>
                        <b style="font-size: 26px">
                            {{$qu->question_text}}:
                        </b>
                    </li>
                </ul>
                {{--            <div class="nav navbar-nav ml-sm-auto navbar-list__item">--}}
                {{--                <div class="nav-item d-flex flex-column flex-sm-row ml-sm-16pt">--}}
                {{--                    <a href="student-quiz-result-details.html"--}}
                {{--                       class="btn justify-content-center btn-outline-secondary w-100 w-sm-auto mb-16pt mb-sm-0">Skip--}}
                {{--                        Quiz</a>--}}
                {{--                    <a href="student-take-lesson.html"--}}
                {{--                       class="btn justify-content-center btn-outline-secondary w-100 w-sm-auto mb-16pt mb-sm-0 ml-sm-16pt">Review--}}
                {{--                        Video</a>--}}
                {{--                    <a href="student-quiz-result-details.html"--}}
                {{--                       class="btn justify-content-center btn-accent w-100 w-sm-auto mb-16pt mb-sm-0 ml-sm-16pt">Next--}}
                {{--                        Question <i class="material-icons icon--right">keyboard_arrow_right</i></a>--}}
                {{--                </div>--}}
                {{--            </div>--}}
            </div>
        </div>

        <div class="container page__container">
            <div class="page-section">
                <div class="page-separator">
                    <div class="page-separator__text">
                        الخيارات
                    </div>
                </div>

                @if ($qu->question_type == 'radio_answer')
                    @foreach(\Modules\DataResource\Entities\Question\Answer::where('question_id',$qu->id)->get() as $answer)
                        @php(json_encode($data_radio_answer=$answer->answer['answer'], 15, 512))
                        @foreach($data_radio_answer as $index=>$ans)
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input id="customRadio{{$index}}{{$answer->id}}"
                                           type="radio"
                                           name="question-{{$answer->id}}"
                                           value="{{$ans}}"
                                           class="custom-control-input">
                                    <label for="customRadio{{$index}}{{$answer->id}}"
                                           class="custom-control-label">{{$ans}}</label>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @elseif($qu->question_type == 'true_false_answer')
                    @foreach(\Modules\DataResource\Entities\Question\Answer::where('question_id',$qu->id)->get() as $answer)
                        @php(json_encode($data_radio_answer=$answer->answer['answer'], 15, 512))
                        <div class="row">
                            @foreach($data_radio_answer as $index=>$ans)

                                <div class="form-group col-3">
                                    <div class="custom-control custom-checkbox">
                                        <input id="customRadio{{$index}}{{$answer->id}}"
                                               type="radio"
                                               name="question-{{$answer->id}}"
                                               value="{{$ans}}"
                                               class="custom-control-input">
                                        <label for="customRadio{{$index}}{{$answer->id}}"
                                               class="custom-control-label">{{$ans}}</label>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    @endforeach

                @elseif($qu->question_type == 'filling_blank_answer')
                    @foreach(\Modules\DataResource\Entities\Question\Answer::where('question_id',$qu->id)->get() as $answer)
                        @json($answer->answer)
                    @endforeach

                @elseif($qu->question_type == 'checkbox_answer')
                    @foreach(\Modules\DataResource\Entities\Question\Answer::where('question_id',$qu->id)->get() as $answer)
                        @php(json_encode($data_radio_answer=$answer->answer['answer'], 15, 512))
                        @foreach($data_radio_answer as $index=>$ans)
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input id="customCheckbox{{$index}}{{$answer->id}}"
                                           type="checkbox"
                                           name="question-{{$answer->id}}"
                                           value="{{$ans}}"
                                           class="custom-control-input">
                                    <label for="customCheckbox{{$index}}{{$answer->id}}"
                                           class="custom-control-label">{{$ans}}</label>
                                </div>
                            </div>
                        @endforeach
                    @endforeach

                @elseif($qu->question_type == 'filling_blank_answer')
                    @foreach(\Modules\DataResource\Entities\Question\Answer::where('question_id',$qu->id)->get() as $answer)
                        @json($answer->answer)
                    @endforeach

                @elseif($qu->question_type == 'sortable')
                    @foreach(\Modules\DataResource\Entities\Question\Answer::where('question_id',$qu->id)->get() as $answer)

                        @php(json_encode($data_sortable=$answer->answer['phrase'], 15, 512))
                        <div class="demo">
                            <div id="sortable" class="ui-state-default">
                                @foreach($data_sortable as $index=>$sort)

                                    <div id="draggable{{$index+1}}" class="ui-state-default" style=" width: 150px;
            height: 35px;
            padding: 3px;
            margin: 0.5em;
            text-align: center;
border: 1px solid black"> {{$sort}}</div>

                                @endforeach
                            </div>
                        </div>
                    @endforeach

                @endif

                {{--                <div class="form-group">--}}
                {{--                    <div class="custom-control custom-checkbox">--}}
                {{--                        <input id="customCheck01"--}}
                {{--                               type="checkbox"--}}
                {{--                               class="custom-control-input">--}}
                {{--                        <label for="customCheck01"--}}
                {{--                               class="custom-control-label">Ability to use newer syntax and offers reliability</label>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="form-group">--}}
                {{--                    <div class="custom-control custom-checkbox">--}}
                {{--                        <input id="customCheck02"--}}
                {{--                               type="checkbox"--}}
                {{--                               class="custom-control-input"--}}
                {{--                               checked="">--}}
                {{--                        <label for="customCheck02"--}}
                {{--                               class="custom-control-label">Compatibility</label>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="form-group mb-32pt mb-lg-48pt">--}}
                {{--                    <div class="custom-control custom-checkbox">--}}
                {{--                        <input id="customCheck03"--}}
                {{--                               type="checkbox"--}}
                {{--                               class="custom-control-input">--}}
                {{--                        <label for="customCheck03"--}}
                {{--                               class="custom-control-label">Usage of missing features</label>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <p class="text-50 mb-0">Note: There can be multiple correct answers to this question.</p>--}}
            </div>
        </div>
    @endforeach
    <div class="row">
        <div class="container">

            <button class="col-6 btn btn-success m-5">
                إرسال
            </button>


        </div>

    </div>

@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $("#sortable").sortable({
            revert: true
        });
    </script>
@endpush
