@extends('datasource::management.layout.master')

@section('content')

<div class="page-wrapper">
  <div class="page-content">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update {{$table_name}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href=#>Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('admin.'.$route_name.'.index')}}"> {{$table_name}}</a></li>

            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <form class="form-course2" action="{{ route('admin.courseContent.update', $item->id) }}" id="form-about" method="POST" enctype="multipart/form-data">
              @csrf

              @method('PUT')
              <input type="hidden" name="boxArr" id="boxArr">

              <div class="card-body">
                <div class="row">
                  @foreach(localeSupported() as $locale)
                  <div class="col-4">
                    <div class="form-group">
                      <label for="title">Title {{ ucwords($locale) }}</label>
                      <input type="text" class="form-control" name="title-{{ $locale }}" value="{{ old('title-'.$locale, $item->translateOrDefault($locale)->title) }}" placeholder="Enter Title {{ ucwords($locale) }}">
                    </div>
                  </div>
                  @endforeach
                </div>



                <div class="row">
                  @foreach(localeSupported() as $locale)
                  <div class="col-4">
                    <div class="form-group">
                      <label for="slug">Slug {{ ucwords($locale) }} </label>
                      <input type="text" class="form-control" name="slug-{{ $locale }}" value="{{ old('slug-'.$locale, $item->translateOrDefault($locale)->slug) }}" placeholder="Enter Slug {{ ucwords($locale) }}">
                    </div>
                  </div>
                  @endforeach
                </div>



                <div class="row">
                  @foreach(localeSupported() as $locale)
                  <div class="col-4">
                    <div class="form-group">
                      <label for="desc">Description {{ ucwords($locale) }}</label>
                      <input class="form-control" name="desc-{{ $locale }}" value="{{ old('desc-'.$locale, $item->translateOrDefault($locale)->desc) }}" placeholder="Enter Description {{ ucwords($locale) }}">
                    </div>
                  </div>
                  @endforeach
                </div>



                <div class="row">
                  @foreach(localeSupported() as $locale)
                  <div class="col-4">
                    <div class="form-group">
                      <label for="about">About {{ ucwords($locale) }} </label>
                      <textarea type="text" class="form-control" name="about-{{ $locale }}" placeholder="Enter About {{ ucwords($locale) }}">{{ old('about-'.$locale, $item->translateOrDefault($locale)->about) }}</textarea>
                    </div>
                  </div>
                  @endforeach
                </div>



                <div class="row">
                  @foreach(localeSupported() as $locale)
                  <div class="col-4">
                    <div class="form-group">
                      <label for="benefit">Benefit {{ ucwords($locale) }} </label>
                      <textarea type="text" class="form-control" name="benefit-{{ $locale }}" placeholder="Enter Benefit {{ ucwords($locale) }}">{{ old('benefit-'.$locale, $item->translateOrDefault($locale)->benefit) }}</textarea>
                    </div>
                  </div>
                  @endforeach
                </div>

                @php
                $options = [
                'en' => ['Beginner', 'Intermediate', 'Expert'],
                'ar' => ['مبتدئ', 'متوسط', 'خبير'],
                'de' => ['Anfänger', 'Mittelstufe', 'Experte'],
                ];
                @endphp

                <div class="row">
                  @foreach(localeSupported() as $locale)
                  <div class="col-4">
                    <div class="form-group">
                      <label for="level">Level {{ ucwords($locale) }} </label>
                      <select class="form-select" name="level-{{ $locale }}">
                        @foreach ($options[$locale] as $option)
                        <option value="{{ $option }}" {{ old('level-' . $locale, $item->translateOrDefault($locale)->level) == $option ? 'selected' : '' }}>
                          {{ $option }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  @endforeach
                </div>



                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                      <label for="price">Price</label>
                      <input type="number" class="form-control" step="0.001" name="price" value="{{ old('price', $item->price) }}" placeholder="Enter Price">
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="payment_type">Payment Type</label>
                      <select class="form-control" name="payment_type" id="payment_type">
                        <option value="once" {{ old('payment_type', $item->payment_type) == 'once' ? 'selected' : '' }}>Once</option>
                        <option value="monthly" {{ old('payment_type', $item->payment_type) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                      </select>
                    </div>
                  </div>
                  <!-- Category -->
                  <div class="col-4">
                    <div class="form-group">
                      <label for="taxonomy">Category</label>
                      <select class="form-select" name="taxonomy_id">
                        @foreach ($taxonomies as $taxonomy)
                        <option value="{{ $taxonomy->id }}" {{ old('taxonomy_id', $item->taxonomy_id) == $taxonomy->id ? 'selected' : '' }}>
                          {{ $taxonomy->title }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <!-- Instructor -->
                  <div class="col-4">
                    <div class="form-group">
                      <label for="instructor">Instructor</label>
                      <select class="form-select" name="instructor_id">
                        @foreach ($instructors as $instructor)
                        <option value="{{ $instructor->user_id }}" {{ ($instructor->user_id == old('instructor_id', $item->instructor_id)) ? 'selected' : '' }}>
                          {{ $instructor->first_name.' '.$instructor->last_name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>



                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                      <label for="photo">Photo</label>

                      <input type="file" class="form-control-file" name="photo" value="{{$item->photo}}">

                    </div>
                    @if($item->photo)
                    <div>
                      <img src="{{ $item->photo }}" alt="Current Photo" style="max-width: 100px;">
                    </div>
                    @endif
                  </div>

                </div>

                <hr />
                <div class="row">

                  <label>Steps Course Content</label>
                </div>


                @include('datasource::management.courseContent.partials.stepsUpdate')

                <hr />

                <div class="row">
                  <button class="btn btn-primary col-md-2 m-2 mb-5" id="submitForm">SAVE</button>
                </div>


            </form>
            </form>
          </div>
        </div>
      </div>
    </section>


  </div>
</div>
@endsection