<div class="page-sidebar-wrapper">
    <!-- END SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item start @if(Request::route()->getName() == 'admin.home' ){{'active open'}} @endif">
                <a href="{{route('admin.home')}}" class="nav-link nav-toggle">
                    <i class="fa fa-home"></i>
                    <span class="title">الرئيسيه</span>
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                </a>
            </li>

            <li class="nav-item start @if(Request::route()->getName() == 'admin.categories.index'){{'active open'}} @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-list-ol"></i>
                    <span class="title">Categories</span>
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start @if(Request::route()->slug == 'main'){{'active open'}} @endif">
                        <a href="{{route('admin.categories.index' , ['type' => 'main'])}}" class="nav-link ">
                            <i class="fa fa-gear"></i>
                            <span class="title">Main Categories</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item start @if(Request::route()->slug == 'sub'){{'active open'}} @endif">
                        <a href="{{route('admin.categories.index' , ['type' => 'sub'])}}" class="nav-link ">
                            <i class="fa fa-map"></i>
                            <span class="title">Sub Categories</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item start @if(Request::route()->slug == 'subsub'){{'active open'}} @endif">
                        <a href="{{route('admin.categories.index' , ['type' => 'subsub'])}}" class="nav-link ">
                            <i class="fa fa-map"></i>
                            <span class="title">Sub Sub Categories</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>



            <li class="nav-item start @if(Request::route()->getName() == 'admin.products.index') {{'active'}} @endif">
                <a href="{{ route('admin.products.index') }}">
                    <i class="fa fa-pencil-square-o"></i>
                    <span class="title">Products </span>
                </a>
            </li>

            <li class="nav-item start @if(Request::route()->getName() == 'admin.orders.index') {{'active'}} @endif">
                <a href="{{ route('admin.orders.index') }}">
                    <i class="fa fa-pencil-square-o"></i>
                    <span class="title">Orders </span>
                </a>
            </li>


            <li class="nav-item start @if(Request::route()->getName() == 'admin.settings.map' || Request::route()->getName() == 'admin.settings'){{'active open'}} @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-gears"></i>
                    <span class="title">الاعدادات</span>
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start @if(Request::route()->getName() == 'admin.settings'){{'active open'}} @endif">
                        <a href="{{route('admin.settings')}}" class="nav-link ">
                            <i class="fa fa-gear"></i>
                            <span class="title">بيانات الموقع</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.sliders') {{'active'}} @endif">
                <a href="{{route('admin.sliders')}}">
                    <i class="fa fa-image"></i>
                    <span class="title">السلايد شو</span>
                </a>
            </li>

            <li class="nav-item start @if(Request::route()->getName() == 'admin.members') {{'active'}} @endif">
                <a href="{{route('admin.members')}}">
                    <i class="fa fa-users"></i>
                    <span class="title">members</span>
                </a>
            </li>

            <li class="nav-item start @if(Request::route()->getName() == 'admin.statics'){{'active open'}}@endif">
                <a href="{{route('admin.statics')}}" class="nav-link nav-toggle ">
                    <i class="fa fa-info-circle"></i>
                    <span class="title">البيانات الثابته</span>
                </a>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.about') {{'active'}} @endif">
                <a href="{{route('admin.about')}}">
                    <i class="fa fa-info"></i>
                    <span class="title">من نحن</span>
                </a>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.sproducts') {{'active'}} @endif">
                <a href="{{route('admin.sproducts')}}">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="title">المنتجات</span>
                </a>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.solutions') {{'active'}} @endif">
                <a href="{{route('admin.solutions')}}">
                    <i class="fa fa-info-circle"></i>
                    <span class="title">حلولنا</span>
                </a>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.customers') {{'active'}} @endif">
                <a href="{{route('admin.customers')}}">
                    <i class="fa fa-user"></i>
                    <span class="title">العملاء</span>
                </a>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.blogs') {{'active'}} @endif">
                <a href="{{route('admin.blogs')}}">
                    <i class="fa fa-newspaper-o"></i>
                    <span class="title">المقالات</span>
                </a>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.services') {{'active'}} @endif">
                <a href="{{route('admin.services')}}">
                    <i class="fa fa-list"></i>
                    <span class="title">الخدمات</span>
                </a>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.partners') {{'active'}} @endif">
                <a href="{{route('admin.partners')}}">
                    <i class="fa fa-users"></i>
                    <span class="title">الشركاء</span>
                </a>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.clients') {{'active'}} @endif">
                <a href="{{route('admin.clients')}}">
                    <i class="fa fa-users"></i>
                    <span class="title">العملاء بصفحه من نحن</span>
                </a>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.subscribtions.index') {{'active'}} @endif">
                <a href="{{route('admin.subscribtions.index')}}">
                    <i class="fa fa-envelope"></i>
                    <span class="title">الاشتراكات</span>
                </a>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.messages'){{'active open'}}@endif">
                <a href="{{route('admin.messages')}}" class="nav-link nav-toggle ">
                    <i class="fa fa-envelope"></i>
                    <span class="title">الرسائل</span>
                </a>
            </li>
            <li class="nav-item start @if(Request::route()->getName() == 'admin.contact') {{'active'}} @endif">
                <a href="{{route('admin.contact')}}">
                    <i class="fa fa-info-circle"></i>
                    <span class="title">بيانات تواصل معنا</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
