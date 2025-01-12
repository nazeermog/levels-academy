@extends("guest::layouts.master")
@section("content")

<!-- Page Content -->

<div class="page-section bg-body border-bottom-2">
  <div class="container page__container">

    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start flex mb-16pt text-center text-md-left">
      <div class="avatar overlay overlay--primary mb-16pt mb-md-0 mr-md-16pt">
        <img src="{{asset($blog->photo)}}"
          class="avatar-img rounded"
          alt="lesson">
        <div class="overlay__content"></div>
      </div>
      <div class="flex">
        <h1 class="h2 measure-lead-max mb-16pt">{{$blog->title}}</h1>
        <div class="d-flex align-items-center">
          <a href="teacher-profile.html"
            class="avatar avatar-sm mr-12pt">
            <img src="{{ asset('images/people/50/guy-6.jpg') }}"
              width="40"
              alt="avatar"
              class="rounded-circle">
          </a>
          <div class="mr-16pt">
            <a href="teacher-profile.html"
              class="card-title">{{$blog->user->first_name.' '.$blog->user->last_name}}</a>
            <div class="d-flex align-items-center">
              <small class="text-50 mr-2">{{ $blog->created_at->diffForHumans() }}</small>
              <a href=""
                class="text-50"><small>Liked</small></a>
            </div>
          </div>
          <div>
            <a href=""
              class="text-50 d-flex align-items-center text-decoration-0"><i class="material-icons icon--left">favorite_border</i></a>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<div class="page-section border-bottom-2">
  <div class="container page__container">

    <div class="mb-24pt">
      <a href=""
        class="chip chip-outline-secondary">tag</a>
    </div>




    <h4>{{$blog->title}}</h4>

    <div class="d-flex flex-column flex-md-row mb-32pt">
      <div class="flex mb-16pt mb-md-0 mr-md-16pt">
        <p class="lead text-70 measure-paragraph-max">{{$blog->desc}}</p>
      </div>
      <div>
        <div class="rounded p-relative o-hidden overlay overlay--primary">
          <img class="img-fluid rounded" style="width:400px; height: 400px;"
            src="{{asset($blog->photo)}}"
            alt="image" width="100px">
          <div class="overlay__content"></div>
        </div>
      </div>
    </div>

    <div class="measure-lead-max">

      <div class="mb-8pt">
        <div class="page-separator">
          <div class="page-separator__text">Author</div>
        </div>

        <div class="media align-items-center mb-16pt">
          <span class="media-left mr-16pt">
            <img src="{{ asset('images/people/50/guy-6.jpg') }}"
              width="40"
              alt="avatar"
              class="rounded-circle">

          </span>
          <div class="media-body">
            <a class="card-title m-0"
              href="teacher-profile.html">{{$blog->user->first_name.' '.$blog->user->last_name}}</a>
            <p class="text-50 lh-1 mb-0">{{$blog->user->role}}</p>
          </div>
        </div>

        <a href="teacher-profile.html"
          class="btn btn-white mb-24pt">Follow</a>
      </div>



    </div>
  </div>

  <div class="page-section bg-white">
    <div class="container page__container">

      <div class="page-separator">
        <div class="page-separator__text">Feedback</div>
      </div>

      <div class="row">

        <div class="col-sm-6 col-md-4">

          <div class="card card-feedback card-body">
            <blockquote class="blockquote mb-0">
              <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
            </blockquote>
          </div>
          <div class="media ml-12pt">
            <div class="media-left mr-12pt">
              <a href="student-profile.html"
                class="avatar avatar-sm">
                <!-- <img src="public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
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

        <div class="col-sm-6 col-md-4">

          <div class="card card-feedback card-body">
            <blockquote class="blockquote mb-0">
              <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
            </blockquote>
          </div>
          <div class="media ml-12pt">
            <div class="media-left mr-12pt">
              <a href="student-profile.html"
                class="avatar avatar-sm">
                <!-- <img src="public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
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

        <div class="col-sm-6 col-md-4">

          <div class="card card-feedback card-body">
            <blockquote class="blockquote mb-0">
              <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
            </blockquote>
          </div>
          <div class="media ml-12pt">
            <div class="media-left mr-12pt">
              <a href="student-profile.html"
                class="avatar avatar-sm">
                <!-- <img src="public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
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



</div>
@endsection