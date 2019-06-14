@extends('site.layouts.master')
@section('title')
    المقالات
@endsection
@section('content')
    <div class="page-head">
        <div class="container">
            <div class="page-head-info">
                <ul class="breadcrumb">
                    <li><a href="{{route('site.home')}}">{{trans('trans.home')}}</a></li>
                    <li class="active">{{trans('trans.blogs')}}</li>
                </ul><!-- End breadcrumb -->
                <h2 class="page-head-title">{{trans('trans.blogs')}}</h2>
            </div><!-- End Page-Head-Info -->
        </div><!-- End container -->
    </div><!-- End Page-Head -->
    <div class="page-content">
        <section class="blog section-lg">
            <div class="container">
                <div class="row">
                    @foreach($blogs as $blog)
                    <div class="col-md-4 wow fadeInUp">
                        <div class="blog-box">
                            <div class="blog-box-img custom-hover">
                                <div class="date">
                                    <span>{{$blog->created_at->format('D')}}</span>
                                    <span>{{$blog->created_at->format('M')}}</span>
                                </div><!--End date-->
                                <img src="{{asset('storage/uploads/blogs/'.$blog->image)}}" alt="...">
                                <figcaption></figcaption>
                            </div><!--End Blog-box-img-->
                            <div class="blog-box-content">
                                <h2 class="blog-title">{{$blog->translated()->title}}</h2>
                                {{ strip_tags(str_limit($blog->translated()->description ,100)) }}
                                <a href="{{route('site.blogs.only' ,['slug'=>$blog->slug])}}" class="btn-more">المزيد +</a>
                            </div><!--End Blog-box-content-->
                        </div><!--End Blog-box-->
                    </div><!--End Col-md-4-->
                    @endforeach
                </div><!--End Row-->
            </div><!--End Container-->
        </section>
    </div><!--End page-content-->
@endsection