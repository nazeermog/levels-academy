@extends('instructor.layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Edit Course — {{ $item->title }}</h3>
      <a href="{{ route('instructor.mycourses.index') }}" class="btn btn-sm btn-secondary">Back</a>
    </div>
    <div class="card-body">
      @if($errors->any())
      <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
      @endif

      <form action="{{ route('instructor.mycourses.update', $item->id) }}" id="form-instructor-course" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="boxArr" id="boxArr">
        {{-- Course stays owned by this instructor; not editable here. --}}
        <input type="hidden" name="instructor_id" value="{{ $item->instructor_id }}">

        <div class="row">
          @foreach(localeSupported() as $locale)
          <div class="col-md-4">
            <div class="form-group">
              <label>Title {{ ucwords($locale) }}</label>
              <input type="text" class="form-control" name="title-{{ $locale }}" value="{{ old('title-'.$locale, $item->translateOrDefault($locale)->title) }}">
            </div>
          </div>
          @endforeach
        </div>

        <div class="row">
          @foreach(localeSupported() as $locale)
          <div class="col-md-4">
            <div class="form-group">
              <label>Slug {{ ucwords($locale) }}</label>
              <input type="text" class="form-control" name="slug-{{ $locale }}" value="{{ old('slug-'.$locale, $item->translateOrDefault($locale)->slug) }}">
            </div>
          </div>
          @endforeach
        </div>

        <div class="row">
          @foreach(localeSupported() as $locale)
          <div class="col-md-4">
            <div class="form-group">
              <label>Description {{ ucwords($locale) }}</label>
              <input class="form-control" name="desc-{{ $locale }}" value="{{ old('desc-'.$locale, $item->translateOrDefault($locale)->desc) }}">
            </div>
          </div>
          @endforeach
        </div>

        <div class="row">
          @foreach(localeSupported() as $locale)
          <div class="col-md-4">
            <div class="form-group">
              <label>About {{ ucwords($locale) }}</label>
              <textarea class="form-control" name="about-{{ $locale }}">{{ old('about-'.$locale, $item->translateOrDefault($locale)->about) }}</textarea>
            </div>
          </div>
          @endforeach
        </div>

        <div class="row">
          @foreach(localeSupported() as $locale)
          <div class="col-md-4">
            <div class="form-group">
              <label>Benefit {{ ucwords($locale) }}</label>
              <textarea class="form-control" name="benefit-{{ $locale }}">{{ old('benefit-'.$locale, $item->translateOrDefault($locale)->benefit) }}</textarea>
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
          <div class="col-md-4">
            <div class="form-group">
              <label>Level {{ ucwords($locale) }}</label>
              <select class="form-control" name="level-{{ $locale }}">
                @foreach (($options[$locale] ?? $options['en']) as $option)
                <option value="{{ $option }}" {{ old('level-'.$locale, $item->translateOrDefault($locale)->level) == $option ? 'selected' : '' }}>{{ $option }}</option>
                @endforeach
              </select>
            </div>
          </div>
          @endforeach
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Price</label>
              <input type="number" step="0.001" class="form-control" name="price" value="{{ old('price', $item->price) }}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Payment Type</label>
              <select class="form-control" name="payment_type">
                <option value="once" {{ old('payment_type', $item->payment_type) == 'once' ? 'selected' : '' }}>Once</option>
                <option value="monthly" {{ old('payment_type', $item->payment_type) == 'monthly' ? 'selected' : '' }}>Monthly</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Category</label>
              <select class="form-control" name="taxonomy_id">
                @foreach ($taxonomies as $taxonomy)
                <option value="{{ $taxonomy->id }}" {{ old('taxonomy_id', $item->taxonomy_id) == $taxonomy->id ? 'selected' : '' }}>{{ $taxonomy->title }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Photo</label>
              <input type="file" class="form-control-file" name="photo">
              @if($item->photo)
              <div class="mt-2"><img src="{{ asset($item->photo) }}" alt="Course photo" style="max-width:100px;"></div>
              @endif
            </div>
          </div>
        </div>

        <hr>
        <label class="font-weight-bold">Steps</label>

        @include('datasource::management.courseContent.partials.stepsUpdate')

        <hr>
        <button class="btn btn-primary" id="submitForm">Save</button>
      </form>
    </div>
  </div>
</div>
@endsection
