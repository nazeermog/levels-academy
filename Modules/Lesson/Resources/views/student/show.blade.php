@extends("student.layouts.dashboard")
@section('content')

   

  

                <div class="navbar navbar-light border-0 navbar-expand">
                    <div class="container page__container">
                        <div class="media flex-nowrap">
                            <div class="media-left mr-16pt">
                            <a href="student-course.html"><img src="{{asset($course->photo)}}"
                                         width="80"
                                         alt="{{$course->title}}"
                                         class="rounded"></a>
                            </div>                                                    
                            <div class="media-body">
                                <a href="student-course.html"
                                   class="card-title text-body mb-0">{{$course->title}}</a>
                                <p class="lh-1 d-flex align-items-center mb-0">
                                    <span class="text-50 small font-weight-bold mr-8pt">{{ $instructor->first_name.' '.$instructor->last_name}}</span>
                                    <span class="text-50 small">{{$instructor->spec}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-primary pb-lg-64pt py-32pt">
                    <div class="container page__container">
                        <nav class="course-nav">
                            <a data-toggle="tooltip"
                               data-placement="bottom"
                               data-title="Getting Started with Angular: Introduction"
                               href=""><span class="material-icons">lock</span></a>
                            <a data-toggle="tooltip"
                               data-placement="bottom"
                               data-title="Getting Started with Angular: Introduction to TypeScript"
                               href=""><span class="material-icons text-primary">account_circle</span></a>
                            <a data-toggle="tooltip"
                               data-placement="bottom"
                               data-title="Getting Started with Angular: Comparing Angular to AngularJS"
                               href=""><span class="material-icons">lock</span></a>
                            <a data-toggle="tooltip"
                               data-placement="bottom"
                               data-title="Getting Started with Angular: Lesson 4"
                               href=""><span class="material-icons">lock</span></a>
                        </nav>
                        <div class="js-player embed-responsive embed-responsive-16by9 mb-32pt">
                            <div class="player embed-responsive-item">
                                <div class="player__content">
                                    <div class="player__image"
                                         style="--player-image: url(../../public/images/illustration/player.svg)"></div>
                                    <a href=""
                                       class="player__play bg-primary">
                                        <span class="material-icons">play_arrow</span>
                                    </a>
                                </div>
                             <div class="player__embed ">
                            @if (Str::startsWith($lesson->url, 'https://www.youtube.com/'))
                                    <iframe class="embed-responsive-item" src="{{ $lesson->url }}" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                           @elseif (Str::startsWith($lesson->url, 'https://player.vimeo.com/'))
                            <iframe src="{{ $lesson->url }}" width="640" height="564" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                                    @else
                                <video class="embed-responsive-item" controls>
                                    <source src="{{ asset($lesson->url) }}" type="video/mp4">
                                   
                                </video>
                            @endif
                        </div>
                        </div>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-16pt">
                            <h1 class="text-white flex m-0">{{$lesson->title}}</h1>
                            <div class="d-flex align-items-center ml-16pt">
                                <i class="far fa-clock text-white-50 mr-4pt" style="font-size: 24px;"></i>
                                <p class="h1 text-white-50 font-weight-light m-0">{{$lesson->time}}m</p>
                            </div>
                        </div>


                        <p class="hero__lead measure-hero-lead text-white-50 mb-24pt">{{$lesson->desc}}</p>
                            <div class="col-md-6">
                                <h3>Attachment: {{$lesson->attachment_name}}</h3>
                            </div>
                            <div class="col-md-10">
                                @php
                                    $extension = pathinfo($lesson->attachment, PATHINFO_EXTENSION);
                                @endphp

                                @if ($extension === 'pdf')
                                    <a class="hero__lead measure-hero-lead text-white-50 mb-24p" href="{{ asset($lesson->attachment) }}" download="{{ $lesson->attachment }}">Download PDF</a>
                                @else
                                <p class="hero__lead measure-hero-lead text-white-50 mb-24p" style="word-wrap: break-word;">{{ $lesson->attachment }}</p>
                                @endif
                        
                        </div>



                        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-start">
                            <a href="lesson.html"
                               class="btn btn-outline-white mb-16pt mb-sm-0 mr-sm-16pt">Watch trailer <i class="material-icons icon--right">play_circle_outline</i></a>
                            <a href="pricing.html"
                               class="btn btn-white">Get started</a>
                        </div>
                    </div>
                </div>
                <div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
                    <div class="container page__container">
                        <ul class="nav navbar-nav flex align-items-sm-center">
                            <li class="nav-item navbar-list__item">
                                <div class="media align-items-center">
                                    <span class="media-left mr-16pt">
                                    <img src="{{asset($instructor->avatar)}}"
                                             width="40"
                                             alt="avatar"
                                             class="rounded-circle">
                                    </span>
                                    <div class="media-body">
                                        <a class="card-title m-0"
                                           href="teacher-profile.html">{{ $instructor->first_name.' '.$instructor->last_name}}</a>
                                        <p class="text-50 lh-1 mb-0">Instructor</p>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item navbar-list__item">
                                <i class="material-icons text-muted icon--left">schedule</i>
                                {{$totalLessonTime}}m
                            </li>
                            <li class="nav-item navbar-list__item">
                                <i class="material-icons text-muted icon--left">assessment</i>
                                Beginner
                            </li>
                            <li class="nav-item ml-sm-auto text-sm-center flex-column navbar-list__item">
                            <div class="rating rating-24">
                                        <?php
                                        $stars_count = $courseRate;
                                        for ($i = 1; $i <= 5; $i++) {
                                        if ($stars_count >= $i) {
                                        ?> 
                                        <div class="rating__item"><i class="material-icons">star</i></div> <?php
                                        } else {
                                        ?> <div class="rating__item"><i class="material-icons">star_border</i></div> <?php
                                        }}
                                        ?>
                                    </div>
                                    <p class="lh-1 mb-0"><small class="text-muted">{{$ratingCount}} ratings</small></p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- // END Page Content -->

                <!-- Footer -->

                <div class="bg-white border-top-2 mt-auto">
                    <div class="container page__container page-section d-flex flex-column">
                        <p class="text-70 brand mb-24pt">
                            <img class="brand-icon"
                                 src="{{asset('/images/logo/black-70@2x.png')}}"
                                 width="30"
                                 alt="Luma"> Levels Academy
                        </p>
                        <p class="measure-lead-max text-50 small mr-8pt">Luma is a beautifully crafted user interface for modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher Dashboard, Curriculum Management, Earnings and Reporting, ERP, HR, CMS, Tasks, Projects, eCommerce and more.</p>
                        <p class="mb-8pt d-flex">
                            <a href=""
                               class="text-70 text-underline mr-8pt small">Terms</a>
                            <a href=""
                               class="text-70 text-underline small">Privacy policy</a>
                        </p>
                        <p class="text-50 small mt-n1 mb-0">Copyright 2019 &copy; All rights reserved.</p>
                    </div>
                </div>

                <!-- // END Footer -->


           
@endsection
