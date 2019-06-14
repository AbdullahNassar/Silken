@extends('site.layouts.master')
@section('title')
عن سلكين
@endsection
@section('content')
<div class="page-head">
    <div class="container">
        <div class="page-head-info">
            <ul class="breadcrumb">
                <li><a href="{{route('site.cart.index')}}">{{trans('trans.home')}}</a></li>
                <li class="active">{{trans('trans.cart')}}</li>
            </ul><!-- End breadcrumb -->
            <h2 class="page-head-title">{{trans('trans.home')}}</h2>
        </div><!-- End Page-Head-Info -->
    </div><!-- End container -->
</div><!-- End Page-Head -->

<div class="page-content">
    <section class="section-lg">
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>تفاصيل المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    $total=0;
                    @endphp

                    @foreach($items as $product)
                    <tr>
                        <td>
                            <img src="@if(count($product->getImages())>0){{$product->getImages()[0]->url}}@endif" alt="...">
                        </td>
                        <td>
                            <a href="{{$product->getUrl()}}"  class="product-link">         
                                @php
                                $name = $product->translated(app()->getLocale());
                                @endphp
                                {{$name->name}}
                            </a>
                        </td>
                        <td>
                            <div class="cart-number">
                                <a href="#" class="number-down" data-url="{{route('site.cart.min',$product->id)}}"  data-id="{{$product->id}}">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <input  value="{{$product->count}}" class="form-control " type="text" id="pro_coun_{{$product->id}}">
                                <a href="#" class="number-up" data-url="{{route('site.cart.add',$product->id)}}"  data-id="{{$product->id}}">
                                    <i class="fa fa-angle-up"></i>
                                </a>
                            </div><!--End cart-number-->
                        </td>
                        @php
                        $total=$total+($product->price*$product->count);
                        @endphp
                        <td class="po-prices" id="pro_price_{{$product->id}}">{{$product->price*$product->count}} </td>
                        <td>

                            <a href="#" class="trash-btn cart  " data-url="{{route('site.cart.delete',$product->id)}}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach



                </tbody>
            </table><!-- End Table -->
            <div class="row">
                <div class="col-md-4 col-md-offset-8">
                    <div class="total-widget">
                        <div class="total-widget-head">
                            <h3 class="title">اجمالي المشتريات</h3>
                        </div><!-- Total-Widget-Head -->
                        <div class="total-widget-content">
                            <div class="total-price">
                                <p>
                                    <span>اجمالي السعر</span>
                                    <span class="total-prices">{{$total}} </span>
                                </p>
                                <p>
                                    <span>تكلفة الشحن</span>
                                    <span>00 </span>
                                </p>
                            </div><!-- End Total-Widget-Price -->
                            <div class="total-price required-price">
                                <p>
                                    <span>المبلغ المطلوب</span>
                                    <span class="total-prices">{{$total}} </span>
                                </p>
                            </div><!-- End Required-Price -->
                        </div><!-- End Total-Content -->
                        <div class="total-widget-footer">
                            <a href="{{route('site.cart.checkout')}}" class="custom-btn">الاستمرار الي الدفع</a>
                        </div><!-- End Total-Widget-Footer -->
                    </div><!-- End Total -->
                </div><!-- End col -->
            </div><!-- End row -->

        </div><!-- End container -->
    </section><!-- End Section -->


</div>
@endsection