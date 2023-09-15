@extends("student.layouts.dashboard")
@section("content")
<div class="mdk-drawer-layout__content page-content">
  <div class="pt-32pt">
    <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
      <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

        <div class="mb-24pt mb-sm-0 mr-sm-24pt">
          <h2 class="mb-0">
            @if(session('locale', config('app.locale')) == 'en')
            Training Courses
            @endif
            @if(session('locale', config('app.locale')) == 'ar')
            الدورات التدريبية
            @endif
            @if(session('locale', config('app.locale')) == 'de')
            Bildungskurse
            @endif
          </h2>

          <!-- <ol class="breadcrumb p-0 m-0">
            <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>

            <li class="breadcrumb-item active">

              الدورات التدريبية

            </li> -->

          </ol>

        </div>
      </div>

      <div class="row" role="tablist">
        <div class="col-auto">
          <a href="student-paths.html" class="btn btn-outline-secondary">
            @if(session('locale', config('app.locale')) == 'en')
            Educational path
            @endif
            @if(session('locale', config('app.locale')) == 'ar')
            المسار التعليمي
            @endif
            @if(session('locale', config('app.locale')) == 'de')
            Bildungsweg
            @endif
          </a>
        </div>
      </div>

    </div>
  </div>
  <div class="page-section border-bottom-2">
    <div class="container page__container">
      <div class="card">
        <img src="{{asset('/images/paths/typescript_892x286.png')}}" alt="TypeScript" class="card-img" style="max-height: 100%; width: initial;">
        <div class="fullbleed bg-primary" style="opacity: .5;"></div>
        <img src="{{asset('/images/paths/typescript_64x64.svg')}}" width="64" alt="Instruduction to TypeScript" class="rounded position-absolute" style="right: 1rem; top: 1rem;">
        <div class="card-body d-flex align-items-center justify-content-center fullbleed">
          <div>
            <h2 class="text-white mb-16pt">
              الحساب السريع
            </h2>
            <div class="d-flex align-items-center mb-16pt justify-content-center">
              <div class="d-flex align-items-center mr-16pt">
                <span class="material-icons icon-16pt text-white-50 mr-4pt">access_time</span>
                <p class="flex text-white-50 lh-1 mb-0">50 minutes left</p>
              </div>
              <div class="d-flex align-items-center">
                <span class="material-icons icon-16pt text-white-50 mr-4pt">play_circle_outline</span>
                <p class="flex text-white-50 lh-1 mb-0">12 lessons</p>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
              <a href="student-take-lesson.html" class="btn btn-white mr-8pt">
                @if(session('locale', config('app.locale')) == 'en')
                Resumption
                @endif
                @if(session('locale', config('app.locale')) == 'ar')
                استئناف
                @endif
                @if(session('locale', config('app.locale')) == 'de')
                Wiederaufnahme
                @endif
              </a>
              <a href="student-take-course.html" class="btn btn-outline-white ml-0">
                @if(session('locale', config('app.locale')) == 'en')
                Start from the beginning
                @endif
                @if(session('locale', config('app.locale')) == 'ar')
                ابدأ من جديد
                @endif
                @if(session('locale', config('app.locale')) == 'de')
                Fang nochmal an
                @endif
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex flex-wrap align-items-start">
        <div class="d-flex align-items-center mr-24pt">
          <a href="student-take-course.html" class="mr-12pt">
            <img src="{{asset('/images/paths/woderhafen.jpeg')}}" width="40" alt="Angular" class="rounded">
          </a>
          <div class="flex">
            <a class="card-title" href="student-take-course.html">wonerhafen</a>
            <p class="lh-1 mb-0">
              <span class="text-50 small">Elijah Murray</span>
            </p>
          </div>
        </div>
        <div class="d-flex align-items-center py-4pt" style="white-space: nowrap;">
          <small class="text-50 mr-8pt">
            @if(session('locale', config('app.locale')) == 'en')
            Your rating
            @endif
            @if(session('locale', config('app.locale')) == 'ar')
            تقييمك
            @endif
            @if(session('locale', config('app.locale')) == 'de')
            Deine Bewertung
            @endif</small>
          <div class="rating mr-8pt">
            <span class="rating__item"><span class="material-icons text-orange">star</span></span>
            <span class="rating__item"><span class="material-icons text-orange">star</span></span>
            <span class="rating__item"><span class="material-icons text-orange">star</span></span>
            <span class="rating__item"><span class="material-icons text-orange">star</span></span>
            <span class="rating__item"><span class="material-icons text-orange">star_border</span></span>
          </div>
          <small class="text-50">4/5</small>
        </div>

      </div>
    </div>
  </div>
  <div class="container page__container">
    <div class="page-section">
      @foreach ($taxonomies as $taxonomy)
      @if ($taxonomy->courses->count() > 0)
      <div class="page-separator">
        <div class="page-separator__text">{{$taxonomy->title}}</div>
      </div>

      <div class="row">
        @foreach ($courses as $course)
        @if ($course->taxonomy_id === $taxonomy->id)

        <div class="col-lg-3 mb-24pt">
          <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card">

            <!-- Course Image -->
            <a href="{{ route('student.courses.show', ['CourseId' => $course->id]) }}" class="card-img-top js-image" data-position="" data-height="140">
              <img src="{{ asset($course->photo) }}" alt="course"></a>
            <!-- <span class="overlay__content">
                            <span class="overlay__action d-flex flex-column text-center">
                                <i class="material-icons icon-32pt">play_circle_outline</i>
                                <span class="card-title text-white">Resume</span>
                            </span> -->
            </span>
            </a>

            <!-- <span class="corner-ribbon corner-ribbon--default-right-top corner-ribbon--shadow bg-accent text-white">NEW</span> -->

            <div class="card-body flex">
              <div class="d-flex">
                <div class="flex">
                  <a href="{{ route('student.courses.show', ['CourseId' => $course->id]) }}" class="card-title">{{$course->title}}</a>
                  <small class="text-50 font-weight-bold mb-4pt">{{ $instructor[$course->id]->first_name.' '.$instructor[$course->id]->last_name}}</small>
                </div>
                <a href="student-take-course.html" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                  <p class="flex text-50 lh-1 mb-0"><small>{{ $totalLessonTime[$course->id] }}m</small></p>
                </div>
                <div class="col-auto d-flex align-items-center">
                  <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                  <p class="flex text-50 lh-1 mb-0"><small>{{$courseLessons[$course->id]}}
                      @if(session('locale', config('app.locale')) == 'en')
                      lessons
                      @endif
                      @if(session('locale', config('app.locale')) == 'ar')
                      الدروس
                      @endif
                      @if(session('locale', config('app.locale')) == 'de')
                      Unterricht
                      @endif
                    </small></p>
                </div>
              </div>

            </div>
          </div>
          <div class="popoverContainer d-none">
            <!-- Course Details Popover Content -->
          </div>
        </div>
        @endif
        @endforeach
      </div>
      @endif
      @endforeach

      @if ($coursePaths->count() > 0)
      <div class="page-separator">
        <div class="page-separator__text">
          @if(session('locale', config('app.locale')) == 'en')
          Learning Paths
          @endif
          @if(session('locale', config('app.locale')) == 'ar')
          مسارات التعلم
          @endif
          @if(session('locale', config('app.locale')) == 'de')
          Lernpfade
          @endif
        </div>
      </div>
      @endif

      <div class="row card-group-row mb-lg-8pt">
      @foreach ($coursePaths as $coursePath)
        <div class="col-sm-4 card-group-row__col">
          <a href="{{ route('student.path.show', ['pathId' => $coursePath->id]) }}">
            <div class="card card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card">
              <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center">
                  <div class="flex">
                    <div class="d-flex align-items-center">
                      <div class="rounded mr-12pt z-0 o-hidden">
                        <div class="overlay">
                          <img src="{{ asset($coursePath->photo) }}" width="40" height="40" alt="Angular" class="rounded">
                          <span class="overlay__content overlay__content-transparent">
                            <span class="overlay__action d-flex flex-column text-center lh-1">
                              <small class="h6 small text-white mb-0" style="font-weight: 500;">80%</small>
                            </span>
                          </span>
                        </div>
                      </div>
                      <div class="flex">
                        <div class="card-title">{{ $coursePath->title }}</div>
                        <p class="flex text-50 lh-1 mb-0"><small>{{$coursesCounts[$coursePath->id] }}    
                        @if(session('locale', config('app.locale')) == 'en')
                        courses
                        @endif
                        @if(session('locale', config('app.locale')) == 'ar')
                        دورات
                        @endif
                        @if(session('locale', config('app.locale')) == 'de')
                        Kurse
                        @endif
                        </small></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>

   
      <div class="page-separator">
        <div class="page-separator__text">
          @if(session('locale', config('app.locale')) == 'en')
          Achievements
          @endif
          @if(session('locale', config('app.locale')) == 'ar')
          الانجازات
          @endif
          @if(session('locale', config('app.locale')) == 'de')
          Erfolge
          @endif
        </div>
      </div>
      <div class="position-relative carousel-card">
        <div class="js-mdk-carousel row d-block" id="carousel-achievements">

          <a class="carousel-control-next js-mdk-carousel-control" href="#carousel-achievements" role="button" data-slide="next">
            <span class="carousel-control-icon material-icons" aria-hidden="true">keyboard_arrow_right</span>
            <span class="sr-only">Next</span>
          </a>

          <div class="mdk-carousel__content">

            <div class="col-12 col-sm-6">

              <a class="card border-0 mb-0" href="">
                <img src="{{asset('/images/achievements/flinto.png')}}" alt="Flinto" class="card-img" style="max-height: 100%; width: initial;">
                <div class="fullbleed bg-primary" style="opacity: .5;"></div>
                <span class="card-body d-flex flex-column align-items-center justify-content-center fullbleed">
                  <span class="row flex-nowrap">
                    <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                      <span class="h5 text-white text-uppercase font-weight-normal m-0 d-block">Achievement</span>
                      <span class="text-white-60 d-block mb-24pt">Jun 5, 2018</span>
                    </span>
                    <span class="col d-flex flex-column">
                      <span class="text-right flex mb-16pt">
                        <img src="{{asset('/images/paths/flinto_40x40@2x.png')}}" width="64" alt="Flinto" class="rounded">
                      </span>
                    </span>
                  </span>
                  <span class="row flex-nowrap">
                    <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                      <img src="{{asset('/images/illustration/achievement/128/white.png')}}" width="64" alt="achievement">
                    </span>
                    <span class="col d-flex flex-column">
                      <span>
                        <span class="card-title text-white mb-4pt d-block">Flinto</span>
                        <span class="text-white-60">Introduction to The App Design Application</span>
                      </span>
                    </span>
                  </span>
                </span>
              </a>

            </div>

            <div class="col-12 col-sm-6">

              <a class="card border-0 mb-0" href="">
                <img src="{{asset('/images/achievements/angular.png')}}" alt="Angular fundamentals" class="card-img" style="max-height: 100%; width: initial;">
                <div class="fullbleed bg-primary" style="opacity: .5;"></div>
                <span class="card-body d-flex flex-column align-items-center justify-content-center fullbleed">
                  <span class="row flex-nowrap">
                    <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                      <span class="h5 text-white text-uppercase font-weight-normal m-0 d-block">Achievement</span>
                      <span class="text-white-60 d-block mb-24pt">Jun 5, 2018</span>
                    </span>
                    <span class="col d-flex flex-column">
                      <span class="text-right flex mb-16pt">
                        <img src="{{asset('/images/paths/angular_64x64.png')}}" width="64" alt="Angular fundamentals" class="rounded">
                      </span>
                    </span>
                  </span>
                  <span class="row flex-nowrap">
                    <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                      <img src="{{asset('/images/illustration/achievement/128/white.png')}}" width="64" alt="achievement">
                    </span>
                    <span class="col d-flex flex-column">
                      <span>
                        <span class="card-title text-white mb-4pt d-block">Angular fundamentals</span>
                        <span class="text-white-60">Creating and Communicating Between Angular Components</span>
                      </span>
                    </span>
                  </span>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection