@extends('site.layouts.master')
@section('title')
    الصفحه الرئيسيه
@endsection
@section('content')
    <section class="section-lg about">
        <div class="container">
            <div class="row">
                <div class="col-md-6 wow fadeInRight" data-wow-delay=".4s">
                    <div class="section-content">
                        <h3 class="section-title has-before has-after">
                            {{$statics[0]->translated()->title}}
                        </h3>
                        <p>
                            {{$statics[0]->translated()->description}}
                        </p>
                    </div>
                </div><!-- End col -->
                <div class="col-md-5 col-md-offset-1 wow fadeInLeft" data-wow-delay=".4s">
                    <div class="section-img">
                        <div class="image-corners">
                            <img src="{{asset('storage/uploads/about/'.$about[0]->image)}}" alt="">
                        </div><!-- End Image-Corners -->
                    </div><!-- End Section-Img -->
                </div><!-- End col -->
            </div><!-- End row -->
        </div><!-- End container -->
    </section><!-- End Section -->
    <section class="services section-lg" >
        <div class="container">
            <div class="row">
                <div class="col-md-4 service-img wow fadeInRight" data-wow-delay=".4s" data-type="background" data-speed="5">

                </div> <!-- End Col -->
                <div class="col-md-8 col-md-offset-4">
                    <h2 class="title-lg">
                        {{trans('trans.offer')}}
                    </h2>
                    <div class="row">
                        @foreach($services as $service)
                        <div class="col-md-6 wow fadeInUp" data-wow-delay=".4s">
                            <div class="service">
                                <div class="service-icon">
                                    <img src="{{asset('storage/uploads/services/'.$service->image)}}" alt="icon">
                                </div><!-- End service-icon -->
                                <div class="service-content">
                                    <h5 class="title">{{$service->translated()->title}}</h5>
                                    <p>{{ strip_tags($service->translated()->description) }}</p>

                                </div> <!-- End service-title -->
                            </div> <!-- End service -->
                        </div><!--End col-md-6-->
                        @endforeach
                    </div><!--End row-->

                </div> <!-- End Col -->
            </div> <!-- End Row -->
        </div> <!-- End container -->
    </section> <!-- End Services -->

    <section class="section-lg">
        <div class="container">
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-3 col-sm-6 wow fadeInUp" data-wow-delay=".4s">
                    <div class="product-block home-product">
                        <div class="product-block--head custom-hover">
                            <img src="{{asset('storage/uploads/products/'.$product->image)}}" alt="">
                            <div class="product-block--icon">
                                <img src="{{asset('storage/uploads/products/'.$product->icon)}}">
                            </div><!-- End Widget-Hover -->
                            <figcaption></figcaption>
                        </div><!-- End Widget-Head -->
                        <div class="product-block--content">
                            <h3 class="title">
                                {{$product->translated()->title}}
                            </h3>
                        </div><!-- End Widget-Content -->
                    </div><!-- End Widget -->
                </div><!-- End col -->
                @endforeach
            </div><!-- End row -->
        </div><!-- End container -->
    </section>
    <section class="section-lg partners">
        <div class="container">
            <div class="row">
                <div class="col-md-4 wow fadeInRight" data-wow-delay=".4s">
                    <div class="section-content">
                        <h3 class="section-title has-before has-after">
                            {{$statics[7]->translated()->title}}
                        </h3>
                        <p>
                            {{$statics[7]->translated()->description}}
                        </p>
                    </div><!-- End Section-Content -->
                </div><!-- End col -->
                <div class="col-md-7">
                      <div class="carousel-items">
                      @foreach($partners as $index=>$partner)
                                    @if($index == 0 || $index%2 == 0)
                                    <div class="carousel-blocks">
                                    @endif
                                    <div class="partner-item">
                                        <img src="{{asset('storage/uploads/partners/'.$partner->image)}}" alt="">
                                        <div class="layout"></div><!-- End Layout -->
                                    </div><!-- End Partner-Item -->
                                    @if($index%2 == 1 || $index == sizeof($partners )-1)
                                    </div>
                                    @endif
                                
                            @endforeach
                    </div><!--End Partner-carousel-->
                </div><!-- End col -->
            </div><!-- End row -->
        </div><!-- End container -->
    </section><!-- End Section -->

@endsection