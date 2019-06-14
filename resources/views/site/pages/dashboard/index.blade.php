@extends('site.layouts.master')
@section('title')
dashboard
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
                                        <span>{{trans('trans.Hello')}} {{auth()->guard('members')->user()->name}} </span> {{trans('trans.HelloText')}} 
                                    </p>
                                </div><!--End dashboard-item-->
                            </div><!--End Col-xs-12-->
                            <div class="col-xs-12">
                                <div class="dashboard-item">
                                    <div class="dash-item-head">
                                        <h3 class="title">
                                            {{trans('trans.Recent requests')}}
                                        </h3>
                                    </div><!--End dash-item-head-->
                                    <div class="dash-item-content">
                                        <p>
                                            {{trans('trans.no orders')}}
                                            <a href="{{route('site.store')}}">
                                                {{trans('trans.click to shop')}}
                                            </a>
                                        </p>
                                    </div><!--End Dash-item-content-->
                                </div><!--End dashboard-item-->
                            </div><!--End Col-xs-12-->
                            <div class="col-sm-6">
                                <div class="dashboard-item">
                                    <div class="dash-item-head">
                                        <h3 class="title">

                                            {{trans('trans.Account Information')}}
                                            <a href="{{route('site.dashboard.accountsettings')}}" class="edit-btn">{{trans('trans.edit')}}</a>
                                        </h3>
                                    </div><!--End dash-item-head-->
                                    <div class="dash-item-content">
                                        <ul class="account-info">
                                            <li>
                                                <span> {{trans('trans.name')}}</span>
                                                <span>{{auth()->guard('members')->user()->name}}</span>
                                            </li>
                                            <li>
                                                <span>{{trans('trans.email')}}</span>
                                                <span>{{auth()->guard('members')->user()->email}}</span>
                                            </li>
                                        </ul>
                                    </div><!--End Dash-item-content-->
                                </div><!--End dashboard-item-->
                            </div><!--End Col-sm-6-->
                            <div class="col-sm-6">
                                <div class="dashboard-item">
                                    <div class="dash-item-head">
                                        <h3 class="title">
                                            <span>{{trans('trans.address')}}
                                            <a href="{{route('site.dashboard.address')}}" class="edit-btn">{{trans('trans.edit')}}</a>
                                        </h3>
                                    </div><!--End dash-item-head-->
                                    <div class="dash-item-content">
                                        <p>
                                            {{auth()->guard('members')->user()->address}}
                                        </p>
                                    </div><!--End Dash-item-content-->
                                </div><!--End dashboard-item-->
                            </div><!--End Col-sm-6-->
                        </div><!--End Row-->
                    </div>
                </div><!--End Col-md-9-->
            </div><!--End Row-->
        </div><!-- End container -->
    </section><!-- End Section -->
</div>

@endsection