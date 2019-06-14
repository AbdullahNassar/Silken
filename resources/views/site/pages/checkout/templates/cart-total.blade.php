<ul>
    <li>
        {{trans('site_global.subtotal')}} :
        <span>{{ $basket->subTotal() }}$</span>
    </li>
    <li>
        Shipping :
        <span>{{ $shipping_price }}$</span>
    </li>
    <li>
        {{trans('site_global.total')}} :
        <span>{{ ($subTotal = $basket->subTotal()) > 0 ?  $subTotal + $shipping_price : 0}}$</span>
    </li>
</ul>