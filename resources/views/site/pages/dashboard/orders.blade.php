@extends('site.layouts.master')
@section('title')
orders
@endsection
@section('content')
<div class="page-head">
    <div class="container">
        <div class="page-head-info">
            <ul class="breadcrumb">
                <li><a href="{{route('site.home')}}">{{trans('trans.home')}}</a></li>
                <li class="active">{{trans('trans.myprofile')}}</li>
            </ul><!-- End breadcrumb -->
            <h2 class="page-head-title">{{trans('trans.orders')}}</h2>
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
                        @foreach($orders as $order)

                        <div class="order-box">
                            <div class="order-box-head">
                                <div class="pull-left">
                                    <span>{{trans('trans.Order Number')}}</span>
                                    <span>#{{$order->code}}</span>
                                </div>
                                <div class="pull-right">
                                    <span>{{trans('trans.Order Total')}}</span>
                                    <span>{{$order->total}}</span>
                                </div>
                            </div><!--End Order-box-head-->
                            <div class="order-box-content">
                                @foreach($order->products as $product)
                                <div class="order-item">

                                    <div class="order-item-head">


                                        <div class="order-item-img">
                                            <img src="@if(count($product->getImages())>0){{$product->getImages()[0]->url}}@endif" alt="...">
                                        </div>
                                        <div class="order-item-desc">
                                            <a href="{{$product->getUrl()}}" class="title">
                                                @php
                                                $name = $product->translated(app()->getLocale());
                                                $slug=$product->slug;
                                                @endphp
                                                {{$name->name}}

                                            </a>
                                            <ul class="rate-list">
                                                @php
                                                $total = $product->total_reviews();
                                                @endphp
                                                @for($i=1 ; $i<=5 ;$i++)
                                                @if($i <= $total)
                                                <li> <i class="fa fa-star"></i> </li>
                                                @else
                                                <li> <i class="fa fa-star-o"></i> </li>
                                                @endif
                                                @endfor

                                            </ul><span>@if($total){{$total}}@endif</span>


                                        </div>
                                    </div><!--End Order-item-head-->

                                    <div class="order-item-info">
                                        <p>
                                            <span>{{trans('trans.Price')}} :</span>
                                            <span>{{$product->price}}</span>
                                        </p>
                                        <p>
                                            <span>{{trans('trans.Date')}} :</span>
                                            <span> {{date('Y-m-d',strtotime($product->created_at))  }}</span> 
                                        </p>
                                    </div><!--End Order-item-info-->

                                </div><!--End Order-item-->
                                @endforeach

                            </div><!--End Order-box-content-->
                        </div><!--End Order-item-->
                        @endforeach

                    </div>

                </div><!--End Col-md-9-->
            </div><!--End Row-->
        </div><!-- End container -->
    </section><!-- End Section -->
</div>

@endsection