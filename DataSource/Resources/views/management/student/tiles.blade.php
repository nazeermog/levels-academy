@extends('datasource::management.layout.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid py-4">
            <div class="row">
                <!-- Total Students -->
                <div class="col-md-6 mb-4">
                    <div class="metric-card bg-primary" onclick="location.href='{{ route('admin.students.index') }}'">
                        <div class="icon-wrapper">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="metric-title">Total Students</div>
                        <div class="metric-value">{{ $studentsCount }}</div>
                    </div>
                </div>

                <!-- Total Parents -->
                <div class="col-md-6 mb-4">
                    <div class="metric-card bg-secondary" onclick="location.href='{{ route('admin.parentts.index') }}'">
                        <div class="icon-wrapper">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="metric-title">Total Parents</div>
                        <div class="metric-value">{{ $parents }}</div>
                    </div>
                </div>

                <!-- Total Courses -->
                <div class="col-md-6 mb-4">
                    <div class="metric-card bg-success" onclick="location.href='{{ route('admin.courseContent.index') }}'">
                        <div class="icon-wrapper">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="metric-title">Total Courses</div>
                        <div class="metric-value">{{ $coursesCount }}</div>
                    </div>
                </div>

                <!-- Total Enrollments -->
                <div class="col-md-6 mb-4">
                    <div class="metric-card bg-info" onclick="location.href='{{ route('admin.inrollments.index') }}'">
                        <div class="icon-wrapper">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="metric-title">Total Enrollments</div>
                        <div class="metric-value">{{ $inrollmentsCount }}</div>
                    </div>
                </div>

                <!-- Completed Enrollments -->
                <div class="col-md-6 mb-4">
                    <div class="metric-card bg-warning" onclick="location.href='{{ route('admin.inrollments.index') }}'">
                        <div class="icon-wrapper">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="metric-title">Completed Enrollments</div>
                        <div class="metric-value">{{ $completedEnrollments }}</div>
                    </div>
                </div>

                <!-- Ongoing Enrollments -->
                <div class="col-md-6 mb-4">
                    <div class="metric-card bg-danger" onclick="location.href='{{ route('admin.inrollments.index') }}'">
                        <div class="icon-wrapper">
                            <i class="fas fa-sync"></i>
                        </div>
                        <div class="metric-title">Ongoing Enrollments</div>
                        <div class="metric-value">{{ $ongoingEnrollments }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .metric-card {
        position: relative;
        border-radius: 15px;
        color: white;
        padding: 25px;
        height: 180px;
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
        left: 25px;
        transform: translateY(-50%);
        font-size: 72px;
        opacity: 0.8;
        color: white;
    }

    .metric-title {
        position: absolute;
        top: 25px;
        right: 25px;
        left: 120px;
        text-align: right;
        font-size: 24px;
        font-weight: 500;
        color: white;
    }

    .metric-value {
        position: absolute;
        bottom: 25px;
        right: 25px;
        font-size: 36px;
        font-weight: 700;
        color: white;
    }

    @media (max-width: 768px) {
        .metric-card {
            height: 150px;
            padding: 20px;
        }
        .icon-wrapper {
            font-size: 56px;
            left: 20px;
        }
        .metric-title {
            font-size: 20px;
            top: 20px;
            right: 20px;
            left: 100px;
        }
        .metric-value {
            font-size: 30px;
            bottom: 20px;
            right: 20px;
        }
    }

    @media (max-width: 576px) {
        .metric-card {
            height: 130px;
            padding: 15px;
        }
        .icon-wrapper {
            font-size: 48px;
            left: 15px;
        }
        .metric-title {
            font-size: 18px;
            top: 15px;
            right: 15px;
            left: 80px;
        }
        .metric-value {
            font-size: 26px;
            bottom: 15px;
            right: 15px;
        }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .metric-card:hover .metric-value {
        animation: pulse 1s infinite;
    }
</style>

<!-- Add Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection