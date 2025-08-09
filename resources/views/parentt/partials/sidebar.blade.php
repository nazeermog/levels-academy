<div class="mdk-drawer js-mdk-drawer" id="default-drawer">
    <div class="mdk-drawer__content top-navbar">
        <div class="sidebar sidebar-dark-pickled-bluewood sidebar-left sidebar-p-t" data-perfect-scrollbar>
            <!-- Sidebar Content -->
            <div class="sidebar-heading font-droid">
                @if(session('locale', config('app.locale')) == 'en')
                The Parent
                @endif
                @if(session('locale', config('app.locale')) == 'ar')
                الوالد
                @endif
                @if(session('locale', config('app.locale')) == 'de')
                der Elternteil
                @endif
            </div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button" href="{{ route('parentt.progressChilderns') }}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">format_shapes</span>
                        <span class="sidebar-menu-text font-droid">
                            @if(session('locale', config('app.locale')) == 'en')
                            Watch childrens progresses
                            @endif
                            @if(session('locale', config('app.locale')) == 'ar')
                            شاهد التقدم لأطفالك
                            @endif
                            @if(session('locale', config('app.locale')) == 'de')
                            Beobachten Sie die Fortschritte der Kinder
                            @endif
                        </span>
                    </a>
                    <a class="sidebar-menu-button" href="{{ route('parentt.childrenEvents') }}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">event</span>
                        <span class="sidebar-menu-text font-droid">
                            @if(session('locale', config('app.locale')) == 'en')
                            Watch childrens events
                            @endif
                            @if(session('locale', config('app.locale')) == 'ar')
                            شاهد فعاليات أطفالك
                            @endif
                            @if(session('locale', config('app.locale')) == 'de')
                            Sehen Sie sich die Veranstaltungen Ihrer Kinder an
                            @endif
                        </span>
                    </a>
                    <a class="sidebar-menu-button" href="{{ route('parentt.notes.childernNotes') }}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">note</span>
                        <span class="sidebar-menu-text font-droid">
                            @if(session('locale', config('app.locale')) == 'en')
                            View Notes
                            @endif
                            @if(session('locale', config('app.locale')) == 'ar')
                            عرض الملاحظات
                            @endif
                            @if(session('locale', config('app.locale')) == 'de')
                            Notizen anzeigen
                            @endif
                        </span>
                    </a>
                    <a class="sidebar-menu-button" href="{{ route('parentt.transactions.index') }}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">format_shapes</span>
                        <span class="sidebar-menu-text font-droid">
                            @if(session('locale', config('app.locale')) == 'en')
                            View Transactions
                            @endif
                            @if(session('locale', config('app.locale')) == 'ar')
                            عرض المعاملات
                            @endif
                            @if(session('locale', config('app.locale')) == 'de')
                            Transaktionen anzeigen
                            @endif
                        </span>
                    </a>
                </li>


            </ul>


            <!-- // END Sidebar Content -->

        </div>
    </div>
</div>