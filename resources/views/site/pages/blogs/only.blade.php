@extends('site.layouts.master')
@section('title')
    {{$blog->translated()->title}}
@endsection
@section('content')
    <div class="page-head">
    </div><!-- End Page-Head -->
    <div class="page-content">
        <section class="blog-post">
            <div class="blog-post-img">
                <img src="{{asset('storage/uploads/blogs/'.$blog->image)}}" alt="">
            </div><!-- End Blog-Post-Img -->
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <div class="blog-post-head">
                            <ul class="icon">
                                <li>
                                    <i class="fa fa-user"></i>
                                    <span> بواسطة :</span>
                                    <span class="name">{{$blog->user['username']}}</span>
                                </li>
                                <li>
                                    <i class="fa fa-clock-o"></i>
                                    <span>{{$blog->created_at->format('d,M Y')}}</span>
                                </li>
                            </ul><!-- End Icon -->
                            <h3 class="title wow fadeInRight">
                                {{$blog->translated()->title}}
                            </h3>
                        </div><!-- End Blog-Post-Head -->
                        <div class="blog-post-content wow fadeInRight">
                            {!! $blog->translated()->description !!}
                        </div><!-- End Blog-Post-Content -->
                    </div><!-- End col -->
                </div><!-- End row -->
            </div><!-- End container -->

        </section><!-- End Blog-Post -->
    </div><!--End page-content-->
@endsection