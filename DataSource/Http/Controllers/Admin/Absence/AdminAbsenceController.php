<?php

namespace DataSource\Http\Controllers\Admin\Absence;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use DataSource\Entities\Absence\Absence;

class AdminAbsenceController extends BaseController
{
    public function index(Request $request)
    {
        $absences = Absence::with('session')->latest('id')->paginate(25);
        return view('datasource::management.absences.index', compact('absences'));
    }
}

?>


