@extends('site.layouts.master')
@section('title')
Register
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
                            <h3 class="title">{{trans('trans.register')}}</h3>
                            <p>{{trans('trans.register-text')}} </p>
                        </div><!-- End Login-Register-Head -->
                        <div class="login-register-content">
                            <form id="registerform" action="{{route('site.register.post')}}" method="post">
                                {!! csrf_field() !!}
                                <div class="alert alert-success hidden" id="email-alert-success">
                                    {{trans('trans.register success')}}
                                </div>
                                <div class="alert alert-danger hidden" id="email-alert-error">
                                    {{trans('trans.error')}}
                                </div>


                                <div class="form-group">
                                    <label for="name">{{trans('trans.fullname')}} </label>
                                    <input class="form-control" name="name" data-msg-required="{{trans('trans.name_req')}}"  type="text">
                                </div><!-- End Form-Group -->
                                <div class="form-group">
                                    <label for="name">{{trans('trans.membershiptype')}} </label>
                                    <select class="form-control" name="membershiptype">
                                        <option value="user">{{trans('trans.user')}}</option>
                                        <option value="trader">{{trans('trans.trader')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="email">{{trans('trans.email')}} </label>
                                    <input class="form-control"  type="email" name="email" data-msg-required="{{trans('trans.email_req')}}" data-msg-email="{{trans('trans.email_in_valide')}}">
                                </div><!-- End Form-Group -->
                                <div class="form-group">
                                    <label for="password">{{trans('trans.password')}} </label>
                                    <input class="form-control"  type="password" id="password" name="password"  data-msg-minlength="{{trans('trans.minlength')}}" data-msg-required="{{trans('trans.password_req')}}">
                                </div><!-- End Form-Group -->
                                <div class="form-group">
                                    <label for="password">{{trans('trans.confirmpassword')}}</label>
                                    <input class="form-control"  type="password" name="confirmpassword" data-msg-minlength="{{trans('trans.minlength')}}" data-msg-equalTo="{{trans('trans.confirmepassword_err')}}" data-msg-required="{{trans('trans.confirmepassword_req')}}">
                                </div><!-- End Form-Group -->
                                <div class="form-group">
                                    <button class="custom-btn">{{trans('trans.register')}}</button>
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