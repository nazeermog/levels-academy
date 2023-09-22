<div class="mdk-drawer js-mdk-drawer" id="default-drawer">
    <div class="mdk-drawer__content top-navbar">
        <div class="sidebar sidebar-dark-pickled-bluewood sidebar-left sidebar-p-t" data-perfect-scrollbar>
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
                {{-- <li class="sidebar-menu-item">--}}
                {{-- <a class="sidebar-menu-button"--}}
                {{-- href="instructor-dashboard.html">--}}
                {{-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">school</span>--}}
                {{-- <span class="sidebar-menu-text font-droid">--}}
                {{-- الواجهة الرئيسية--}}
                {{-- </span>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="sidebar-menu-item">--}}
                {{-- <a class="sidebar-menu-button"--}}
                {{-- href="instructor-courses.html">--}}
                {{-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">import_contacts</span>--}}
                {{-- <span class="sidebar-menu-text font-droid">--}}
                {{-- إدارة الدروس--}}
                {{-- </span>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="sidebar-menu-item">--}}
                {{-- <a class="sidebar-menu-button"--}}
                {{-- href="instructor-quizzes.html">--}}
                {{-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">help</span>--}}
                {{-- <span class="sidebar-menu-text">Manage Quizzes</span>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="sidebar-menu-item">--}}
                {{-- <a class="sidebar-menu-button"--}}
                {{-- href="instructor-earnings.html">--}}
                {{-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">trending_up</span>--}}
                {{-- <span class="sidebar-menu-text">Earnings</span>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="sidebar-menu-item">--}}
                {{-- <a class="sidebar-menu-button"--}}
                {{-- href="instructor-statement.html">--}}
                {{-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">receipt</span>--}}
                {{-- <span class="sidebar-menu-text">Statement</span>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="sidebar-menu-item">--}}
                {{-- <a class="sidebar-menu-button"--}}
                {{-- href="instructor-edit-course.html">--}}
                {{-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">post_add</span>--}}
                {{-- <span class="sidebar-menu-text">Edit Course</span>--}}
                {{-- </a>--}}
                {{-- </li>--}}
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
            </ul>
            <!-- // END Sidebar Content -->
        </div>
    </div>
</div>