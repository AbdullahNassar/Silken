@extends('site.layouts.master')
@section('title')
{{$product->master->translated(app()->getLocale())->name}}
@endsection
@section('content')
<div class="page-head">
    <div class="container">
        <div class="page-head-info">
            <ul class="breadcrumb">
                <li><a href="{{route('site.store')}}">{{trans('trans.home')}}</a></li>
                <li class="active">{{trans('trans.store')}}</li>
            </ul><!-- End breadcrumb -->
            <h2 class="page-head-title">{{$product->master->translated(app()->getLocale())->name}}</h2>
        </div><!-- End Page-Head-Info -->
    </div><!-- End container -->
</div><!-- End Page-Head -->
<div class="page-content">
    <section class="section-lg single-product">
        <div class="container">
            <div class="single-product-item">
                <div class="row">
                    <div class="col-md-5">
                        <div class="single-product-img">
                            <div class="gallery-image">
                                <img src="@if(count($product->master->getImages())>0){{$product->master->getImages()[0]->url}}@endif" alt=""/>
                            </div>
                            <div class="wrap-gallery-thumb">
                                <div class="gallery-thumb">
                                    <ul>
                                        @if(count($product->master->getImages())>0)
                                        <li class="active">
                                            <a href="#">
                                                <img src="{{$product->master->getImages()[0]->url}}" alt=""/>
                                            </a>
                                        </li>
                                        `

                                        @endif
                                        @foreach($product->master->getImages() as $image)
                                        <li class="">
                                            <a href="#">
                                                <img src="{{$image->url}}" alt=""/>
                                            </a>
                                        </li>
                                        @endforeach


                                    </ul>
                                </div><!--End gallery-thumb-->
                                <div class="gallery-control">
                                    <a href="#" class="prev">
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <a href="#" class="next">
                                        <i class="fa fa-angle-left"></i>
                                    </a>
                                </div><!--End gallery-control-->
                            </div><!--End wrap-gallery-thumb-->
                        </div><!--End Single-produt-img-->
                    </div><!--End Col-md-5-->
                    <div class="col-md-7">
                        <div class="single-product-content">
                            <h2 class="single-product-name">
                                {{$product->master->translated(app()->getLocale())->name}}
                            </h2>
                            <div class="rate-product">
                                <ul class="rate-list">
                                    @php
                                    $total = $product->master->total_reviews();
                                    @endphp
                                    @for($i=1 ; $i<=5 ;$i++)
                                    @if($i <= $total)
                                    <li> <i class="fa fa-star"></i> </li>
                                    @else
                                    <li> <i class="fa fa-star-o"></i> </li>
                                    @endif
                                    @endfor

                                </ul>
                                <span>({{$total}})</span>
                                <a href="#reviews" class="add-review">قيم المنتج</a>
                            </div><!--End rate-product-->
                            <div class="product-info">
                                <P>
                                    {!! $product->master->translated(app()->getLocale())->description !!}
                                </P>

                                <span class="price">
                                    @if (Auth::guard('members')->check() && auth()->guard('members')->user()->membershiptype=='trader')
                                    {{$product->master->price_trader}}
                                    @else
                                    {{$product->master->price}}

                                    @endif
                                </span>

                            </div><!--End Product-info-->
                            <div class="product-store">


                                <a href="#" class="cart-btn cart custom-btn " data-url="{{route('site.cart.add',$product->product_id)}}">
                                    <span>أضف للسلة</span>
                                    <i class="fa fa-shopping-cart"></i>

                                </a>

                                <a href="#" class="wishlist-btn custom-btn" data-url="{{route('site.wishlist.index')}}/{{$product->product_id}}">

                                    <i class="fa fa-heart"></i>
                                </a>

                            </div><!--End product-store-->
                        </div><!--End single-product-content-->
                    </div><!--End Col-md-7-->
                </div><!--End Row-->
            </div><!--End Single-product-item-->
            <div class="single-product-desc">
                <div class="tablist">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active">
                            <a href="#description" aria-controls="description" role="tab" data-toggle="tab">تفاصيل المنتج</a>
                        </li>
                        <li>
                            <a href="#information" aria-controls="information" role="tab" data-toggle="tab">مواصفات المنتج</a>
                        </li>
                        <li>
                            <a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">تقيمات المشترين</a>
                        </li>
                    </ul>
                </div><!--End Tablist-->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="description">
                        {!! $product->master->translated(app()->getLocale())->details !!}


                    </div><!--End Tab-penel-->
                    <div role="tabpanel" class="tab-pane" id="information">
                        <ul class="sepecefications">

                           

                        </ul><!-- End Sepecef                                                                                ications -->
                    </div><!--End Tab-penel-->
                    <div role="tabpanel" class="tab-pane" id="reviews">
                        <div class="rate-comments" id="comment-reviews">
                            @include('site.pages.products.templates.review-template' ,compact('reviews'))

                        </div><!-- End Rate-Comments -->


                        <div class="write-comment">

                            @if(Auth::guard('members')->check())
                            <div class="write-comme    nt-title">
                                <h3 class="title">اضف     تعليقا</h3>
                            </div><!-- End Blog-Co            mments-title -->

                            <form  class="ajax-f        orm review-form" action="{{route('site.products.review')}}"method="post" id="data_review">
                                {{ csrf_field() }}
                                <input type="hidden" name="product_id" value="{{$product->product_id}}">

                                Star
                                <br>
                                <input  name="rate[]" id="rate1" type="checkbox" value="rate1">
                                <input name="rate[]" id="rate2" type="checkbox" value="rate2">
                                <input name="rate[]" id="rate3" type="checkbox" value="rate3">
                                <input name="rate[]" id="rate4" type="checkbox" value="rate4">
                                <input name="rate[]" id="rate5" type="checkbox" value="rate5">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="rateit" data-rateit-mode="font" data-rateit-icon="" style="font-family:fontawesome">  
                                            </div>
                                        </div><!-- End Form-Group -->
                                    </div><!--End Col-md-12-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">اسم بالكامل</label>
                                            <input name="name" class="form-control" value="{{Auth()->guard('members')->user()->name}}" type="text" disabled="disabled">
                                        </div><!-- End Form-Group -->
                                    </div><!-- End col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">البريد الالكتروني</label>
                                            <input id="email" name="email" value="{{Auth()->guard('members')->user()->email}}" type="email" class="form-control" disabled="disabled">
                                        </div><!-- End Form-Group -->
                                    </div><!-- End col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Message">اكتب تعليق</label>
                                            <textarea name="review" id="Message" class="form-control" rows="8"></textarea>
                                        </div><!-- End Form-Group -->
                                    </div><!-- End col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" id="add_review"
                                                    class="ajax-submit custom-btn">{{trans('site_global.submit')}}</button>
                                        </div><!-- End Form-Group -->
                                    </div><!-- End col -->
                                </div><!-- End row -->
                            </form><!-- End form -->
                            @else
                            Please Login To Make Reviews

                            @endif



                        </div>

                    </div>

                </div><!--End Tab-content-->
            </div><!--End Single-product-description-->
        </div><!-- End container -->
    </section><!-- End Section -->
</div><!--End page-content-->
@endsection