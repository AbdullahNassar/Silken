<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="widget">
                    <div class="widget-content">
                        <div class="foot-about">
                            <a href="{{route('site.home')}}">
                                <img src="{{asset('assets/site/images/footer-logo.png')}}" alt="...">
                            </a>
                            <p>{{$statics[2]->translated()->description}}</p>
                        </div>
                        <ul class="social-list">
                            <li><a href="{{$settings->facebook}}"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{$settings->twitter}}"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{$settings->google}}"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="{{$settings->linkdin}}"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="{{$settings->instagram}}"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div><!--End WIdget-content-->
                </div><!--End Foot-widget-->
            </div><!--End Col-md-4-->
            <div class="col-md-4">
                <div class="widget">
                    <div class="widget-head">
                        <h2 class="title title-md has-before">الخدمات</h2>
                    </div><!--End Widget-head-->
                    <div class="widget-content">
                        <ul class="importan-links">
                            @foreach($services as $service)
                            <li>
                                {{$service->translated()->title}}
                            </li>
                            @endforeach
                        </ul>
                    </div><!--End WIdget-content-->
                </div><!--End Foot-widget-->
            </div><!--End Col-md-4-->
            <div class="col-md-3">
                <div class="widget">
                    <div class="widget-head">
                        <h2 class="title title-md has-before">{{$statics[3]->translated()->title}}</h2>
                    </div><!--End Widget-head-->
                    <div class="widget-content">
                        <p>{{$statics[3]->translated()->description}}</p>
                        <form class="subscribe-form" method="post" action="{{route('site.subscribe')}}">
                            {!! csrf_field() !!}
                            <div class="alert alert-success hidden" id="news-alert-success"></div>
                            <div class="alert alert-danger hidden" id="news-alert-error"></div>

                            <div class="form-group">
                                <input class="form-control" name="email" data-msg-required="{{trans('trans.email_req')}}" type="email" placeholder="{{trans('trans.email')}}">
                                <button class="subscribe-btn" type="submit">{{trans('trans.sub_button')}}</button>
                            </div><!--End Form-group-->
                        </form><!--End Subscribe-form-->
                    </div><!--End WIdget-content-->
                </div><!--End Foot-widget-->
            </div><!--End Col-md-4-->
        </div><!--End Row-->
    </div><!--End COntainer-->
    <div class="copyright">
        <div class="container">
            <div class="pull-left">
                &copy; جميع الحقوق محفوظة لصالح <a href="{{route('site.home')}}">سلكين</a>
            </div>
            <div class="pull-right">
               تصميم و برمجة <a href="http://upureka.com/">Upureka</a>
            </div>
        </div><!--End Container-->
    </div><!--End Copyright-->
</footer><!--End Footer-->