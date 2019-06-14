<header class="header">
    <div class="top-header">
        <div class="container">
            <div class="register-lang">
                <ul class="top-header-links">
                    @if (Auth::guard('members')->check())
                    <li>
                        <a href="{{route('site.dashboard.index')}}" class="sign">
                            <i class="fa fa-home"></i>
                            {{trans('trans.dashboard')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('site.logout')}}" class="sign">
                            <i class="fa fa-lock"></i>
                            {{trans('trans.logout')}}
                        </a>
                    </li>
                    
                    @else
                    <li>
                        <a href="{{route('site.login')}}" class="sign">
                            <i class="fa fa-user"></i>
                            {{trans('trans.login')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('site.register')}}" class="sign">
                            <i class="fa fa-lock"></i>
                            {{trans('trans.register')}}
                        </a>
                    </li>
                    @endif

                    <li>
                        @if (Config::get('app.locale') == 'en')
                        <a href="{{action('LangController@postIndex')}}" class="langSwitch" data-lang="ar"><i class="fa fa-language"></i></a>
                        @elseif(Config::get('app.locale') == 'ar')
                        <a href="{{action('LangController@postIndex')}}" class="langSwitch" data-lang="en"><i class="fa fa-language"></i></a>
                        @endif
                    </li>
                </ul><!--End top-header-links-->
            </div><!-- End Register-Lang -->
        </div><!-- End container -->
    </div><!-- End Top-Header -->
    <div class="container">
        <div class="logo">
            <a href="{{route('site.home')}}">
                <img src="{{asset('storage/uploads/logo/'.$settings->logo)}}">
            </a>
        </div><!-- End Logo -->
        <button class="btn btn-responsive-nav" data-toggle="collapse" data-target=".navbar-collapse">
            <i class="fa fa-bars"></i>
        </button>

        <div class="header-control">
            <div class="icon">
                
                <a href="{{route('site.wishlist.index')}}" class="head-wish">
                    <i class="fa fa-heart">
                        <span id="wishlist-count" class="badge"></span>
                    </i>
                </a>
            </div>
            <div class="icon cart dropdown">
                <a href="#" id="getCartTopMenu-url" data-url="{{route('site.cart.getCartTopMenu')}}" style="display: none"></a>
                <a href="{{route('site.cart.index')}}">
                    <i class="fa fa-shopping-cart"></i>
                    <span id="shopping-cart-count" class="badge"></span>
                </a>
                <div class="dropdown-menu" id="shopping-cart-box"></div>
                
            </div>
            <div class="icon search dropdown open">
                <a href="#" data-toggle="dropdown" aria-expanded="true">
                    <i class="fa fa-search"></i>
                </a>
                <div class="dropdown-menu">
                    <form class="search-form">
                        <input class="form-control" placeholder="ابحث هنا ..." type="text">
                        <button class="search-btn">
                            <i class="fa fa-search"></i>
                        </button>
                    </form><!--End Form-->
                </div><!--End Dropdown-menu-->
            </div>
        </div>
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
                    <li class="@if(Request::route()->getName() == 'site.sproducts'){{'active'}}@endif"><a href="{{route('site.sproducts')}}">{{trans('trans.products')}}</a></li>

                    <li class="@if(Request::route()->getName() == 'site.store'){{'active'}}@endif"><a href="{{route('site.store')}}">{{trans('trans.store')}}</a></li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            {{trans('trans.more')}} <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu small-menu">
                            <li class="@if(Request::route()->getName() == 'site.blogs'){{'active'}}@endif"><a href="{{route('site.blogs')}}">{{trans('trans.blogs')}}</a></li>
                            <li class="@if(Request::route()->getName() == 'site.contact'){{'active'}}@endif"><a href="{{route('site.contact')}}">{{trans('trans.contact')}}</a></li>


                        </ul><!--End dropdown-menu-->
                    </li>

                </ul>
            </nav><!-- End nav-main -->
        </div><!-- End Container -->
    </div><!-- End nav-main-collapse -->
</header><!-- End Header -->