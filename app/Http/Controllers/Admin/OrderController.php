<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = config('define.post.limit_rows');
        $orders = Order::when(isset($request->order_status), function ($query) use ($request) {
            return $query->where('status', '=', $request->order_status);
        })->when(isset($request->order_by_total), function ($query) use ($request) {
            return $query->orderBy('total', $request->order_by_total);
        })
        ->with(['user'])->paginate($perPage);
        $orders->appends(request()->query());
        $data['orders'] = $orders;
        return view('admin.pages.orders.index', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id order id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $perPage = config('define.post.limit_rows');
        $orderDetails = Order::find($id)->orderDetails()->with(['product' => function ($query) {
            return $query->with('images');
        }])->paginate($perPage);
        $data['orders'] = $orderDetails;
        $data['order_id'] = $id;
        return view('admin.pages.orders.show', $data);
    }
}
