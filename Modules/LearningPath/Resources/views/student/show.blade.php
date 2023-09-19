@extends("student.layouts.dashboard")
@section("content")
<!-- Page Content -->
<style>
  .course-card {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    height: 250px;
  }

  .course-image {
    position: relative;
    width: 100%;
    overflow: hidden;
    border-radius: 10px 10px 0 0;
  }

  .course-image img {
    width: 100%;
    display: block;
    border-radius: 10px 10px 0 0;
  }

  .course-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .course-card:hover .course-overlay {
    opacity: 1;
  }
  .course-number {
        background-color: #5567ff!important;
        color: #fff;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        text-align: center;
        line-height: 28px;
        font-size: 14px;
        margin-right: 10px;
  }
</style>

<div class="mdk-box bg-primary mdk-box--bg-primary js-mdk-box mb-0" data-effects="blend-background">
  <div class="mdk-box__content">
    <div class="hero py-64pt text-center text-sm-left">
      <div class="container-fluid page__container">
        <div class="d-flex flex-column flex-sm-row">
          <div class="order-1 order-sm-0">
            <h1 class="text-white">{{$coursePath->title}}</h1>
            <p class="lead text-white-50 measure-hero-lead mb-24pt">{{$coursePath->desc}}</p>
            <a href="" class="btn btn-outline-white">
            <li class="nav-item navbar-list__item">
            @if(session('locale', config('app.locale')) == 'en')
            GET STARTED
            @endif
            @if(session('locale', config('app.locale')) == 'ar')
            ابدأ الآن       
            @endif
            @if(session('locale', config('app.locale')) == 'de')
            LOSLEGEN
            @endif
            </li>            
          </a>
          </div>
          <div class="ml-sm-auto order-sm-1">
            <div class="position-relative overflow-hidden rounded border-4 border-light mb-16pt mb-sm-0">
              <div class="bg-primary fullbleed avatar-xs" style="opacity: .5;"></div>
              <img class="" src="{{asset($coursePath->photo)}}" alt="Angular" style="max-width: 200px;max-height: 100px;">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
      <div class="container-fluid page__container">
        <ul class="nav navbar-nav flex align-items-sm-center">
          <li class="nav-item navbar-list__item">{{$totalLessonCount}} 
          @if(session('locale', config('app.locale')) == 'en')
          Lessons
          @endif
          @if(session('locale', config('app.locale')) == 'ar')
          دروس
          @endif
          @if(session('locale', config('app.locale')) == 'de')
          Unterricht
          @endif
          </li>
          <li class="nav-item navbar-list__item">
            <i class="material-icons text-muted icon--left">schedule</i>
            {{ \Carbon\Carbon::now()->addMinutes($totalLessonCoursesTime)->diffForHumans(null, true, false, 2)}}
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="page-section border-bottom-2">

  <div class="container-fluid page__container">
    <div class="row ">
      <div class="col-md-7">
        <div class="page-separator">
          <div class="page-separator__text">
          @if(session('locale', config('app.locale')) == 'en')
          Introduction
          @endif
          @if(session('locale', config('app.locale')) == 'ar')
          المقدمة
          @endif
          @if(session('locale', config('app.locale')) == 'de')
          Einführung
          @endif
          </div>
        </div>
        <p class="text-70">{{$coursePath->about}}</p>
      </div>
      <div class="col-md-5">
        <div class="page-separator">
          <div class="page-separator__text ">
          @if(session('locale', config('app.locale')) == 'en')
          What you’ll learn
          @endif
          @if(session('locale', config('app.locale')) == 'ar')
          ما ستتعلمه
          @endif
          @if(session('locale', config('app.locale')) == 'de')
          Was Sie lernen werden
          @endif
          </div>
        </div>
        <ul class="list-unstyled">
          @foreach(explode("\n", $coursePath->benefit) as $benefit)
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


<div class="container-fluid page__container">
  <div class="border-left-2 page-section pl-32pt pb-8pt">
    <div class="d-flex align-items-center page-num-container">
      <div class="page-num"></div>
      <h4> 
      @if(session('locale', config('app.locale')) == 'en')
      COURSES
      @endif
      @if(session('locale', config('app.locale')) == 'ar')
      الدورات
      @endif
      @if(session('locale', config('app.locale')) == 'de')
      KURSE
      @endif
      </h4>
    </div>
    <div class="position-relative carousel-card">
      <div class="js-mdk-carousel row d-block" id="carousel-courses1">
        <div class="row">
          @foreach ($courses as $course)
          <div class="col-12 col-sm-6 col-md-4 col-xl-3">
            <div class="course-card">
              <div class="course-image">
                <a href="{{route('student.courses.show', ['CourseId' => $course->id])}}" class="js-image" data-position="">
                  <img src="{{$course->photo}}" alt="course">
                </a>
                <div class="course-overlay">
                  <a href="{{route('student.courses.show', ['CourseId' => $course->id])}}" class="text-white">
                    <i class="material-icons">play_circle_outline</i>
                    <span class="card-title">Preview</span>
                  </a>
                </div>
              </div>

              <div class="mdk-reveal__content">
                <div class="card-body">
                  <div class="d-flex">
                    <div class="flex">
                      <a class="card-title" href="{{route('student.courses.show', ['CourseId' => $course->id])}}">{{$course->title}}</a>
                      <small class="text-50 font-weight-bold mb-4pt">
                        {{$instructors[$course->id]->first_name.' '. $instructors[$course->id]->last_name}}
                      </small>
                    </div>
                    <a href="{{route('student.courses.show', ['CourseId' => $course->id])}}" data-toggle="tooltip" data-title="" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
                  </div>
                  <div class="d-flex">
                    <div class="rating rating-24">
                      @for ($i = 1; $i <= 5; $i++) @if ($i <=$ratingavg[$course->id])
                        <div class="rating__item"><i class="material-icons">star</i></div>
                        @else
                        <div class="rating__item"><i class="material-icons">star_border</i></div>
                        @endif
                        @endfor
                    </div>
                  </div>
                  <div class="d-flex">
                  <div class="course-number" style="margin-right: inherit;">{{ $course->ordering }}</div>

                    <small class="text-50" style="margin-right: auto!important;">{{  \Carbon\Carbon::now()->addMinutes($totalLessonTime[$course->id])->diffForHumans(null, true, false, 2)}}</small>
                  </div>

                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>


<!-- // END Page Content -->

<!-- Footer -->
@endsection