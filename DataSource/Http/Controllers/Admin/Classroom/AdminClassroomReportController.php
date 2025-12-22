<?php

namespace DataSource\Http\Controllers\Admin\Classroom;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Classroom\Classroom;
use DataSource\Entities\Classroom\ClassSessionType;
use DataSource\Entities\User\User;
use DataSource\Entities\Transaction\Transaction;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Student\Student;
use Carbon\Carbon;

class AdminClassroomReportController extends BaseController
{
    public function instructorTotals(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $instructorId = $request->input('instructor_id');
        $classroomId = $request->input('classroom_id');
        $typeId = $request->input('class_session_type_id');
        $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $baseQuery = function () use ($currentOrg, $startOfMonth, $endOfMonth, $instructorId, $classroomId, $typeId) {
            return ClassSession::with(['instructor', 'type', 'classroom'])
                ->when($currentOrg, function ($q) use ($currentOrg) {
                    $q->whereHas('classroom', function ($cq) use ($currentOrg) {
                        $cq->where('organization_id', $currentOrg->id);
                    });
                })
                ->when(!empty($instructorId), function ($q) use ($instructorId) {
                    $q->where('instructor_id', $instructorId);
                })
                ->when(!empty($classroomId), function ($q) use ($classroomId) {
                    $q->where('classroom_id', $classroomId);
                })
                ->when(!empty($typeId), function ($q) use ($typeId) {
                    $q->where('class_session_type_id', $typeId);
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
                    return optional($s->type)->teacher_payout ?? 0;
                }),
            ];
        })->values();
        $grandTotal = $totals->sum('amount');

        // Dropdown data
        $instructorIds = ClassSession::when($currentOrg, function ($q) use ($currentOrg) {
                $q->whereHas('classroom', function ($cq) use ($currentOrg) {
                    $cq->where('organization_id', $currentOrg->id);
                });
            })
            ->distinct()
            ->pluck('instructor_id')
            ->filter()
            ->values();
        $instructors = User::whereIn('id', $instructorIds)->orderBy('first_name')->get();
        $classrooms = Classroom::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();
        $types = ClassSessionType::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();

        return view('datasource::management.classrooms.report.instructor_totals', compact(
            'sessions',
            'totals',
            'grandTotal',
            'currentOrg',
            'month',
            'instructorId',
            'classroomId',
            'typeId',
            'instructors',
            'classrooms',
            'types'
        ));
    }

    public function profit(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $instructorId = $request->input('instructor_id');
        $classroomId = $request->input('classroom_id');
        $typeId = $request->input('class_session_type_id');
        $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $sessions = ClassSession::with(['type', 'classroom', 'instructor'])
            ->when($currentOrg, function ($q) use ($currentOrg) {
                $q->whereHas('classroom', function ($cq) use ($currentOrg) {
                    $cq->where('organization_id', $currentOrg->id);
                });
            })
            ->when(!empty($instructorId), function ($q) use ($instructorId) {
                $q->where('instructor_id', $instructorId);
            })
            ->when(!empty($classroomId), function ($q) use ($classroomId) {
                $q->where('classroom_id', $classroomId);
            })
            ->when(!empty($typeId), function ($q) use ($typeId) {
                $q->where('class_session_type_id', $typeId);
            })
            ->whereBetween('held_at', [$startOfMonth, $endOfMonth])
            ->get();

        $sessionIds = $sessions->pluck('id')->all();

        // Pull all transactions for month and match those referencing our sessions (by description)
        $monthlyTx = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        $txBySession = $monthlyTx->mapWithKeys(function ($t) {
            if (!is_string($t->desc)) {
                return [null => null];
            }
            if (preg_match('/Class session #(\d+)/i', $t->desc, $m)) {
                return [(int) $m[1] => $t];
            }
            return [null => null];
        })->filter(function ($v, $k) {
            return $k !== null;
        })->groupBy(function ($t, $sid) {
            return $sid;
        });

        // Revenue: sum of charges (is_credit = 0) on transactions linked to our sessions
        $revenue = collect($sessionIds)->sum(function ($sid) use ($txBySession) {
            $list = $txBySession->get($sid, collect());
            return $list->where('is_credit', 0)->sum('price');
        });

        // Payouts: sum teacher_payout for the sessions
        $payouts = $sessions->sum(function ($s) {
            return optional($s->type)->teacher_payout ?? 0;
        });

        $profit = $revenue - $payouts;

        // Breakdown by classroom
        $byClassroom = $sessions->groupBy('classroom_id')->map(function ($group, $classroomId) use ($txBySession) {
            $sessionIds = $group->pluck('id');
            $revenue = $sessionIds->sum(function ($sid) use ($txBySession) {
                $list = $txBySession->get($sid, collect());
                return $list->where('is_credit', 0)->sum('price');
            });
            $payouts = $group->sum(function ($s) {
                return optional($s->type)->teacher_payout ?? 0;
            });
            return [
                'classroom' => optional($group->first())->classroom,
                'sessions_count' => $group->count(),
                'revenue' => $revenue,
                'payouts' => $payouts,
                'profit' => $revenue - $payouts,
            ];
        })->values();

        // Breakdown by type
        $byType = $sessions->groupBy('class_session_type_id')->map(function ($group, $typeId) use ($txBySession) {
            $sessionIds = $group->pluck('id');
            $revenue = $sessionIds->sum(function ($sid) use ($txBySession) {
                $list = $txBySession->get($sid, collect());
                return $list->where('is_credit', 0)->sum('price');
            });
            $payouts = $group->sum(function ($s) {
                return optional($s->type)->teacher_payout ?? 0;
            });
            return [
                'type' => optional($group->first())->type,
                'sessions_count' => $group->count(),
                'revenue' => $revenue,
                'payouts' => $payouts,
                'profit' => $revenue - $payouts,
            ];
        })->values();

        // Dropdown data
        $instructorIds = ClassSession::when($currentOrg, function ($q) use ($currentOrg) {
                $q->whereHas('classroom', function ($cq) use ($currentOrg) {
                    $cq->where('organization_id', $currentOrg->id);
                });
            })
            ->distinct()
            ->pluck('instructor_id')
            ->filter()
            ->values();
        $instructors = User::whereIn('id', $instructorIds)->orderBy('first_name')->get();
        $classrooms = Classroom::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();
        $types = ClassSessionType::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();

        return view('datasource::management.classrooms.report.profit', compact(
            'currentOrg',
            'month',
            'instructorId',
            'classroomId',
            'typeId',
            'revenue',
            'payouts',
            'profit',
            'byClassroom',
            'byType',
            'instructors',
            'classrooms',
            'types'
        ));
    }

    public function studentDues(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $studentId = $request->input('student_id');
        $parentId = $request->input('parent_id');
        $classroomId = $request->input('classroom_id');
        $typeId = $request->input('class_session_type_id');
        $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $sessions = ClassSession::with(['classroom'])
            ->when($currentOrg, function ($q) use ($currentOrg) {
                $q->whereHas('classroom', function ($cq) use ($currentOrg) {
                    $cq->where('organization_id', $currentOrg->id);
                });
            })
            ->when(!empty($classroomId), function ($q) use ($classroomId) {
                $q->where('classroom_id', $classroomId);
            })
            ->when(!empty($typeId), function ($q) use ($typeId) {
                $q->where('class_session_type_id', $typeId);
            })
            ->whereBetween('held_at', [$startOfMonth, $endOfMonth])
            ->get();
        $sessionIds = $sessions->pluck('id')->all();

        $txQuery = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        if (!empty($studentId)) {
            $txQuery->where('student_id', $studentId);
        }
        if (!empty($parentId)) {
            $txQuery->where('parent_id', $parentId);
        }
        $monthlyTx = $txQuery->get();

        // Include all monthly transactions, but if a transaction references a session,
        // only include it when that session belongs to the current org.
        $sessionIdSet = array_flip($sessionIds);
        $filtered = $monthlyTx->filter(function ($t) use ($sessionIdSet, $currentOrg, $classroomId, $typeId) {
            if (!is_string($t->desc)) {
                // Not a session-based transaction; include only if no explicit classroom/type filter
                return empty($classroomId) && empty($typeId);
            }
            if (preg_match('/Class session #(\d+)/i', $t->desc, $m)) {
                $sid = (int) $m[1];
                // Include only if session belongs to current org (or no org scoping)
                return isset($sessionIdSet[$sid]) || !$currentOrg;
            }
            // No detectable session link; include it
            return empty($classroomId) && empty($typeId);
        })->values();

        // Group by student + parent
        $grouped = $filtered->groupBy(function ($t) {
            return ($t->student_id ?? '0') . '-' . ($t->parent_id ?? '0');
        });

        $studentIds = $grouped->map(function ($g) {
            return optional($g->first())->student_id;
        })->filter()->unique()->values()->all();
        $parentIds = $grouped->map(function ($g) {
            return optional($g->first())->parent_id;
        })->filter()->unique()->values()->all();

        $students = Student::whereIn('user_id', $studentIds)->get()->keyBy('user_id');
        $parents = Parentt::whereIn('user_id', $parentIds)->get()->keyBy('user_id');

        $rows = $grouped->map(function ($items, $key) use ($students, $parents) {
            $studentId = optional($items->first())->student_id;
            $parentId = optional($items->first())->parent_id;
            $charges = $items->where('is_credit', 0)->sum('price');
            $credits = $items->where('is_credit', 1)->sum('price');
            return [
                'student' => $students->get($studentId),
                'parent' => $parents->get($parentId),
                'student_id' => $studentId,
                'parent_id' => $parentId,
                'transactions_count' => $items->count(),
                'charges' => $charges,
                'credits' => $credits,
                'net' => $charges - $credits,
            ];
        })->sortByDesc('net')->values();

        // Dropdown data for filters
        $classrooms = Classroom::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();
        $types = ClassSessionType::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();
        $studentUserIds = Classroom::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->with('students')->get()->flatMap(function ($c) {
                return $c->students->pluck('id');
            })->unique()->values();
        $studentsList = Student::whereIn('user_id', $studentUserIds)->orderBy('first_name')->get();
        $parentIds = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->distinct()->pluck('parent_id')->filter();
        $parentsList = Parentt::whereIn('user_id', $parentIds)->orderBy('first_name')->get();

        return view('datasource::management.classrooms.report.student_dues', compact(
            'currentOrg',
            'month',
            'studentId',
            'parentId',
            'classroomId',
            'typeId',
            'rows',
            'classrooms',
            'types',
            'studentsList',
            'parentsList'
        ));
    }
}


