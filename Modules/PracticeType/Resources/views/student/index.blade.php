@extends("student.layouts.dashboard")
@section("content")

<div class="position-relative carousel-card">
        <div class="js-mdk-carousel row" id="carousel-achievements">
          <div class="mdk-carousel__content">
            @foreach ($practices as $practice )
            <div class="col-12 col-sm-6">
              <a class="card border-0 mb-0 m-2 " href="{{ route('student.practice.levels', ['id' => $practice->id]) }}">
                <img src="{{$practice->photo}}" alt="Flinto" class="card-img" style="max-height: 100%; width: initial;">
                <div class="fullbleed bg-secondary" style="opacity: .15;"></div>
                <span class="card-body d-flex flex-column align-items-center justify-content-center fullbleed">
                  <span class="row flex-nowrap" style="margin-top: auto;">
                    <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                      <span class="h5 text-white text-uppercase font-weight-normal m-0 d-block"></span>
                      <span class="text-white-60 d-block mb-24pt">{{$practice->created_at}}</span>
                    </span>
                    <span class="col d-flex flex-column">
                      <span class="text-right flex mb-16pt">
                        <!-- <img src="{{asset('images/paths/new_numbers_sum.png')}}" width="128" alt="Flinto" class="rounded"> -->
                      </span>
                    </span>
                  </span>
                  <span class="row flex-nowrap">
                    <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                      <img src="{{asset('/images/illustration/achievement/128/white.png')}}" width="64" alt="achievement">
                    </span>
                    <span class="col d-flex flex-column">
                      <span>
                        <span class="card-title text-white mb-4pt d-block" style="color:#152c46!important;">
                        {{$practice->title}} 
                        @if(session('locale', config('app.locale')) == 'en')
                        Practice
                        @endif
                        @if(session('locale', config('app.locale')) == 'ar')
                        تمرين
                        @endif
                        @if(session('locale', config('app.locale')) == 'de')
                        Üben
                        @endif
                        </span>
                        <span class="text-white-60"  style="color:#152c46!important;">{{$practice->about}}</span>
                      </span>
                    </span>
                  </span>
                </span>
              </a>

            </div>
            @endforeach

          
          </div>
        </div>
      </div>

@endsection