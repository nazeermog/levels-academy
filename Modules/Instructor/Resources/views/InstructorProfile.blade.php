@extends("student.layouts.dashboard")
@section('content')

<style>
  .instructor-avatar {
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }
</style>
<div class="page-section bg-primary">
  <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-md-left">
    <img src="{{ asset($instructor->avatar) }}" width="104" class="mr-md-32pt mb-32pt mb-md-0 instructor-avatar" alt="instructor">
    <div class="flex mb-32pt mb-md-0">
      <h2 class="text-white mb-0">{{$instructor->first_name.' '.$instructor->last_name}}</h2>
      <p class="lead text-white-50 d-flex align-items-center">
        @if(session('locale', config('app.locale')) == 'en')
        Instructor
        @endif
        @if(session('locale', config('app.locale')) == 'ar')
        مدرس
        @endif
        @if(session('locale', config('app.locale')) == 'de')
        Lehrer
        @endif
        <span class="ml-16pt d-flex align-items-center">
      </p>
    </div>
    <img src="{{asset('images\illustration\teacher\128\white.svg')}}" width="104" class="mr-md-32pt mb-32pt mb-md-0" alt="instructor">
  </div>
</div>

<div class="page-section bg-white border-bottom-2">
  <div class="container page__container">
    <div class="row">
      <div class="col-md-6">
        <h4>
          @if(session('locale', config('app.locale')) == 'en')
          About me
          @endif
          @if(session('locale', config('app.locale')) == 'ar')
          عَنِّي      
          @endif
          @if(session('locale', config('app.locale')) == 'de')
          Über mich
          @endif
        </h4>
        <p>{{$instructor->about}}</p>
      </div>
      <div class="col-md-6">
        <h4>
          @if(session('locale', config('app.locale')) == 'en')
          Specialization
          @endif
          @if(session('locale', config('app.locale')) == 'ar')
          تخصص
          @endif
          @if(session('locale', config('app.locale')) == 'de')
          Spezialisierung
          @endif
        </h4>
        <p>{{$instructor->spec}}</p>
        <div class="d-flex align-items-center">
          <a href="#" class="text-accent fab fa-facebook-square font-size-24pt mr-8pt"></a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container page__container page-section">
  <div class="page-headline text-center">
    <h2>
      @if(session('locale', config('app.locale')) == 'en')
      Level-up Your Career
      @endif
      @if(session('locale', config('app.locale')) == 'ar')
      ارفع مستوى حياتك المهنية
      @endif
      @if(session('locale', config('app.locale')) == 'de')
      Steigern Sie Ihre Karriere
      @endif
    </h2>
    <p class="lead text-70 col-lg-8 mx-auto">
      @if(session('locale', config('app.locale')) == 'en')
      Courses by
      @endif
      @if(session('locale', config('app.locale')) == 'ar')
      الدورات بواسطة
      @endif
      @if(session('locale', config('app.locale')) == 'de')
      Kurse von
      @endif
      {{$instructor->first_name.' '.$instructor->last_name}}
    </p>
  </div>
  <div class="row card-group-row mb-8pt">
    @foreach ($instructorCourses as $instructorCourse)
    <div class="col-sm-6 card-group-row__col">
      <div class="card card-sm card-group-row__card">
        <div class="card-body d-flex align-items-center">
          <a href="{{ route('student.courses.show', ['CourseId' => $instructorCourse->id]) }}" class="avatar avatar-4by3 overlay overlay--primary mr-12pt">
            <img src="{{$instructorCourse->photo}}" alt="{{$instructorCourse->title}}" class="avatar-img rounded">
            <span class="overlay__content"></span>
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
    </div>
    @endforeach
  </div>
</div>
@endsection