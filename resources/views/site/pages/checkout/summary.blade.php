<html>
    <head>
        <!-- Basic page needs
        ===========================-->
        <title>@yield('title')</title>
        <meta charset="utf-8">
        <meta name="author" content="">
        <meta name="description" content="">
        <meta name="keywords" content="">

        <!-- Mobile specific metas
        ===========================-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Favicon
        ===========================-->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/site/images/fave.png')}}">

        <!-- Google Web Fonts
        ===========================-->
        @if(app()->getLocale() == 'en')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700">
        @else
        <link href="http://fonts.googleapis.com/earlyaccess/droidarabickufi.css" rel="stylesheet" type="text/css">
        @endif
        <!-- Css Base And Vendor
        ===========================-->
        @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{asset('assets/site/vendor/bootstrap/css/bootstrap-ar.css')}}">
        @else
        <link rel="stylesheet" href="{{asset('assets/site/vendor/bootstrap/css/bootstrap.css')}}">
        @endif
        <link rel="stylesheet" href="{{asset('assets/site/vendor/jquery-ui/jquery-ui.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/site/vendor/font-awesome/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/site/vendor/owl-carousel/css/owl.carousel.css')}}">
        <link rel="stylesheet" href="{{asset('assets/site/vendor/owl-carousel/css/owl.theme.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

        <!-- Site Style
        ===========================-->
        <link rel="stylesheet" href="{{asset('assets/site/css/style.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/site/css/test.css') }}">
        @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{asset('assets/site/css/style-en.css')}}">
        @endif
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style media="screen">
            * { margin:0 }
        </style>
    </head>
    <body onload="print();">

        <div class="wrapper">
            <div class="main" role="main">
                @php
                $user = auth()->guard('members')->user();
                $address = $order->address;
                $payment = $order->payment;
                
                $items = $order->products;
                $subTotal = $items->sum('pivot.total');
                @endphp
                <div class="page-content">
                    <section class="invoice" >
                        <div class="container-fluid">
                            <div class="top-box">
                                <div class="logo">
                                    <img src="{{ asset("assets/site/images/logo.png") }}" alt="logo">
                                </div> <!-- End logo -->
                                <div class="date">
                                    Date: {{ $order->created_at->format('d/m/Y') }}
                                </div> <!-- End Text --->
                            </div>
                            <div class="middle-box">
                                <div class="middle-box-head">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            From
                                            <address>
                                                <b>Silken, Inc.</b><br>
                                                {{ $settings->address }}<br>
                                                eCommerce Platform.<br>
                                                Phone: {{ $settings->phone }}<br>
                                                Email: {{ $settings->email }}
                                            </address>
                                        </div> <!-- End Col -->
                                        <div class="col-sm-4">
                                            To
                                            <address>
                                                <address>
                                                    <b>{{ $address->getFullName() }}</b><br>
                                                    {{ $address->address }}<br>
                                                    Online Customer.<br>
                                                    Phone: {{ $address->phone }}<br>
                                                    Email: {{ $address->email }}
                                                </address>
                                            </address>
                                        </div> <!-- End Col -->
                                        <div class="col-sm-4">
                                            <b>Code #{{ $order->code }}</b><br><br>
                                            <b>Order ID:</b> #{{ $order->id }}<br>
                                            
                                        </div> <!-- End Col -->
                                    </div> <!-- End Row -->
                                </div> <!-- End middel-box-head -->
                                <div class="middle-box-content">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Qty</th>
                                                <th>Product</th>
                                                <th>Serial #</th>
                                                <th>Description</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $item->pivot->quantity }}</td>
                                                <td>{{ $item->translated()->name }}</td>
                                                <td>#{{ $item->id }}</td>
                                                <td>{{ $item->getDescription(85) }}</td>
                                                <td>{{ num_format($item->pivot->total) }} (SAR)</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- End middle-box-content -->
                                <div class="middle-box-footer">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="payment">
                                                <p>Payment Methods:</p>
                                                
                                                <img src="{{ asset("assets/site/images/cash.png") }}" alt="Cash">
                                                
                                                <p class="text-note">
                                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
                                                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                                </p>
                                            </div> <!-- End payment -->
                                        </div> <!-- End Col -->
                                        <div class="col-sm-6">
                                            <div class="">
                                                <ul class="second">
                                                    <li>Subtotal:</li>
                                                    <li>{{ num_format($subTotal) }} (SAR)</li>
                                                    <li>Shipping:</li>
                                                    <li>{{ num_format($order->total - $subTotal) }} (SAR)</li>
                                                    <li>Total:</li>
                                                    <li>{{ num_format($order->total) }} (SAR)</li>
                                                </ul>
                                            </div> <!-- End -->
                                        </div> <!-- End Col -->
                                    </div> <!-- End Row -->
                                </div> <!-- End middle-box-footer -->
                            </div>
                        </div><!--End container-fluid-->
                    </section>
                </div><!--End page-content-->
            </div>
        </div>
    </body>
</html>
