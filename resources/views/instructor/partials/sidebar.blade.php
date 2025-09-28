<style>
  .sidebar {
    background-color: #424242 !important;
    min-height: 100vh;
  }

  .sidebar-heading {
    color: #ffffff !important;
    padding: 20px 16px 10px !important;
    font-size: 18px;
    font-weight: 600;
  }

  .sidebar-menu {
    padding: 0;
    margin: 0;
    list-style: none;
  }

  .sidebar-menu-item {
    margin: 0;
    padding: 0;
  }

  .sidebar-menu-button {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    color: #ffffff !important;
    text-decoration: none;
    transition: background-color 0.2s ease;
    border: none;
    background: transparent;
    width: 100%;
    text-align: left;
  }

  .sidebar-menu-button:hover {
    background-color: #555555 !important;
    color: #ffffff !important;
  }

  .sidebar-menu-button.active {
    background-color: #555555 !important;
    color: #ffffff !important;
  }

  .sidebar-menu-text {
    color: #ffffff !important;
    font-size: 14px;
    font-weight: 400;
    flex: 1;
  }

  .sidebar-menu-icon {
    margin-right: 12px;
    font-size: 20px;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff !important;
  }

  .sidebar-menu-text {
    font-size: 14px;
    font-weight: 400;
    flex: 1;
  }
</style>
<div class="mdk-drawer js-mdk-drawer" id="default-drawer">
    <div class="mdk-drawer__content top-navbar">
        <div class="sidebar sidebar-dark sidebar-left sidebar-p-t" data-perfect-scrollbar dir="{{ session('locale', config('app.locale')) == 'ar' ? 'rtl' : 'ltr' }}">
            <!-- Sidebar Content -->
            <div class="sidebar-heading font-droid">
                @if(session('locale', config('app.locale')) == 'en')
                The Teacher
                @endif
                @if(session('locale', config('app.locale')) == 'ar')
                المعلم
                @endif
                @if(session('locale', config('app.locale')) == 'de')
                Der Lehrer
                @endif
            </div>
            <ul class="sidebar-menu">

                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button" href="{{route('instructor.practice-details.index')}}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">format_shapes</span>
                        <span class="sidebar-menu-text font-droid">
                            @if(session('locale', config('app.locale')) == 'en')
                            Test management
                            @endif
                            @if(session('locale', config('app.locale')) == 'ar')
                            إدارة الاختبارات
                            @endif
                            @if(session('locale', config('app.locale')) == 'de')
                            Testmanagement
                            @endif
                        </span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button" href="{{route('instructor.result-practice.index')}}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">format_shapes</span>
                        <span class="sidebar-menu-text font-droid">
                            @if(session('locale', config('app.locale')) == 'en')
                            Results management
                            @endif
                            @if(session('locale', config('app.locale')) == 'ar')
                            إدارة النتائج
                            @endif
                            @if(session('locale', config('app.locale')) == 'de')
                            Ergebnismanagement
                            @endif
                        </span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button" href="{{route('instructor.InrollmentCourses.index')}}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">format_shapes</span>
                        <span class="sidebar-menu-text font-droid">
                            @if(session('locale', config('app.locale')) == 'en')
                            Course management
                            @endif
                            @if(session('locale', config('app.locale')) == 'ar')
                            إدارة الكورسات
                            @endif
                            @if(session('locale', config('app.locale')) == 'de')
                            Kursmanagement
                            @endif
                        </span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button" href="{{route('instructor.studentscore.index')}}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">format_shapes</span>
                        <span class="sidebar-menu-text font-droid">
                            @if(session('locale', config('app.locale')) == 'en')
                            Leaderboard students
                            @endif
                            @if(session('locale', config('app.locale')) == 'ar')
                            الطلاب المتصدرين
                            @endif
                            @if(session('locale', config('app.locale')) == 'de')
                            Bestenliste der Schüler
                            @endif
                        </span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button" href="{{ route('instructor.student.events') }}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">format_shapes</span>
                        <span class="sidebar-menu-text font-droid">
                            @if(session('locale', config('app.locale')) == 'en')
                            Events for Students
                            @elseif(session('locale', config('app.locale')) == 'ar')
                            فعاليات الطلاب
                            @elseif(session('locale', config('app.locale')) == 'de')
                            Veranstaltungen für Schüler
                            @endif
                        </span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button" href="{{ route('instructor.notes.index') }}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">format_shapes</span>

                        <span class="sidebar-menu-text font-droid">
                            @if(session('locale', config('app.locale')) == 'en')
                            Instructor Notes
                            @elseif(session('locale', config('app.locale')) == 'ar')
                            ملاحظات المعلم
                            @elseif(session('locale', config('app.locale')) == 'de')
                            Anmerkungen des Dozenten
                            @endif
                        </span>
                    </a>
                </li>

            </ul>
            <!-- // END Sidebar Content -->
        </div>
    </div>
</div>