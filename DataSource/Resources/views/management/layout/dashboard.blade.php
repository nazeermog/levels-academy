@extends('datasource::management.layout.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">

            @php
                $tiles = [
                    ['count' => $practiceTypesCount, 'title' => '📝 Total Practice Types', 'route' => route('admin.practices.index'), 'bg' => 'bg-primary'],
                    ['count' => $practiceLevelsCount, 'title' => '🏅 Total Practice Levels', 'route' => route('admin.practicesType.index'), 'bg' => 'bg-secondary'],
                    ['count' => $resultPracticesCount, 'title' => '📈 Result Practice', 'route' => route('admin.resultPractices.index'), 'bg' => 'bg-success'],
                    ['count' => $coursesCount, 'title' => '📚 Total Courses', 'route' => route('admin.courseContent.index'), 'bg' => 'bg-info'],
                    ['count' => $categoriesCount, 'title' => '📂 Total Categories', 'route' => route('admin.taxonomies.index'), 'bg' => 'bg-warning text-dark'],
                    ['count' => $coursePathsCount, 'title' => '🔗 Course Paths', 'route' => route('admin.coursePath.index'), 'bg' => 'bg-dark'],
                    ['count' => $lessonsCount, 'title' => '📖 Total Lessons', 'route' => route('admin.lessons.index'), 'bg' => 'bg-danger'],
                    ['count' => $instructorsCount, 'title' => '👨‍🏫 Total Instructors', 'route' => route('admin.instructors.index'), 'bg' => 'bg-secondary'],
                    ['count' => $studentsCount, 'title' => '🎓 Total Students', 'route' => route('admin.students.index'), 'bg' => 'bg-primary'],
                    ['count' => $semestersCount, 'title' => '📅 Total Semesters', 'route' => route('admin.semesters.index'), 'bg' => 'bg-info'],
                    ['count' => $parentsCount, 'title' => '🧑‍🤝‍🧑 Total Parents', 'route' => route('admin.parentts.index'), 'bg' => 'bg-warning text-dark'],
                    ['count' => $bookExercisesCount, 'title' => '📚 Book Exercises', 'route' => route('admin.exercises.index'), 'bg' => 'bg-dark'],
                    ['count' => $productsCount, 'title' => '🛍 Total Products', 'route' => route('admin.products.index'), 'bg' => 'bg-success'],
                    ['count' => $ordersCount, 'title' => '🛒 Total Orders', 'route' => route('admin.orders.index'), 'bg' => 'bg-primary'],
                    ['count' => $blogsCount, 'title' => '📝 Total Blogs', 'route' => route('admin.blogs.index'), 'bg' => 'bg-info'],
                ];
            @endphp

            @foreach ($tiles as $tile)
                <div class="col-md-4 mb-3">
                    <div class="card {{ $tile['bg'] }} text-white shadow rounded-4 h-100" style="cursor: pointer;" onclick="location.href='{{ $tile['route'] }}'">
                        <div class="card-body text-center">
                            <h5 class="text-white">{{ $tile['title'] }}</h5>
                            <h2 class="text-white">{{ $tile['count'] }}</h2>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
                