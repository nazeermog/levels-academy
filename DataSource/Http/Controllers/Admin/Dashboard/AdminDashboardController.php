<?php

namespace DataSource\Http\Controllers\Admin\Dashboard;

use DataSource\Entities\Blog\Blog;
use DataSource\Entities\Order\Order;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Lesson\Lesson;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Product\Product;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Course\CoursePath;
use DataSource\Entities\Exercise\Exercise;
use DataSource\Entities\Semester\Semester;
use DataSource\Entities\Taxonomy\Taxonomy;
use DataSource\Entities\Instructor\Instructor;
use DataSource\Http\Controllers\BaseController;
use DataSource\Entities\PracticeType\PracticeType;
use DataSource\Entities\PracticeLevel\PracticeLevel;
use DataSource\Entities\PracticeType\PracticeTypeDetail;
use DataSource\Entities\ResultPractice\ResultPractice;

class AdminDashboardController extends BaseController
{
    public function index()
    {

        $practiceTypesCount = PracticeType::count();
        $practiceLevelsCount = PracticeTypeDetail::count();
        $resultPracticesCount = ResultPractice::count();
        $coursesCount = Course::count();
        $categoriesCount = Taxonomy::count();
        $coursePathsCount = CoursePath::count();
        $lessonsCount = Lesson::count();
        $instructorsCount = Instructor::count();
        $studentsCount = Student::count();
        $semestersCount = Semester::count();
        $parentsCount = Parentt::count();
        $bookExercisesCount = Exercise::count();
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $blogsCount = Blog::count();

        return view('datasource::management.layout.dashboard', compact(
            'practiceTypesCount',
            'practiceLevelsCount',
            'resultPracticesCount',
            'coursesCount',
            'categoriesCount',
            'coursePathsCount',
            'lessonsCount',
            'instructorsCount',
            'studentsCount',
            'semestersCount',
            'parentsCount',
            'bookExercisesCount',
            'productsCount',
            'ordersCount',
            'blogsCount'
        ));
    }
}
