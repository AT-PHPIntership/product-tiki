<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GenerateCouponMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:money {discount=10} {min=20} {day=3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generation coupon money';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $coupon = [
            'discount' => $this->argument('discount'),
            'discount_type' => Coupon::MONEY,
            'coupon_code' =>  Str::random(20),
            'min_total' => $this->argument('min'),
            'date_begin' => Carbon::now(),
            'date_end' => Carbon::now()->addDays($this->argument('day')),
        ];
        Coupon::create($coupon);
    }
}
