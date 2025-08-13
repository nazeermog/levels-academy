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
    $parentId = Auth::id();
    $parent = Parentt::find($parentId);

    if (!$parent) {
      return redirect()->back()->withError('Parent not found.');
    }

    $list = $parent->transactions()->with(['student', 'course'])
      ->orderBy('created_at', 'desc')
      ->get();

    $table_name = 'Transactions';
    $balance = $parent->balance();

    return view('studentactivity::transaction', compact('list', 'table_name', 'balance'));
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
