@extends('datasource::management.layout.master')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid py-4">
            <div class="row metrics-grid">
                @php
                $metrics = [
                ['title' => 'Practice Types', 'value' => $practiceTypesCount, 'icon_image' => asset('images/icons/Vector (3).png'), 'bg' => 'bg-green', 'route' => route('admin.practices.index')],
                ['title' => 'Practice Levels', 'value' => $practiceLevelsCount, 'icon_image' => asset('images/icons/Vector (1).png'), 'bg' => 'bg-gray', 'route' => route('admin.practicesType.index')],
                ['title' => 'Result Practice', 'value' => $resultPracticesCount, 'icon_image' => asset('images/icons/uil_chart-bar (1).png'), 'bg' => 'bg-blue', 'route' => route('admin.resultPractices.index')],
                ['title' => 'Total Courses', 'value' => $coursesCount, 'icon_image' => asset('images/icons/Vector (2).png'), 'bg' => 'bg-gray', 'route' => route('admin.courseContent.index')],
                ['title' => 'Total Categories', 'value' => $categoriesCount, 'icon_image' => asset('images/icons/Vector (3).png'), 'bg' => 'bg-blue', 'route' => route('admin.taxonomies.index')],
                ['title' => 'Course Paths', 'value' => $coursePathsCount, 'icon_image' => asset('images/icons/Vector (4).png'), 'bg' => 'bg-gray', 'route' => route('admin.coursePath.index')],
                ['title' => 'Total Lessons', 'value' => $lessonsCount, 'icon_image' => asset('images/icons/Vector (5).png'), 'bg' => 'bg-green', 'route' => route('admin.lessons.index')],
                ['title' => 'Total Instructors', 'value' => $instructorsCount, 'icon_image' => asset('images/icons/Vector (6).png'), 'bg' => 'bg-blue', 'route' => route('admin.instructors.index')],
                ['title' => 'Total Students', 'value' => $studentsCount, 'icon_image' => asset('images/icons/hugeicons_students.png'), 'bg' => 'bg-green', 'route' => route('admin.students.index')],
                ['title' => 'Total Semesters', 'value' => $semestersCount, 'icon_image' => asset('images/icons/fa-solid_calendar-alt.png'), 'bg' => 'bg-blue', 'route' => route('admin.semesters.index')],
                ['title' => 'Total Parents', 'value' => $parentsCount, 'icon_image' => asset('images/icons/Vector (7).png'), 'bg' => 'bg-green', 'route' => route('admin.parentts.index')],
                ['title' => 'Book Exercises', 'value' => $bookExercisesCount, 'icon_image' => asset('images/icons/flowbite_book-solid.png'), 'bg' => 'bg-gray', 'route' => route('admin.exercises.index')],
                ['title' => 'Total Products', 'value' => $productsCount, 'icon_image' => asset('images/icons/eos-icons_products.png'), 'bg' => 'bg-blue', 'route' => route('admin.products.index')],
                ['title' => 'Total Orders', 'value' => $ordersCount, 'icon_image' => asset('images/icons/material-symbols_shopping-cart.png'), 'bg' => 'bg-green', 'route' => route('admin.orders.index')],
                ['title' => 'Total Blogs', 'value' => $blogsCount, 'icon_image' => asset('images/icons/Vector (8).png'), 'bg' => 'bg-gray', 'route' => route('admin.blogs.index')],
                ];
                @endphp

                @foreach ($metrics as $metric)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="metric-card {{ $metric['bg'] }}" onclick="location.href='{{ $metric['route'] }}'">
                        <div class="metric-title">{{ $metric['title'] }}</div>
                        <div class="metric-value">{{ $metric['value'] }}</div>
                        <div class="icon-wrapper-right">
                            <img src="{{ $metric['icon_image'] }}" alt="icon" class="metric-icon-img">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection