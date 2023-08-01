<div class="mdk-drawer js-mdk-drawer"
     id="default-drawer">
    <div class="mdk-drawer__content top-navbar">
        <div class="sidebar sidebar-dark-pickled-bluewood sidebar-left sidebar-p-t"
             data-perfect-scrollbar>

            <!-- Sidebar Content -->

            <div class="sidebar-heading font-droid">
                الطالب
            </div>
            <ul class="sidebar-menu">

{{--                <li class="sidebar-menu-item active">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="index.html">--}}
{{--                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">home</span>--}}
{{--                        <span class="sidebar-menu-text">--}}
{{--                            الرئيسية--}}
{{--                        </span>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button"
                       href="{{route('student.courses.index')}}">
                                                    <span
                                                        class="material-icons sidebar-menu-icon sidebar-menu-icon--left">local_library</span>
                        <span class="sidebar-menu-text">
                            تصفح الدورات

                        </span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button"
                       href="{{route('student.paths.index')}}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">style</span>
                        <span class="sidebar-menu-text">
                            مسارات التعليم
                        </span>
                    </a>
                </li>
{{--                <li class="sidebar-menu-item">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="student-dashboard.html">--}}
{{--                                                    <span--}}
{{--                                                        class="material-icons sidebar-menu-icon sidebar-menu-icon--left">account_box</span>--}}
{{--                        <span class="sidebar-menu-text">لوحة التحكم</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="sidebar-menu-item">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="student-my-courses.html">--}}
{{--                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">search</span>--}}
{{--                        <span class="sidebar-menu-text">--}}
{{--                            الدروس--}}

{{--                        </span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="sidebar-menu-item">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="student-paths.html">--}}
{{--                                                    <span--}}
{{--                                                        class="material-icons sidebar-menu-icon sidebar-menu-icon--left">timeline</span>--}}
{{--                        <span class="sidebar-menu-text">مساري التعليمي</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="sidebar-menu-item">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="student-path.html">--}}
{{--                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">change_history</span>--}}
{{--                        <span class="sidebar-menu-text">تفاصيل المسار</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
                
{{--                <li class="sidebar-menu-item">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="student-lesson.html">--}}
{{--                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">panorama_fish_eye</span>--}}
{{--                        <span class="sidebar-menu-text">عرض الدرس</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="sidebar-menu-item">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="student-take-course.html">--}}
{{--                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">class</span>--}}
{{--                        <span class="sidebar-menu-text"> احضر الدورة التدريبية </span>--}}
{{--                        <span--}}
{{--                            class="sidebar-menu-badge badge badge-accent badge-notifications ml-auto">PRO</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="sidebar-menu-item">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="student-take-lesson.html">--}}
{{--                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">import_contacts</span>--}}
{{--                        <span class="sidebar-menu-text">احضر الدرس</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button"
                       href="{{route('student.practice.show',['id'=>\DataSource\Entities\PracticeType\PracticeType::first()->id])}}">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">dvr</span>
                        <span class="sidebar-menu-text">
                            التمارين
                        </span>
                    </a>
                </li>
{{--                <li class="sidebar-menu-item">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="student-quiz-results.html">--}}
{{--                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">poll</span>--}}
{{--                        <span class="sidebar-menu-text">مذاكراتي</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="sidebar-menu-item">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="student-quiz-result-details.html">--}}
{{--                                                    <span--}}
{{--                                                        class="material-icons sidebar-menu-icon sidebar-menu-icon--left">live_help</span>--}}
{{--                        <span class="sidebar-menu-text">نتائج المذاكرات</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="sidebar-menu-item">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="student-path-assessment.html">--}}
{{--                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">layers</span>--}}
{{--                        <span class="sidebar-menu-text">Skill Assessment</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="sidebar-menu-item">--}}
{{--                    <a class="sidebar-menu-button"--}}
{{--                       href="student-path-assessment-result.html">--}}
{{--                                        <span--}}
{{--                                            class="material-icons sidebar-menu-icon sidebar-menu-icon--left">assignment_turned_in</span>--}}
{{--                        <span class="sidebar-menu-text">Skill Result</span>--}}
{{--                    </a>--}}
{{--                </li>--}}

            </ul>


            <!-- // END Sidebar Content -->

        </div>
    </div>
</div>
