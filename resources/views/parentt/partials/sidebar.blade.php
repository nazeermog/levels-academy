<div class="mdk-drawer js-mdk-drawer" id="default-drawer">
    <div class="mdk-drawer__content top-navbar">
        <div class="sidebar sidebar-dark-pickled-bluewood sidebar-left sidebar-p-t" data-perfect-scrollbar>

            <!-- Sidebar Heading -->
            <div class="sidebar-heading font-droid text-uppercase fw-bold py-3 px-3 border-bottom border-light">
                @if(session('locale', config('app.locale')) == 'en')
                    The Parent
                @elseif(session('locale', config('app.locale')) == 'ar')
                    الوالد
                @elseif(session('locale', config('app.locale')) == 'de')
                    der Elternteil
                @endif
            </div>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu list-unstyled mt-3">
                @php
                    $menuItems = [
                        ['route' => 'parentt.progressChilderns', 'icon' => 'format_shapes', 'en' => 'Watch childrens progresses', 'ar' => 'شاهد التقدم لأطفالك', 'de' => 'Beobachten Sie die Fortschritte der Kinder'],
                        ['route' => 'parentt.childrenEvents', 'icon' => 'event', 'en' => 'Watch childrens events', 'ar' => 'شاهد فعاليات أطفالك', 'de' => 'Sehen Sie sich die Veranstaltungen Ihrer Kinder an'],
                        ['route' => 'parentt.notes.childernNotes', 'icon' => 'note', 'en' => 'View Notes', 'ar' => 'عرض الملاحظات', 'de' => 'Notizen anzeigen'],
                        ['route' => 'parentt.transactions.index', 'icon' => 'format_shapes', 'en' => 'View Transactions', 'ar' => 'عرض المعاملات', 'de' => 'Transaktionen anzeigen'],
                        ['route' => 'parentt.addmoney.show', 'icon' => 'add_circle', 'en' => 'Add Money', 'ar' => 'إضافة رصيد', 'de' => 'Geld hinzufügen'],
                    ];
                    $locale = session('locale', config('app.locale'));
                @endphp

                @foreach($menuItems as $item)
                    @php $isActive = request()->routeIs($item['route']); @endphp
                    <li class="sidebar-menu-item mb-1">
                        <a
                            class="sidebar-menu-button d-flex align-items-center px-3 py-2 rounded {{ $isActive ? 'is-active' : '' }}"
                            href="{{ route($item['route']) }}"
                        >
                            <span class="material-icons sidebar-menu-icon me-3">{{ $item['icon'] }}</span>
                            <span class="sidebar-menu-text font-droid">
                                {{ $item[$locale] ?? $item['en'] }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
</div>

@push('css')
<style>
    /* General menu item styling */
    .sidebar-menu-button {
        position: relative;
        color: #fff;
        text-decoration: none;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        width: 100%;
        transition: all 0.3s ease-in-out;
        border-radius: 4px;
    }

    /* Hover background */
    .sidebar.sidebar-dark-pickled-bluewood .sidebar-menu-button:hover {
        background-color: rgba(255, 255, 255, 0.25) !important;
        padding-left: 1.5rem;
    }

    /* Active background (gray) */
    .sidebar.sidebar-dark-pickled-bluewood .sidebar-menu-button.is-active {
        background-color: rgba(128, 128, 128, 0.35) !important;
    }

    /* Accent bar for hover/active */
    .sidebar.sidebar-dark-pickled-bluewood .sidebar-menu-button:hover::before,
    .sidebar.sidebar-dark-pickled-bluewood .sidebar-menu-button.is-active::before {
        content: "";
        position: absolute;
        left: 0; top: 0;
        width: 4px; height: 100%;
        background-color: #00bcd4;
        border-radius: 2px;
    }

    /* Icons */
    .sidebar-menu-icon {
        font-size: 1.4rem;
        flex-shrink: 0;
        margin-right: 0.75rem;
        transition: all 0.25s ease-in-out;
    }

    /* Icon hover & active effect */
    .sidebar.sidebar-dark-pickled-bluewood .sidebar-menu-button:hover .sidebar-menu-icon,
    .sidebar.sidebar-dark-pickled-bluewood .sidebar-menu-button.is-active .sidebar-menu-icon {
        transform: scale(1.1);
        color: #00bcd4 !important;
    }

    /* Sidebar heading */
    .sidebar-heading {
        letter-spacing: 0.5px;
        font-size: 0.85rem;
        opacity: 0.8;
    }
</style>
@endpush
