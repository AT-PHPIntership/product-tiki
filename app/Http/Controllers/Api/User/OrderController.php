<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Order;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\NoteOrder;
use App\Models\TrackingOrder;
use App\Models\Coupon;
use Illuminate\Http\Response;
use App\Http\Requests\CreateOrderRequest;
use Auth;
use Validator;
use Exception;
use DB;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $perPage = isset($request->perpage) ? $request->perpage : config('define.order.limit_rows');

        $orders = Order::with('user')->withCount('orderDetails')->where('user_id', $user->id)->paginate($perPage);
        $data = $this->formatPaginate($orders);
        return $this->showAll($data, Response::HTTP_OK);
    }

    /**
     * Display detail order.
     *
     * @param \App\Models\Order $order order to get detail
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $user = Auth::user();

        $orderDetail = Order::where('id', $order->id)->where('user_id', $user->id)->with('orderDetails.product.images')->first();

        $urlEnd = ends_with(config('app.url'), '/') ? '' : '/';
        $orderDetail['image_path'] = config('app.url') . $urlEnd . config('define.product.upload_image_url');
        $orderDetail['total_formated'] = number_format($orderDetail['total']);

        foreach ($orderDetail->orderDetails as $detail) {
            $detail['price_formated'] = number_format($detail['product_price']);
        }

        return $this->showOne($orderDetail, Response::HTTP_OK);
    }

    /**
    * Create order
    *
    * @param App\Http\Requests\CreateOrderRequest $request request
    *
    * @return \Illuminate\Http\Response
    */
    public function store(CreateOrderRequest $request)
    {
        $user = Auth::user();

        $products = [];
        $errors = [];

        $coupon = Coupon::where('coupon_code', $request->coupon)->first();

        if (!$coupon) {
            array_push($errors, config('define.exception.coupon_code_doesnt_exist'));
        } else if (!$coupon->isAvailable()) {
            array_push($errors, config('define.exception.expired_coupon_code'));
        }

        foreach ($request->products as $input) {
            $product = Product::find($input['id']);
            if ((int) $input['quantity'] <= $product->quantity) {
                $input['product_price'] = $product->price;
                array_push($products, $input);
            } else {
                $error = $product->name . ': ' . config('define.product.exceed_quantity');
                array_push($errors, $error);
            }
        }

        if (count($products)) {
            $order = Order::create([
                'user_id' => $user->id
            ]);

            $total = 0;

            foreach ($products as $input) {
                $input['product_id'] = $input['id'];
                $input['order_id'] = $order->id;
                unset($input['id']);

                OrderDetail::create($input);
                $total += $input['product_price'] * $input['quantity'];
            }

            $order->total = $total;
            if ($coupon && $coupon->isAvailable()) {
                $discount = $order->getDiscount($coupon);
                $order->total = $total - $discount;
                $order->coupon_id = $coupon->id;
            }
            $order->save();
            $order->load('orderDetails', 'coupon');
        } else {
            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $data['order'] = $order;
        $data['errors'] = $errors;
        return $this->successResponse($data, Response::HTTP_OK);
    }

    /**
     * Update status order.
     *
     * @param \App\Models\Order $order order
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel(Order $order)
    {
        $user = Auth::user();
        if ($user->id == $order->user_id) {
            if ($order->status != Order::UNAPPROVED) {
                throw new \Exception(config('define.exception.cancel_approve_order'));
            }
            DB::beginTransaction();
            try {
                NoteOrder::create([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'note' => request('note'),
                ]);

                TrackingOrder::create([
                    'order_id' => $order->id,
                    'old_status' => $order->status,
                    'new_status' => Order::CANCELED,
                    'date_changed' => date("Y-m-d H:i:s")
                ]);

                $order->status = Order::CANCELED;
                $order->save();
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }
            return $this->showOne($order, Response::HTTP_OK);
        } else {
            throw new AuthenticationException();
        }
    }

    /**
    * Update order
    *
    * @param App\Http\Requests\CreateOrderRequest $request request
    * @param App\Models\Order                     $order   order to update
    *
    * @return \Illuminate\Http\Response
    */
    public function update(CreateOrderRequest $request, Order $order)
    {
        $products = [];
        $errors = [];

        $coupon = Coupon::where('coupon_code', $request->coupon)->first();

        $total = 0;

        if ($request->products) {
            foreach ($request->products as $input) {
                $input['product_id'] = $input['id'];
                $input['order_id'] = $order->id;
                $product = Product::where('id', $input['id'])->first();
                $details = OrderDetail::where('order_id', $order->id)->where('product_id', $input['product_id'])->first();
                if ((int) $input['quantity'] <= $product->quantity) {
                    $input['product_price'] = $details->product_price;
                    $details->quantity = $input['quantity'];
                    $details->save();
                    array_push($products, $input);
                    $total += $input['product_price'] * $input['quantity'];
                } else {
                    $error = $product->name . ': ' . config('define.product.exceed_quantity');
                    array_push($errors, $error);
                }
            }
            OrderDetail::where('order_id', $order->id)->whereNotIn('product_id', array_pluck($request->products, 'id'))->delete();
        }
        if (!$products) {
            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $order->total = $total;
        if (!$coupon) {
            array_push($errors, config('define.exception.coupon_code_doesnt_exist'));
        } else if (!$coupon->isAvailable()) {
            array_push($errors, config('define.exception.expired_coupon_code'));
        } else {
            $discount = $order->getDiscount($coupon);
            $order->total = $total - $discount;
            $order->coupon_id = $coupon->id;
        }
        $order->save();
        $order->load('orderDetails', 'coupon');

        $data['order'] = $order;
        $data['errors'] = $errors;
        return $this->successResponse($data, Response::HTTP_OK);
    }
}
