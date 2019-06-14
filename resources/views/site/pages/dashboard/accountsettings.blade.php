@extends('site.layouts.master')
@section('title')
Account  Settings
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
                        <div class="dashboard-item head-item">
                            <p>
                                {{trans('trans.acountsettingstext')}}
                            </p>
                        </div><!--End dashboard-item-->
                        <form id="acount-settings" class="dashboard-form ">
                            <div class="alert alert-success hidden" id="email-alert-success">
                                {{trans('trans.change success')}}
                            </div>
                            <div class="alert alert-danger hidden" id="email-alert-error">
                                
                            </div>

                            <div class="form-group">
                                <label>{{trans('trans.Name and e-mail')}}</label>
                                <input class="form-control" value="{{auth()->guard('members')->user()->name}}" name="name" placeholder="{{trans('trans.name')}}" type="text" required="">
                                <input class="form-control" value="{{auth()->guard('members')->user()->email}}" name="email" placeholder="{{trans('trans.email')}}" type="email" required="">
                            </div><!--End Form-group-->

                            <div class="form-group">
                                <label>{{trans('trans.Password')}}</label>
                                <input class="form-control" name="password" placeholder="{{trans('trans.Current Password')}}" type="password" required="">
                                <input class="form-control" id="newpassword" name="newpassword" placeholder="{{trans('trans.New password')}}" type="password">
                                <input class="form-control" name="confirmpassword" placeholder="{{trans('trans.Confirm New Passowrd')}}" type="password">
                            </div><!--End Form-group-->
                            <button class="custom-btn" type="submit">{{trans('trans.Save Changes')}}</button>
                        </form><!--End Form-->
                    </div>
                </div><!--End Col-md-9-->
            </div><!--End Row-->
        </div><!-- End container -->
    </section><!-- End Section -->
</div>

@endsection