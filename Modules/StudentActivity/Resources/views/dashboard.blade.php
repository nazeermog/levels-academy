@extends('parentt.layouts.dashboard')

@section('content')
@php
    $locale = session('locale', config('app.locale'));
    // One card per parent sidebar menu item (navigation shortcuts).
    $items = [
        ['route' => 'parentt.progressChilderns',      'icon' => 'bar_chart',   'bg' => 'bg-green', 'en' => "Children's Progress", 'ar' => 'شاهد التقدم لأطفالك', 'de' => 'Fortschritte der Kinder'],
        ['route' => 'parentt.childrenEvents',         'icon' => 'event',       'bg' => 'bg-blue',  'en' => "Children's Events",   'ar' => 'شاهد فعاليات أطفالك', 'de' => 'Veranstaltungen der Kinder'],
        ['route' => 'parentt.notes.childernNotes',    'icon' => 'note',        'bg' => 'bg-gray',  'en' => 'View Notes',          'ar' => 'عرض الملاحظات',       'de' => 'Notizen anzeigen'],
        ['route' => 'parentt.classrooms.sessions',    'icon' => 'event_note',  'bg' => 'bg-blue',  'en' => 'Classroom Sessions',  'ar' => 'جلسات الصف',          'de' => 'Unterrichtssitzungen'],
        ['route' => 'parentt.transactions.index',     'icon' => 'receipt_long','bg' => 'bg-green', 'en' => 'Transactions',        'ar' => 'عرض المعاملات',       'de' => 'Transaktionen'],
        ['route' => 'parentt.addmoney.show',          'icon' => 'add_circle',  'bg' => 'bg-gray',  'en' => 'Add Money',           'ar' => 'إضافة رصيد',          'de' => 'Geld hinzufügen'],
        ['route' => 'parentt.absences.index',         'icon' => 'event_busy',  'bg' => 'bg-blue',  'en' => 'Absence Requests',    'ar' => 'طلبات الغياب',        'de' => 'Fehlzeitenanträge'],
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
