@extends('site.layouts.master')
@section('title')
    عن سلكين
@endsection
@section('content')
    <div class="page-head">
        <div class="container">
            <div class="page-head-info">
                <ul class="breadcrumb">
                    <li><a href="{{route('site.home')}}">{{trans('trans.home')}}</a></li>
                    <li class="active">{{$statics[0]->translated()->title}}</li>
                </ul><!-- End breadcrumb -->
                <h2 class="page-head-title">{{$statics[0]->translated()->title}}</h2>
            </div><!-- End Page-Head-Info -->
        </div><!-- End container -->
    </div><!-- End Page-Head -->
    <div class="page-content">
        <section class="section-lg about-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 section-head section-title section-title-border wow fadeInUp">
                        @foreach($about as $index=>$a)
                            @if($index == 0)
                            {!! $a->translated()->description !!}
                            @endif
                        @endforeach
                    </div><!--End col-md-10 -->
                </div><!--End row-->
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-6 wow fadeInRight">
                            <div class="toggle-container" id="about">
                                @foreach($about as $index=>$a)
                                    @if($index != 0)
                                    <div class="panel">
                                        <a href="#item-{{$index}}" data-toggle="collapse" data-parent="#about" class="@if($index != 1){{'collapsed'}}@endif">
                                            <img src="{{asset('storage/uploads/about/'.$a->image)}}" alt="">
                                            {{$a->translated()->title}}
                                        </a>
                                        <div class="panel-collapse collapse @if($index == 1){{'in'}}@endif" id="item-{{$index}}">
                                            <div class="panel-content">
                                                {!! $a->translated()->description !!}
                                            </div><!-- end content -->
                                        </div><!--End panel-collapse-->
                                    </div><!--End Panel-->
                                    @endif
                                @endforeach
                            </div><!--End toggle-container-->
                        </div><!-- End col -->

                        <div class="col-md-6 wow fadeInLeft">
                            <div class="section-img">
                                @foreach($about as $index=>$a)
                                    @if($index == 0)
                                        <img src="{{asset('storage/uploads/about/'.$a->image)}}" alt="">
                                    @endif
                                @endforeach
                            </div><!-- End Section-Img -->
                        </div><!-- End col -->
                    </div><!-- End row -->
                </div><!-- End Section-Content -->
            </div><!-- End container -->
        </section><!-- End Section -->
        <section class="section-lg partners">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 wow fadeInRight">
                        <div class="section-content">
                            <h3 class="section-title has-before has-after">
                                {{$statics[1]->translated()->title}}
                            </h3>
                            <p>
                                {{strip_tags($statics[1]->translated()->description)}}
                            </p>
                        </div><!-- End Section-Content -->
                    </div><!-- End col -->
                    <div class="col-md-7">
                      <div class="carousel-items">
                      @foreach($clients as $index=>$partner)
                                    @if($index == 0 || $index%2 == 0)
                                    <div class="carousel-blocks">
                                    @endif
                                    <div class="partner-item">
                                        <img src="{{asset('storage/uploads/clients/'.$partner->image)}}" alt="">
                                        <div class="layout"></div><!-- End Layout -->
                                    </div><!-- End Partner-Item -->
                                    @if($index%2 == 1 || $index == sizeof($clients)-1)
                                    </div>
                                    @endif
                                
                            @endforeach
                    </div><!--End Partner-carousel-->
                </div><!-- End col -->
                </div><!-- End row -->
            </div><!-- End container -->
        </section><!-- End Section -->
    </div><!--End page-content-->
@endsection