@extends('site.layouts.master')
@section('title')
Login
@endsection
@section('content')
<div class="page-head">
    <div class="container">
        <div class="page-head-info">
            <ul class="breadcrumb">
                <li><a href="{{route('site.home')}}">{{trans('trans.home')}}</a></li>
                <li class="active">{{trans('trans.register')}}</li>
            </ul><!-- End breadcrumb -->
            <h2 class="page-head-title">{{trans('trans.register')}}</h2>
        </div><!-- End Page-Head-Info -->
    </div><!-- End container -->
</div>
<div class="page-content">
    <section class="section-lg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="login-register">
                        <div class="login-register-head">
                            <h3 class="title">{{trans('trans.login')}}</h3>
                            <p>{{trans('trans.login-text')}} </p>
                        </div><!-- End Login-Register-Head -->
                        <div class="login-register-content">
                            <form id="loginform" action="{{route('site.login.post')}}" method="post">
                                {!! csrf_field() !!}
                                <div class="alert alert-success hidden" id="email-alert-success">
                                    {{trans('trans.login success')}}
                                </div>
                                <div class="alert alert-danger hidden" id="email-alert-error">
                                    {{trans('trans.error')}}
                                </div>
                                
                                
                                <div class="form-group">
                                    <label for="email">{{trans('trans.email')}} </label>
                                    <input class="form-control"  type="email" name="email" data-msg-required="{{trans('trans.email_req')}}">
                                </div><!-- End Form-Group -->
                                <div class="form-group">
                                    <label for="password">{{trans('trans.password')}} </label>
                                    <input class="form-control"  type="password" name="password" data-msg-required="{{trans('trans.password_req')}}">
                                </div><!-- End Form-Group -->
                                <div class="form-group">
                                    <button class="custom-btn">{{trans('trans.login')}}</button>
                                </div><!-- End Form-Group -->
                            </form><!-- End Form -->
                        </div><!-- End Login-Register-Content -->
                    </div><!-- End Login-Register -->
                </div><!--End Col-md-6-->
            </div><!--End Row-->
        </div><!-- End container -->
    </section><!-- End Section -->


</div>

@endsection