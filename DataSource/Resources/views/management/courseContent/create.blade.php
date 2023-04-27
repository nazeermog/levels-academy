@extends('datasource::management.layout.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <style>
        .droppable-area2 {
            min-height: 100px;
        }

        .accordion-body {
            padding: 0;
        }

        .draggable-item {
            padding: .5rem;
        }

        .draggable-item:not(:last-child) {
            border-bottom: 1px solid #f7f7f7;
        }

        .draggable-item h4 {
            margin-bottom: 0;
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <div class="container py-5">
        <form id="form-course">
            <div class="row">
                <label>Add Course </label>
            </div>
            <hr/>
            <div class="row">
                @foreach(localeSupported() as $locale)
                    <div class="col-md-4 m-1">
                        <label for="">Title {{ucwords($locale)}}</label>
                        <input class="form-control" name="title-{{$locale}}" id="title-{{$locale}}">
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach(localeSupported() as $locale)
                    <div class="col-md-4 m-1">
                        <label for="">Slug {{ucwords($locale)}}</label>
                        <input class="form-control" name="slug-{{$locale}}" id="slug-{{$locale}}">
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-4 m-1">
                    <label for="">Price </label>
                    <input class="form-control" name="price" id="price">
                </div>
            </div>
            <hr/>
        </form>


        <div class="row">
            <label>Course Content</label>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                <span class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                      aria-expanded="true" aria-controls="collapseOne">
                  Lessons
                </span>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                            <div class="accordion-body">
                                <ul class="list-unstyled connected-sortable droppable-area1 mb-0">
                                    @foreach($lessons as $lesson)
                                        <li class="draggable-item cursor-pointer"
                                            data-type="Lesson"
                                            data-id="{{$lesson->id}}">
                                            <div
                                                class="d-flex align-items-center justify-content-between border px-3 py-2">
                                                <h4>{{$lesson->title}}</h4>
                                                <i class="bi bi-chevron-double-right move-btn"></i>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                <span class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Practices
                </span>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        >
                            <div class="accordion-body">
                                <ul class="list-unstyled connected-sortable droppable-area1 mb-0">
                                    @foreach($practices as $practice)
                                        <li class="draggable-item cursor-pointer"
                                            data-type="Practice"
                                            data-id="{{$practice->id}}">
                                            <div
                                                class="d-flex align-items-center justify-content-between border px-3 py-2">
                                                <h4>{{$practice->title}}</h4>
                                                <i class="bi bi-chevron-double-right move-btn"></i>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                <span class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Quizzes
                </span>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        >
                            <div class="accordion-body">
                                <ul class="list-unstyled connected-sortable droppable-area1 mb-0">
                                    <li class="draggable-item">
                                        <h4>Task5</h4>
                                    </li>
                                    <li class="draggable-item">
                                        <h4>Task6</h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 border p-0">
                <div class="accordion" id="accordionExample2">
                    <ul class="list-unstyled connected-sortable droppable-area2 mb-0" id="myList">


                    </ul>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
        </div>
    </div>
@endsection
@push('js')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
            integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
            integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
            integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
            integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(init);

        function init() {
            $(".droppable-area1, .droppable-area2").sortable({
                connectWith: ".connected-sortable",
                stack: '.connected-sortable ul'
            }).disableSelection();
        }

        $(document).ready(function () {
            $('.move-btn').click(function () {
                setTimeout(function () {
                    var selectedItem = $('.droppable-area1 li.selected');
                    if (selectedItem.length) {
                        selectedItem.detach();
                        selectedItem.removeClass('selected');
                        $('.droppable-area2').append(selectedItem);
                        // $('.droppable-area2').append(`<input type="hidden" name="data-id[]" value="${selectedItem.attr('data-id')}">`);
                        // $('.droppable-area2').append(`<input type="hidden" name="data-type[]" value="${selectedItem.attr('data-type')}">`);

                    }
                }, 20)
            });

            $('.droppable-area1').on('click', 'li', function () {
                $('.droppable-area1 li').removeClass('selected');
                $(this).addClass('selected');
            });
            $('#submitForm').click(function () {
                const myList = document.getElementById("myList");
                const liItems = myList.querySelectorAll("li");
                const liArray = Array.from(liItems);
                var dataArray = [];
                liArray.forEach((li, index) => {
                    dataArray.push({
                        ordering: index + 1,
                        type_id: li.getAttribute('data-id'),
                        type: li.getAttribute('data-type')
                    })
                });
                $.ajax({
                    method: "POST",
                    url: "{{ route('admin.courseContent.store')}}",
                    data: {
                        arrayData: dataArray,
                        price: $('#price').val(),

                    },
                    success: function (one, two, three) {
                        toastr.success('updated successfully')
                    },
                    error: function (one, two, three) {
                        toastr.error('error')
                    },
                });

                console.log(dataArray)
                console.log(($('#form-course').serializeArray()) )

            })
        });
    </script>

@endpush


{{--<head>--}}

{{--    <title>Course Content</title>--}}
{{--   --}}
{{--</head>--}}




