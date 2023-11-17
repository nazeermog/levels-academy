@extends("student.layouts.dashboard")
@section("content")

<div class="position-relative carousel-card">
  <div class="js-mdk-carousel row" id="carousel-achievements">
    <div class="mdk-carousel__content ">
      @foreach ($practiceDetail as $detail)
      <div class="col-12 col-sm-{{ count($practiceDetail) > 1 ? '6' : '12' }}">
        <a class="card border-0 mb-0 m-2" href="{{ route('student.practice.show', ['id' => $detail->id, 'type' => $practice->blade_name]) }}">
          <img src="{{ $practice->photo }}" alt="Flinto" class="card-img" style="max-height: 100%; width: initial;">
          <!-- <div class="fullbleed bg-primary" style="opacity: .5;"></div> -->
          <span class="card-body d-flex flex-column align-items-center justify-content-center fullbleed ">
            <span class="row flex-nowrap" style="margin-bottom: 80px;">
              <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                <span class="h5 text-black text-uppercase font-weight-normal m-0 d-block">
                  @if(session('locale', config('app.locale')) == 'en')
                  Level : 
                  @endif
                  @if(session('locale', config('app.locale')) == 'ar')
                  مستوى :
                  @endif
                  @if(session('locale', config('app.locale')) == 'de')
                  Ebene :
                  @endif
                  {{ $detail->practiceLevel->title }}</span>
                <span class="text-black-60 d-block mb-24pt">{{ $detail->created_at }}</span>
              </span>
              <span class="col d-flex flex-column">
                <span class="text-right flex mb-16pt">
                  <!-- <img src="{{ $practice->photo }}" width="128" alt="Flinto" class="rounded"> -->
                </span>
              </span>
            </span>
            <span class="row flex-nowrap">
              <span class="col d-flex flex-column">
                <span>
                  <!-- <span class="card-title text-black mb-4pt d-block">
                  @if(session('locale', config('app.locale')) == 'en')
                    Practice
                    @endif
                    @if(session('locale', config('app.locale')) == 'ar')
                    تمرين
                    @endif
                    @if(session('locale', config('app.locale')) == 'de')
                    Üben
                    @endif
                  {{ $detail->level }} {{ $practice->title }}
                  </span> -->
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