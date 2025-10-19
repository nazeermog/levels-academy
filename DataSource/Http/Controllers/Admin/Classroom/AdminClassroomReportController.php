<?php

namespace DataSource\Http\Controllers\Admin\Classroom;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use DataSource\Entities\Classroom\ClassSession;
use Carbon\Carbon;

class AdminClassroomReportController extends BaseController
{
    public function instructorTotals(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $baseQuery = function () use ($currentOrg, $startOfMonth, $endOfMonth) {
            return ClassSession::with(['instructor', 'type', 'classroom'])
                ->when($currentOrg, function ($q) use ($currentOrg) {
                    $q->whereHas('classroom', function ($cq) use ($currentOrg) {
                        $cq->where('organization_id', $currentOrg->id);
                    });
                })
                ->whereBetween('held_at', [$startOfMonth, $endOfMonth]);
        };

        // Sessions list (paginated)
        $sessions = $baseQuery()->latest('held_at')->paginate(25);

        // Totals by instructor + grand total
        $all = $baseQuery()->get();
        $totals = $all->groupBy('instructor_id')->map(function ($group) {
            return [
                'instructor' => optional($group->first())->instructor,
                'sessions_count' => $group->count(),
                'amount' => $group->sum(function ($s) {
                    return optional($s->type)->price ?? 0;
                }),
            ];
        })->values();
        $grandTotal = $totals->sum('amount');

        return view('datasource::management.classrooms.report.instructor_totals', compact('sessions', 'totals', 'grandTotal', 'currentOrg', 'month'));
    }
}


