<?php

namespace App\Listeners;

use App\Events\CouponGenerated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Mail\SendMailCouponGenerated;
use Mail;

class SendCouponNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CouponGenerated  $event
     * @return void
     */
    public function handle(CouponGenerated $event)
    {
        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new SendMailCouponGenerated($event->coupon));
        }
    }
}
