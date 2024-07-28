<?php

namespace DataSource\Http\Controllers\Admin\Order;

use Illuminate\Http\Request;
use DataSource\Entities\Order\Order;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Order\Update;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Order\Admin\AdminOrderRepository;


class AdminOrderController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.orders';
    protected string $table_name = 'orders';
    protected string $route_name = 'orders';
    protected string $interface = AdminOrderRepository::class;
    protected string $update_request = Update::class;

    public function show($id)
    {
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        $item = $this->getRepository()->find($id);
        return view($this->module . '.show', compact('route_name', 'table_name', 'item'));
    }

    public function acceptOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = 'accepted';
        $order->save();

        return redirect()->back()->with('success', 'Order accepted successfully!');
    }

    public function rejectOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = 'rejected';
        $order->price = 0;
        $order->save();

        return redirect()->back()->with('success', 'Order rejected successfully!');
    }
    public function update(Request $request, $orderId)
    {
        // Find the order by ID
        $order = Order::findOrFail($orderId);

        // Validate the status
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $newStatus = $request->input('status');

        if ($newStatus == 'rejected') {
            $order->price = 0;
            $order->status = $newStatus;
        }
        if ($newStatus == 'approved' || $newStatus == 'pending') {
            $order->price = $order->product->price;
            $order->status = $newStatus;
        }
        $order->save();
        return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully!');
    }
}
