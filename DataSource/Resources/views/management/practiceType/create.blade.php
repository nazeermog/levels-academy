@extends('datasource::management.layout.master')

@section('content')
<div class="container py-5">
  <div class="row">
    <label>Add Practice Level</label>
  </div>
  <hr />
  <form action="{{route('admin.practicesType.store')}}" method="POST">
    @csrf
    <div class="row">
      @foreach(localeSupported() as $locale)
      <div class="col-md-4 ">
        <label for="">Title {{ucwords($locale)}}</label>
        <input class="form-control" name="title-{{$locale}}">
      </div>
      @endforeach
    </div>
    <hr />
    <div class="row">

      <div class="col-md-4 ">
        <label for="">Practice</label>
        <select class="form-control" name="practice_id">
          @foreach($practices as $practice)
          <option value="{{$practice->id}}">
            {{$practice->title}}
          </option>
          @endforeach
        </select>
      </div>


      <div class="col-md-4 ">
        <label for="">Levels</label>
        <select class="form-control" name="level_id">
                @foreach($practiceLevels as $level)
                    <option value="{{ $level->id }}">{{ $level->title }}</option>
                @endforeach
            </select>
      </div>

    </div>
    <hr />

    <div class="row">

      <div class="col-md-6 ">
        <label for="">seconds speed (for number_sum & math game(1)) </label>
        <input class="form-control" name="seconds_speed">
      </div>
      <div class="col-md-6 ">
        <label for="">card number (for number_sum)</label>
        <input class="form-control" name="card_number">
      </div>


    </div>
    <div class="row">
      <div class="col-md-6 ">
        <label for="">range number from </label>
        <input class="form-control" name="range_number_from">
      </div>
      <div class="col-md-6 ">
        <label for="">range number to </label>
        <input class="form-control" name="range_number_to">
      </div>
    </div>
    <div class="row">
    <div class="col-md-6 ">
        <label for="">Column Count (for abacus)</label>
        <input class="form-control" name="col_count">
      </div>
      <div class="col-md-6 ">
        <label for="">numbers To Sum (for abacus & math game)</label>
        <input class="form-control" name="numbers_to_sum">
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 ">
        <label for="">Timer (for math games)</label>
        <input class="form-control" name="timer">
      </div>
      <div class="col-md-6 ">
        <label for="">Turns (for math games)</label>
        <input class="form-control" name="timer">
      </div>
    </div>
    <hr />
    <div class="row">
      <button class="btn btn-primary col-md-2 m-2" id="submitForm">SAVE</button>
    </div>
  </form>
</div>
@endsection