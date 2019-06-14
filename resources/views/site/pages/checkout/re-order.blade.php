@extends('site.layouts.master')
@section('title')
    {{trans('site_global.checkout')}}
@endsection
@php
$address = $order->address;
$products = $order->products;
@endphp
@section('page-title')
    <ul class="breadcrumb">
        <li>
            <a href="{{url('/')}}">
                <i class="fa fa-home">
                </i>
                {{trans('site_global.home')}}
            </a>
        </li>
        <li class="active">
            {{trans('site_global.checkout')}}
        </li>
    </ul>
    <!--End breadcrumb-->
@endsection
@section('content')
    <div class="page-content">
        <form action="{{ route('site.orders.re-order', ['order_id' => $order->id]) }}" id="payment-form" method="post" onsubmit="return false;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        @include('global.process')
                        <div class="toggle-container" id="accordion1">
                            <div class="panel">
                                <a class="panel-title" data-parent="#accordion1" data-toggle="collapse" href="#accord1">
                                    {{trans('login.account_info')}}
                                </a>
                                <div class="panel-collapse collapse in" id="accord1">
                                    <div class="panel-content">
                                        <div class="item-box padding-30">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h3>
                                                        Personal Information
                                                    </h3>
                                                    <div class="form-group">
                                                        <input class="form-control" name="f_name" placeholder="First Name" type="text" value="{{ $address->f_name }}">
                                                    </input>
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="l_name" placeholder="Last Name" type="text" value="{{ $address->l_name }}">
                                                </input>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" name="phone" placeholder="Phone" type="text" value="{{ $address->phone }}">
                                            </input>
                                        </div>
                                    </div>
                                    <!--End col-md-6-->
                                    <div class="col-md-6">
                                        <h3>
                                            Shipping Information
                                        </h3>
                                        <div class="form-group">
                                            <input class="form-control" name="email" placeholder="Email" type="email" value="{{ $address->email }}">
                                        </input>
                                    </div>
                                    <!--End form-group-->
                                    <div class="form-group">
                                        <input class="form-control" name="address" placeholder="Address" type="text" value="{{ $address->address }}">
                                    </input>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" data-url="{{ route('site.cart.total') }}" id="company-select" name="company">
                                        <option value="">
                                            -- Select Company --
                                        </option>
                                        @foreach (App\Company::all() as $company)
                                            <option value="{{ $company->id }}" {{ $address->company_id == $company->id? 'selected' : '' }}>
                                                {{ $company->translated()->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--End col-md-6-->
                        </div>
                        <!--End row-->
                    </div>
                    <!--End item-box-->
                </div>
                <!-- end content -->
            </div>
        </div>
        <!--End panel-->
        <div class="panel">
            <a class="collapsed panel-title" data-parent="#accordion1" data-toggle="collapse" href="#accord3">
                {{trans('site_global.order_summery')}}
            </a>
            <div class="panel-collapse collapse" id="accord3">
                <div class="panel-content">
                    <div class="box-wrap brdr-rd-3">
                        <table class="table-cart">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">
                                    </th>
                                    <th class="product-name">
                                        {{trans('site_global.product')}}
                                    </th>
                                    <th class="product-price">
                                        {{trans('site_global.price')}}
                                    </th>
                                    <th class="product-quantity">
                                        {{trans('site_global.quantity')}}
                                    </th>
                                    <th class="product-subtotal">
                                        {{trans('site_global.subtotal')}}
                                    </th>
                                </tr>
                            </thead>
                            @php
                                $subtotal = 0;
                            @endphp
                            <tbody>
                                @foreach ($products as $item)
                                    @php
                                    $item_details = $item->translated()->toArray();
                                    $image = $item->getImages()[0];
                                    @endphp
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="{{$item->getUrl()}}">
                                                <img src="{{$image->url}}">
                                            </img>
                                        </a>
                                    </td>
                                    <td class="product-name">
                                        <a href="">
                                            {{ $item_details['name']}}
                                        </a>
                                    </td>
                                    <td class="product-price">
                                        ${{ $item->getDiscount() }}
                                    </td>
                                    <td class="product-quantity">
                                        {{ $item->pivot->quantity }}
                                    </td>
                                    @php
                                        $subtotal += $total = ($item->pivot->quantity * $item->getDiscount())
                                    @endphp
                                    <td class="product-subtotal">
                                        ${{ num_format($total) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!--End box-wrap-->
            </div>
            <!-- end content -->
        </div>
    </div>
    <!--End panel-->
    <div class="panel">
        <a class=" collapsed panel-title" data-parent="#accordion1" data-toggle="collapse" href="#accord4">
            Payment Details
        </a>
        <div class="panel-collapse collapse" id="accord4">
            <div class="panel-content">
                <div class="item-box padding-30">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="dropin-container">
                            </div>
                            <div class="spacer-20">
                            </div>
                            <input id="nonce" name="nonce" type="hidden">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="custom-btn" id="pay-online" type="button">
                                        Pay Online
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button class="custom-btn" id="on-delivary" type="button">
                                        Cash on Delivary
                                    </button>
                                </div>
                            </div>
                        </input>
                    </div>
                    <!--End col-md-6-->
                    <div class="col-md-6">
                        <div class="spacer-30">
                        </div>
                        <div class="cart-total" id="cart-total">
                            <ul>
                                <li>
                                    {{trans('site_global.subtotal')}} :
                                    <span>
                                        {{ num_format($subtotal) }}$
                                    </span>
                                </li>
                                <li>
                                    Shipping :
                                    <span>
                                        {{ $address->company->price }}$
                                    </span>
                                </li>
                                <li>
                                    {{trans('site_global.total')}} :
                                    <span>
                                        {{ num_format($subtotal + $address->company->price) }}$
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--End col-md-6-->
                </div>
                <!--End row-->
            </div>
            <!--End item-box-->
        </div>
        <!-- end content -->
    </div>
</div>
<!--End panel-->
</div>
</div>
<!--End toggle-container-->
</div>
<!--End col-md-10-->
</div>
<!--End Row-->
</form>
</div>
<!--End container-fluid-->
<!--End page-content-->
@endsection
@section('scripts')
    <script src="https://js.braintreegateway.com/web/dropin/1.4.0/js/dropin.min.js">
    </script>
    <script>
    var form = document.getElementById('payment-form');
    document.getElementById('on-delivary').addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('nonce').value = 'on-delivary';
        form.submit();
    });;
    braintree.dropin.create({
        authorization: "{{ Braintree\ClientToken::generate() }}",
        container: '#dropin-container',
        paypal: {
            flow: 'vault'
        }
    }, function (createErr, instance) {
        document.getElementById('pay-online').addEventListener('click', function (event) {
            event.preventDefault();
            instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                    alert(err);
                    return;
                }
                // Add the nonce to the form and submit
                document.getElementById('nonce').value = payload.nonce;
                form.submit();
            });
        });
    });
    </script>
@endsection
