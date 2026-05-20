@extends('instructor.layouts.dashboard')
@push('css')
    <!-- Quill Theme -->
    <link type="text/css"
          href="{{asset('css/quill.css')}}"
          rel="stylesheet">
    <!-- Select2 -->
    <link type="text/css"
          href="{{asset('vendor/select2/select2.min.css')}}"
          rel="stylesheet">
    <link type="text/css"
          href="{{asset('css/select2.css')}}"
          rel="stylesheet">
@endpush
@section('content')

    <div class="pt-32pt">
        <div
            class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">
                        إضافة اختبار
                    </h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">
                                الرئيسية
                            </a></li>

                        <li class="breadcrumb-item active">

                            إضافة اختبار
                        </li>

                    </ol>

                </div>
            </div>

        </div>
    </div>

    <div class="page-section border-bottom-2">
        <div class="container page__container">
            <form class="row align-items-start" action="{{route('practice.store')}}" method="POST">
                @csrf
                <div class="col-md-8">

                    <div class="page-separator">
                        <div class="page-separator__text">
                            الأسئلة
                        </div>
                    </div>
                    <ul class="list-group stack mb-40pt" id="list_questions">

                        {{--                        <li class="list-group-item d-flex">--}}
                        {{--                            <i class="material-icons text-70 icon-16pt icon--left">drag_handle</i>--}}
                        {{--                            <div class="flex d-flex flex-column">--}}
                        {{--                                <div class="card-title mb-4pt">Question 1 of 2</div>--}}
                        {{--                                <div class="card-subtitle text-70 paragraph-max mb-16pt">An angular 2 project written in--}}
                        {{--                                    typescript is* transpiled to javascript duri*ng the build process. Which of the--}}
                        {{--                                    following additional features are provided to the developer while programming on--}}
                        {{--                                    typescript over javascript?--}}
                        {{--                                </div>--}}
                        {{--                                <div>--}}
                        {{--                                    <a href=""--}}
                        {{--                                       class="chip chip-light d-inline-flex align-items-center"><i--}}
                        {{--                                            class="material-icons icon-16pt icon--left">keyboard_arrow_down</i> Answers</a>--}}
                        {{--                                    <div class="chip chip-outline-secondary">Single Answer</div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <span class="text-muted mx-12pt">800 pt</span>--}}

                        {{--                            <div class="dropdown">--}}
                        {{--                                <a href="#"--}}
                        {{--                                   data-toggle="dropdown"--}}
                        {{--                                   data-caret="false"--}}
                        {{--                                   class="text-muted"><i class="material-icons">more_horiz</i></a>--}}
                        {{--                                <div class="dropdown-menu dropdown-menu-right">--}}
                        {{--                                    <a href="javascript:void(0)"--}}
                        {{--                                       class="dropdown-item">Edit Question</a>--}}
                        {{--                                    <div class="dropdown-divider"></div>--}}
                        {{--                                    <a href="javascript:void(0)"--}}
                        {{--                                       class="dropdown-item text-danger">Delete Question</a>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}

                        {{--                        </li>--}}

                        {{--                        <li class="list-group-item d-flex">--}}
                        {{--                            <i class="material-icons text-70 icon-16pt icon--left">drag_handle</i>--}}
                        {{--                            <div class="flex d-flex flex-column">--}}
                        {{--                                <div class="card-title mb-4pt">Question 2 of 2</div>--}}
                        {{--                                <div class="card-subtitle text-70 paragraph-max mb-8pt">What will be the output of below--}}
                        {{--                                    program?--}}
                        {{--                                </div>--}}

                        {{--                                <code class="highlight js mb-16pt bg-transparent">function&nbsp;f(input:&nbsp;boolean)&nbsp;{<br/>--}}
                        {{--                                    &nbsp;&nbsp;let&nbsp;a&nbsp;=&nbsp;100;<br/>--}}
                        {{--                                    <br/>--}}
                        {{--                                    &nbsp;&nbsp;if&nbsp;(input)&nbsp;{<br/>--}}
                        {{--                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;let&nbsp;b&nbsp;=&nbsp;a&nbsp;+&nbsp;1;<br/>--}}
                        {{--                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;b;<br/>--}}
                        {{--                                    &nbsp;&nbsp;}<br/>--}}
                        {{--                                    &nbsp;&nbsp;return&nbsp;b;<br/>--}}
                        {{--                                    }</code>--}}

                        {{--                                <div class="d-flex">--}}
                        {{--                                    <a href=""--}}
                        {{--                                       class="chip chip-light d-inline-flex align-items-center"><i--}}
                        {{--                                            class="material-icons icon-16pt icon--left">keyboard_arrow_down</i> Answers</a>--}}
                        {{--                                    <div class="chip chip-outline-secondary">Single Answer</div>--}}
                        {{--                                    <div class="chip chip-outline-secondary">Code</div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <span class="text-muted mx-12pt">800 pt</span>--}}

                        {{--                            <div class="dropdown">--}}
                        {{--                                <a href="#"--}}
                        {{--                                   data-toggle="dropdown"--}}
                        {{--                                   data-caret="false"--}}
                        {{--                                   class="text-muted"><i class="material-icons">more_horiz</i></a>--}}
                        {{--                                <div class="dropdown-menu dropdown-menu-right">--}}
                        {{--                                    <a href="javascript:void(0)"--}}
                        {{--                                       class="dropdown-item">Edit Question</a>--}}
                        {{--                                    <div class="dropdown-divider"></div>--}}
                        {{--                                    <a href="javascript:void(0)"--}}
                        {{--                                       class="dropdown-item text-danger">Delete Question</a>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}

                        {{--                        </li>--}}
                    </ul>

                    <div class="page-separator">
                        <div class="page-separator__text">
                            إضافة سؤال
                        </div>
                    </div>
                    <div class="card card-body">

                        <div class="form-group">
                            <label class="form-label">
                                نص السؤال
                            </label>
                            <textarea class="form-control" rows="3" placeholder="أدخل نص السؤال" id="question"></textarea>
                            {{--                            <div style="height: 150px;"--}}
                            {{--                                 id="question"--}}
                            {{--                                 class="mb-0"--}}
                            {{--                                 data-toggle="quill"--}}
                            {{--                                 data-quill-placeholder="Question">--}}
                            {{--                            </div>--}}
{{--                            <small class="form-text text-muted">Shortly describe the question.</small>--}}
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                نوع السؤال
                            </label>
                            <select name="category" id="type_answer"
                                    class="form-control custom-select">
                                <option value="">
                                    اختر نوع ....
                                </option>
                                <option id="radio_answer" value="radio_answer">
                                    اختيار من متعدد
                                </option>
                                <option id="true_false_answer" value="true_false_answer">
                                    صح و خطأ
                                </option>
                                <option id="checkbox_answer" value="checkbox_answer">
                                    اختيار أكثر من جواب
                                </option>
                                <option id="filling_blank_answer" value="filling_blank_answer">
                                    املأ الفراغات
                                </option>
                                <option id="text_answer" value="text_answer">
                                    جواب نصي
                                </option>
                                <option id="sortable" value="sortable">
                                    رتب الكلمات
                                </option>
                            </select>
                        </div>

                        <div class="form-group" id="multiple_answer">
                            <label class="form-label"
                                   for="select01">Answers</label>
                            <select id="select01"
                                    data-toggle="select"
                                    data-multiple="true"
                                    multiple="multiple"
                                    class="form-control">
                                <option value="My first option">My first option</option>
                                <option value="Another option">Another option</option>
                                <option value="Third option is here">Third option is here</option>
                            </select>
                        </div>
                        <div class="form-group" id="single_answer">
                            <label class="form-label"
                                   for="select02">Answers</label>
                            <select id="select02"
                                    data-toggle="select"
                                    class="form-control">
                                <option value="My first option">My first option</option>
                                <option value="Another option">Another option</option>
                                <option value="Third option is here">Third option is here</option>
                            </select>
                        </div>
                        <div class="form-group" id="sortable_answer">
                            <div class="row mb-2 ml-1">
                                <button type="button" id="add_option_sortable"
                                        class="btn btn-outline-primary"> Add Option +
                                </button>
                            </div>
                            <div class="form-group" id="sortable_answer_options">
                                {{--                                <div class="row mb-2">--}}
                                {{--                                    <div class="col-5">--}}
                                {{--                                        <input type="text" class="form-control" placeholder="phrase">--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="col-5">--}}
                                {{--                                        <input type="number" class="form-control" placeholder="order">--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="col-2">--}}
                                {{--                                        <button type="button"--}}
                                {{--                                                class="btn btn-outline-danger">X--}}
                                {{--                                        </button>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>

                        </div>
                        <div class="form-group" id="options_answer">
                            <div class="row mb-2 ml-1">
                                <button type="button" id="add_option_answers"
                                        class="btn btn-outline-primary"> Add Option +
                                </button>
                            </div>
                            <div class="form-group" id="options_answer_items">
                                {{--                                <div class="row mb-2">--}}
                                {{--                                    <div class="col-5">--}}
                                {{--                                        <input type="text" class="form-control" placeholder="phrase">--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="col-5">--}}
                                {{--                                        <input type="number" class="form-control" placeholder="order">--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="col-2">--}}
                                {{--                                        <button type="button"--}}
                                {{--                                                class="btn btn-outline-danger">X--}}
                                {{--                                        </button>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                علامة السؤال
                            </label>
                            <input type="text"
                                   id="question_points"
                                   class="form-control"
                                   value="10">
                        </div>
                        <div class="form-group">
                            <label class="form-label"
                                   for="select01">
                                التاغ
                            </label>
                            <select id="select01"
                                    data-toggle="select"
                                    data-multiple="true"
                                    multiple="multiple"
                                    class="form-control">
                                <option value="My first option">
                                    مستوى متوسط
                                </option>
                                <option value="Another option">
                                    اختيار متعدد
                                </option>
                                <option value="Third option is here">
                                    رتب الكلمات
                                </option>
                                <option value="Third option is here">
                                  أحرف العطف
                                </option>
                            </select>
                        </div>

                        <div>
                            <button type="button" id="add_question"
                                    class="btn btn-outline-secondary">
                                إضافة السؤال
                            </button>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">

                    <div class="card">
                        <div class="card-header text-center">
                            <button type="submit"
                                    class="btn btn-accent">
                                حفظ الاختبار
                            </button>
                        </div>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex">
                                <a class="flex"
                                   href="#"><strong>
                                        حفظ كمسودة
                                    </strong></a>
                                <i class="material-icons text-muted">check</i>
                            </div>
                            <div class="list-group-item">
                                <a href="#"
                                   class="text-danger"><strong>
                                        حذف التدريب
                                    </strong></a>
                            </div>
                        </div>
                    </div>

                    <div class="page-separator">
                        <div class="page-separator__text">
                            الدروس
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <label class="form-label">
                                    إضافة إلى درس
                                </label>
                                <select name="course"
                                        id="course"
                                        data-toggle="select"
                                        data-tags="false"
                                        data-multiple="true"
                                        data-minimum-results-for-search="0"
                                        class="form-control"
                                        data-placeholder="Select course ...">
                                    <option data-avatar-src="../../public/images/paths/angular_40x40@2x.png"
                                            selected="">
                                        حروف العطف
                                    </option>
                                    <option data-avatar-src="../../public/images/paths/swift_40x40@2x.png">
                                        اللغة العربية المستوى الثالث
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')

    <!-- Quill -->
    <script src="{{asset('vendor/quill.min.js')}}"></script>
    <script src="{{asset('js/quill.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('vendor/select2/select2.min.js')}}"></script>
    <script src="{{asset('js/select2.js')}}"></script>

    <!-- Highlight.js -->
    <script src="{{asset('/js/hljs.js')}}"></script>
    <script>
        var questionArr = []
        $('#single_answer').hide()
        $('#sortable_answer').hide()
        $('#options_answer').hide()
        $('#multiple_answer').hide()
        $('#type_answer').on('change', function () {
            if ($('#type_answer').val() === 'radio_answer'||$('#type_answer').val() === 'checkbox_answer' ) {
                $('#single_answer').hide()
                $('#multiple_answer').hide()
                $('#sortable_answer').hide()
                $('#options_answer').show()
            }
            if ($('#type_answer').val() === 'filling_blank_answer') {
                $('#single_answer').hide()
                $('#multiple_answer').show()
                $('#sortable_answer').hide()
                $('#options_answer').hide()
            }
            if ($('#type_answer').val() === 'sortable' || $('#type_answer').val() === 'text_answer') {
                $('#single_answer').hide()
                $('#multiple_answer').hide()
                $('#sortable_answer').hide()
                $('#options_answer').hide()
            }
            if ($('#type_answer').val() === 'sortable') {
                $('#sortable_answer').show()
                $('#single_answer').hide()
                $('#multiple_answer').hide()
                $('#options_answer').hide()
            }
            if ($('#type_answer').val() === 'true_false_answer') {
                $('#options_answer').show()
                $('#single_answer').hide()
                $('#sortable_answer').hide()
                $('#multiple_answer').hide()
            }
        })
        $('#add_option_sortable').on('click', function () {
            $('#sortable_answer_options').append(
                ` <div class="row mb-2">
                                <div class="col-5">
                                    <input type="text"  name="answers[${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}][phrase][]" id="phrase${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}" class="form-control" placeholder="phrase">
                                </div>
                                <div class="col-5">
                                    <input type="number" name="answers[${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}][order][]"  id="order${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}" class="form-control" placeholder="order">
                                </div>
                                <div class="col-2">
                                    <button type="button"
                                            class="btn btn-outline-danger">X
                                    </button>
                                </div>
                            </div>`
            )
        })
        $('#add_option_answers').on('click', function () {
            $('#options_answer_items').append(
                ` <div class="row mb-2">
                                <div class="col-7">
                                     <label>
                                      السؤال
                                    </label>
                                    <input type="text"  name="answers[${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}][answer][]" id="answer${$('#list_questions li').length - 1 > 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}" class="form-control" placeholder="answer">
                                </div>
                                <div class="col-1">
                                    <label>
                                        صح
                                    </label>
                                    <input type="radio" name="answers[${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}][is_correct][${$('#options_answer_items .row').length}][]"  id="is_correct${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}" value="on" class="form-control">
                                </div>
                                 <div class="col-1">
                                    <label>
                                      خطأ
                                    </label>
                                    <input type="radio" name="answers[${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}][is_correct][${$('#options_answer_items .row').length}][]"  id="is_correct${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}" value="off" class="form-control">
                                </div>
                                <div class="col-2">
                                        <label></label>
                                    <button type="button"
                                            class="btn btn-outline-danger">X
                                    </button>
                                </div>
                            </div>`
            )
        })

        $('#add_question').on('click', function () {
            $('#list_questions').append(`<li class="list-group-item d-flex" >
                            <i class="material-icons text-70 icon-16pt icon--left">drag_handle</i>
                            <div class="flex d-flex flex-column">
                                <div class="card-title mb-4pt">Question 1 of 2</div>
                                <div class="card-subtitle text-70 paragraph-max mb-16pt">
                                  <input name="questions[]" value="${$('#question').val()}" type="hidden">
                                  <input name="question_types[]" value="${$('#type_answer').val()}" type="hidden">
                                    ${$('#question').val()}
                                </div>
                                <div>
                                    <a href=""
                                       class="chip chip-light d-inline-flex align-items-center"><i
                                            class="material-icons icon-16pt icon--left">keyboard_arrow_down</i> Answers</a>
                                    <div class="chip chip-outline-secondary">Single Answer</div>
                                </div>
                            </div>
                                <input name="points[]" value="${$('#question_points').val()}" type="hidden">
                            <span class="text-muted mx-12pt">${$('#question_points').val()} pt</span>

                            <div class="dropdown">
                                <a href="#"
                                   data-toggle="dropdown"
                                   data-caret="false"
                                   class="text-muted"><i class="material-icons">more_horiz</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)"
                                       class="dropdown-item">Edit Question</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0)"
                                       class="dropdown-item text-danger">Delete Question</a>
                                </div>
                            </div>

                        </li>`)
            if ($('#type_answer').val() === 'radio_answer'
                || $('#type_answer').val() === 'true_false_answer'
                || $('#type_answer').val() === 'checkbox_answer')
            {
                $('#options_answer_items').find('input:text')
                    .each(function () {
                        $('#list_questions').append(
                            ` <input type="hidden" value="${$(this).val()}"  name="answers[${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}][answer][]" class="form-control" >`
                        )
                    });
                $('#options_answer_items').find(':input[type="radio"]:checked')
                    .each(function () {
                        $('#list_questions').append(`<input type="hidden" value="${$(this).val()}"  name="answers[${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}][is_correct][]" class="form-control" >`)
                    });
                $('#options_answer_items').empty()
            }
            // if ($('#type_answer').val() === 'checkbox_answer' || $('#type_answer').val() === 'filling_blank_answer') {
                // $('#list_questions').append(
                //     `<input name="answers[]" value="${$('#select01').val()}" type="hidden">`
                // )
            // }
            if ($('#type_answer').val() === 'sortable') {
                $('#sortable_answer_options').find('input:text')
                    .each(function () {
                        $('#list_questions').append(
                            ` <input type="hidden" value="${$(this).val()}"  name="answers[${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}][phrase][]" class="form-control" placeholder="phrase">`
                        )
                    });
                $('#sortable_answer_options').find(':input[type="number"]')
                    .each(function () {
                        $('#list_questions').append(`<input type="hidden" value="${$(this).val()}"  name="answers[${$('#list_questions li').length - 1 >= 0 ? $('#list_questions li').length - 1 : $('#list_questions li').length}][order][]" class="form-control" placeholder="phrase">`)
                    });
                $('#sortable_answer_options').empty()
            }
        })


    </script>
@endpush
