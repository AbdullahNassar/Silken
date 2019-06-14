@extends('admin.layouts.master')
@section('title')
    Orders data
@endsection
@section('content')
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{url('/')}}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Orders Data</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="font-dark"></i>
                            <span class="caption-subject bold uppercase">All data</span>
                        </div>
                    </div>
                    <form action="{{ url('admin/orders/') }}" onsubmit="return false;">
                        <div class="box-body" >
                            <div class="margin-bottom row">

                                <div class="row top-table">

                                    <div class=" col-md-12 col-sm-12">

                                        <div class="col-md-9 col-xs-9">

                                            <div class="btn-group" data-toggle="buttons">

                                                <label class="btn btn-sm btn-default" >

                                                    <input type="radio" name="options" class="btn-filter" data-filter="all" autocomplete="off" >

                                                    {{ trans('products.filter_all') }}

                                                </label>
                                                <label class="btn btn-sm btn-default" title="Active Products">

                                                    <input type="radio" name="options"  class="btn-filter" data-filter="approved" autocomplete="off">

                                                    <i class="fa fa-eye text-success"></i>

                                                    Approved

                                                </label>

                                                <label class="btn btn-sm btn-default" title="Rejected Products">

                                                    <input type="radio" name="options" class="btn-filter" data-filter="canceled" autocomplete="off">

                                                    <i class="fa fa-eye-slash text-danger"></i>

                                                    Canceled

                                                </label>

                                                <label class="btn btn-sm btn-default" title="Today products">

                                                    <input type="radio" name="options" class="btn-filter" data-filter="pending" autocomplete="off">

                                                    <i class="fa fa-bell text-warning "></i>

                                                    Pending

                                                </label>

                                            </div>

                                        </div>

                                        <div class="col-md-3 col-xs-3">

                                            <div class="dropdown">

                                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">

                                                    {{ trans('products.set_as') }}<i class="fa fa-cogs text-danger"></i>

                                                    <span class="caret"></span>

                                                </button>

                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

                                                    <li><a href="#" class="btn-action"  data-action="approved"><span><i class="fa fa-eye text-success"></i></span> &nbsp; Approved </a></li>

                                                    <li><a href="#" class="btn-action"  data-action="canceled"><span><i class="fa fa-eye-slash text-danger"></i></span> &nbsp; Canceled</a></li>

                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-center" id="ajax-table">
                                @include('admin.pages.orders.templates.orders-table')
                            </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
                </form>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>
@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('assets/global/process.css')}}">
@endsection
@section('foot')
    <script src="{{asset('assets/global/process.js')}}" type="text/javascript"></script>
@endsection
