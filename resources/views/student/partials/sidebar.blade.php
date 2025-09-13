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

@if(session('locale', config('app.locale')) == 'ar')
<div class="mdk-drawer js-mdk-drawer" id="default-drawer" data-position="left">
  <div class="mdk-drawer__content top-navbar">
    <div class="sidebar sidebar-dark sidebar-left sidebar-p-t" data-perfect-scrollbar dir="rtl">
      <!-- Sidebar Content -->
      <div class="sidebar-heading font-droid">
        الطالب
      </div>
      <ul class="sidebar-menu">
        <!-- <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.dashboard') }}">
            <span class="material-icons sidebar-menu-icon">home</span>
            <span class="sidebar-menu-text">لوحة التحكم</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.inrollment.index') }}">
            <span class="material-icons sidebar-menu-icon">school</span>
            <span class="sidebar-menu-text">الدورات المشتراة</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.paths.index') }}">
            <span class="material-icons sidebar-menu-icon">timeline</span>
            <span class="sidebar-menu-text">مسارات التعليم</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.practice.index') }}">
            <span class="material-icons sidebar-menu-icon">assignment</span>
            <span class="sidebar-menu-text">تمارين</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.exercise') }}">
            <span class="material-icons sidebar-menu-icon">menu_book</span>
            <span class="sidebar-menu-text">تمارين الكتاب</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.Bookexercise') }}">
            <span class="material-icons sidebar-menu-icon">library_books</span>
            <span class="sidebar-menu-text">جميع تمارين الكتاب</span>
          </a>
        </li>-->
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.Bookexercise.pages.qr') }}">
            <span class="material-icons sidebar-menu-icon">import_contacts</span>
            <span class="sidebar-menu-text">جميع تمارين الكتاب</span>
          </a>
        </li>
        <!-- <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.products') }}">
            <span class="material-icons sidebar-menu-icon">folder</span>
            <span class="sidebar-menu-text">المنتجات</span>
          </a>
        </li>  -->
      </ul>
    </div>
  </div>
</div>

@elseif (session('locale', config('app.locale')) == 'de')
<div class="mdk-drawer js-mdk-drawer" id="default-drawer" data-position="left">
  <div class="mdk-drawer__content top-navbar">
    <div class="sidebar sidebar-dark sidebar-left sidebar-p-t" data-perfect-scrollbar dir="ltr">
      <!-- Sidebar Content -->
      <div class="sidebar-heading font-droid">
        Student
      </div>
      <ul class="sidebar-menu">
        <!-- <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.dashboard') }}">
            <span class="material-icons sidebar-menu-icon">home</span>
            <span class="sidebar-menu-text">Dashboard</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.inrollment.index') }}">
            <span class="material-icons sidebar-menu-icon">school</span>
            <span class="sidebar-menu-text">Gekaufte Kurse</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.paths.index') }}">
            <span class="material-icons sidebar-menu-icon">timeline</span>
            <span class="sidebar-menu-text">Bildungswege</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.practice.index') }}">
            <span class="material-icons sidebar-menu-icon">assignment</span>
            <span class="sidebar-menu-text">Übungen</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.exercise') }}">
            <span class="material-icons sidebar-menu-icon">menu_book</span>
            <span class="sidebar-menu-text">Buch Übungen</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.Bookexercise') }}">
            <span class="material-icons sidebar-menu-icon">library_books</span>
            <span class="sidebar-menu-text">Alle Buch Übungen</span>
          </a>
        </li> -->
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.Bookexercise.pages.qr') }}">
            <span class="material-icons sidebar-menu-icon">import_contacts</span>
            <span class="sidebar-menu-text">Alle Buch Übungen</span>
          </a>
        </li>
        <!-- <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.products') }}">
            <span class="material-icons sidebar-menu-icon">folder</span>
            <span class="sidebar-menu-text">Produkte</span>
          </a>
        </li> -->
      </ul>
    </div>
  </div>
</div>

@elseif (session('locale', config('app.locale')) == 'en')
<div class="mdk-drawer js-mdk-drawer" id="default-drawer" data-position="left">
  <div class="mdk-drawer__content top-navbar">
    <div class="sidebar sidebar-dark sidebar-left sidebar-p-t" data-perfect-scrollbar dir="ltr">
      <!-- Sidebar Content -->
      <div class="sidebar-heading font-droid">
        Student
      </div>
      <ul class="sidebar-menu">
        <!-- <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.dashboard') }}">
            <span class="material-icons sidebar-menu-icon">home</span>
            <span class="sidebar-menu-text">Dashboard</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.inrollment.index') }}">
            <span class="material-icons sidebar-menu-icon">school</span>
            <span class="sidebar-menu-text">Bower Courses</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.paths.index') }}">
            <span class="material-icons sidebar-menu-icon">timeline</span>
            <span class="sidebar-menu-text">Education Paths</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.practice.index') }}">
            <span class="material-icons sidebar-menu-icon">assignment</span>
            <span class="sidebar-menu-text">Exercises</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.exercise') }}">
            <span class="material-icons sidebar-menu-icon">menu_book</span>
            <span class="sidebar-menu-text">Book Exercises</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.Bookexercise') }}">
            <span class="material-icons sidebar-menu-icon">library_books</span>
            <span class="sidebar-menu-text">All Book Exercises</span>
          </a>
        </li> -->
        <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.Bookexercise.pages.qr') }}">
            <span class="material-icons sidebar-menu-icon">import_contacts</span>
            <span class="sidebar-menu-text">All Book Exercises</span>
          </a>
        </li>
        <!-- <li class="sidebar-menu-item">
          <a class="sidebar-menu-button" href="{{ route('student.index.products') }}">
            <span class="material-icons sidebar-menu-icon">folder</span>
            <span class="sidebar-menu-text">Products</span>
          </a>
        </li> -->
      </ul>
    </div>
  </div>
</div>
@endif