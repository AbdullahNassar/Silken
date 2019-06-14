<header class="header">
    <div class="container">
        <div class="logo">
            <a href="{{route('site.home')}}">
                <img src="{{asset('storage/uploads/logo/'.$settings->logo)}}">
            </a>
        </div><!-- End Logo -->
        <button class="btn btn-responsive-nav" data-toggle="collapse" data-target=".navbar-collapse">
            <i class="fa fa-bars"></i>
        </button>
    </div><!-- End container-->
    <div class="navbar-collapse collapse">
        <div class="container">
            <nav class="nav-main">
                <ul class="nav navbar-nav">
                    <li class="@if(Request::route()->getName() == 'site.home'){{'active'}}@endif"><a href="{{route('site.home')}}">{{trans('trans.home')}}</a></li>
                    <li class="@if(Request::route()->getName() == 'site.about'){{'active'}}@endif"><a href="{{route('site.about')}}">{{trans('trans.about')}}</a></li>
                    <li class="@if(Request::route()->getName() == 'site.services'){{'active'}}@endif"><a href="{{route('site.services')}}">{{trans('trans.services')}}</a></li>
                    <li class="dropdown @if(Request::route()->getName() == 'site.solution'){{'active'}}@endif">
                        <a href="#" data-toggle="dropdown">
                            {{trans('trans.solutions')}}<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-menu-content">
                                <div class="row">
                                    @foreach($solutions as $solution)
                                    <div class="col-md-3 col-xs-6">
                                        <a href="{{route('site.solution',['slug'=>$solution->slug])}}" class="">
                                            <img src="{{asset('storage/uploads/solutions/'.$solution->icon)}}">
                                            {{$solution->translated()->title}}
                                        </a>
                                    </div><!--End col-md-4-->
                                    @endforeach
                                </div><!--End row -->
                            </li><!--End dropdown-menu-content-->
                        </ul><!--End dropdown-menu-->
                    </li>
                    <li class="@if(Request::route()->getName() == 'site.products'){{'active'}}@endif"><a href="{{route('site.products')}}">{{trans('trans.products')}}</a></li>
                    <li class="@if(Request::route()->getName() == 'site.blogs'){{'active'}}@endif"><a href="{{route('site.blogs')}}">{{trans('trans.blogs')}}</a></li>
                    <li class="@if(Request::route()->getName() == 'site.contact'){{'active'}}@endif"><a href="{{route('site.contact')}}">{{trans('trans.contact')}}</a></li>
                    <li>
                    @if (Config::get('app.locale') == 'en')
                        <a href="{{action('LangController@postIndex')}}" class="langSwitch" data-lang="ar"><i class="fa fa-language"></i></a>
                        @elseif(Config::get('app.locale') == 'ar')
                        <a href="{{action('LangController@postIndex')}}" class="langSwitch" data-lang="en"><i class="fa fa-language"></i></a>
	            @endif
                    </li>
                </ul>
            </nav><!-- End nav-main -->
        </div><!-- End Container -->
    </div><!-- End nav-main-collapse -->
</header><!-- End Header -->