@extends("student.layouts.dashboard")
@section('content')

<div class="mdk-drawer-layout__content page-content">

  <div class="mdk-box bg-primary mdk-box--bg-gradient-primary2 js-mdk-box mb-0" data-effects="blend-background">
    <div class="mdk-box__content">
      <div class="hero py-64pt text-center text-sm-left">
        <div class="container page__container">
          <h1 class="text-white">{{$course->title}}</h1>
          <p class="lead text-white-50 measure-hero-lead mb-24pt">{{$course->desc}}</p>
          <a href="student-take-lesson.html" class="btn btn-white">Resume course</a>
        </div>
      </div>
      <div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
        <div class="container page__container">
          <ul class="nav navbar-nav flex align-items-sm-center">
            <li class="nav-item navbar-list__item">
              <div class="media align-items-center">
                <span class="media-left mr-16pt">
                  <img src="{{asset($instructor->avatar)}}" width="40" alt="avatar" class="rounded-circle">
                </span>
                <div class="media-body">
                  <a class="card-title m-0" href="teacher-profile.html">{{ $instructor->first_name.' '.$instructor->last_name}}</a>
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
              {{$course->level}}
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
    </div>
  </div>

  <div class="container page__container">
    <div class="row">
      <div class="col-lg-7">
        <div class="border-left-2 page-section pl-32pt">
          @foreach ($contents as $content)
          <div class="d-flex align-items-center page-num-container">
            <div class="page-num">{{ $content->ordering }}</div>
            <h4>{{ $content->title }}</h4>
          </div>

          <p class="text-70 mb-24pt">{{ $content->desc }}</p>

          <div class="card mb-32pt mb-lg-64pt">
            <ul class="accordion accordion--boxed mb-0">
              <li class="accordion__item">
                <a class="accordion__toggle" data-toggle="collapse" href="#toc-content-{{ $content->id }}">
                  <span class="flex"> {{$coursestepCount[$content->id]}} Steps</span>
                  <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                </a>
                <div class="accordion__menu collapse show" id="toc-content-{{ $content->id }}">
                  <ul class="list-unstyled">
                    @foreach ($contentSteps[$content->id] as $step)
                    <li class="accordion__menu-link">
                      @if ($step->stepable_type === 'Lessons')
                      <span class="material-icons icon-16pt icon--left text-body">play_circle_outline</span>
                      <a class="flex" href="{{route('student.lesson.show', ['lessonId' => $step->stepable_id,'courseId'=> $course->id] ) }}">{{ $step->stepable_type }}: {{ $step->title }}</a>
                      @elseif ($step->stepable_type === 'Practices')
                      @if ($step->title === 'abacus')
                      <span class="material-icons icon-16pt icon--left text-50">hourglass_empty</span>
                      <a class="flex" href="{{route('student.practice.show', ['id' => 1,'type'=>'abacus'] ) }}">{{ $step->stepable_type }}: {{ $step->title }}</a>
                      @else
                      <span class="material-icons icon-16pt icon--left text-50">hourglass_empty</span>
                      <a class="flex" href="{{route('student.practice.show', ['id' => 1] ) }}">{{ $step->stepable_type }}: {{ $step->title }}</a>
                      @endif

                      @elseif ($step->stepable_type === 'Quizzes')
                      <span class="material-icons icon-16pt icon--left text-50">question_answer</span>
                      @endif



                      @endforeach
                  </ul>
                </div>
              </li>
            </ul>
          </div>
          @endforeach



        </div>
      </div>
      <div class="col-lg-5 page-nav">
        <div class="page-section">
          <div class="page-nav__content">
            <div class="page-separator">
              <div class="page-separator__text">Table of contents</div>
            </div>
            <!-- <h4 class="mb-16pt">Table of contents</h4> -->
          </div>
          <nav class="nav page-nav__menu">
            @foreach($contents as $content)

            <a class="nav-link" href="">{{$content->title}}</a>
            @endforeach
          </nav>
        </div>
      </div>
    </div>
  </div>

  <div class="page-section bg-white border-top-2 border-bottom-2">

    <div class="container page__container">
      <div class="row ">
        <div class="col-md-7">
          <div class="page-separator">
            <div class="page-separator__text">About this course</div>
          </div>
          <p class="text-70">{{$course->about}}</p>
        </div>
        <div class="col-md-5">
          <div class="page-separator">
            <div class="page-separator__text bg-white">What you’ll learn</div>
          </div>
          <ul class="list-unstyled">
            @foreach(explode("\n", $course->benefit) as $benefit)
            <li class="d-flex align-items-center">
              <span class="material-icons text-50 mr-8pt">check</span>
              <span class="text-70">{{ $benefit }}</span>
            </li>
            @endforeach
          </ul>

        </div>
      </div>
    </div>

  </div>

  <div class="page-section bg-white border-bottom-2">
    <div class="container">
      <div class="row">
        <div class="col-md-7 mb-24pt mb-md-0">
          <h4>About the author</h4>
          <p class="text-70 mb-24pt">{{$instructor->about}}</p>

          <div class="page-separator">
            <div class="page-separator__text bg-white">More from the author</div>
          </div>

          <div class="card card-sm mb-8pt">
            <div class="card-body d-flex align-items-center">
              <a href="course.html" class="avatar avatar-4by3 mr-12pt">
                <img src="{{asset('/images/paths/angular_routing_200x168.png')}}" alt="Angular Routing In-Depth" class="avatar-img rounded">
              </a>
              <div class="flex">
                <a class="card-title mb-4pt" href="course.html">Angular Routing In-Depth</a>
                <div class="d-flex align-items-center">
                  <div class="rating mr-8pt">

                    <span class="rating__item"><span class="material-icons">star</span></span>

                    <span class="rating__item"><span class="material-icons">star</span></span>

                    <span class="rating__item"><span class="material-icons">star</span></span>

                    <span class="rating__item"><span class="material-icons">star_border</span></span>

                    <span class="rating__item"><span class="material-icons">star_border</span></span>

                  </div>
                  <small class="text-muted">3/5</small>
                </div>
              </div>
            </div>
          </div>

          <div class="card card-sm mb-16pt">
            <div class="card-body d-flex align-items-center">
              <a href="course.html" class="avatar avatar-4by3 mr-12pt">
                <img src="{{asset('/images/paths/angular_testing_200x168.png')}}" alt="Angular Unit Testing" class="avatar-img rounded">
              </a>
              <div class="flex">
                <a class="card-title mb-4pt" href="course.html">Angular Unit Testing</a>
                <div class="d-flex align-items-center">
                  <div class="rating mr-8pt">

                    <span class="rating__item"><span class="material-icons">star</span></span>

                    <span class="rating__item"><span class="material-icons">star</span></span>

                    <span class="rating__item"><span class="material-icons">star</span></span>

                    <span class="rating__item"><span class="material-icons">star</span></span>

                    <span class="rating__item"><span class="material-icons">star_border</span></span>

                  </div>
                  <small class="text-muted">4/5</small>
                </div>
              </div>
            </div>
          </div>

          <div class="list-group list-group-flush">
            <div class="list-group-item px-0">
              <a href="" class="card-title mb-4pt">Angular Best Practices</a>
              <p class="lh-1 mb-0">
                <small class="text-muted mr-8pt">6h 40m</small>
                <small class="text-muted mr-8pt">13,876 Views</small>
                <small class="text-muted">13 May 2018</small>
              </p>
            </div>
            <div class="list-group-item px-0">
              <a href="" class="card-title mb-4pt">Unit Testing in Angular</a>
              <p class="lh-1 mb-0">
                <small class="text-muted mr-8pt">6h 40m</small>
                <small class="text-muted mr-8pt">13,876 Views</small>
                <small class="text-muted">13 May 2018</small>
              </p>
            </div>
            <div class="list-group-item px-0">
              <a href="" class="card-title mb-4pt">Migrating Applications from AngularJS to Angular</a>
              <p class="lh-1 mb-0">
                <small class="text-muted mr-8pt">6h 40m</small>
                <small class="text-muted mr-8pt">13,876 Views</small>
                <small class="text-muted">13 May 2018</small>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-5 pt-sm-32pt pt-md-0 d-flex flex-column align-items-center justify-content-start">
          <div class="text-center">
            <p class="mb-16pt">
              <img src="{{asset($instructor->avatar)}}" alt="guy-6" class="rounded-circle" width="64">
            </p>
            <h4 class="m-0">{{ $instructor->first_name.' '.$instructor->last_name}}</h4>
            <p class="lh-1">
              <small class="text-muted">{{$instructor->spec}}</small>
            </p>
            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-start">
              <a href="teacher-profile.html" class="btn btn-outline-primary mb-16pt mb-sm-0 mr-sm-16pt">Follow</a>
              <a href="teacher-profile.html" class="btn btn-outline-secondary">View Profile</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="page-section border-bottom-2">
    <div class="container">
        <div class="page-headline text-center">
            <h2>Your Feedback Matters</h2>
            <p class="lead text-70 measure-lead mx-auto">
                Help us enhance your experience by providing your feedback. Rate the course and share your thoughts with us.
            </p>
        </div>

              <div class="text-center">
          <div id="rating" class="ui massive star rating" data-rating="0" data-max-rating="5">
              <i class="icon" data-value="1"></i>
              <i class="icon" data-value="2"></i>
              <i class="icon" data-value="3"></i>
              <i class="icon" data-value="4"></i>
              <i class="icon" data-value="5"></i>
          </div>
      </div>

      <form id="commentForm" class="ui form">
          <div class="field">
              <label>Your Comment:</label>
              <textarea id="commentInput" placeholder="Share your thoughts..." style="height: 100px;"></textarea>
          </div>
          <div class="text-center"> <!-- Center-align the button -->
              <button class="ui button" type="submit" style="background-color: #5567ff; color: white;">Submit</button>
          </div>
      </form>
      <div class="text-center" id="thankYouSection" style="display: none;">
          <p class="lead text-100 measure-lead mx-auto" style="font-size: 24px;">Thank you for your feedback!</p>
      </div>
    </div>
