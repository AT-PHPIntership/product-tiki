<h2>Mail from Product-tiki</h1>
<h3>Coupon information</h3>
<p>Discount for each order: {{ $discount_type == 0 ? $discount . '%' : $discount . '$' }}</p>
<p>Duration: {{ $date_begin . ' -> ' . $date_end }}</p>
<p>Coupon Code: {{ $coupon_code }}</p>
