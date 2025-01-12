@include("guest::layouts.master")
@section("content")
      <!-- BEFORE Page Content -->

      <!-- // END BEFORE Page Content -->

      <!-- Page Content -->

      <div class="mdk-box mdk-box--bg-primary bg-dark js-mdk-box mb-0"
        data-effects="parallax-background blend-background">
        <div class="mdk-box__bg">
          <div class="mdk-box__bg-front"
            style="background-image: url(../../public/images/photodune-4161018-group-of-students-m.jpg);"></div>
        </div>
        <div class="mdk-box__content justify-content-center">
          <div class="hero container page__container text-center py-112pt">
            <h1 class="text-white text-shadow">Learn to Code</h1>
            <p class="lead measure-hero-lead mx-auto text-white text-shadow mb-48pt">Business, Technology and Creative Skills taught by industry experts. Explore a wide range of skills with our professional tutorials.</p>

            <a href="courses.html"
              class="btn btn-lg btn-white btn--raised mb-16pt">Browse Courses</a>

            <p class="mb-0"><a href="{{ route('login') }}"
                class="text-white text-shadow"><strong>Are you a teacher?</strong></a></p>

          </div>
        </div>
      </div>

      <div class="border-bottom-2 py-16pt navbar-light bg-white border-bottom-2">
        <div class="container page__container">
          <div class="row align-items-center">
            <div class="d-flex col-md align-items-center border-bottom border-md-0 mb-16pt mb-md-0 pb-16pt pb-md-0">
              <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                <i class="material-icons text-white">subscriptions</i>
              </div>
              <div class="flex">
                <div class="card-title mb-4pt">8,000+ Courses</div>
                <p class="card-subtitle text-70">Explore a wide range of skills.</p>
              </div>
            </div>
            <div class="d-flex col-md align-items-center border-bottom border-md-0 mb-16pt mb-md-0 pb-16pt pb-md-0">
              <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                <i class="material-icons text-white">verified_user</i>
              </div>
              <div class="flex">
                <div class="card-title mb-4pt">By Industry Experts</div>
                <p class="card-subtitle text-70">Professional development from the best people.</p>
              </div>
            </div>
            <div class="d-flex col-md align-items-center">
              <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                <i class="material-icons text-white">update</i>
              </div>
              <div class="flex">
                <div class="card-title mb-4pt">Unlimited Access</div>
                <p class="card-subtitle text-70">Unlock Library and learn any topic with one subscription.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="page-section border-bottom-2">
        <div class="container page__container">

          <div class="page-separator">
            <div class="page-separator__text">From the blog</div>
          </div>

          <div class="row card-group-row">
            @foreach ($blogs as $blog)

            <div class="col-md-6 col-lg-4 card-group-row__col">

              <div class="card card--elevated posts-card-popular overlay card-group-row__card">
                <img src="{{ asset($blog->photo) }}"
                  alt=""
                  class="card-img">
                <div class="fullbleed bg-primary"
                  style="opacity: .5"></div>
                <div class="posts-card-popular__content">
                  <div class="card-body d-flex align-items-center">

                    <a style="text-decoration: none;"
                      class="d-flex align-items-center"
                      href=""><i class="material-icons mr-1"
                        style="font-size: inherit;">remove_red_eye</i> <small>0</small></a>
                  </div>
                  <div class="posts-card-popular__title card-body">
                    <small class="text-muted text-uppercase">{{$blog->user->first_name.' '.$blog->user->last_name}}</small>
                    <a class="card-title"
                      href="{{ route('blog.show', ['blogid' => $blog->id]) }}">{{$blog->title}}</a>
                  </div>
                </div>
              </div>

            </div>
            @endforeach



          </div>
          @if(isset($blogs[1]))

          <div class="posts-cards">

            <div class="card posts-card mb-0">
              <div class="posts-card__content d-flex align-items-center flex-wrap">
                <div class="avatar avatar-lg mr-3">
                  <a href="{{ route('blog.show', ['blogid' => $blogs[1]->id]) }}"><img src="{{ asset($blogs[1]->photo) }}"
                      alt="avatar"
                      class="avatar-img rounded"></a>
                </div>
                <div class="posts-card__title flex d-flex flex-column">
                  <a href="{{ route('blog.show', ['blogid' => $blogs[1]->id]) }}"
                    class="card-title mr-3">{{$blogs[1]->title}}</a>
                  <small class="text-50">{{ $blogs[1]->created_at->diffForHumans() }}</small>
                </div>
                <div class="d-flex align-items-center flex-column flex-sm-row posts-card__meta">
                  <div class="mr-3 text-50 text-uppercase posts-card__tag d-flex align-items-center">
                    <i class="material-icons text-muted-light mr-1">folder_open</i> inVision
                  </div>
                  <div class="mr-3 text-50 posts-card__date">
                    <small>{{$blogs[1]->created_at}}</small>
                  </div>
                  <div class="media ml-sm-auto align-items-center">
                    <div class="media-left mr-2 avatar-group">
                    </div>

                  </div>
                </div>
              </div>
            </div>

          </div>
        @endif
        </div>
      </div>

      <div class="page-section border-bottom-2">
        <div class="container page__container">
          <div class="page-separator">
            <div class="page-separator__text">Learning Paths</div>
          </div>

          <div class="row card-group-row">
            @foreach ($coursePaths as $coursePath)

            <div class="col-sm-4 card-group-row__col">

              <div class="card js-overlay card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card"
                data-toggle="popover"
                data-trigger="click">

                <div class="card-body d-flex flex-column">
                  <div class="d-flex align-items-center">
                    <div class="flex">
                      <div class="d-flex align-items-center">
                        <div class="rounded mr-12pt z-0 o-hidden">
                          <div class="overlay">
                            <img src="{{ asset($coursePath->photo) }}"
                              width="40"
                              height="40"
                              alt="Angular"
                              class="rounded">
                            <span class="overlay__content overlay__content-transparent">
                              <span class="overlay__action d-flex flex-column text-center lh-1">
                                <small class="h6 small text-white mb-0"
                                  style="font-weight: 500;">0%</small>
                              </span>
                            </span>
                          </div>
                        </div>
                        <div class="flex">
                          <div class="card-title">{{$coursePath->title}}</div>
                          <p class="flex text-50 lh-1 mb-0"><small>{{$coursesCounts[$coursePath->id] }} courses</small></p>
                        </div>
                      </div>
                    </div>

                    <a href="{{ route('student.path.show', ['pathId' => $coursePath->id]) }}"
                      data-toggle="tooltip"
                      data-title="Add Favorite"
                      data-placement="top"
                      data-boundary="window"
                      class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>

                  </div>

                </div>
              </div>

              <div class="popoverContainer d-none">
                <div class="media">
                  <div class="media-left mr-12pt">
                    <img src="{{ asset($coursePath->photo) }}"
                      width="40"
                      height="40"
                      alt="Angular"
                      class="rounded">
                  </div>
                  <div class="media-body">
                    <div class="card-title">{{$coursePath->title}}</div>
                    <p class="text-50 d-flex lh-1 mb-0 small">{{$coursesCounts[$coursePath->id] }} courses</p>
                  </div>
                </div>

                <p class="mt-16pt text-70">{{$coursePath->about}}</p>

                <div class="my-32pt">
                  <div class="d-flex align-items-center mb-8pt justify-content-center">
                    <div class="d-flex align-items-center mr-8pt">
                      <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                      <p class="flex text-50 lh-1 mb-0"><small>{{$coursePath->totalLessonCoursesTime}} minutes </small></p>
                    </div>
                    <div class="d-flex align-items-center">
                      <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                      <p class="flex text-50 lh-1 mb-0"><small>{{$coursePath->totalLessonCount }} lessons</small></p>
                    </div>
                  </div>
                  <div class="d-flex align-items-center justify-content-center">
                    <a href="{{ route('student.path.show', ['pathId' => $coursePath->id]) }}"
                      class="btn btn-primary mr-8pt">Resume</a>
                    <a href="{{ route('student.path.show', ['pathId' => $coursePath->id]) }}"
                      class="btn btn-outline-secondary ml-0">Start over</a>
                  </div>
                </div>

                <!-- <div class="d-flex align-items-center">
                  <small class="text-50 mr-8pt">Your rating</small>
                  <div class="rating mr-8pt">
                    <span class="rating__item"><span class="material-icons text-primary">star</span></span>
                    <span class="rating__item"><span class="material-icons text-primary">star</span></span>
                    <span class="rating__item"><span class="material-icons text-primary">star</span></span>
                    <span class="rating__item"><span class="material-icons text-primary">star</span></span>
                    <span class="rating__item"><span class="material-icons text-primary">star_border</span></span>
                  </div>
                  <small class="text-50">4/5</small>
                </div> -->
              </div>

            </div>
            @endforeach
          </div>



        </div>
      </div>

      <div class="page-section border-bottom-2">
        <div class="container page__container">
          <div class="page-separator">
            <div class="page-separator__text">Courses</div>
          </div>

          <div class="row card-group-row">
            @foreach ($courses as $course)

            <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

              <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card"
                data-toggle="popover"
                data-trigger="click">

                <a href="{{ route('student.courses.show', ['CourseId' => $course->id]) }}"
                  class="card-img-top js-image"
                  data-position=""
                  data-height="140">
                  <img src="{{ asset($course->photo) }}"
                    alt="course">
                  <span class="overlay__content">
                    <span class="overlay__action d-flex flex-column text-center">
                      <i class="material-icons icon-32pt">play_circle_outline</i>
                      <span class="card-title text-white">Preview</span>
                    </span>
                  </span>
                </a>

                <div class="card-body flex">
                  <div class="d-flex">
                    <div class="flex">
                      <a class="card-title"
                        href="{{ route('student.courses.show', ['CourseId' => $course->id]) }}">{{$course->title}}</a>
                      <small class="text-50 font-weight-bold mb-4pt">{{ $instructor[$course->id]->first_name.' '.$instructor[$course->id]->last_name}}</small>
                    </div>
                    <a href="{{ route('student.courses.show', ['CourseId' => $course->id]) }}"
                      data-toggle="tooltip"
                      data-title="Add Favorite"
                      data-placement="top"
                      data-boundary="window"
                      class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
                  </div>
                  <div class="d-flex">


                    <div class="rating rating-24">
                      @for ($i = 1; $i <= 5; $i++) @if ($i <=$courseRate[$course->id])
                        <div class="rating__item"><i class="material-icons">star</i></div>
                        @else
                        <div class="rating__item"><i class="material-icons">star_border</i></div>
                        @endif
                        @endfor
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row justify-content-between">
                    <div class="col-auto d-flex align-items-center">
                      <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                      <p class="flex text-50 lh-1 mb-0"><small>{{ \Carbon\Carbon::now()->addMinutes($totalLessonTime[$course->id])->diffForHumans(null, true, false, 2) }}</small></p>
                    </div>
                    <div class="col-auto d-flex align-items-center">
                      <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                      <p class="flex text-50 lh-1 mb-0"><small>{{$courseLessons[$course->id]}} lessons</small></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="popoverContainer d-none">
                <div class="media">
                  <div class="media-left mr-12pt">
                    <img src="{{ asset($course->photo) }}"
                      width="40"
                      height="40"
                      alt="Angular"
                      class="rounded">
                  </div>
                  <div class="media-body">
                    <div class="card-title mb-0">{{$course->title}}</div>
                    <p class="lh-1 mb-0">
                      <span class="text-50 small">with</span>
                      <span class="text-50 small font-weight-bold">{{ $instructor[$course->id]->first_name.' '.$instructor[$course->id]->last_name}}</span>
                    </p>
                  </div>
                </div>

                <p class="my-16pt text-70">{{$course->about}}</p>

                <ul class="list-unstyled">
                  @foreach(explode("\n", $course->benefit) as $benefit)
                  <li class="d-flex align-items-center">
                    <span class="material-icons text-50 mr-8pt">check</span>
                    <span class="text-70">{{ $benefit }}</span>
                  </li>
                  @endforeach
                </ul>

                <div class="row align-items-center">
                  <div class="col-auto">
                    <div class="d-flex align-items-center mb-4pt">
                      <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                      <p class="flex text-50 lh-1 mb-0"><small>{{ \Carbon\Carbon::now()->addMinutes($totalLessonTime[$course->id])->diffForHumans(null, true, false, 2) }}</small></p>
                    </div>
                    <div class="d-flex align-items-center mb-4pt">
                      <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                      <p class="flex text-50 lh-1 mb-0"><small>{{$courseLessons[$course->id]}} lessons</small></p>
                    </div>
                    <div class="d-flex align-items-center">
                      <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                      <p class="flex text-50 lh-1 mb-0"><small>{{$course->level}}</small></p>
                    </div>
                  </div>
                  <div class="col text-right">
                    <a href="{{ route('student.courses.show', ['CourseId' => $course->id]) }}"
                      class="btn btn-primary">more details</a>
                  </div>
                </div>

              </div>

            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="page-section">
        <div class="container page__container">
          <div class="page-headline text-center">
            <h2>Feedback</h2>
            <p class="lead measure-lead mx-auto text-70">What other students turned professionals have to say about us after learning with us and reaching their goals.</p>
          </div>

          <div class="position-relative carousel-card p-0 mx-auto">
            <div class="row d-block js-mdk-carousel"
              id="carousel-feedback">
              <a class="carousel-control-next js-mdk-carousel-control mt-n24pt"
                href="#carousel-feedback"
                role="button"
                data-slide="next">
                <span class="carousel-control-icon material-icons"
                  aria-hidden="true">keyboard_arrow_right</span>
                <span class="sr-only">Next</span>
              </a>
              <div class="mdk-carousel__content">

                <div class="col-12 col-md-6">

                  <div class="card card-feedback card-body">
                    <blockquote class="blockquote mb-0">
                      <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
                    </blockquote>
                  </div>
                  <div class="media ml-12pt">
                    <div class="media-left mr-12pt">
                      <a href="student-profile.html"
                        class="avatar avatar-sm">
                        <!-- <img src="../../public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                        <span class="avatar-title rounded-circle">UK</span>
                      </a>
                    </div>
                    <div class="media-body media-middle">
                      <a href="student-profile.html"
                        class="card-title">Umberto Kass</a>
                      <div class="rating mt-4pt">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="col-12 col-md-6">

                  <div class="card card-feedback card-body">
                    <blockquote class="blockquote mb-0">
                      <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
                    </blockquote>
                  </div>
                  <div class="media ml-12pt">
                    <div class="media-left mr-12pt">
                      <a href="student-profile.html"
                        class="avatar avatar-sm">
                        <!-- <img src="../../public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                        <span class="avatar-title rounded-circle">UK</span>
                      </a>
                    </div>
                    <div class="media-body media-middle">
                      <a href="student-profile.html"
                        class="card-title">Umberto Kass</a>
                      <div class="rating mt-4pt">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="col-12 col-md-6">

                  <div class="card card-feedback card-body">
                    <blockquote class="blockquote mb-0">
                      <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
                    </blockquote>
                  </div>
                  <div class="media ml-12pt">
                    <div class="media-left mr-12pt">
                      <a href="student-profile.html"
                        class="avatar avatar-sm">
                        <!-- <img src="../../public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                        <span class="avatar-title rounded-circle">UK</span>
                      </a>
                    </div>
                    <div class="media-body media-middle">
                      <a href="student-profile.html"
                        class="card-title">Umberto Kass</a>
                      <div class="rating mt-4pt">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                      </div>
                    </div>
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- // END Page Content -->

      <!-- Footer -->

      <div class="bg-white border-top-2 mt-auto">
        <div class="container page__container page-section d-flex flex-column">
          <p class="text-70 brand mb-24pt">
            <img class="brand-icon"
              src="../../public/images/logo/black-70@2x.png"
              width="30"
              alt="Luma"> Luma
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

    </div>

    <!-- // END drawer-layout__content -->

    <!-- Drawer -->


    <!-- // END Drawer -->

  </div>

  <!-- // END Drawer Layout -->

 
</body>

</html>