@extends("student.layouts.dashboard")
@section("content")

    <div class="mdk-drawer-layout__content page-content">
        <div class="page-section">
            <div class="container page__container">

                <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-24pt"
                     style="white-space: nowrap;">
                    <small class="flex text-muted text-headings text-uppercase mr-3 mb-2 mb-sm-0">Displaying 4 out
                        of 10 paths</small>
                    <div class="w-auto ml-sm-auto table d-flex align-items-center mb-2 mb-sm-0">
                        <small class="text-muted text-headings text-uppercase mr-3 d-none d-sm-block">Sort
                            by</small>

                        <a href="#"
                           class="sort desc small text-headings text-uppercase">Newest</a>

                        <a href="#"
                           class="sort small text-headings text-uppercase ml-2">Popularity</a>

                    </div>

                    <a href="#"
                       data-target="#library-drawer"
                       data-toggle="sidebar"
                       class="btn btn-sm btn-white ml-sm-16pt">
                        <i class="material-icons icon--left">tune</i> Filters
                    </a>

                </div>

         

   @foreach ($taxonomies as $taxonomy)
    @php
        $coursePathsWithCourses = $coursePaths->where('taxonomy_id', $taxonomy->id)->filter(function ($coursePath) {
                                                return $coursePath->courses->isNotEmpty(); });
    @endphp

    @if ($coursePathsWithCourses->isNotEmpty())
        <div class="page-separator">
            <div class="page-separator__text">{{ $taxonomy->title }}</div>
        </div>
        @endif

    <div class="row mb-lg-8pt">
        @php
            $previousPathTitle = null;
        @endphp

        @foreach ($coursePaths as $coursePath)

        @if ($previousPathTitle !== $coursePath->title)
        @php
            $previousPathTitle = $coursePath->title;
        @endphp
        
        @if ($coursePath->taxonomy_id === $taxonomy->id)

                <div class="col-sm-4 card-group-row__col">

                    <div class="card card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center">
                                <div class="flex">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded mr-12pt z-0 o-hidden">
                                            <div class="overlay">
                                                <img src="{{ asset($coursePath->photo) }}" width="40" height="40"
                                                     alt="Angular" class="rounded">
                                                <span class="overlay__content overlay__content-transparent">
                                                    <span class="overlay__action d-flex flex-column text-center lh-1">
                                                        <small class="h6 small text-white mb-0"
                                                               style="font-weight: 500;">80%</small>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex">
                                            <div class="card-title">{{ $coursePath->title }}</div>
                                            <p class="flex text-50 lh-1 mb-0"><small>{{$coursesCounts[$coursePath->id] }} courses</small></p>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                  

                </div>
            @endif
            @endif
        @endforeach
    </div>
@endforeach

                <ul class="pagination justify-content-start pagination-xsm m-0">
                    <li class="page-item disabled">
                        <a class="page-link"
                           href="#"
                           aria-label="Previous">
                                            <span aria-hidden="true"
                                                  class="material-icons">chevron_left</span>
                            <span>Prev</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link"
                           href="#"
                           aria-label="Page 1">
                            <span>1</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link"
                           href="#"
                           aria-label="Page 2">
                            <span>2</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link"
                           href="#"
                           aria-label="Next">
                            <span>Next</span>
                            <span aria-hidden="true"
                                  class="material-icons">chevron_right</span>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
@endsection
