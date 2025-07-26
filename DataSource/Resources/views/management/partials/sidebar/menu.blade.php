<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{asset('images/logo/Levels-logo.png')}}" alt="{{ config('app.name', 'Project Name') }} Logo" class="brand-image  " height="100" width="100" style="opacity: .8">

    </a>


    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
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

                {{-- <li class="nav-item {{$url == route('admin.customers.index')?'menu-open':''}} ">--}}
                {{-- <a href="#"--}}
                {{-- class="nav-link {{$url == route('admin.customers.index')?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-users"></i>--}}
                {{-- <p>--}}
                {{-- Customers--}}
                {{-- <i class="right fas fa-angle-left"></i>--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- <ul class="nav nav-treeview">--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.customers.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.customers.index')?'active':''}}">--}}

                {{-- <p class="ml-3">- Customers</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}

                {{-- </ul>--}}

                {{-- </li>--}}


                {{-- <li class="nav-item {{$url == route('admin.orders.all')||$url == route('admin.orders.pending')||$url == route('admin.orders.scheduled')||$url == route('admin.orders.accepted')||$url == route('admin.orders.inProgress')||$url == route('admin.orders.completed')||$url == route('admin.orders.paymentFailed')||$url == route('admin.orders.refunded')||$url == route('admin.orders.canceled')?'menu-open':''}} ">--}}
                {{-- <a href="#"--}}
                {{-- class="nav-link {{$url == route('admin.orders.all')||$url == route('admin.orders.pending')||$url == route('admin.orders.scheduled')||$url == route('admin.orders.accepted')||$url == route('admin.orders.inProgress')||$url == route('admin.orders.completed')||$url == route('admin.orders.paymentFailed')||$url == route('admin.orders.refunded')||$url == route('admin.orders.canceled')?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-boxes"></i>--}}
                {{-- <p>--}}
                {{-- Orders--}}
                {{-- <i class="right fas fa-angle-left"></i>--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- <ul class="nav nav-treeview">--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.orders.all')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.orders.all')?'active':''}}">--}}

                {{-- <p class="ml-3">- All</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.orders.scheduled')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.orders.scheduled')?'active':''}}">--}}

                {{-- <p class="ml-3">- Scheduled</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.orders.pending')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.orders.pending')?'active':''}}">--}}

                {{-- <p class="ml-3">- Pending</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.orders.accepted')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.orders.accepted')?'active':''}}">--}}

                {{-- <p class="ml-3">- Accepted</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.orders.inProgress')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.orders.inProgress')?'active':''}}">--}}

                {{-- <p class="ml-3">- In Progress</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.orders.completed')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.orders.completed')?'active':''}}">--}}

                {{-- <p class="ml-3">- Completed</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.orders.canceled')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.orders.canceled')?'active':''}}">--}}

                {{-- <p class="ml-3">- Canceled</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.orders.paymentFailed')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.orders.paymentFailed')?'active':''}}">--}}

                {{-- <p class="ml-3">- Payment Failed</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.orders.refunded')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.orders.refunded')?'active':''}}">--}}

                {{-- <p class="ml-3">- Refunded</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}

                {{-- </ul>--}}

                {{-- </li>--}}


                {{-- <li class="nav-item {{$url == route('admin.vouchers.index')?'menu-open':''}} ">--}}
                {{-- <a href="#"--}}
                {{-- class="nav-link {{$url == route('admin.vouchers.index')||$url == route('admin.vouchers.create')||$url == route('admin.vouchers.show',['id'=>$param])?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-user-tag"></i>--}}
                {{-- <p>--}}
                {{-- Vouchers--}}
                {{-- <i class="right fas fa-angle-left"></i>--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- <ul class="nav nav-treeview">--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.vouchers.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.vouchers.index')?'active':''}}">--}}

                {{-- <p class="ml-3">- Vouchers</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.vouchers.create')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.vouchers.create')?'active':''}}">--}}

                {{-- <p class="ml-3">- Add Voucher</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}

                {{-- </ul>--}}

                {{-- </li>--}}
                {{-- <li class="nav-item {{$url == route('admin.brands.index')||$url == route('admin.brands.edit',['id'=>$param])||$url == route('admin.brands.create')?'menu-open':''}} ">--}}
                {{-- <a href="#"--}}
                {{-- class="nav-link {{$url == route('admin.brands.index')||$url == route('admin.brands.create')||$url == route('admin.brands.edit',['id'=>$param])?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-car-alt"></i>--}}
                {{-- <p>--}}
                {{-- Brands--}}

                {{-- </p>--}}
                {{-- </a>--}}
                {{-- <ul class="nav nav-treeview">--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.brands.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.brands.index')?'active':''}}">--}}

                {{-- <p class="ml-3">- Brands</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- </ul>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item {{$url == route('admin.carModels.index')||$url == route('admin.carModels.edit',['id'=>$param])||$url == route('admin.carModels.create')?'menu-open':''}} ">--}}
                {{-- <a href="#"--}}
                {{-- class="nav-link {{$url == route('admin.carModels.index')||$url == route('admin.carModels.create')||$url == route('admin.carModels.edit',['id'=>$param])?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-car-side"></i>--}}
                {{-- <p>--}}
                {{-- Car Models--}}

                {{-- </p>--}}
                {{-- </a>--}}
                {{-- <ul class="nav nav-treeview">--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.carModels.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.carModels.index')?'active':''}}">--}}

                {{-- <p class="ml-3">- Car Models</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- </ul>--}}
                {{-- </li>--}}

                {{-- <li class="nav-item {{$url == route('admin.vehicles.index')?'menu-open':''}} ">--}}
                {{-- <a href="#"--}}
                {{-- class="nav-link {{$url == route('admin.vehicles.index')?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-car"></i>--}}
                {{-- <p>--}}
                {{-- Vehicles--}}
                {{-- <i class="right fas fa-angle-left"></i>--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- <ul class="nav nav-treeview">--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.vehicles.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.vehicles.index')?'active':''}}">--}}

                {{-- <p class="ml-3">- Vehicles</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}


                {{-- </ul>--}}

                {{-- </li>--}}
                {{-- <li class="nav-item {{$url == route('admin.products.index')||$url == route('admin.products.create')||$url == route('admin.products.show',['id'=>$param])||$url == route('admin.variations.index')||$url == route('admin.variations.create')||$url == route('admin.variations.show',['id'=>$param])||$url == route('admin.collections.index')||$url == route('admin.collections.create')||$url == route('admin.collections.show',['id'=>$param])?'menu-open':''}} ">--}}
                {{-- <a href="#"--}}
                {{-- class="nav-link {{$url == route('admin.products.index')||$url == route('admin.products.create')||$url == route('admin.products.show',['id'=>$param])||$url == route('admin.variations.index')||$url == route('admin.variations.create')||$url == route('admin.variations.show',['id'=>$param])||$url == route('admin.collections.index')||$url == route('admin.collections.create')||$url == route('admin.collections.show',['id'=>$param])?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-spray-can"></i>--}}
                {{-- <p>--}}
                {{-- Products--}}
                {{-- <i class="right fas fa-angle-left"></i>--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- <ul class="nav nav-treeview">--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.collections.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.collections.index')||$url == route('admin.collections.create')||$url == route('admin.collections.show',['id'=>$param])?'active':''}}">--}}

                {{-- <p class="ml-3">- Collections</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.products.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.products.index')||$url == route('admin.products.create')||$url == route('admin.products.show',['id'=>$param])?'active':''}}">--}}

                {{-- <p class="ml-3">- Products</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.variations.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.variations.index')||$url == route('admin.variations.create')||$url == route('admin.variations.show',['id'=>$param])?'active':''}}">--}}

                {{-- <p class="ml-3">- Variations</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}


                {{-- </ul>--}}

                {{-- </li>--}}
                {{-- <li class="nav-item {{$url == route('admin.productCategories.index')||$url == route('admin.providerCategories.index')||$url == route('admin.providerCategories.create')||$url == route('admin.providerCategories.edit',['id'=>$param])||$url == route('admin.serviceCategories.edit',['id'=>$param])||$url == route('admin.serviceCategories.create')||$url == route('admin.productCategories.create')||$url == route('admin.serviceCategories.index')||$url == route('admin.helpCenterCategory.index')||$url == route('admin.helpCenterCategory.create')||$url == route('admin.helpCenterCategory.edit',['id'=>$param])||$url == route('admin.sizeCategories.index')||$url == route('admin.sizeCategories.create')||$url == route('admin.sizeCategories.edit',['id'=>$param])?'menu-open':''}} ">--}}
                {{-- <a href="#"--}}
                {{-- class="nav-link {{$url == route('admin.providerCategories.index')||$url == route('admin.productCategories.index')||$url == route('admin.providerCategories.create')||$url == route('admin.providerCategories.edit',['id'=>$param])||$url == route('admin.serviceCategories.edit',['id'=>$param])||$url == route('admin.serviceCategories.create')||$url == route('admin.productCategories.create')||$url == route('admin.serviceCategories.index')||$url == route('admin.helpCenterCategory.index')||$url == route('admin.helpCenterCategory.create')||$url == route('admin.helpCenterCategory.edit',['id'=>$param])||$url == route('admin.sizeCategories.index')||$url == route('admin.sizeCategories.create')||$url == route('admin.sizeCategories.edit',['id'=>$param])?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-list"></i>--}}
                {{-- <p>--}}
                {{-- Categories--}}
                {{-- <i class="right fas fa-angle-left"></i>--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- <ul class="nav nav-treeview">--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.providerCategories.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.providerCategories.index')||$url == route('admin.providerCategories.edit',['id'=>$param])?'active':''}}">--}}

                {{-- <p class="ml-3">- Categories</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.providerCategories.create')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.providerCategories.create')?'active':''}}">--}}

                {{-- <p class="ml-3">- Add Category</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.serviceCategories.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.serviceCategories.index')||$url == route('admin.serviceCategories.edit',['id'=>$param])?'active':''}}">--}}

                {{-- <p class="ml-3">- Service Categories</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.serviceCategories.create')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.serviceCategories.create')?'active':''}}">--}}

                {{-- <p class="ml-3">- Add Service Category</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.productCategories.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.productCategories.index')||$url == route('admin.productCategories.edit',['id'=>$param])?'active':''}}">--}}

                {{-- <p class="ml-3">- Product Categories</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.productCategories.create')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.productCategories.create')?'active':''}}">--}}

                {{-- <p class="ml-3">- Add Product Category</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.sizeCategories.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.sizeCategories.index')||$url == route('admin.sizeCategories.edit',['id'=>$param])?'active':''}}">--}}

                {{-- <p class="ml-3">- Size Categories</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.sizeCategories.create')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.sizeCategories.create')?'active':''}}">--}}

                {{-- <p class="ml-3">- Add Size Category</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.helpCenterCategory.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.helpCenterCategory.index')||$url == route('admin.helpCenterCategory.edit',['id'=>$param])?'active':''}}">--}}

                {{-- <p class="ml-3">- Help Center Category</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.helpCenterCategory.create')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.helpCenterCategory.create')?'active':''}}">--}}

                {{-- <p class="ml-3">- Add Help Center Category</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- </ul>--}}

                {{-- </li>--}}

                {{-- <li class="mt-1 mb-1 p-0 w-100" style="border-bottom: 1px solid #4b545c;">--}}

                {{-- </li>--}}
                {{-- <li class="nav-item {{$url == route('admin.transactions.index')||$url == route('admin.transactions.GuestPayout')||$url == route('admin.transactions.edit',['id'=>$param])?'menu-open':''}} ">--}}
                {{-- <a href="#"--}}
                {{-- class="nav-link {{$url == route('admin.transactions.index')||$url == route('admin.transactions.GuestPayout')||$url == route('admin.transactions.edit',['id'=>$param])?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-money-bill"></i>--}}
                {{-- <p>--}}
                {{-- Payments--}}
                {{-- <i class="right fas fa-angle-left"></i>--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- <ul class="nav nav-treeview">--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.transactions.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.transactions.index')?'active':''}}">--}}

                {{-- <p class="ml-3">- Payment History</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.transactions.GuestPayout')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.transactions.GuestPayout')?'active':''}}">--}}

                {{-- <p class="ml-3">- Guest Payout</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- </ul>--}}

                {{-- </li>--}}

                {{-- <li class="mt-1 mb-1 p-0 w-100" style="border-bottom: 1px solid #4b545c;">--}}

                {{-- </li>--}}


                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('users.index')}}"--}}
                {{-- class="nav-link {{$url == route('users.index')||$url == route('users.create')||$url == route('users.edit',['users'=>$param])?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-users-cog"></i>--}}
                {{-- <p>--}}
                {{-- Users--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item {{$url == route('admin.feedbacks.show',['id'=>$param])||$url == route('admin.feedbacks.index')||$url == route('admin.privacyPolicy.edit',['id'=>$param])||$url == route('admin.privacyPolicy.index')||$url == route('admin.privacyPolicy.create')||$url == route('admin.termsUse.edit',['id'=>$param])||$url == route('admin.termsUse.index')||$url == route('admin.termsUse.create')||$url == route('admin.faqs.edit',['id'=>$param])||$url == route('admin.faqs.index')||$url == route('admin.faqs.create')?'menu-open':''}} ">--}}
                {{-- <a href="#"--}}
                {{-- class="nav-link {{$url == route('admin.feedbacks.show',['id'=>$param])||$url == route('admin.feedbacks.index')||$url == route('admin.privacyPolicy.edit',['id'=>$param])||$url == route('admin.privacyPolicy.index')||$url == route('admin.privacyPolicy.create')||$url == route('admin.termsUse.edit',['id'=>$param])||$url == route('admin.termsUse.index')||$url == route('admin.termsUse.create')||$url == route('admin.faqs.edit',['id'=>$param])||$url == route('admin.faqs.index')||$url == route('admin.faqs.create')?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-question-circle"></i>--}}
                {{-- <p>--}}
                {{-- About Us--}}
                {{-- <i class="right fas fa-angle-left"></i>--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- <ul class="nav nav-treeview">--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.feedbacks.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.feedbacks.index')?'active':''}}">--}}

                {{-- <p class="ml-3">- Feedbacks</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.faqs.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.faqs.index')||$url == route('admin.faqs.create')?'active':''}}">--}}

                {{-- <p class="ml-3">- Faqs</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.termsUse.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.termsUse.index')||$url == route('admin.termsUse.create')?'active':''}}">--}}

                {{-- <p class="ml-3">- Terms Of Use</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.privacyPolicy.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.privacyPolicy.index')||$url == route('admin.privacyPolicy.create')?'active':''}}">--}}

                {{-- <p class="ml-3">- Privacy Policy</p>--}}
                {{-- </a>--}}
                {{-- </li>--}}


                {{-- </ul>--}}

                {{-- </li>--}}

                {{-- <li class="mt-1 mb-1 p-0 w-100" style="border-bottom: 1px solid #4b545c;">--}}

                {{-- </li>--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.ads.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.ads.edit',['id'=>$param])||$url == route('admin.ads.index')||$url == route('admin.ads.create')?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-ad"></i>--}}
                {{-- <p>--}}
                {{-- Ads--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('admin.badges.index')}}"--}}
                {{-- class="nav-link  {{$url == route('admin.badges.edit',['id'=>$param])||$url == route('admin.badges.index')||$url == route('admin.badges.create')?'active':''}}">--}}
                {{-- <i class="nav-icon fas fa-icons"></i>--}}
                {{-- <p>--}}
                {{-- Badges--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- </li>--}}

                {{-- <li class="nav-item">--}}
                {{-- <a href="{{route('logout')}}" class="nav-link">--}}
                {{-- <i class="nav-icon fas fa-sign-out-alt"></i>--}}
                {{-- <p>--}}
                {{-- Logout--}}
                {{-- </p>--}}
                {{-- </a>--}}
                {{-- </li>--}}

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>