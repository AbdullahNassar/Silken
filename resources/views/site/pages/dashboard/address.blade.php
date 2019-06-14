@extends('site.layouts.master')
@section('title')
Address
@endsection
@section('content')
<div class="page-head">
    <div class="container">
        <div class="page-head-info">
            <ul class="breadcrumb">
                <li><a href="{{route('site.home')}}">{{trans('trans.home')}}</a></li>
                <li class="active">{{trans('trans.myprofile')}}</li>
            </ul><!-- End breadcrumb -->
            <h2 class="page-head-title">{{trans('trans.dashboard')}}</h2>
        </div><!-- End Page-Head-Info -->
    </div><!-- End container -->
</div><!-- End Page-Head -->

<div class="page-content">
    <section class="section-lg">
        <div class="container">
            <div class="row">



                @include('site.layouts.aside')

                <div class="col-md-9">

                    <div class="dashboard-content">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="dashboard-item head-item">
                                    <p>
                                        {{trans('trans.addresstext')}}
                                    </p>
                                </div><!--End dashboard-item-->
                            </div><!--End Col-xs-12-->
                            <div class="col-sm-6">
                                <div class="dashboard-item">
                                    <div class="dash-item-head">
                                        <h3 class="title">
                                            {{trans('trans.Payment address')}}
                                            <a href="#" class="edit-btn payment-address-btn">{{trans('trans.edit')}}</a>
                                        </h3>
                                    </div><!--End dash-item-head-->
                                    <div class="dash-item-content">
                                        <ul class="account-info">
                                            @php
                                            $payment_address=json_decode(auth()->guard('members')->user()->payment_address);
                                            @endphp
                                            <li>
                                                <span>{{trans('trans.name')}} </span>
                                                <span>{{$payment_address->name}}</span>
                                            </li>
                                            <li>
                                                <span>{{trans('trans.Address')}}</span>
                                                <span>{{$payment_address->address}}</span>
                                            </li>
                                            <li>
                                                <span>{{trans('trans.Tel')}}</span>
                                                <span>{{$payment_address->phone}}</span>
                                            </li>
                                        </ul>
                                    </div><!--End Dash-item-content-->
                                </div><!--End dashboard-item-->
                            </div><!--End Col-sm-6-->
                            <div class="col-sm-6">
                                <div class="dashboard-item">
                                    <div class="dash-item-head">
                                        <h3 class="title">
                                            {{trans('trans.Shipping Address')}}
                                            <a href="#" class="edit-btn shipping-address-btn">{{trans('trans.edit')}}</a>
                                        </h3>
                                    </div><!--End dash-item-head-->
                                    <div class="dash-item-content">
                                        <ul class="account-info">
                                            @php
                                            $shipping_address=json_decode(auth()->guard('members')->user()->shipping_address);
                                            @endphp
                                            <li>
                                                <span>{{trans('trans.name')}} </span>
                                                <span>{{$shipping_address->name}}</span>
                                            </li>
                                            <li>
                                                <span>{{trans('trans.Address')}}</span>
                                                <span>{{$shipping_address->address}}</span>
                                            </li>
                                            <li>
                                                <span>{{trans('trans.Tel')}}</span>
                                                <span>{{$shipping_address->phone}}</span>
                                            </li>
                                        </ul>
                                    </div><!--End Dash-item-content-->
                                </div><!--End dashboard-item-->
                            </div><!--End Col-sm-6-->
                            <div class="col-sm-12">
                                <form class="dashboard-form payment-address-form hidden from-payment-address" method="post" action="{{route('site.dashboard.address.post')}}">
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label>{{trans('trans.Edit Payment Address')}}</label>

                                        <input type="hidden" name="type" value="payment">
                                        <input class="form-control" value="{{$payment_address->name}}" name="name" placeholder="{{trans('trans.name')}}" type="text">
                                        <input class="form-control" value="{{$payment_address->address}}" name="address" placeholder="{{trans('trans.Address')}}" type="text">
                                        <input class="form-control"  value="{{$payment_address->phone}}"name="phone" placeholder="{{trans('trans.Tel')}}" type="text">
                                    </div><!--End Form-group-->
                                    <button class="custom-btn" type="submit">{{trans('trans.Save changes')}}</button>
                                </form><!--End Form-->
                            </div><!--End Col-12-->
                            <div class="col-sm-12">
                                <form class="dashboard-form shipping-address-form from-shipping-address" method="post" action="{{route('site.dashboard.address.post')}}">
                                    {!! csrf_field() !!}

                                    <div class="form-group">
                                        <input type="hidden" name="type" value="shipping">
                                        <label>{{trans('trans.Edit shipping address')}}</label>


                                        <input class="form-control"name="name" value="{{$shipping_address->name}}" placeholder="{{trans('trans.name')}}" type="text">
                                        <input class="form-control"name="address" value="{{$shipping_address->address}}" placeholder="{{trans('trans.Address')}}" type="text">
                                        <input class="form-control"name="phone" value="{{$shipping_address->phone}}" placeholder="{{trans('trans.Tel')}}" type="text">
                                    </div><!--End Form-group-->
                                    <button class="custom-btn" type="submit">{{trans('trans.Save changes')}}</button>
                                </form><!--End Form-->
                            </div><!--End Col-12-->
                        </div><!--End Row-->
                    </div>
                </div><!--End Col-md-9-->
            </div><!--End Row-->
        </div><!-- End container -->
    </section><!-- End Section -->
</div>

@endsection