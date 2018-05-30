<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $perPage = config('define.order.limit_rows');
        $orders = Order::when(isset($request->order_status), function ($query) use ($request) {
            return $query->where('status', '=', $request->order_status);
        })->when(isset($request->sortBy) && isset($request->dir), function ($query) use ($request) {
            return $query->orderBy($request->sortBy, $request->dir);
        })
        ->with(['user' => function ($query) {
            return $query->with('userInfo');
        }])->withCount('orderdetails')->paginate($perPage);

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
        $perPage = config('define.order.limit_rows');
        $order = Order::with(['user' => function ($query) {
            return $query->with('userInfo');
        }])->withCount('orderdetails')->find($id);

        $orderDetails = Order::find($id)->orderDetails()->with(['product' => function ($query) {
            return $query->with('images');
        }])->paginate($perPage);
        $data['orderInfo'] = $order;
        $data['orders'] = $orderDetails;
        return view('admin.pages.orders.show', $data);
    }

    /**
    * Remove the specified resource from storage.
     *
     * @param int $id order id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->orderDetails()->delete();
            $order->delete();
            session(['message' => __('orders.admin.list.deleted')]);
        } catch (ModelNotFoundException $e) {
            session(['message' => __('orders.admin.list.id_not_found')]);
        } finally {
            return redirect()->route('admin.orders.index');
        }
    }
}
