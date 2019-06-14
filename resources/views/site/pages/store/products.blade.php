
<div class="section-content" id="products-area">
    <div class="row">

        @foreach ($products as $product)

        <div class="col-md-4 col-sm-6">
            <div class="product-item">
                <div class="product-item-head">
                    <img src="@if(count($product->getImages())>0){{$product->getImages()[0]->url}}@endif" alt="...">
                </div><!-- End Product-Item-Head -->
                <div class="product-item-content">
                    @php
                    $name = $product->translated(app()->getLocale());
                    $slug=$product->slug;
                    @endphp
                    <a href="{{$product->getUrl()}}" class="title">

                        {{$name->name}}



                    </a>
                    <ul class="rate-list">
                        @php
                        $total = $product->total_reviews();
                        @endphp
                        @for($i=1 ; $i<=5 ;$i++)
                        @if($i <= $total)
                        <li> <i class="fa fa-star"></i> </li>
                        @else
                        <li> <i class="fa fa-star-o"></i> </li>
                        @endif
                        @endfor

                    </ul><span>@if($total){{$total}}@endif</span>

                    <p class="item-desc">


                        {{$product->getDescription()}}
                        ...<a href="single-product.html">المزيد+</a>
                    </p>
                </div><!-- End Product-Content -->
                <div class="product-item-layout">
                    <p class="price">
                        @if (Auth::guard('members')->check() && auth()->guard('members')->user()->membershiptype=='trader')
                        {{$product->price_trader}}
                        @else
                        {{$product->price}}

                        @endif
                    </p>
                    <a href="#" class="cart-btn cart" data-url="{{route('site.cart.add',$product->id)}}">

                        <i class="fa fa-shopping-cart"></i>
                        <span>أضف للسلة</span>
                    </a>
                    <ul class="product-otion">
                        <li>
                            <a href="#" class="wishlist-btn" data-url="{{route('site.wishlist.index')}}/{{$product->id}}">
                                <i class="fa fa-heart"></i>
                                <span>اضف للمفضلة</span>
                            </a>
                        </li>
                        <!--                        <li>
                                                    <a href="#">
                                                        <i class="fa fa-refresh"></i>
                                                        <span>قارن</span>
                                                    </a>
                                                </li>-->
<!--                        <li>
                            <a href="#">
                                <i class="fa fa-eye"></i>
                                <span>مشاهدة</span>
                            </a>
                        </li>-->
                    </ul><!-- End Product-option -->
                </div><!-- End Layout -->
            </div><!-- End Product-Item -->
        </div><!-- End col -->

        @endforeach






    </div><!-- End row -->

    @include('site.pages.store.pagination')
</div><!-- End Section-Content -->
