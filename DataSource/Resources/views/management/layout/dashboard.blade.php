@extends('datasource::management.layout.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid py-4">
            <div class="row metrics-grid">
                @php
                    $metrics = [
                        [
                            'title' => 'Practice Types',
                            'value' => $practiceTypesCount,
                            'icon' => 'fas fa-file-alt',
                            'bg' => 'bg-danger',
                            'route' => route('admin.practices.index')
                        ],
                        [
                            'title' => 'Practice Levels',
                            'value' => $practiceLevelsCount,
                            'icon' => 'fas fa-layer-group',
                            'bg' => 'bg-success',
                            'route' => route('admin.practicesType.index')
                        ],
                        [
                            'title' => 'Result Practice',
                            'value' => $resultPracticesCount,
                            'icon' => 'fas fa-chart-line',
                            'bg' => 'bg-warning',
                            'route' => route('admin.resultPractices.index')
                        ],
                        [
                            'title' => 'Total Courses',
                            'value' => $coursesCount,
                            'icon' => 'fas fa-book',
                            'bg' => 'bg-pink',
                            'route' => route('admin.courseContent.index')
                        ],
                        [
                            'title' => 'Total Categories',
                            'value' => $categoriesCount,
                            'icon' => 'fas fa-folder',
                            'bg' => 'bg-orange',
                            'route' => route('admin.taxonomies.index')
                        ],
                        [
                            'title' => 'Course Paths',
                            'value' => $coursePathsCount,
                            'icon' => 'fas fa-route',
                            'bg' => 'bg-info',
                            'route' => route('admin.coursePath.index')
                        ],
                        [
                            'title' => 'Total Lessons',
                            'value' => $lessonsCount,
                            'icon' => 'fas fa-book-open',
                            'bg' => 'bg-purple',
                            'route' => route('admin.lessons.index')
                        ],
                        [
                            'title' => 'Total Instructors',
                            'value' => $instructorsCount,
                            'icon' => 'fas fa-chalkboard-teacher',
                            'bg' => 'bg-success-dark',
                            'route' => route('admin.instructors.index')
                        ],
                        [
                            'title' => 'Total Students',
                            'value' => $studentsCount,
                            'icon' => 'fas fa-user-graduate',
                            'bg' => 'bg-success',
                            'route' => route('admin.students.index')
                        ],
                        [
                            'title' => 'Total Semesters',
                            'value' => $semestersCount,
                            'icon' => 'fas fa-calendar-alt',
                            'bg' => 'bg-success-light',
                            'route' => route('admin.semesters.index')
                        ],
                        [
                            'title' => 'Total Parents',
                            'value' => $parentsCount,
                            'icon' => 'fas fa-users',
                            'bg' => 'bg-gray',
                            'route' => route('admin.parentts.index')
                        ],
                        [
                            'title' => 'Book Exercises',
                            'value' => $bookExercisesCount,
                            'icon' => 'fas fa-book-reader',
                            'bg' => 'bg-danger-light',
                            'route' => route('admin.exercises.index')
                        ],
                        [
                            'title' => 'Total Products',
                            'value' => $productsCount,
                            'icon' => 'fas fa-box',
                            'bg' => 'bg-warning',
                            'route' => route('admin.products.index')
                        ],
                        [
                            'title' => 'Total Orders',
                            'value' => $ordersCount,
                            'icon' => 'fas fa-shopping-cart',
                            'bg' => 'bg-pink',
                            'route' => route('admin.orders.index')
                        ],
                        [
                            'title' => 'Total Blogs',
                            'value' => $blogsCount,
                            'icon' => 'fas fa-blog',
                            'bg' => 'bg-primary',
                            'route' => route('admin.blogs.index')
                        ],
                    ];
                @endphp

                @foreach ($metrics as $metric)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="metric-card {{ $metric['bg'] }}" onclick="location.href='{{ $metric['route'] }}'">
                            <div class="icon-wrapper">
                                <i class="{{ $metric['icon'] }}"></i>
                            </div>
                            <div class="metric-title">{{ $metric['title'] }}</div>
                            <div class="metric-value">{{ $metric['value'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Colors */
    .bg-pink {
        background-color: #FF69B4;
    }
    .bg-purple {
        background-color: #8A2BE2;
    }
    .bg-orange {
        background-color: #FFA500;
    }
    .bg-orange-dark {
        background-color: #FF8C42;
    }
    .bg-success-dark {
        background-color: #27AE60;
    }
    .bg-success-light {
        background-color: #2ECC71;
    }
    .bg-danger-light {
        background-color: #FF5252;
    }
    .bg-gray {
        background-color: #95A5A6;
    }

    /* Metric Card Styling */
    .metric-card {
        position: relative;
        border-radius: 8px;
        color: white;
        padding: 15px;
        height: 120px;
        transition: all 0.3s ease;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .icon-wrapper {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        font-size: 48px;
        opacity: 0.8;
        color: white;
    }

    .metric-title {
        position: absolute;
        top: 15px;
        right: 15px;
        left: 80px;
        text-align: right;
        font-size: 18px;
        font-weight: 500;
        color: white;
    }

    .metric-value {
        position: absolute;
        bottom: 15px;
        right: 15px;
        font-size: 28px;
        font-weight: 700;
        color: white;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .metric-title {
            font-size: 16px;
        }
        .metric-value {
            font-size: 24px;
        }
        .icon-wrapper {
            font-size: 36px;
        }
    }

    @media (max-width: 576px) {
        .metric-card {
            height: 100px;
        }
        .icon-wrapper {
            font-size: 32px;
        }
        .metric-title {
            font-size: 14px;
        }
        .metric-value {
            font-size: 20px;
        }
    }

    /* Add animation */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .metric-card:hover .metric-value {
        animation: pulse 1s infinite;
    }
</style>


@endsection