</div>

  <div class="page-section bg-white border-bottom-2">

    <div class="container page__container">
      <div class="page-separator">
        <div class="page-separator__text">Student Feedback</div>
      </div>
      <div class="row mb-32pt">
        <div class="col-md-3 mb-32pt mb-md-0">
          <div class="display-1">{{number_format($courseRate, 1)}}</div>
          <div class="rating rating-24">
                        @for ($i = 1; $i <= 5; $i++) @if ($i <=$courseRate)
                        <div class="rating__item"><i class="material-icons">star</i></div>
                        @else
                        <div class="rating__item"><i class="material-icons">star_border</i></div>
                        @endif
                        @endfor
                    </div>
          <p class="text-muted mb-0">{{$ratingCount}} ratings</p>
        </div>
          <div class="col-md-9">
          <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="{{number_format($rating5,1)}}% rated 5/5" data-placement="top">
            <div class="col-md col-sm-6">
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="{{$rating5}}" style="width: {{$rating5}}%" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
              <div class="rating">
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star</span></span>
              </div>
            </div>
          </div>
          <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="{{number_format($rating3,1)}}% rated 4/5" data-placement="top">
            <div class="col-md col-sm-6">
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="{{$rating4}}%" style="width: {{$rating4}}%" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
              <div class="rating">
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star_border</span></span>
              </div>
            </div>
          </div>
          <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="{{number_format($rating3,1)}}% rated 3/5" data-placement="top">
            <div class="col-md col-sm-6">
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="{{$rating3}}" style="width: {{$rating3}}%" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
              <div class="rating">
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star_border</span></span>
                <span class="rating__item"><span class="material-icons">star_border</span></span>
              </div>
            </div>
          </div>
          <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="{{number_format($rating2,1)}}% rated 2/5" data-placement="top">
            <div class="col-md col-sm-6">
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="{{$rating2}}%" style="width: {{$rating2}}%" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
              <div class="rating">
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star_border</span></span>
                <span class="rating__item"><span class="material-icons">star_border</span></span>
                <span class="rating__item"><span class="material-icons">star_border</span></span>
              </div>
            </div>
          </div>
          <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="{{number_format($rating1,1)}}% rated 1/5" data-placement="top">
            <div class="col-md col-sm-6">
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="{{$rating1}}" style="width: {{$rating1}}%" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
              <div class="rating">
                <span class="rating__item"><span class="material-icons">star</span></span>
                <span class="rating__item"><span class="material-icons">star_border</span></span>
                <span class="rating__item"><span class="material-icons">star_border</span></span>
                <span class="rating__item"><span class="material-icons">star_border</span></span>
                <span class="rating__item"><span class="material-icons">star_border</span></span>
              </div>
            </div>
          </div>
        

          </div>
      </div>

      @foreach ($ratingWithComments as $oneRating )
      <div class="pb-16pt mb-16pt border-bottom row">
                    <div class="col-md-3 mb-16pt mb-md-0">
                        <div class="d-flex">
                            <a href="student-profile.html"
                               class="avatar avatar-sm mr-12pt">
                                <!-- <img src="LB" alt="avatar" class="avatar-img rounded-circle"> -->
                                <span class="avatar-title rounded-circle">user</span>
                            </a>
                            <div class="flex">
                                <p class="small text-muted m-0">{{Carbon\Carbon::parse($oneRating->created_at)->format('Y-m-d')}}</p>
                                <a href="student-profile.html"
                                   class="card-title">{{$oneRating->user_name}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                    <div class="rating rating-24">
                        <?php
                        $stars_count = $oneRating->rate;
                        for ($i = 1; $i <= 5; $i++) {
                          if ($stars_count >= $i) {
                        ?> 
                        <div class="rating__item"><i class="material-icons">star</i></div> <?php
                        } else {
                          ?> <div class="rating__item"><i class="material-icons">star_border</i></div> <?php
                          }}
                          ?>
                      </div>
                        <p class="text-70 mb-0">{{$oneRating->user_review}}</p>
                    </div>
                </div>                
      @endforeach
      <div class="col-12">
    <div class="row justify-content-center">
        <div class="col-auto">
            {{ $ratingWithComments->links() }}
        </div>
    </div>
</div>



    </div>

  </div>

  <div class="page-section">
    <div class="container page__container">
      <div class="page-heading">
        <h4>Top Development Courses</h4>
        <a href="" class="text-underline ml-sm-auto">See Development Courses</a>
      </div>

      <div class="position-relative carousel-card">
        <div class="js-mdk-carousel row d-block" id="carousel-courses1">

          <a class="carousel-control-next js-mdk-carousel-control mt-n24pt" href="#carousel-courses1" role="button" data-slide="next">
            <span class="carousel-control-icon material-icons" aria-hidden="true">keyboard_arrow_right</span>
            <span class="sr-only">Next</span>
          </a>

          <div class="mdk-carousel__content">

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">

              <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal " data-partial-height="44" data-toggle="popover" data-trigger="click">

                <a href="student-course.html" class="js-image" data-position="">
                  <img src="{{asset('/images/paths/angular_430x168.png')}}" alt="course">
                  <span class="overlay__content align-items-start justify-content-start">
                    <span class="overlay__action card-body d-flex align-items-center">
                      <i class="material-icons mr-4pt">play_circle_outline</i>
                      <span class="card-title text-white">Preview</span>
                    </span>
                  </span>
                </a>

                <span class="corner-ribbon corner-ribbon--default-right-top corner-ribbon--shadow bg-accent text-white">NEW</span>

                <div class="mdk-reveal__content">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="flex">
                        <a class="card-title" href="student-course.html">Learn Angular fundamentals</a>
                        <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                      </div>
                      <a href="student-course.html" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
                    </div>
                    <div class="d-flex">
                      <div class="rating flex">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                      </div>
                      <small class="text-50">6 hours</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="popoverContainer d-none">
                <div class="media">
                  <div class="media-left mr-12pt">
                    <img src="{{asset('/images/paths/angular_40x40@2x.png')}}" width="40" height="40" alt="Angular" class="rounded">
                  </div>
                  <div class="media-body">
                    <div class="card-title mb-0">Learn Angular fundamentals</div>
                    <p class="lh-1 mb-0">
                      <span class="text-50 small">with</span>
                      <span class="text-50 small font-weight-bold">Elijah Murray</span>
                    </p>
                  </div>
                </div>

                <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to
                  create basic applications.</p>

                <div class="mb-16pt">
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Fundamentals of working with
                        Angular</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Create complete Angular
                        applications</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Working with the Angular
                        CLI</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Understanding Dependency
                        Injection</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Testing with Angular</small></p>
                  </div>
                </div>

                <div class="row align-items-center">
                  <div class="col-auto">
                    <div class="d-flex align-items-center mb-4pt">
                      <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                      <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                    </div>
                    <div class="d-flex align-items-center mb-4pt">
                      <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                      <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                    </div>
                    <div class="d-flex align-items-center">
                      <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                      <p class="flex text-50 lh-1 mb-0"><small>Beginner</small></p>
                    </div>
                  </div>
                  <div class="col text-right">
                    <a href="student-course.html" class="btn btn-primary">Watch trailer</a>
                  </div>
                </div>

              </div>

            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">

              <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal " data-partial-height="44" data-toggle="popover" data-trigger="click">

                <a href="student-course.html" class="js-image" data-position="">
                  <img src="{{asset('/images/paths/swift_430x168.png')}}" alt="course">
                  <span class="overlay__content align-items-start justify-content-start">
                    <span class="overlay__action card-body d-flex align-items-center">
                      <i class="material-icons mr-4pt">play_circle_outline</i>
                      <span class="card-title text-white">Preview</span>
                    </span>
                  </span>
                </a>

                <div class="mdk-reveal__content">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="flex">
                        <a class="card-title" href="student-course.html">Build an iOS Application in Swift</a>
                        <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                      </div>
                      <a href="student-course.html" data-toggle="tooltip" data-title="Remove Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite</a>
                    </div>
                    <div class="d-flex">
                      <div class="rating flex">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                      </div>
                      <small class="text-50">6 hours</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="popoverContainer d-none">
                <div class="media">
                  <div class="media-left mr-12pt">
                    <img src="{{asset('/images/paths/swift_40x40@2x.png')}}" width="40" height="40" alt="Angular" class="rounded">
                  </div>
                  <div class="media-body">
                    <div class="card-title mb-0">Build an iOS Application in Swift</div>
                    <p class="lh-1 mb-0">
                      <span class="text-50 small">with</span>
                      <span class="text-50 small font-weight-bold">Elijah Murray</span>
                    </p>
                  </div>
                </div>

                <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to
                  create basic applications.</p>

                <div class="mb-16pt">
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Fundamentals of working with
                        Angular</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Create complete Angular
                        applications</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Working with the Angular
                        CLI</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Understanding Dependency
                        Injection</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Testing with Angular</small></p>
                  </div>
                </div>

                <div class="row align-items-center">
                  <div class="col-auto">
                    <div class="d-flex align-items-center mb-4pt">
                      <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                      <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                    </div>
                    <div class="d-flex align-items-center mb-4pt">
                      <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                      <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                    </div>
                    <div class="d-flex align-items-center">
                      <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                      <p class="flex text-50 lh-1 mb-0"><small>Beginner</small></p>
                    </div>
                  </div>
                  <div class="col text-right">
                    <a href="student-course.html" class="btn btn-primary">Watch trailer</a>
                  </div>
                </div>

              </div>

            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">

              <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal " data-partial-height="44" data-toggle="popover" data-trigger="click">

                <a href="student-course.html" class="js-image" data-position="">
                  <img src="{{asset('/images/paths/wordpress_430x168.png')}}" alt="course">
                  <span class="overlay__content align-items-start justify-content-start">
                    <span class="overlay__action card-body d-flex align-items-center">
                      <i class="material-icons mr-4pt">play_circle_outline</i>
                      <span class="card-title text-white">Preview</span>
                    </span>
                  </span>
                </a>

                <div class="mdk-reveal__content">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="flex">
                        <a class="card-title" href="student-course.html">Build a WordPress Website</a>
                        <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                      </div>
                      <a href="student-course.html" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
                    </div>
                    <div class="d-flex">
                      <div class="rating flex">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                      </div>
                      <small class="text-50">6 hours</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="popoverContainer d-none">
                <div class="media">
                  <div class="media-left mr-12pt">
                    <img src="{{asset('/images/paths/wordpress_40x40@2x.png')}}" width="40" height="40" alt="Angular" class="rounded">
                  </div>
                  <div class="media-body">
                    <div class="card-title mb-0">Build a WordPress Website</div>
                    <p class="lh-1 mb-0">
                      <span class="text-50 small">with</span>
                      <span class="text-50 small font-weight-bold">Elijah Murray</span>
                    </p>
                  </div>
                </div>

                <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to
                  create basic applications.</p>

                <div class="mb-16pt">
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Fundamentals of working with
                        Angular</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Create complete Angular
                        applications</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Working with the Angular
                        CLI</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Understanding Dependency
                        Injection</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Testing with Angular</small></p>
                  </div>
                </div>

                <div class="row align-items-center">
                  <div class="col-auto">
                    <div class="d-flex align-items-center mb-4pt">
                      <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                      <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                    </div>
                    <div class="d-flex align-items-center mb-4pt">
                      <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                      <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                    </div>
                    <div class="d-flex align-items-center">
                      <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                      <p class="flex text-50 lh-1 mb-0"><small>Beginner</small></p>
                    </div>
                  </div>
                  <div class="col text-right">
                    <a href="student-course.html" class="btn btn-primary">Watch trailer</a>
                  </div>
                </div>

              </div>

            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">

              <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal " data-partial-height="44" data-toggle="popover" data-trigger="click">

                <a href="student-course.html" class="js-image" data-position="left">
                  <img src="{{asset('/images/paths/react_430x168.png')}}" alt="course">
                  <span class="overlay__content align-items-start justify-content-start">
                    <span class="overlay__action card-body d-flex align-items-center">
                      <i class="material-icons mr-4pt">play_circle_outline</i>
                      <span class="card-title text-white">Preview</span>
                    </span>
                  </span>
                </a>

                <div class="mdk-reveal__content">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="flex">
                        <a class="card-title" href="student-course.html">Become a React Native Developer</a>
                        <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                      </div>
                      <a href="student-course.html" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
                    </div>
                    <div class="d-flex">
                      <div class="rating flex">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                      </div>
                      <small class="text-50">6 hours</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="popoverContainer d-none">
                <div class="media">
                  <div class="media-left mr-12pt">
                    <img src="{{asset('/images/paths/react_40x40@2x.png')}}" width="40" height="40" alt="Angular" class="rounded">
                  </div>
                  <div class="media-body">
                    <div class="card-title mb-0">Become a React Native Developer</div>
                    <p class="lh-1 mb-0">
                      <span class="text-50 small">with</span>
                      <span class="text-50 small font-weight-bold">Elijah Murray</span>
                    </p>
                  </div>
                </div>

                <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to
                  create basic applications.</p>

                <div class="mb-16pt">
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Fundamentals of working with
                        Angular</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Create complete Angular
                        applications</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Working with the Angular
                        CLI</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Understanding Dependency
                        Injection</small></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                    <p class="flex text-50 lh-1 mb-0"><small>Testing with Angular</small></p>
                  </div>
                </div>

                <div class="row align-items-center">
                  <div class="col-auto">
                    <div class="d-flex align-items-center mb-4pt">
                      <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                      <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                    </div>
                    <div class="d-flex align-items-center mb-4pt">
                      <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                      <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                    </div>
                    <div class="d-flex align-items-center">
                      <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                      <p class="flex text-50 lh-1 mb-0"><small>Beginner</small></p>
                    </div>
                  </div>
                  <div class="col text-right">
                    <a href="student-course.html" class="btn btn-primary">Watch trailer</a>
                  </div>
                </div>

              </div>

            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
  <link href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>
<script>
    $('.ui.rating')
        .rating({
            maxRating: 5,
        });

    var rate = ['hate it', 'bad', 'just ok', 'like it', 'love it'];
    var selectedRating = 0; // Initialize with default value

    $(document).ready(function () {
        $.each($('#rating > i.icon'), function (index, item) {
            $(item).attr('data-ratetext', rate[index]);
        });

        // $(document).on('mouseenter', '#rating > i.icon', function () {
        //     $(this)
        //         .popup({
        //             title: $(this).attr('data-ratetext'),
        //             on: 'hover'
        //         })
        //         .popup('show');
        // });

        $('#rating > i.icon').on('click', function () {
            selectedRating = $(this).data('value');
            console.log(selectedRating);
        });

        $('#commentForm').on('submit', function (e) {
            e.preventDefault();
            
            const comment = $('#commentInput').val();
            console.log(comment);
            console.log(selectedRating);

            $.ajax({
                type: 'POST',
                url: '/student/courses/rateCourse/' + {{$course->id}},
                data: {
                    rate: selectedRating,
                    user_review: comment,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log("success");
                    $('#ratingSection').hide();
                    $('#commentForm').hide();
                    $('#thankYouSection').show();
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    });
</script>
</div>
@endsection