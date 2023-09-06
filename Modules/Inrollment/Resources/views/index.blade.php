@extends("student.layouts.dashboard")

@section('content')
<div class="container page__container">
  <div class="page-section">
    @foreach ($taxonomies as $taxonomy)
    @if ($taxonomy->courses->isNotEmpty())
    @foreach ($taxonomy->courses as $course)
    @if ($course->inrollments->count() > 0)
    <div class="page-separator">
      <div class="page-separator__text">{{$taxonomy->title}}</div>
    </div>

    <div class="row">
      @foreach ($courses as $course)
      @if ($course->course->taxonomy_id === $taxonomy->id)

      <div class="col-lg-3 mb-24pt">
        <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card">

          <!-- Course Image -->
          <a href="{{ route('student.courses.show', ['CourseId' => $course->course->id]) }}" class="card-img-top js-image" data-position="" data-height="140">
            <img src="{{ asset($course->course->photo) }}" alt="course"></a>
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
                <a href="{{ route('student.courses.show', ['CourseId' => $course->course->id]) }}" class="card-title">{{$course->course->title}}</a>
                <small class="text-50 font-weight-bold mb-4pt">{{ $instructor[$course->course->id]->first_name.' '.$instructor[$course->course->id]->last_name}}</small>
              </div>
              <a href="student-take-course.html" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
            </div>
            <div class="d-flex">


              <div class="rating rating-24">
                @for ($i = 1; $i <= 5; $i++) @if ($i <=$courseRate[$course->course->id])
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
                <p class="flex text-50 lh-1 mb-0"><small>{{ $totalLessonTime[$course->course->id] }}m</small></p>
              </div>
              <div class="col-auto d-flex align-items-center">
                <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                <p class="flex text-50 lh-1 mb-0"><small>{{$courseLessons[$course->course->id]}} lessons</small></p>
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
    @endif
    @endforeach
  </div>
</div>

@endsection