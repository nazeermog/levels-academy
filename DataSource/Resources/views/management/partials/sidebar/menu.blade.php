<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{asset('images/logo/Levels-logo.png')}}" alt="{{ config('app.name', 'Project Name') }} Logo" class="brand-image  " height="100" width="100" style="opacity: .8">

    </a>


    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @php
                $sidebarUser = auth()->user();
                $orgsOn = (bool) config('features.organizations');
                // Global catalog/dashboard: super_admin always; admin only when organizations are OFF (merged "sees everything" mode).
                $showCatalog = $sidebarUser && ($sidebarUser->role === 'super_admin' || ($sidebarUser->role === 'admin' && ! $orgsOn));
                @endphp
                @if(auth()->check() && in_array(auth()->user()->role, ['admin','super_admin']))
                {{-- Dashboard (global) is the first item — only when the global catalog is available. --}}
                @if($showCatalog)
                <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @endif

                {{-- All organization features grouped in one tab. Hidden until config('features.organizations') is true. --}}
                @if(config('features.organizations'))
                <li class="nav-item {{ (Route::is('admin.org.dashboard') || Route::is('admin.org.users.*') || Route::is('admin.org.settings.*') || Route::is('admin.org.instructor-notes.*') || Route::is('admin.organizations.*')) ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link {{ (Route::is('admin.org.dashboard') || Route::is('admin.org.users.*') || Route::is('admin.org.settings.*') || Route::is('admin.org.instructor-notes.*') || Route::is('admin.organizations.*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sitemap"></i>
                        <p>
                            Organization
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.org.dashboard') }}" class="nav-link {{ Route::is('admin.org.dashboard') ? 'active' : '' }}">
                                <p class="ml-3">- Organization Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.org.users.index') }}" class="nav-link {{ Route::is('admin.org.users.index') ? 'active' : '' }}">
                                <p class="ml-3">- Organization Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.org.settings.edit') }}" class="nav-link {{ Route::is('admin.org.settings.*') ? 'active' : '' }}">
                                <p class="ml-3">- Organization Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.org.instructor-notes.index') }}" class="nav-link {{ Route::is('admin.org.instructor-notes.*') ? 'active' : '' }}">
                                <p class="ml-3">- Instructor Notes</p>
                            </a>
                        </li>
                        @if(auth()->user()->role === 'super_admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.organizations.index') }}" class="nav-link {{ Route::is('admin.organizations.index') ? 'active' : '' }}">
                                <p class="ml-3">- Organizations</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.organizations.create') }}" class="nav-link {{ Route::is('admin.organizations.create') ? 'active' : '' }}">
                                <p class="ml-3">- Create Organization</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @endif

                {{-- Classrooms / Session Types / Reports: kept available to admin & super_admin, now organization-agnostic. --}}
                @if(auth()->check() && in_array(auth()->user()->role, ['admin','super_admin']))
                <li class="nav-item {{ Route::is('admin.free-sessions.*') ? 'menu-open' : '' }} ">
                    <a href="{{ route('admin.free-sessions.index') }}" class="nav-link {{ Route::is('admin.free-sessions.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-gift"></i>
                        <p>Free Sessions</p>
                    </a>
                </li>
                <li class="nav-item {{ (Route::is('admin.org.classrooms.*') && !Route::is('admin.org.classrooms.reports.*')) ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link {{ (Route::is('admin.org.classrooms.*') && !Route::is('admin.org.classrooms.reports.*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chalkboard"></i>
                        <p>
                            Classrooms
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.org.classrooms.index')}}" class="nav-link  {{ Route::is('admin.org.classrooms.index')?'active':''}}">
                                <p class="ml-3">Classrooms</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Route::is('admin.org.class_session_types.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.org.class_session_types.*')?'active':''}}">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            Session Types
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.org.class_session_types.index')}}" class="nav-link  {{ Route::is('admin.org.class_session_types.index')?'active':''}}">
                                <p class="ml-3">Session Types</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item {{Route::is('admin.org.classrooms.reports.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.org.classrooms.reports.*')?'active':''}}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.org.classrooms.reports.instructors') }}" class="nav-link  {{ Route::is('admin.org.classrooms.reports.instructors')?'active':''}}">
                                <p class="ml-3">- Instructors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.org.classrooms.reports.student_dues') }}" class="nav-link  {{ Route::is('admin.org.classrooms.reports.student_dues')?'active':''}}">
                                <p class="ml-3">- Student Dues</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.org.classrooms.reports.profit') }}" class="nav-link  {{ Route::is('admin.org.classrooms.reports.profit')?'active':''}}">
                                <p class="ml-3">- Profit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.org.classrooms.reports.expected_earnings') }}" class="nav-link  {{ Route::is('admin.org.classrooms.reports.expected_earnings')?'active':''}}">
                                <p class="ml-3">- Expected Earnings</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                {{-- Global catalog: super_admin always; admin only when organizations are OFF. --}}
                @if($showCatalog)
                <li class="nav-item {{Route::is('admin.practices.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.practices.*')?'active':''}}">
                        <i class="nav-icon fas fa-dumbbell"></i>
                        <p>
                            Practice Types
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.practices.index')}}" class="nav-link  {{ Route::is('admin.practices.index')?'active':''}}">

                                <p class="ml-3">- Practice Types</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.practices.create')}}" class="nav-link  {{ Route::is('admin.practices.create')?'active':''}}">

                                <p class="ml-3">- Create Practice Type </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Route::is('admin.practicesType.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.practicesType.*')?'active':''}}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            Practice Type Details
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.practicesType.index')}}" class="nav-link  {{ Route::is('admin.practicesType.index')||Route::is('admin.practicesType.create')?'active':''}}">

                                <p class="ml-3">- Practice Type Details</p>
                            </a>
                        </li>


                    </ul>
                <li class="nav-item {{Route::is('admin.Practiceslevels.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.Practiceslevels.*')?'active':''}}">
                        <i class="nav-icon fas fa-signal"></i>
                        <p>
                            Practice levels
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.Practiceslevels.index')}}" class="nav-link  {{ Route::is('admin.Practiceslevels.index')?'active':''}}">

                                <p class="ml-3">- Practice levels </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.Practiceslevels.create')}}" class="nav-link  {{ Route::is('admin.Practiceslevels.create')?'active':''}}">

                                <p class="ml-3">- Create Practice level </p>
                            </a>
                        </li>


                    </ul>


                </li>

                </li>
                <li class="nav-item {{Route::is('admin.resultPractices.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.resultPractices.*')?'active':''}}">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>
                            Result Practices
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.resultPractices.index')}}" class="nav-link  {{ Route::is('admin.resultPractices.index')?'active':''}}">

                                <p class="ml-3">- Result Practice </p>
                            </a>
                        </li>


                    </ul>


                </li>
                <li class="nav-item {{ (Route::is('admin.courseContent.*') || Route::is('admin.course-progress.*')) ?'menu-open':''}} ">
                    <a href="#" class="nav-link {{ (Route::is('admin.courseContent.*') || Route::is('admin.course-progress.*')) ?'active':''}}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Courses
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.courseContent.index')}}" class="nav-link  {{ Route::is('admin.courseContent.index')?'active':''}}">

                                <p class="ml-3">- Courses </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.inrollments.index')}}" class="nav-link  {{ Route::is('admin.inrollments.index')?'active':''}}">

                                <p class="ml-3">- student Enrollment </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.course-progress.index')}}" class="nav-link  {{ Route::is('admin.course-progress.*')?'active':''}}">

                                <p class="ml-3">- Course Progress </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.courseContent.create')}}" class="nav-link  {{ Route::is('admin.courseContent.create')?'active':''}}">

                                <p class="ml-3">- Create Courses </p>
                            </a>
                        </li>


                    </ul>


                </li>
                <li class="nav-item {{Route::is('admin.taxonomies.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.taxonomies.*')?'active':''}}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Categories
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.taxonomies.index')}}" class="nav-link  {{ Route::is('admin.taxonomies.index')?'active':''}}">

                                <p class="ml-3">- Categories </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.taxonomies.create')}}" class="nav-link  {{ Route::is('admin.taxonomies.create')?'active':''}}">

                                <p class="ml-3">- Create Category </p>
                            </a>
                        </li>


                    </ul>


                </li>


                </li>
                <li class="nav-item {{Route::is('admin.coursePath.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.coursePath.*')?'active':''}}">
                        <i class="nav-icon fas fa-route"></i>
                        <p>
                            Course Paths
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.coursePath.index')}}" class="nav-link  {{ Route::is('admin.coursePath.index')?'active':''}}">

                                <p class="ml-3">- Course Paths </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.coursePath.create')}}" class="nav-link  {{ Route::is('admin.coursePath.create')?'active':''}}">

                                <p class="ml-3">- Create Course Paths </p>
                            </a>
                        </li>


                    </ul>


                </li>

                <li class="nav-item {{Route::is('admin.lessons.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.lessons.*')?'active':''}}">
                        <i class="nav-icon fas fa-play-circle"></i>
                        <p>
                            Lessons
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.lessons.index')}}" class="nav-link  {{ Route::is('admin.lessons.index')?'active':''}}">

                                <p class="ml-3">- Lessons </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.lessons.create')}}" class="nav-link  {{ Route::is('admin.lessons.create')?'active':''}}">

                                <p class="ml-3">- Create Lessons </p>
                            </a>
                        </li>


                    </ul>


                </li>
                <li class="nav-item {{Route::is('admin.worksheets.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.worksheets.*')?'active':''}}">
                        <i class="nav-icon fas fa-file-pdf"></i>
                        <p>
                            Worksheets
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.worksheets.index')}}" class="nav-link  {{ Route::is('admin.worksheets.index')?'active':''}}">
                                <p class="ml-3">- Worksheets </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.worksheets.create')}}" class="nav-link  {{ Route::is('admin.worksheets.create')?'active':''}}">
                                <p class="ml-3">- Upload Worksheet </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Route::is('admin.links.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.links.*')?'active':''}}">
                        <i class="nav-icon fas fa-link"></i>
                        <p>
                            Links
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.links.index')}}" class="nav-link  {{ Route::is('admin.links.index')?'active':''}}">
                                <p class="ml-3">- Links </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.links.create')}}" class="nav-link  {{ Route::is('admin.links.create')?'active':''}}">
                                <p class="ml-3">- Add Link </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Route::is('admin.instructors.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.instructors.*')?'active':''}}">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>
                            Instructors
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.instructors.index')}}" class="nav-link  {{ Route::is('admin.instructors.index')?'active':''}}">

                                <p class="ml-3">- Instructors </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.instructors.create')}}" class="nav-link  {{ Route::is('admin.instructors.create')?'active':''}}">

                                <p class="ml-3">- Create Instructor </p>
                            </a>
                        </li>


                    </ul>


                </li>

                <li class="nav-item {{Route::is('admin.students.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.students.*')?'active':''}}">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            Students
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.students2.tiles')}}" class="nav-link  {{ Route::is('admin.students2.tiles')?'active':''}}">

                                <p class="ml-3">- Students Dashboard </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.students.index')}}" class="nav-link  {{ Route::is('admin.students.index')?'active':''}}">

                                <p class="ml-3">- Students </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.students.create')}}" class="nav-link  {{ Route::is('admin.students.create')?'active':''}}">

                                <p class="ml-3">- Create Student </p>
                            </a>
                        </li>


                    </ul>


                </li>
                <li class="nav-item {{Route::is('admin.semesters.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.semesters.*')?'active':''}}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Semesters
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.semesters.index')}}" class="nav-link  {{ Route::is('admin.semesters.index')?'active':''}}">

                                <p class="ml-3">- Semesters </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.semesters.create')}}" class="nav-link  {{ Route::is('admin.semesters.create')?'active':''}}">

                                <p class="ml-3">- Create semester </p>
                            </a>
                        </li>


                    </ul>


                </li>


                <li class="nav-item {{Route::is('admin.parentts.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.parentts.*')?'active':''}}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Parents
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.parentts.index')}}" class="nav-link  {{ Route::is('admin.parentts.index')?'active':''}}">

                                <p class="ml-3">- Parents </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.parentts.create')}}" class="nav-link  {{ Route::is('admin.parentts.create')?'active':''}}">

                                <p class="ml-3">- Create Parent </p>
                            </a>
                        </li>


                    </ul>


                </li>





                <li class="nav-item {{Route::is('admin.categoryProduct.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.exercises.*')?'active':''}}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Book Exercises
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.exercises.index')}}" class="nav-link  {{ Route::is('admin.exercises.index')?'active':''}}">

                                <p class="ml-3">- Book Exercises </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.exercises.create')}}" class="nav-link  {{ Route::is('admin.exercises.create')?'active':''}}">

                                <p class="ml-3">- Create Book Exercise </p>
                            </a>
                        </li>


                    </ul>


                </li>

                <li class="nav-item {{Route::is('admin.categoryProducts.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.categoryProducts.*')?'active':''}}">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                            Category Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.categoryProducts.index')}}" class="nav-link  {{ Route::is('admin.categoryProducts.index')?'active':''}}">

                                <p class="ml-3">- Category Products </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.categoryProducts.create')}}" class="nav-link  {{ Route::is('admin.categoryProducts.create')?'active':''}}">

                                <p class="ml-3">- Create category Product </p>
                            </a>
                        </li>

                    </ul>


                </li>






                <li class="nav-item {{Route::is('admin.products.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.products.*')?'active':''}}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.products.index')}}" class="nav-link  {{ Route::is('admin.products.index')?'active':''}}">

                                <p class="ml-3">- products </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.products.create')}}" class="nav-link  {{ Route::is('admin.products.create')?'active':''}}">

                                <p class="ml-3">- Create product </p>
                            </a>
                        </li>

                    </ul>


                </li>


                <li class="nav-item {{Route::is('admin.orders.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.orders.*')?'active':''}}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            orders
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.orders.index')}}" class="nav-link  {{ Route::is('admin.orders.index')?'active':''}}">

                                <p class="ml-3">- orders </p>
                            </a>
                        </li>

                    </ul>


                </li>

                <li class="nav-item {{Route::is('admin.blogs.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.blogs.*')?'active':''}}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            blogs
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.blogs.index')}}" class="nav-link  {{ Route::is('admin.blogs.index')?'active':''}}">

                                <p class="ml-3">- blogs </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.blogs.create')}}" class="nav-link  {{ Route::is('admin.blogs.create')?'active':''}}">

                                <p class="ml-3">- Create blogs </p>
                            </a>
                        </li>
                    </ul>

                </li>
                <li class="nav-item {{Route::is('admin.userevents')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.userevents')?'active':''}}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>
                            user Events
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.userevents')}}" class="nav-link  {{ Route::is('admin.userevents')?'active':''}}">

                                <p class="ml-3">- Events </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::is('admin.importstudents.form') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.importstudents.form') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-import"></i>
                        <p>
                            Import Students
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.importstudents.form') }}"
                                class="nav-link {{ Route::is('admin.importstudents.form') ? 'active' : '' }}">
                                <p class="ml-3">Import from CSV</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Route::is('admin.instructor-notes.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.instructor-notes.*')?'active':''}}">
                        <i class="nav-icon fas fa-sticky-note"></i>
                        <p>
                            instructor notes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.instructor-notes.index')}}" class="nav-link  {{ Route::is('admin.instructor-notes.index')?'active':''}}">

                                <p class="ml-3">instructor notes </p>
                            </a>
                        </li>
                    </ul>


                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>