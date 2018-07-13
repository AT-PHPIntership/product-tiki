<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Events\CouponGenerated;

class GenerateCouponPercent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:percent {discount=20} {max=200} {day=3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generation coupon percent';

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
            'discount_type' => Coupon::PERCENT,
            'coupon_code' =>  Str::random(20),
            'max_total' => $this->argument('max'),
            'date_begin' => Carbon::now(),
            'date_end' => Carbon::now()->addDays($this->argument('day')),
        ];
        Coupon::create($coupon);
        event(new CouponGenerated($coupon));
    }
}
