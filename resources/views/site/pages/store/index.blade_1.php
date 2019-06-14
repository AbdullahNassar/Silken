@extends('site.layouts.master')
@section('title')
Store
@endsection
@section('content')
<div class="page-head">
    <div class="container">
        <div class="page-head-info">
            <ul class="breadcrumb">
                <li><a href="{{route('site.store')}}">{{trans('trans.home')}}</a></li>
                <li class="active">{{trans('trans.store')}}</li>
            </ul><!-- End breadcrumb -->
            <h2 class="page-head-title">{{trans('trans.home')}}</h2>
        </div><!-- End Page-Head-Info -->
    </div><!-- End container -->
</div><!-- End Page-Head -->
<div class="page-content">
    <section class="section-lg category">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="sitebar">
                        <div class="aside-widget">
                            <div class="aside-widget-head">
                                <h3 class="title">{{trans('trans.Product Categories')}} </h3>
                            </div><!-- End Aside-Widget-Head -->
                            <div class="aside-widget-content">
                                <div class="toggle-container style-2" id="items">

                                    @foreach ($cats as $category)
                                    <div class="panel">
                                        @php


                                        $Cat = $category->translated(app()->getLocale());
                                        @endphp
                                        <a href="#{{$category->id}}" data-toggle="collapse" data-parent="#items" class="collapsed">
                                            {{ "$Cat->name" }}
                                        </a>

                                    </div>
                                    @endforeach



                                    @foreach ($categories['main'] as $category)
                                    <div class="panel">
                                        @php


                                        $Cat = $category->translated(app()->getLocale());
                                        @endphp
                                        <a href="#{{$category->id}}" data-toggle="collapse" data-parent="#items" class="collapsed">
                                            {{ "$Cat->name" }}
                                        </a>
                                        <div class="panel-collapse collapse" id="{{$category->id}}">
                                            <form class="{{route('site.store')}}">

                                                @foreach ($category->subCategories as $sub)
                                                @php

                                                $SubCat = $sub->translated(app()->getLocale());
                                                @endphp


                                                <div class="form-group">

                                                    <div class="radio-check-item">
                                                        <input type="checkbox" name="categories[{{ $sub->id }}]" class="form-control categoriy-input" value="{{ $sub->id }}" id="cat-{{ $sub->id }}">
                                                        <label for="cat-{{ $sub->id }}">
                                                            {{ "$SubCat->name" }}
                                                        </label>
                                                    </div><!-- End Radio-Check-Item -->
                                                </div><!-- End Form-Group -->  
                                                @endforeach




                                            </form><!-- End form -->
                                        </div><!--End panel-collapse-->
                                    </div><!--End Panel-->
                                    @endforeach









                                </div><!--End toggle-container-->
                            </div><!-- End Asite-Widget-Content -->
                        </div><!-- End Aside-Widget -->
                        <div class="aside-widget">
                            <div class="aside-widget-head">
                                <h3 class="title">{{trans('trans.price')}}</h3>
                            </div><!-- End Aside-Widget-Head -->
                            <div class="aside-widget-content">
                                <div class="widget-range">
                                    <div class="clearfix">
                                        <input id="first_limit" data-value="{{$min}}" class="first_limit" readonly name="" type="text" value="{{$min}}">
                                        <input id="last_limit" data-value="{{$max}}" class="last_limit" readonly name="" type="text" value="{{$max}}">
                                    </div>     
                                    <div id="price_range"></div>
                                </div><!--En                            d Widget-Range -->
                            </div><!-- End Aside-Widget-Cont                        ent -->
                        </div><!-- End Aside-Widget -->

                    </aside><!-- End Aside -->
                </div><!-- End col -->
                <div class="col-md-9">
                    <form action="{{route('site.store')}}">
                        <div class="section-head">

                            <p>
                                <select id="el-count">
                                    <option value="3">3</option>
                                    <option value="6">6</option>
                                    <option value="9">9</option>
                                    <option value="12">12</option>
                                </select>
                            </p>
                            <p>
                                {{trans('trans.order by')}} :

                                <select id="order_by">
                                    <option value="latest">{{trans('trans.latest')}} </option>
                                    <option value="price_desc">{{trans('trans.Highest price')}}</option>
                                    <option value="price_asc">{{trans('trans.Lowest price')}}</option>
                                </select>
                            </p>
                            <div class="toggle-items">
                                <a href="#" class="active grid">
                                    <i class="fa fa-th"></i>
                                </a>
                                <a href="#" class="list">
                                    <i class="fa fa-th-list"></i>
                                </a>
                            </div><!--End toggle Items-->
                        </div>
                        @include('site.pages.store.products',['paginator' => $products])
                    </form>

                </div><!-- End col -->
            </div><!-- End row -->   
        </div><!-- End container -->
    </section><!-- End Section -->
</div><!--End page-content-->


@endsection