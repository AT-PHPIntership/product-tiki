<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param \App\Models\User  $user  user
     * @param \App\Models\Order $order order
     *
     * @return bool
     */
    public function update(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }
}
