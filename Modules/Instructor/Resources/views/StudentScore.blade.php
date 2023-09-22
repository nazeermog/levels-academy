@extends('instructor.layouts.dashboard')
@section('title')
{{$table_name}}
@endsection
@push('css')
<style>
  .alert-danger-edited {
    color: #000;
    background-color: #dc35457a;
    border-color: #dc35457a;
  }

  .alert-success-edited {
    color: #000;
    background-color: #28a7457a;
    border-color: #28a7457a;
  }
</style>
@endpush
@section('content')
<div class="container py-5">
  <div class="card border-top border-0 border-4 border-primary table-responsive">
    <div class="card-header">
      <h3 class="card-title float-left">
        @if(session('locale', config('app.locale')) == 'en')
        List of Student Score
        @endif
        @if(session('locale', config('app.locale')) == 'ar')
        قائمة درجات الطلاب
        @endif
        @if(session('locale', config('app.locale')) == 'de')
        Liste der Schülerergebnisse
        @endif
      </h3>
    </div>
    <div class="card-body ">
      @if (isset($list)&&$list->count() > 0)
      <div class="row form-group">
        <div class="col-md-6">
          <label for="">Text Search</label>
          <input type="text" class="form-control" placeholder="search">
        </div>
        <div class="col-md-6">
          <label for="">Student Name</label>
          <select class="form-control">
            <option>Student Name</option>
          </select>
        </div>

      </div>
      <div class="row form-group">
        <div class="col-md-6">
          <label for="">From </label>
          <input type="date" class="form-control" placeholder="search">
        </div>
        <div class="col-md-6">
          <label for="">To </label>
          <input type="date" class="form-control" placeholder="search">
        </div>

      </div>
      <button class="btn btn-primary form-group">Search</button>
      <div class="row">
        <div class="col-md-3 m-1">
          <select class="form-control" id="course-select">

            <option value="">
              @if(session('locale', config('app.locale')) == 'en')
              Select a course
              @endif
              @if(session('locale', config('app.locale')) == 'ar')
              اختر دورة
              @endif
              @if(session('locale', config('app.locale')) == 'de')
              Wählen Sie einen Kurs aus
              @endif
            </option>
            @foreach ($courses as $course)
            <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3 m-1">
          <select class="form-control" id="semester-select">
            <option value="">
              @if(session('locale', config('app.locale')) == 'en')
              Select an semester
              @endif
              @if(session('locale', config('app.locale')) == 'ar')
              اختر فصل دراسي
              @endif
              @if(session('locale', config('app.locale')) == 'de')
              Wählen Sie ein Semester aus
              @endif
            </option>
            @foreach ($semesters as $semester)
            <option value="{{ $semester->id }}">{{ $semester->title }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3 m-1">
          <select class="form-control" id="practice-select">
            <option value="">
              @if(session('locale', config('app.locale')) == 'en')
              Select an practice
              @endif
              @if(session('locale', config('app.locale')) == 'ar')
              اختر تمرين
              @endif
              @if(session('locale', config('app.locale')) == 'de')
              Wählen Sie eine Praxis aus
              @endif
            </option>
            @foreach ($practices as $practice)
            <option value="{{ $practice->id }}">{{ $practice->title }}</option>
            @endforeach
          </select>
        </div>
        <button id="fetch-student-scores-button-filter" class="btn btn-primary form-group m-2">
          @if(session('locale', config('app.locale')) == 'en')
          Fetch Student Scores
          @endif
          @if(session('locale', config('app.locale')) == 'ar')
          جلب درجات الطلاب
          @endif
          @if(session('locale', config('app.locale')) == 'de')
          Schülernoten abrufen
          @endif
        </button>
      </div>
      <div class="table-responsive">
        <table class="table table-hover table-rank">
          <thead>
            <tr>
              <th>#</th>
              @if(session('locale', config('app.locale')) == 'en')
              <th>photo</th>
              <th>Student</th>
              <th>Course</th>
              <th>Practice</th>
              <th>Semester</th>
              <th>coins</th>
              @endif
              @if(session('locale', config('app.locale')) == 'ar')
              <th>الصورة</th>
              <th>الطالب</th>
              <th>الدورة التدريبية</th>
              <th>التدريب</th>
              <th>الفصل الدراسي</th>
              <th>عملات معدنية</th>
              @endif
              @if(session('locale', config('app.locale')) == 'de')
              <th>Foto</th>
              <th>Student</th>
              <th>Kurs</th>
              <th>Üben</th>
              <th>Semester</th>
              <th>Münzen</th>
              @endif
            </tr>
          </thead>
          <tbody id="student-score-table-body">
            @foreach($list as $item)
            <tr>
              <td class="student-rank d-flex align-items-center ">{{$loop->iteration}}

                @if($loop->iteration <= 3) <i class="material-icons icon-40pt ml-2">stars</i>
                  @endif

              </td>
              <td><img src="{{asset( $item->student->avatar)}}" alt="student_avatar" style="height: 60px; width: 60px; border-radius: 50%; object-fit: cover;"></td>
              <td>
                {{$item->student->first_name .' '.$item->student->last_name}}
              </td>
              <td>
                ALL
              </td>
              <td>
                ALL
              </td>
              <td>
                ALL
              </td>
              <td>
                {{$totalCoins[$item->student->user_id]}}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
      @else
      <h2>
        @if(session('locale', config('app.locale')) == 'en')
        There is no Students Score Yet
        @endif
        @if(session('locale', config('app.locale')) == 'ar')
        لا توجد نقاط للطلاب حتى الآن
        @endif
        @if(session('locale', config('app.locale')) == 'de')
        Es gibt noch keine Schülerbewertung
        @endif
      </h2>
      @endif

    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#fetch-student-scores-button-filter').on('click', function() {
      var courseId = $('#course-select').val();
      var semesterId = $('#semester-select').val();
      var practiceId = $('#practice-select').val();
      $.ajax({
        url: "{{ route('studentscore.filter') }}",
        type: "GET",
        data: {
          courseId: courseId,
          semesterId: semesterId,
          practiceId: practiceId,
        },
        success: function(response) {
          console.log(response.list);
          var tableBody = $('#student-score-table-body');
          tableBody.empty();
          response.list.forEach(function(item, index) {
            var newRow = '<tr>' +
              '<td class="student-rank d-flex align-items-center ">' + (index + 1);
            if (index < 3) {
              newRow += '<i class="material-icons icon-40pt ml-2">stars</i>';
            }
            newRow += '</td>' +
              '<td><img src="' + item.student_avatar + '" alt="student_avatar" style="height: 60px; width: 60px; border-radius: 50%; object-fit: cover;"></td>' +
              '<td>' + item.student_name + '</td>' +
              '<td>' + (item.course_title ?? 'ALL') + '</td>' +
              '<td>' + (item.practice_title ?? 'ALL') + '</td>' +
              '<td>' + (item.semester_title ?? 'ALL') + '</td>' +
              '<td>' + item.total_coin + '</td>' +
              '</tr>';
            tableBody.append(newRow);
          });
        },

        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });
  });
</script>


@endsection