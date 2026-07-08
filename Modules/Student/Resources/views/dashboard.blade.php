@extends("student.layouts.dashboard")

@section("content")
@php
    $locale = session('locale', config('app.locale'));
    // One card per student sidebar menu item (navigation shortcuts).
    $items = [
        ['route' => 'student.courses.index',                'icon' => 'school',          'bg' => 'bg-green', 'en' => 'Courses',              'ar' => 'الدورات',              'de' => 'Kurse'],
        ['route' => 'student.inrollment.index',             'icon' => 'assignment_ind',  'bg' => 'bg-blue',  'en' => 'Enrollments',          'ar' => 'التسجيلات',            'de' => 'Einschreibungen'],
        ['route' => 'student.paths.index',                  'icon' => 'timeline',        'bg' => 'bg-gray',  'en' => 'Education Paths',      'ar' => 'مسارات التعليم',       'de' => 'Bildungswege'],
        ['route' => 'student.practice.index',               'icon' => 'assignment',      'bg' => 'bg-blue',  'en' => 'Exercises',            'ar' => 'تمارين',               'de' => 'Übungen'],
        ['route' => 'student.index.exercise',               'icon' => 'menu_book',       'bg' => 'bg-green', 'en' => 'Book Exercises',       'ar' => 'تمارين الكتاب',        'de' => 'Buch Übungen'],
        ['route' => 'student.index.Bookexercise',           'icon' => 'library_books',   'bg' => 'bg-gray',  'en' => 'All Book Exercises',   'ar' => 'جميع تمارين الكتاب',   'de' => 'Alle Buch Übungen'],
        ['route' => 'student.index.Bookexercise.pages.qr',  'icon' => 'import_contacts', 'bg' => 'bg-blue',  'en' => 'Book Exercises By QR', 'ar' => 'تمارين الكتاب بالكود', 'de' => 'Buch Übungen per QR'],
        ['route' => 'student.index.products',               'icon' => 'folder',          'bg' => 'bg-green', 'en' => 'Products',             'ar' => 'المنتجات',             'de' => 'Produkte'],
    ];
@endphp

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

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
@endsection
