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
    protected $signature = 'coupon:money {discount?} {min?} {day?}';

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
            'discount' => $this->argument('discount') ? $this->argument('discount') : config('define.coupon_money_defaul.discount'),
            'discount_type' => Coupon::MONEY,
            'coupon_code' =>  Str::random(20),
            'min_total' => $this->argument('min') ? $this->argument('min') : config('define.coupon_money_defaul.min_total'),
            'date_begin' => Carbon::today(),
            'date_end' => Carbon::today()->addDays($this->argument('day') ? $this->argument('day') : config('define.coupon_money_defaul.date_end')),
        ];
        Coupon::create($coupon);
    }
}
