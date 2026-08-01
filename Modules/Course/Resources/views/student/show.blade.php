@extends("student.layouts.dashboard")
@section('content')

<style>
  .dropbtn {
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    background-color: #aad8ce;
    color: black;
  }

  .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
  }

  .dropdown-content button {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    width: 100%;
    border: none;
    background-color: transparent;
    text-align: left;
    cursor: pointer;
  }

  .dropdown-content button:hover {
    background-color: #f1f1f1;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }

  .dropdown:hover .dropbtn {
    background-color: #aad8ce;
  }

  /* Worksheet description: wrap to two lines, then ellipsis. */
  .worksheet-desc {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    white-space: normal;
    line-height: 1.3;
  }
</style>
<div class="mdk-drawer-layout__content page-content">

  <div class="mdk-box bg-primary mdk-box--bg-gradient-primary2 js-mdk-box mb-0" data-effects="blend-background">
    <div class="mdk-box__content">
      <div class="hero py-64pt text-center text-sm-left">
        <div class="container page__container">
          <h1 class="text-white">{{$course->title}}</h1>
          <p class="lead text-white-50 measure-hero-lead mb-24pt">{{$course->desc}}</p>
          @if (!$isAuthInroll)
          <form method="POST" action="{{ route('student.inrollment.store', ['courseId' => $course->id]) }}">
            @csrf
            <div class="dropdown">
              <button type="button" class="dropbtn btn btn-white">Enroll in Course</button>
              <div class="dropdown-content">
                <button type="submit" value="{{ $semester->id }}" name="semester_id">Semester: {{ $semester->title }}</button>
              </div>
            </div>
          </form>
          @endif
        </div>
      </div>
      @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif

      @if(session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
      @endif
      <div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
        <div class="container page__container">
          <ul class="nav navbar-nav flex align-items-sm-center">
            <li class="nav-item navbar-list__item">
              <div class="media align-items-center">
                <span class="media-left mr-16pt">
                  <img src="{{asset($instructor->avatar)}}" width="40" alt="avatar" class="rounded-circle">
                </span>
                <div class="media-body">
                  <a class="card-title m-0" href="{{ route('instructor.profile', ['instructorId' => $instructor->user_id]) }}">{{ $instructor->first_name.' '.$instructor->last_name}}</a>
                  <p class="text-50 lh-1 mb-0">
                    @if(session('locale', config('app.locale')) == 'en')
                    Instructor
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    مدرس
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Lehrer
                    @endif
                  </p>
                </div>
              </div>
            </li>
            <li class="nav-item navbar-list__item">
              <i class="material-icons text-muted icon--left">schedule</i>
              {{ \Carbon\Carbon::now()->addMinutes($totalLessonTime)->diffForHumans(null, true, false, 2)}}
            </li>
            <li class="nav-item navbar-list__item">
              <i class="material-icons text-muted icon--left">assessment</i>
              {{$course->level}}
            </li>
            <li class="nav-item ml-sm-auto text-sm-center flex-column navbar-list__item">

              <div class="rating rating-24">
                @for ($i = 1; $i <= 5; $i++) @if ($i <=$courseRate) <div class="rating__item"><i class="material-icons">star</i></div>
              @else
              <div class="rating__item"><i class="material-icons">star_border</i></div>
              @endif
              @endfor
        </div>
        <p class="text-muted mb-0">{{$ratingCount}}<small>
            @if(session('locale', config('app.locale')) == 'en')
            ratings
            @endif
            @if(session('locale', config('app.locale')) == 'ar')
            التقييمات
            @endif
            @if(session('locale', config('app.locale')) == 'de')
            Bewertungen
            @endif
          </small></p>
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
        @if ($isAuthInroll)
        <div class="card mb-32pt">
          <div class="card-body">
            <div class="page-separator mb-2">
              <div class="page-separator__text">
                @if(session('locale', config('app.locale')) == 'ar') تقدمك
                @elseif(session('locale', config('app.locale')) == 'de') Ihr Fortschritt
                @else Your progress @endif
              </div>
            </div>
            @include('progress._report', ['report' => $myProgress, 'open' => true])
          </div>
        </div>
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
                <span class="flex"> {{$coursestepCount[$content->id]}}
                  @if(session('locale', config('app.locale')) == 'en')
                  Steps
                  @endif
                  @if(session('locale', config('app.locale')) == 'ar')
                  مراحل
                  @endif
                  @if(session('locale', config('app.locale')) == 'de')
                  Schritte
                  @endif
                </span>
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
                    <span class="material-icons icon-16pt icon--left text-50">hourglass_empty</span>
                    <a class="flex" href="{{ route('student.practice.forcourse', ['id' => $step->stepable_id, 'type' => $step->practiceTypeDetail->practice->blade_name, 'course' => $course->id]) }}">{{ $step->stepable_type }}: {{ $step->title }}</a>
                    @elseif ($step->stepable_type === 'ClassSessions')
                    @php($session = $step->classSession)
                    @php($att = $session ? $myAttendance->get($session->id) : null)
                    @php($given = $att && $att->is_given)
                    <span class="material-icons icon-16pt icon--left text-50">videocam</span>
                    <span class="flex" style="display:block; min-width:0;">
                      <div>
                        {{ optional($session->classroom)->name ?? 'Session' }}@if($session && $session->content) — {{ $session->content }}@endif
                        @if($session && $session->held_at)
                        <small class="text-muted">— <span data-localtime="{{ $session->held_at->toIso8601String() }}">{{ $session->held_at->format('Y-m-d H:i') }} UTC</span></small>
                        @endif
                      </div>
                      @if($given)
                      <div class="mt-1">
                        <span class="badge badge-success">&#10003; Given</span>
                        @if($att->given_at)
                        <small class="text-muted ml-1"><span data-localtime="{{ $att->given_at->toIso8601String() }}">{{ $att->given_at->format('Y-m-d H:i') }} UTC</span></small>
                        @endif
                      </div>
                      @if($att->notes)
                      <div class="text-70 mt-1"><small><strong>Note:</strong> {{ $att->notes }}</small></div>
                      @endif
                      @endif
                    </span>
                    @if(!$given)
                      @if($session && $session->zoom_url)
                      <a href="{{ $session->zoom_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-success ml-2">Join</a>
                      @else
                      <span class="badge badge-secondary ml-2">Link not posted yet</span>
                      @endif
                    @endif
                    @elseif ($step->stepable_type === 'Worksheets')
                    @php($ws = $step->worksheet)
                    @php($wsRead = $ws && in_array((int) $ws->id, $myWorksheetReads, true))
                    <span class="material-icons icon-16pt icon--left text-50">description</span>
                    <span class="flex" style="display:block; min-width:0;">
                      <div class="text-truncate">{{ $ws ? $ws->title : 'Worksheet' }}</div>
                      @if($ws && $ws->description)
                      <small class="text-muted worksheet-desc" title="{{ $ws->description }}">{{ $ws->description }}</small>
                      @endif
                      @if($wsRead)
                      <div class="mt-1"><span class="badge badge-success">&#10003; Read</span></div>
                      @endif
                    </span>
                    @if($ws)
                    <a href="{{ route('student.worksheet.open', ['worksheetId' => $ws->id, 'courseId' => $course->id]) }}"
                       class="btn btn-sm {{ $wsRead ? 'btn-outline-secondary' : 'btn-primary' }} ml-2 d-inline-flex align-items-center"
                       style="flex-shrink:0; white-space:nowrap;">
                      <span class="material-icons" style="font-size:1rem;margin-right:4px;">file_download</span>
                      {{ $wsRead ? 'Download again' : 'Download' }}
                    </a>
                    @endif
                    @elseif ($step->stepable_type === 'Links')
                    @php($lnk = $step->link)
                    @php($lnkDone = $lnk && in_array((int) $lnk->id, $myLinkReads, true))
                    <span class="material-icons icon-16pt icon--left text-50">link</span>
                    <span class="flex" style="display:block; min-width:0;">
                      <div class="text-truncate">{{ $lnk ? $lnk->title : 'Link' }}</div>
                      @if($lnkDone)
                      <div class="mt-1"><span class="badge badge-success">&#10003; Done</span></div>
                      @endif
                    </span>
                    @if($lnk)
                    <a href="{{ route('student.link.open', ['linkId' => $lnk->id, 'courseId' => $course->id]) }}"
                       target="_blank" rel="noopener"
                       class="btn btn-sm {{ $lnkDone ? 'btn-outline-secondary' : 'btn-primary' }} ml-2 d-inline-flex align-items-center"
                       style="flex-shrink:0; white-space:nowrap;">
                      <span class="material-icons" style="font-size:1rem;margin-right:4px;">open_in_new</span>
                      {{ $lnkDone ? 'Open again' : 'Open' }}
                    </a>
                    @endif
                    @elseif ($step->stepable_type === 'Quizzes')
                    <span class="material-icons icon-16pt icon--left text-50">question_answer</span>
                    @endif
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
          </ul>
        </div>
        @endforeach
        @endif


      </div>
    </div>
    <div class="col-lg-5 page-nav">
      <div class="page-section">
        <div class="page-nav__content">
          <div class="page-separator">
            <div class="page-separator__text">
              @if(session('locale', config('app.locale')) == 'en')
              Table of contents
              @endif
              @if(session('locale', config('app.locale')) == 'ar')
              جدول المحتويات
              @endif
              @if(session('locale', config('app.locale')) == 'de')
              Inhaltsverzeichnis
              @endif
            </div>
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
          <div class="page-separator__text">
            @if(session('locale', config('app.locale')) == 'en')
            About this course
            @endif
            @if(session('locale', config('app.locale')) == 'ar')
            حول هذه الدورة
            @endif
            @if(session('locale', config('app.locale')) == 'de')
            Über diesen Kurs
            @endif
          </div>
        </div>
        <p class="text-70">{{$course->about}}</p>
      </div>
      <div class="col-md-5">
        <div class="page-separator">
          <div class="page-separator__text bg-white">
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
        <h4>
          @if(session('locale', config('app.locale')) == 'en')
          About the author
          @endif
          @if(session('locale', config('app.locale')) == 'ar')
          عن المؤلف
          @endif
          @if(session('locale', config('app.locale')) == 'de')
          Über den Autor
          @endif
        </h4>
        <p class="text-70 mb-24pt">{{$instructor->about}}</p>

        <div class="page-separator">
          <div class="page-separator__text bg-white">
            @if(session('locale', config('app.locale')) == 'en')
            More from the author
            @endif
            @if(session('locale', config('app.locale')) == 'ar')
            المزيد من المؤلف
            @endif
            @if(session('locale', config('app.locale')) == 'de')
            Mehr vom Autor
            @endif
          </div>
        </div>
        @foreach ($instructorCourses as $instructorCourse)

        <div class="card card-sm mb-8pt">
          <div class="card-body d-flex align-items-center">
            <a href="{{ route('student.courses.show', ['CourseId' => $instructorCourse->id]) }}" class="avatar avatar-4by3 mr-12pt">
              <img src="{{asset($instructorCourse->photo)}}" alt="{{$instructorCourse->title}}" class="avatar-img rounded">
            </a>
            <div class="flex">
              <a class="card-title mb-4pt" href="">{{$instructorCourse->title}}</a>
              <div class="d-flex align-items-center">
                <div class="rating mr-8pt">
                  @for ($i = 1; $i <= 5; $i++) @if ($i <=$instructorCoursesRate[$instructorCourse->id])
                    <div class="rating__item"><i class="material-icons">star</i></div>
                    @else
                    <div class="rating__item"><i class="material-icons">star_border</i></div>
                    @endif
                    @endfor
                </div>
                <small class="text-muted">{{$instructorCoursesRate[$instructorCourse->id]}}/5</small>
              </div>
            </div>
          </div>
        </div>
        @endforeach
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
            <a href="{{ route('instructor.profile', ['instructorId' => $instructor->user_id]) }}" class="btn btn-outline-primary mb-16pt mb-sm-0 mr-sm-16pt">
              @if(session('locale', config('app.locale')) == 'en')
              View Profile
              @endif
              @if(session('locale', config('app.locale')) == 'ar')
              عرض الصفحة الشخصية
              @endif
              @if(session('locale', config('app.locale')) == 'de')
              Profil anzeigen
              @endif</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@if ($isAuthInroll)
@if ($ratingOnce)
<div class="page-section border-bottom-2">
  <div class="container">
    <div class="page-headline text-center">
      <h2>
        @if(session('locale', config('app.locale')) == 'en')
        Your Feedback Matters
        @endif
        @if(session('locale', config('app.locale')) == 'ar')
        ملاحظاتك مهمة
        @endif
        @if(session('locale', config('app.locale')) == 'de')
        Ihr Feedback ist wichtig
        @endif
      </h2>
      <p class="lead text-70 measure-lead mx-auto">
        @if(session('locale', config('app.locale')) == 'en')
        Help us enhance your experience by providing your feedback. Rate the course and share your thoughts with us.
        @endif
        @if(session('locale', config('app.locale')) == 'ar')
        ساعدنا في تعزيز تجربتك من خلال تقديم ملاحظاتك. قيم الدورة وشاركنا أفكارك.
        @endif
        @if(session('locale', config('app.locale')) == 'de')
        Helfen Sie uns, Ihr Erlebnis zu verbessern, indem Sie uns Ihr Feedback geben. Bewerten Sie den Kurs und teilen Sie uns Ihre Gedanken mit.
        @endif
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
        <label>
          @if(session('locale', config('app.locale')) == 'en')
          Your Comment:
          @endif
          @if(session('locale', config('app.locale')) == 'ar')
          تعليقك:
          @endif
          @if(session('locale', config('app.locale')) == 'de')
          Dein Kommentar:
          @endif
        </label>
        <textarea id="commentInput" style="height: 100px;"></textarea>
      </div>
      <div class="text-center"> <!-- Center-align the button -->
        <button class="ui button" type="submit" style="background-color: #fea11f; color: white;">
          @if(session('locale', config('app.locale')) == 'en')
          Submit
          @endif
          @if(session('locale', config('app.locale')) == 'ar')
          ارسال
          @endif
          @if(session('locale', config('app.locale')) == 'de')
          Einreichen
          @endif
        </button>
      </div>
    </form>
    <div class="text-center" id="thankYouSection" style="display: none;">
      <p class="lead text-100 measure-lead mx-auto" style="font-size: 24px;">
        @if(session('locale', config('app.locale')) == 'en')
        Thank you for your feedback!
        @endif
        @if(session('locale', config('app.locale')) == 'ar')
        !شكرا لك على ملاحظاتك
        @endif
        @if(session('locale', config('app.locale')) == 'de')
        Danke für Ihre Rückmeldung!
        @endif
      </p>
    </div>
  </div>
</div>
@endif
@endif

<div class="page-section bg-white border-bottom-2">

  <div class="container page__container">
    <div class="page-separator">
      <div class="page-separator__text">
        @if(session('locale', config('app.locale')) == 'en')
        Student Feedback
        @endif
        @if(session('locale', config('app.locale')) == 'ar')
        ردود فعل الطلاب
        @endif
        @if(session('locale', config('app.locale')) == 'de')
        Feedback der Studierenden
        @endif
      </div>
    </div>
    <div class="row mb-32pt">
      <div class="col-md-3 mb-32pt mb-md-0">
        <div class="display-1">{{number_format($courseRate, 1)}}</div>
        <div class="rating rating-24">
          @for ($i = 1; $i <= 5; $i++) @if ($i <=$courseRate) <div class="rating__item"><i class="material-icons">star</i></div>
        @else
        <div class="rating__item"><i class="material-icons">star_border</i></div>
        @endif
        @endfor
      </div>
      <p class="text-muted mb-0">{{$ratingCount}}
        @if(session('locale', config('app.locale')) == 'en')
        ratings
        @endif
        @if(session('locale', config('app.locale')) == 'ar')
        التقييمات
        @endif
        @if(session('locale', config('app.locale')) == 'de')
        Bewertungen
        @endif
      </p>
    </div>
    <div class="col-md-9">
      <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="{{number_format($rating5,1)}}%" data-placement="top">
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
      <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="{{number_format($rating3,1)}}%" data-placement="top">
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
      <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="{{number_format($rating3,1)}}%" data-placement="top">
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
      <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="{{number_format($rating2,1)}}%" data-placement="top">
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
      <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="{{number_format($rating1,1)}}%" data-placement="top">
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
        <a href="#student-profile" class="avatar avatar-sm mr-12pt">
          <!-- <img src="LB" alt="avatar" class="avatar-img rounded-circle"> -->
          <span class="avatar-title rounded-circle">user</span>
        </a>
        <div class="flex">
          <p class="small text-muted m-0">{{Carbon\Carbon::parse($oneRating->created_at)->format('Y-m-d')}}</p>
          <a href="#" class="card-title">{{$oneRating->user_name}}</a>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="rating rating-24">
        @for ($i = 1; $i <= 5; $i++) @if ($i <=$oneRating->rate)
          <div class="rating__item"><i class="material-icons">star</i></div>
          @else
          <div class="rating__item"><i class="material-icons">star_border</i></div>
          @endif
          @endfor
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
      <h4>
        @if(session('locale', config('app.locale')) == 'en')
        Top Courses
        @endif
        @if(session('locale', config('app.locale')) == 'ar')
        أعلى الدورات
        @endif
        @if(session('locale', config('app.locale')) == 'de')
        Top-Kurse
        @endif
      </h4>
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

              <a href="#" class="js-image" data-position="">
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
                      <a class="card-title" href="#">Learn Angular fundamentals</a>
                      <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                    </div>
                    <a href="#" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                  <a href="#" class="btn btn-primary">Watch trailer</a>
                </div>
              </div>

            </div>

          </div>

          <div class="col-12 col-sm-6 col-md-4 col-xl-3">

            <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal " data-partial-height="44" data-toggle="popover" data-trigger="click">

              <a href="#" class="js-image" data-position="">
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
                      <a class="card-title" href="#">Build an iOS Application in Swift</a>
                      <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                    </div>
                    <a href="#" data-toggle="tooltip" data-title="Remove Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite</a>
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
                  <a href="#" class="btn btn-primary">Watch trailer</a>
                </div>
              </div>

            </div>

          </div>

          <div class="col-12 col-sm-6 col-md-4 col-xl-3">

            <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal " data-partial-height="44" data-toggle="popover" data-trigger="click">

              <a href="#" class="js-image" data-position="">
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
                      <a class="card-title" href="#">Build a WordPress Website</a>
                      <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                    </div>
                    <a href="#" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                  <a href="#" class="btn btn-primary">Watch trailer</a>
                </div>
              </div>

            </div>

          </div>

          <div class="col-12 col-sm-6 col-md-4 col-xl-3">

            <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal " data-partial-height="44" data-toggle="popover" data-trigger="click">

              <a href="#" class="js-image" data-position="left">
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
                      <a class="card-title" href="#">Become a React Native Developer</a>
                      <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                    </div>
                    <a href="#" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                  <a href="#" class="btn btn-primary">Watch trailer</a>
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

  $(document).ready(function() {
    $.each($('#rating > i.icon'), function(index, item) {
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

    $('#rating > i.icon').on('click', function() {
      selectedRating = $(this).data('value');
      console.log(selectedRating);
    });

    $('#commentForm').on('submit', function(e) {
      e.preventDefault();

      const comment = $('#commentInput').val();
      console.log(comment);
      console.log(selectedRating);

      $.ajax({
        type: 'POST',
        url: '/student/courses/rateCourse/' + {
          {
            $course - > id
          }
        },
        data: {
          rate: selectedRating,
          user_review: comment,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          console.log("success");
          $('#ratingSection').hide();
          $('#commentForm').hide();
          $('#thankYouSection').show();
        },
        error: function(error) {
          console.error(error);
        }
      });
    });
  });
</script>
</div>
@endsection