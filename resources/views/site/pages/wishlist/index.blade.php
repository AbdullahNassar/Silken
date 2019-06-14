@extends('site.layouts.master')
@section('title')
Wishlist
@endsection
@section('content')
<div class="page-head">
    <div class="container">
        <div class="page-head-info">
            <ul class="breadcrumb">
                <li><a href="{{route('site.home')}}">{{trans('trans.home')}}</a></li>
                <li class="active">{{trans('trans.myprofile')}}</li>
            </ul><!-- End breadcrumb -->
            <h2 class="page-head-title">{{trans('trans.favoirite')}}</h2>
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
                                        {{trans('trans.Favorite Products')}}

                                    </p>
                                </div><!--End dashboard-item-->
                            </div><!--End Col-xs-12-->
                            <div class="col-xs-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{trans('trans.Product Details')}}</th>
                                            <th>{{trans('trans.price')}}</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if(sizeof($products) > 0)
                                        @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <img src="@if(count($product->getImages())>0){{$product->getImages()[0]->url}}@endif" alt="...">
                                            </td>
                                            <td>
                                                @php
                                                $name = $product->translated(app()->getLocale());
                                                @endphp



                                                <a href="{{$product->getUrl()}}" class="product-link">{{$name->name}}</a>
                                            </td>
                                            <td>@if (Auth::guard('members')->check() && auth()->guard('members')->user()->membershiptype=='trader')
                                                {{$product->price_trader}}
                                                @else
                                                {{$product->price}}

                                                @endif</td>
                                            <td>
                                                <a href="#" class="wishlist-btn wish-trash-btn" data-url="{{route('site.wishlist.index')}}/{{$product->id}}">
                                                    <i class="fa fa-trash"></i>

                                                </a>

                                            </td>
                                        </tr>

                                        @endforeach
                                        @else
                                    <div class="table-cell">
                                        <div class="alert alert-danger col-md-12 text-center">
                                            {{trans('trans.No Results Found')}}
                                        </div>
                                    </div>
                                    @endif



                                    </tbody>
                                </table><!-- End Table -->
                            </div><!--End Col-xs-12-->
                        </div><!--End Row-->
                    </div><!--End Dashboard-content-->
                </div><!--End Col-md-9-->
            </div><!--End Row-->
        </div><!-- End container -->
    </section><!-- End Section -->
</div>

@endsection