@extends('site.layouts.master')
@section('title')
    خدماتنا
@endsection
@section('content')
    <div class="page-head">
        <div class="container">
            <div class="page-head-info">
                <ul class="breadcrumb">
                    <li><a href="{{route('site.home')}}">{{trans('trans.home')}}</a></li>
                    <li class="active">{{$statics[4]->translated()->title}}</li>
                </ul><!-- End breadcrumb -->
                <h2 class="page-head-title">{{$statics[4]->translated()->title}}</h2>
            </div><!-- End Page-Head-Info -->
        </div><!-- End container -->
    </div><!-- End Page-Head -->
    <div class="page-content">
        <section class="section-lg">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 section-head section-title section-title-border wow fadeInUp">
                        <p>
                            {{strip_tags($statics[4]->translated()->description)}}
                        </p>
                    </div><!-- End Section-Head -->
                </div><!--End row-->

                <div class="section-content">
                    <div class="row">
                        @foreach($services as $service)
                        <div class="col-md-6 wow fadeInUp">
                            <div class="service-box">
                                <div class="service-box-head">
                                    <img src="{{asset('storage/uploads/services/'.$service->image)}}">
                                    <h3 class="title title-sm">
                                        {{$service->translated()->title}}
                                    </h3>
                                </div><!-- End Icon-Box-Head -->
                                <div class="service-box-content">
                                <p>
                                    {{ strip_tags( $service->translated()->description ) }}
                                </p>
                                </div><!-- End Icon-Box-Content -->
                            </div><!-- End Icon-Box -->
                        </div><!-- End col -->
                        @endforeach
                    </div><!-- End row -->
                </div>
            </div><!-- End container -->
        </section><!-- End Section -->
        <section class="section-lg solutions">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 wow fadeInRight">
                        <div class="content">
                            <h2>{{$statics[8]->translated()->title}}<span>.</span></h2>
                            {!! $statics[8]->translated()->description !!}
                        </div>
                    </div> <!-- End Col -->
                    <div class="col-md-6 solutions-img wow fadeInLeft" data-type='background' data-speed='5' >
                        <img src="{{asset('assets/site/images/solution-img.png')}}" alt="image">
                    </div> <!-- End Col -->
                </div> <!-- end row -->
            </div> <!-- End Container -->
        </section> <!-- End solutions -->

    </div><!--End page-content-->
@endsection