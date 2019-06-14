@extends('site.layouts.master')
@section('title')
    المنتجات
@endsection
@section('content')
    <div class="page-head">
        <div class="container">
            <div class="page-head-info">
                <ul class="breadcrumb">
                    <li><a href="{{route('site.home')}}">{{trans('trans.home')}}</a></li>
                    <li class="active">{{$statics[5]->translated()->title}}</li>
                </ul><!-- End breadcrumb -->
                <h2 class="page-head-title">{{$statics[5]->translated()->title}}</h2>
            </div><!-- End Page-Head-Info -->
        </div><!-- End container -->
    </div><!-- End Page-Head -->
    <div class="page-content">
        <section class="section-lg">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 section-head section-title section-title-border wow fadeInUp">
                        <p>
                            {{strip_tags($statics[5]->translated()->description)}}
                        </p>
                    </div><!-- End Section-Head -->
                </div><!--End row-->

                <div class="section-content">
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-md-6 wow fadeInUp">
                            <div class="product-block">
                                <div class="product-block--head custom-hover">
                                    <img src="{{asset('storage/uploads/products/'.$product->image)}}" alt="">
                                    <div class="product-block--icon">
                                        <img src="{{asset('assets/site/images/icon-5.png')}}">
                                    </div><!-- End Widget-Hover -->
                                    <figcaption></figcaption>
                                </div><!-- End product-block--head -->
                                <div class="product-block--content">
                                    <h3 class="title">
                                        {{$product->translated()->title}}
                                    </h3>
                                    <ul class="list-items">
                                        {!! $product->translated()->description !!}
                                    </ul><!-- End list-items -->
                                </div><!-- End product-block--content -->
                            </div><!-- End product-block -->
                        </div><!-- End col-md-6 -->
                        @endforeach
                    </div><!-- End row -->
                </div><!-- End Section-Content -->
            </div><!-- End container -->
        </section><!-- End Section -->

    </div><!--End page-content-->
@endsection