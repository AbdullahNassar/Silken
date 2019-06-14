
<div class="col-md-3">
    <div class="aside-widget">
        <div class="aside-widget-img">
            <img src="{{asset('assets/site/images/team1.jpg')}}" alt="...">
        </div>
        <div class="aside-widget-head">
            <h2 class="title">{{auth()->guard('members')->user()->name}}</h2>
        </div><!-- End Aside-Widget-Head -->
        <div class="aside-widget-content">
            <ul class="dashboard-links">
                <li class="@if(Request::route()->getName() == 'site.dashboard.index'){{'active'}}@endif">
                    <a href="{{route('site.dashboard.index')}}">
                        <i class="fa fa-home"></i>
                        {{trans('trans.dashboard')}}
                    </a>
                </li>
                <li class="@if(Request::route()->getName() == 'site.dashboard.orders'){{'active'}}@endif">
                    <a href="{{route('site.dashboard.orders')}}">
                        <i class="fa fa-inbox"></i>
                        {{trans('trans.orders')}}
                    </a>
                </li>
                <li class="@if(Request::route()->getName() == 'site.wishlist.index'){{'active'}}@endif">
                    <a href="{{route('site.wishlist.index')}}">
                        <i class="fa fa-heart"></i>
                        {{trans('trans.wishlist')}}
                    </a>
                </li>
                <li class="@if(Request::route()->getName() == 'site.dashboard.address'){{'active'}}@endif">

                    <a href="{{route('site.dashboard.address')}}">

                        <i class="fa fa-map-signs"></i>
                        {{trans('trans.address')}}
                    </a>
                </li>
                <li class="@if(Request::route()->getName() == 'site.dashboard.accountsettings'){{'active'}}@endif">

                    <a href="{{route('site.dashboard.accountsettings')}}">
                        <i class="fa fa-gears"></i>
                        {{trans('trans.account-settings')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('site.logout')}}">
                        <i class="fa fa-sign-out"></i>
                        {{trans('trans.logout')}}
                    </a>
                </li>
            </ul>
        </div><!-- End Asite-Widget-Content -->
    </div><!-- End Aside-Widget -->
</div>