<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    /**
    * Update the specified resource in storage.
    *
    * @param int $id order id to change status
    *
    * @return array status code
    */
    public function changeStatus($id)
    {
        $order = Order::find($id);
        $order->status = !$order->status;
        $order->save();
        $data['status'] = (int) $order->status;
        $data['msg'] = __('orders.admin.list.updated');
        return $data;
    }
}
