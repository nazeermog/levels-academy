@extends("student.layouts.dashboard")

@section('content')
<div class="container page__container">
  <div class="page-section">
    @foreach ($coursesByTaxonomy as $taxonomyData)
      <div class="page-separator">
        <div class="page-separator__text">{{ $taxonomyData['taxonomy']->title }}</div>
      </div>
      <div class="row">
        @foreach ($taxonomyData['courses'] as $course)
          <div class="col-lg-3 mb-24pt">
            <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card">
              <!-- Course Image -->
              <a href="{{ route('student.courses.show', ['CourseId' => $course->id]) }}" class="card-img-top js-image" data-position="" data-height="140">
                <img src="{{ asset($course->photo) }}" alt="course">
              </a>

              <div class="card-body flex">
                <div class="d-flex">
                  <div class="flex">
                    <a href="{{ route('student.courses.show', ['CourseId' => $course->id]) }}" class="card-title">{{ $course->title }}</a>
                    @if(isset($instructors[$course->id]))
                      <small class="text-50 font-weight-bold mb-4pt">{{ $instructors[$course->id]->first_name . ' ' . $instructors[$course->id]->last_name }}</small>
                    @else
                      <small class="text-50 font-weight-bold mb-4pt">Instructor not found</small>
                    @endif
                  </div>
                  <a href="#" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
                </div>
                <div class="d-flex">
                  <div class="rating rating-24">
                    @if(isset($courseRate[$course->id]))
                      @for ($i = 1; $i <= 5; $i++)
                        <div class="rating__item"><i class="material-icons">{{ $i <= $courseRate[$course->id] ? 'star' : 'star_border' }}</i></div>
                      @endfor
                    @else
                      @for ($i = 1; $i <= 5; $i++)
                        <div class="rating__item"><i class="material-icons">star_border</i></div>
                      @endfor
                    @endif
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="row justify-content-between">
                  <div class="col-auto d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                    <p class="flex text-50 lh-1 mb-0"><small>{{ \Carbon\Carbon::now()->addMinutes($totalLessonTime[$course->id] ?? 0)->diffForHumans(null, true, false, 2) }}</small></p>
                  </div>
                  <div class="col-auto d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                    <p class="flex text-50 lh-1 mb-0"><small>{{ $courseLessons[$course->id] ?? 0 }}
                      @if(session('locale', config('app.locale')) == 'en')
                        lessons
                      @elseif(session('locale', config('app.locale')) == 'ar')
                        دروس
                      @elseif(session('locale', config('app.locale')) == 'de')
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
        @endforeach
      </div>
    @endforeach
  </div>
</div>
@endsection
