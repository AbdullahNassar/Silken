@extends('site.layouts.master')
@section('title')
عن سلكين
@endsection
@section('content')
<div class="page-head">
    <div class="container">
        <div class="page-head-info">
            <ul class="breadcrumb">
                <li><a href="{{route('site.cart.index')}}">{{trans('trans.home')}}</a></li>
                <li class="active">{{trans('trans.cart')}}</li>
            </ul><!-- End breadcrumb -->
            <h2 class="page-head-title">{{trans('trans.home')}}</h2>
        </div><!-- End Page-Head-Info -->
    </div><!-- End container -->
</div><!-- End Page-Head -->


<div class="page-content">
    <form action="{{ route('site.orders.create') }}" id="payment-form" method="post">
        {{ csrf_field() }}
        <section class="section-lg checkout">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="toggle-container style-2" id="accordion1">
<!--                            <div class="panel">
                                <a href="#accord1" data-toggle="collapse" data-parent="#accordion1" class="panel-title collapsed" aria-expanded="false">
                                    معلومات الحساب
                                </a>
                                <div class="panel-collapse collapse" id="accord1" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-content">
                                        <div class="row">


                                        </div>End row
                                    </div> end content 
                                </div>
                            </div>
                            End panel-->
<!--                            <div class="panel">
                                <a class="panel-title collapsed" href="#accord2" data-toggle="collapse" data-parent="#accordion1" aria-expanded="false">وسائل الدفع</a>
                                <div class="panel-collapse collapse" id="accord2" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-content">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="radio-check-item">
                                                    <input name="ship-type" class="form-control" id="Paypal" type="radio">
                                                    <label for="Paypal">
                                                        الدفع عن الاستلام
                                                    </label>
                                                </div> End Radio-Check-Item 
                                            </div>End col-xs-12


                                        </div>End Row
                                    </div> end content 
                                </div>
                            </div>End panel-->
                            <div class="panel">
                                <a class="panel-title " href="#accord3" data-toggle="collapse" data-parent="#accordion1" aria-expanded="true">تفاصيل الطلب</a>
                                <div class="panel-collapse collapse in" id="accord3" aria-expanded="true" style="">
                                    <div class="panel-content">
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>تفاصيل المنتج</th>
                                                    <th>الكمية</th>
                                                    <th>السعر</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                @php
                                                $total=0;
                                                @endphp

                                                @foreach($items as $product)
                                                <tr>
                                                    <td>
                                                        <img src="@if(count($product->getImages())>0){{$product->getImages()[0]->url}}@endif" alt="...">
                                                    </td>
                                                    <td>
                                                        <a href="{{$product->getUrl()}}" class="product-link">         
                                                            @php
                                                            $name = $product->translated(app()->getLocale());
                                                            @endphp
                                                            {{$name->name}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="cart-number">


                                                            {{$product->count}}

                                                        </div><!--End cart-number-->
                                                    </td>
                                                    @php
                                                    $total=$total+($product->price*$product->count);
                                                    @endphp
                                                    <td>{{$product->price*$product->count}} $</td>
                                                    <td>
<!--                                                        <a href="#">
                                                            <i class="fa fa-trash"></i>
                                                        </a>-->
                                                    </td>
                                                </tr>
                                                @endforeach


                                            </tbody>
                                        </table><!-- End Table -->

                                        
                                        <button class="custom-btn btn-checkout " id="on-delivary" type="submit">
                                            ادفع
                                        </button>
                                        
                                        
                                    </div><!-- end content -->
                                </div>
                            </div><!--End panel-->
                        </div><!--End toggle-container-->
                    </div><!--End col-md-10-->
                </div><!--End Row-->
            </div><!-- End container -->
        </section><!-- End Section -->
    </form>

</div>
@endsection
@section('scripts')
<script>
    var form = document.getElementById('payment-form');
    document.getElementById('on-delivary').addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('nonce').value = 'on-delivary';
        form.submit();
    });
    ;
</script>
@endsection
