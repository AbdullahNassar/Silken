@extends('admin.layouts.master')
@section('title')
الرسائل
@endsection
@section('content')
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{url('/admin')}}">الرئيسيه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>رسائل التواصل</span>
            </li>
        </ul>
    </div>
    <form action="{{ url('admin/messages/') }}" onsubmit="return false;">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="fa fa-envelope font-dark"></i>
                            <span class="caption-subject bold uppercase">جميع الرسائل</span>
                        </div>
                    </div>
                    <div class="margin-bottom row">
                        <div class="row top-table">
                            <div class=" col-md-8 col-xs-8">
                                <div class="col-md-8 col-xs-8">
                                    <div class="btn-group" data-toggle="buttons">

                                        <label class="btn btn-sm btn-default" title="All Products">
                                            <input type="radio" name="options" class="btn-filter" data-filter="all" autocomplete="off" >
                                            الكل
                                        </label>
                                        <label class="btn btn-sm btn-default" title="Active Products">
                                            <input type="radio" name="options"  class="btn-filter" data-filter="seen" autocomplete="off">
                                            <i class="fa fa-eye text-success"></i>
                                            تم رؤيته
                                        </label>
                                        <label class="btn btn-sm btn-default" title="Rejected Products">
                                            <input type="radio" name="options" class="btn-filter" data-filter="unseen" autocomplete="off">
                                            <i class="fa fa-eye-slash text-danger"></i>
                                            لم يتم رؤيته
                                        </label>
                                        <label class="btn btn-sm btn-default" title="Today products">
                                            <input type="radio" name="options" class="btn-filter" data-filter="today" autocomplete="off">
                                            <i class="fa fa-bell text-info "></i>
                                            اليوم
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-3">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            تغيير الي <i class="fa fa-cogs text-danger"></i>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="#" class="btn-action"  data-action="seen"><span><i class="fa fa-eye text-primary"></i></span> &nbsp;تم رؤيته</a></li>
                                            <li><a href="#" class="btn-action"  data-action="unseen"><span><i class="fa fa-eye-slash text-danger"></i></span> &nbsp;لم يتم رؤيته</a></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class=" ser-a-del col-md-4 col-xs-4">
                                <div class="col-xs-8 inner-col">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm"  id="input-search" placeholder="ابحث هنا...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-sm btn-success btn-search" data-search="product" type="button">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="addNew col-md-4 bcol-xs-4">
                                    <button type="button" class="btn btn-danger btn-sm btn-action"  data-action="deleted">
                                        <i class="fa fa-trash"></i>
                                        مسح
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body" id="ajax-table">

                        @include('admin.pages.messages.templates.message_template' ,compact('messages'))
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        {!! csrf_field() !!}
    </form>
</div>
@endsection


