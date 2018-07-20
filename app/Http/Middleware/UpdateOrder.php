<?php
namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Order;

class UpdateOrder
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request request
     * @param \Closure                 $next    next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $orderId = explode('/', $request->server()['REQUEST_URI'])[3];
        $order = Order::where('id', $orderId)->first();
        if ($order->status != Order::UNAPPROVED) {
            throw new \Exception(config('define.exception.change_approve_order'));
        }
        if ($user->can('update', $order)) {
            return $next($request);
        } else {
            throw new \Illuminate\Auth\AuthenticationException();
        }
    }
}
