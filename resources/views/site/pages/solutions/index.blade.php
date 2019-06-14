@extends('site.layouts.master')
@section('title')
    حلولنا
@endsection
@section('content')
    <div class="page-head">
        <div class="container">
            <div class="page-head-info">
                <ul class="breadcrumb">
                    <li><a href="{{route('site.home')}}">الرئيسية</a></li>
                    <li class="active">{{$solution->translated()->title}}</li>
                </ul><!-- End breadcrumb -->
                <h2 class="page-head-title">{{$solution->translated()->title}}</h2>
            </div><!-- End Page-Head-Info -->
        </div><!-- End container -->
    </div><!-- End Page-Head -->
    <div class="page-content">
        <section class="section-lg about">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 wow fadeInRight">
                        <div class="section-content">
                            <h3 class="section-title has-before has-after">
                                {{$solution->translated()->title}}
                            </h3>
                            <p>
                                {{strip_tags($solution->translated()->description)}}
                            </p>
                            <a href="{{route('site.contact')}}" class="custom-btn">اطلب خدمة</a>
                        </div>
                    </div><!-- End col -->
                    <div class="col-md-5 col-md-offset-1 wow fadeInLeft">
                        <div class="gallery section-img">
                            <a href="{{asset('storage/uploads/solutions/'.$solution->images[0]->image)}}" class="image-corners">
                                <img src="{{asset('storage/uploads/solutions/'.$solution->images[0]->image)}}">
                                <figcaption></figcaption>
                            </a>
                            @foreach($solution->images as $image)
                                <a href="{{asset('storage/uploads/solutions/'.$image->image)}}"></a>
                            @endforeach
                        </div><!--End Galary-->

                    </div><!-- End col -->
                </div><!-- End row -->
            </div><!-- End container -->
        </section><!-- End Section -->
        <section class="section-lg partners">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 wow fadeInRight">
                        <div class="section-content">
                            <h3 class="section-title has-after">
                                عملاؤنا فى قطاع {{$solution->translated()->title}}
                            </h3>
                        </div><!-- End Section-Content -->
                    </div><!-- End col -->
                    <div class="col-md-8">
                        <div class="carousel-items-4">
                            @foreach($solution->customers as $customer)
                            <div class="sector-block wow fadeInRight" data-wow-delay=".4s">
                                <div class="sector-block-head gallery">
                                    <a href="{{asset('storage/uploads/customers/'.$customer->images[0]->image)}}" class="image-corners">
                                        <img src="{{asset('storage/uploads/customers/'.$customer->images[0]->image)}}">
                                        <div class="gallery-hover">
                                            <i class="fa fa-search"></i>
                                        </div><!--End Gallery-hover-->
                                    </a>
                                    @foreach($customer->images as $image)
                                        <a href="{{asset('storage/uploads/customers/'.$image->image)}}"></a>
                                    @endforeach
                                </div><!-- End Block-Head -->
                                <div class="sector-block-content">
                                    <p>
                                        {{$customer->translated()->title}}
                                    </p>
                                </div><!-- End Block-content -->
                            </div><!-- End block -->
                            @endforeach
                        </div><!--End Partner-carousel-->
                    </div><!-- End col -->
                </div><!-- End row -->
            </div><!-- End container -->
        </section><!-- End Section -->

    </div><!--End page-content-->
@endsection