<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Mail;
use App\Mail\UpdateStatusOrderMail;

class OrderController extends Controller
{
    /**
    * Update the specified resource in storage.
    *
    * @param \Illuminate\Http\Request $request request
    * @param \App\Models\Order        $order   order to update
    *
    * @return \Illuminate\Http\Response
    */
    public function changeStatus(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();
        $data['name'] = $order->user->userinfo['full_name'];
        $data['status'] = $order->status;
        Mail::to($order->user['email'])->send(new UpdateStatusOrderMail($data));
        return response()->json(['order' => $order, 'msg' => __('orders.admin.list.updated')]);
    }
}
