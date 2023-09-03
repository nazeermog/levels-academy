<?php

namespace DataSource\Http\Controllers\Admin\Dashboard;

use DataSource\Http\Controllers\BaseController;

class AdminDashboardController extends BaseController
{
 public function index(){

    return view('datasource::management.layout.dashboard');
}  
}
