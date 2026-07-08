@extends('instructor.layouts.dashboard')

@section('content')
@php
    $locale = session('locale', config('app.locale'));
    // One card per instructor sidebar menu item (navigation shortcuts).
    $items = [
        ['route' => 'instructor.practice-details.index',   'icon' => 'format_shapes', 'bg' => 'bg-green', 'en' => 'Test management',      'ar' => 'إدارة الاختبارات', 'de' => 'Testmanagement'],
        ['route' => 'instructor.result-practice.index',    'icon' => 'assessment',    'bg' => 'bg-blue',  'en' => 'Results management',   'ar' => 'إدارة النتائج',    'de' => 'Ergebnismanagement'],
        ['route' => 'instructor.InrollmentCourses.index',  'icon' => 'menu_book',     'bg' => 'bg-gray',  'en' => 'Course management',    'ar' => 'إدارة الكورسات',   'de' => 'Kursmanagement'],
        ['route' => 'instructor.studentscore.index',       'icon' => 'star',          'bg' => 'bg-blue',  'en' => 'Leaderboard students', 'ar' => 'الطلاب المتصدرين', 'de' => 'Bestenliste der Schüler'],
        ['route' => 'instructor.student.events',           'icon' => 'event',         'bg' => 'bg-green', 'en' => 'Events for Students',  'ar' => 'فعاليات الطلاب',   'de' => 'Veranstaltungen für Schüler'],
        ['route' => 'instructor.notes.index',              'icon' => 'note',          'bg' => 'bg-gray',  'en' => 'Instructor Notes',     'ar' => 'ملاحظات المعلم',   'de' => 'Anmerkungen des Dozenten'],
        ['route' => 'instructor.sessions.index',           'icon' => 'event_note',    'bg' => 'bg-green', 'en' => 'Class Sessions',       'ar' => 'جلسات الصف',       'de' => 'Unterrichtssitzungen'],
        ['route' => 'instructor.availability.index',       'icon' => 'schedule',      'bg' => 'bg-blue',  'en' => 'My Availability',      'ar' => 'أوقات تواجدي',     'de' => 'Meine Verfügbarkeit'],
        ['route' => 'instructor.free-sessions.index',      'icon' => 'card_giftcard', 'bg' => 'bg-gray',  'en' => 'Free Sessions',        'ar' => 'الجلسات المجانية', 'de' => 'Kostenlose Sitzungen'],
        ['route' => 'instructor.progress.index',           'icon' => 'bar_chart',     'bg' => 'bg-green', 'en' => 'Course Progress',      'ar' => 'تقدم الطلاب',      'de' => 'Kursfortschritt'],
        ['route' => 'instructor.reports.per_student',      'icon' => 'attach_money',  'bg' => 'bg-blue',  'en' => 'Students Payout',      'ar' => 'مستحقات لكل طالب', 'de' => 'Auszahlung pro Schüler'],
        ['route' => 'instructor.reports.expected_earnings','icon' => 'trending_up',   'bg' => 'bg-gray',  'en' => 'Expected Earnings',    'ar' => 'الأرباح المتوقعة', 'de' => 'Erwartete Einnahmen'],
    ];
@endphp

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid py-4">
            <div class="row metrics-grid">
                @foreach ($items as $item)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="menu-card {{ $item['bg'] }}" onclick="location.href='{{ route($item['route']) }}'">
                        <div class="menu-card-icon">
                            <span class="material-icons">{{ $item['icon'] }}</span>
                        </div>
                        <div class="menu-card-title">{{ $item[$locale] ?? $item['en'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
