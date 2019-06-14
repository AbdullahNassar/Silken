



<div class="drop-down-head">
    عناصر فى العربة <span>({{$allItemsCount}})</span>
</div><!--End Dropdown-foot-->
<a href="#" id="getCartTopMenu-url" data-url="{{route('site.cart.getCartTopMenu')}}" style="display: none;"></a>
<ul class="cart-dropdown" id="shopping-cart-box" style="overflow-y: hidden;" tabindex="0">
    @foreach($items as $product)
    <li>
        <div class="cart-widget">
            <div class="cart-widget-head">
                <img src="@if(count($product->getImages())>0){{$product->getImages()[0]->url}}@endif" alt="...">
            </div><!--End Cart-widget-head-->
            <div class="cart-widget-content">
                <a href="{{$product->getUrl()}}"  class="cart-widget-name">
                    @php
                    $name = $product->translated(app()->getLocale());
                    @endphp
                    {{$name->name}}


                </a>

                <span class="price">
                    @if (Auth::guard('members')->check() && auth()->guard('members')->user()->membershiptype=='trader')
                    {{$product->price_trader}}
                    @else
                    {{$product->price}}

                    @endif
                </span>
                
                <button class="remove-btn trash-btn" data-url="{{route('site.cart.delete',$product->id)}}">
                    <span aria-hidden="true">×</span>
                </button>
            </div><!--End Cart-widget-content-->
        </div><!--End Cart-widget-->
    </li>
    @endforeach

</ul><!--End Cart-dropdown-->
<div class="drop-down-foot">
    <a href="{{route('site.cart.index')}}">عربة الشراء</a>
</div><!--End Dropdown-foot-->
<div id="ascrail2001" class="nicescroll-rails nicescroll-rails-vr" style="width: 5px; z-index: 999; background: rgba(255, 255, 255, 0.3) none repeat scroll 0% 0%; cursor: default; position: absolute; top: 51px; left: 255px; height: 281px; opacity: 1; display: none;"><div style="position: relative; top: 0px; float: right; width: 5px; height: 0px; background-color: rgb(77, 78, 78); border: medium none; background-clip: padding-box; border-radius: 3px;" class="nicescroll-cursors"></div></div>