<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{asset('images/logo/Levels-logo.png')}}" alt="{{ config('app.name', 'Project Name') }} Logo" class="brand-image  " height="100" width="100" style="opacity: .8">

    </a>


    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if(auth()->check() && auth()->user()->role === 'admin')
                <li class="nav-item {{ Route::is('admin.org.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.org.dashboard') }}" class="nav-link {{ Route::is('admin.org.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Organization Dashboard</p>
                    </a>
                </li>
                @endif
                @if(auth()->check() && auth()->user()->role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.org.users.index') }}" class="nav-link {{ Route::is('admin.org.users.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Organization Users</p>
                    </a>
                </li>
                @endif
                @if(auth()->check() && auth()->user()->role === 'admin' && isset($currentOrganization) && $currentOrganization && $currentOrganization->subdomain === 'yasmine')
                <li class="nav-item {{Route::is('admin.org.instructor-notes.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.org.instructor-notes.*')?'active':''}}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Instructor notes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.org.instructor-notes.index')}}" class="nav-link  {{ Route::is('admin.org.instructor-notes.index')?'active':''}}">

                                <p class="ml-3">instructor notes </p>
                            </a>
                        </li>
                    </ul>


                </li>
                @endif
                @if(auth()->check() && auth()->user()->role === 'super_admin')
                <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{Route::is('admin.organizations.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.organizations.*')?'active':''}}">
                        <i class="nav-icon fas fa-sitemap"></i>
                        <p>
                            organizations
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('admin.organizations.index')}}" class="nav-link  {{ Route::is('admin.organizations.index')?'active':''}}">

                                <p class="ml-3">- organizations </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.organizations.create')}}" class="nav-link  {{ Route::is('admin.organizations.create')?'active':''}}">

                                <p class="ml-3">- Create organizations  </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Route::is('admin.practices.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.practices.*')?'active':''}}">
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                <li class="nav-item {{Route::is('admin.courseContent.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.courseContent.*')?'active':''}}">
                        <i class="nav-icon fas fa-user-circle"></i>
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
                            <a href="{{route('admin.courseContent.create')}}" class="nav-link  {{ Route::is('admin.courseContent.create')?'active':''}}">

                                <p class="ml-3">- Create Courses </p>
                            </a>
                        </li>


                    </ul>


                </li>
                <li class="nav-item {{Route::is('admin.taxonomies.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.taxonomies.*')?'active':''}}">
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                <li class="nav-item {{Route::is('admin.instructors.*')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{Route::is('admin.instructors.*')?'active':''}}">
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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
                        <i class="nav-icon fas fa-user-circle"></i>
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