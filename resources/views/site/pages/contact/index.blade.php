@extends('site.layouts.master')
@section('title')
    اتصل بنا
@endsection
@section('content')
    <div class="page-head">
        <div class="container">
            <div class="page-head-info">
                <ul class="breadcrumb">
                    <li><a href="{{route('site.home')}}">{{trans('trans.home')}}</a></li>
                    <li class="active">{{$statics[6]->translated()->title}}</li>
                </ul><!-- End breadcrumb -->
                <h2 class="page-head-title">{{$statics[6]->translated()->title}}</h2>
            </div><!-- End Page-Head-Info -->
        </div><!-- End container -->
    </div><!-- End Page-Head -->
    <div class="page-content">
        <section class="contact section-lg info has-background">
            <div class="container">
                <div class="section-head section-title section-title-border">
                    <h3 class="wow fadeInUp">
                        {{strip_tags($statics[6]->translated()->description)}}
                    </h3>
                </div><!-- End Section-Head -->
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <form id="contactForm" action="{{route('site.contact.message')}}" method="post">
                                {!! csrf_field() !!}
                                <div class="alert alert-success hidden" id="email-alert-success">
                                    {{trans('trans.success')}}
                                </div>
                                <div class="alert alert-danger hidden" id="email-alert-error">
                                    {{trans('trans.error')}}
                                </div>
                                <div class="row">
                                    <div class="col-md-6 wow fadeInRight">
                                        <div class="form-group">
                                            <input class="form-control" name="name" data-msg-required="{{trans('trans.name_req')}}" placeholder="{{trans('trans.name')}}" type="text">
                                        </div>
                                    </div><!-- End col -->
                                    <div class="col-md-6 wow fadeInLeft">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="{{trans('trans.email')}}" type="email" name="email" data-msg-required="{{trans('trans.email_req')}}">
                                        </div>
                                    </div><!-- End col -->
                                    <div class="col-md-12 wow fadeInUp">
                                        <div class="form-group">
                                            <input class="form-control" name="subject" data-msg-required="{{trans('trans.subject_req')}}" placeholder="{{trans('trans.subject')}}" type="text">
                                        </div>
                                    </div><!-- End col -->
                                    <div class="col-md-12 wow fadeInUp">
                                        <div class="form-group">
                                            <textarea class="form-control" name="message" data-msg-required="{{trans('trans.message_req')}}" placeholder="{{trans('trans.message')}}"></textarea>
                                        </div>

                                    </div><!-- End col -->
                                    <div class="col-md-12 wow fadeInUp">
                                        <button class="custom-btn" type="submit">{{trans('trans.contactBtn')}}</button>
                                    </div>
                                </div><!-- End row -->
                            </form><!-- End Form -->
                        </div><!-- End col -->
                    </div><!-- End row -->
                    <div class="row">
                        @foreach($contact as $item)
                            <div class="col-md-4 wow fadeInUp">
                                <div class="loc-phone-email">
                                    <div class="icon-box">
                                        <i class="fa {{$item->icon}}"></i>
                                    </div><!-- End Icon-Box -->
                                    <div class="box-body">
                                        <h4>{{$item->translated()->title}}</h4>
                                        {!! $item->translated()->description !!}
                                    </div>
                                </div><!-- End Loc-Phone-Email -->
                            </div><!-- End col-md-4 -->
                        @endforeach
                    </div>
                </div><!-- End Section-Content -->
            </div><!-- End container -->
        </section>
        <section class="map-section">
            <div class="map-wrap">
                <div id="map"></div>
            </div><!--End map-wrap-->
        </section>
    </div><!--End page-content-->
@endsection