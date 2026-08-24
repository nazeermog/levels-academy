<?php

namespace Modules\StudentActivity\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\User\UserEvent;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\Transaction\Transaction;
use DataSource\Entities\Instructor\InstructorNote;
use Modules\StudentActivity\Http\Requests\AddMoneyRequest;

class ParenttTransactionController extends Controller
{

  public function transactions()
  {
    $parent = Parentt::find(Auth::id());
    if (!$parent) {
      return redirect()->back()->withError('Parent not found.');
    }

    return view('studentactivity::transaction', $this->buildReport($parent));
  }

  /**
   * Downloadable PDF of the same transactions report.
   */
  public function transactionsPdf()
  {
    $parent = Parentt::find(Auth::id());
    if (!$parent) {
      return redirect()->back()->withError('Parent not found.');
    }

    $data = $this->buildReport($parent);
    $data['generatedAt'] = now();
    $data['appName'] = config('app.name');

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('studentactivity::transaction_pdf', $data)
      ->setPaper('a4', 'portrait');

    return $pdf->download('transactions-report.pdf');
  }

  /**
   * Build the parent's financial statement: every transaction plus the paid /
   * charged / balance totals. A credit (is_credit=1) is a payment in; a debit
   * (is_credit=0) is a charge owed. Balance = paid - charged (negative = owed).
   */
  private function buildReport(Parentt $parent): array
  {
    $list = $parent->transactions()->with(['student', 'course'])
      ->orderBy('created_at', 'desc')
      ->get();

    $totalPaid    = (float) $list->where('is_credit', 1)->sum('price');
    $totalCharged = (float) $list->where('is_credit', 0)->sum('price');

    return [
      'table_name'   => 'Transactions',
      'list'         => $list,
      'totalPaid'    => $totalPaid,
      'totalCharged' => $totalCharged,
      'balance'      => $totalPaid - $totalCharged,
      'parentName'   => trim(($parent->first_name ?? '') . ' ' . ($parent->last_name ?? '')),
    ];
  }

  public function showAddMoney()
  {
    $table_name = 'Add Money';
    $parentId = Auth::id();
    $parent = Parentt::findOrFail($parentId);
    $balance = $parent->balance();

    return view('studentactivity::addmoney', compact('table_name', 'parent', 'balance'));
  }
  public function addMoney(AddMoneyRequest $request)
  {
    $Transaction = Transaction::create([
      'parent_id'   => auth()->id(),
      'price'    => $request->price,
      'is_credit' => 1, // means money in
      'desc' => $request->desc,
    ]);
    return back()->with('success', 'Money added successfully!');
  }
}
