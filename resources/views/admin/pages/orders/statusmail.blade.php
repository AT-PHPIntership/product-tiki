<h1>Mail from Product Tiki</h1>
<h3>Hi {{ $name }}</h3>
@if ($status == App\Models\Order::UNAPPROVED)
<p>{{ trans('user/mail.message.pending') }}</p>
@elseif ($status == App\Models\Order::APPROVED)
<p>{{ trans('user/mail.message.approved') }}</p>
@elseif ($status == App\Models\Order::ON_DELIVERY)
<p>{{ trans('user/mail.message.on_delivery') }}</p>
@elseif ($status == App\Models\Order::CANCELED)
<p>{{ trans('user/mail.message.canceled') }}</p>
@endif
