<?php

namespace App\Http\Controllers\Site;

// use PDF;
use App\Order_product;
use App\Order;
use App\Address;
use App\Company;
use App\Notification;
use App\Basket\Basket;
use Illuminate\Http\Request;
use App\Events\OrderWasCreated;
use App\Http\Controllers\Controller;

class OrderController extends Controller {

    /**
     * Instance of Basket.
     *
     * @var Basket
     */
    protected $basket;

    /**
     * Create a new OrderController instance.
     *
     * @param Basket $basket
     */
    public function __construct(Basket $basket) {
        $this->basket = $basket;
    }

    public function getIndex() {
        return view('site.pages.orders.index');
    }

    /**
     * Show the order.
     *
     * @param $hash
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getSummary($hash) {
        if (!auth()->guard('admins')->check() || !auth()->guard('members')->check()) {
            return redirect(route('site.home'))->withFancy([
                        'status' => 'error',
                        'title' => 'فشل العملية',
                        'msg' => 'ﻻ ﻳﻮﺟﺪ ﻫﻨﺎﻙ اﻱ صلاحيات لك لدخول هذه الصفحة.'
            ]);
        }
//        die('mn3mmm');

        $order = Order::with('address', 'products', 'payment')->where('hash', $hash)->first();

        if (!$order) {
            return redirect(route('site.home'))->withFancy([
                        'status' => 'error',
                        'title' => 'فشل العملية',
                        'msg' => 'ﻻ ﻳﻮﺟﺪ ﻫﻨﺎﻙ اﻱ ﻃﻠﺒﺎﺕ ﺗﻄﺎﺑﻖ ﻫﺬا اﻟﻤﻌﺮﻑ.'
            ]);
        }
//        die('mn3mmmss');

        return view('site.pages.checkout.summary', compact('order'));
    }

    public function postReOrder($id, Request $request) {
        $member = auth()->guard('members')->user();
        $order = $member->orders()->find($id);

        if (!$order) {
            return back()->withWarning('There\'s no order with ID #' . $id);
        }

        $v = validator($request->all(), [
            'f_name' => 'required|min:3',
            'l_name' => 'required|min:3',
            'email' => 'required|email',
            'company' => 'required|integer|exists:companies,id',
            'phone' => 'required|phone',
            'address' => 'required|min:5',
            'nonce' => 'required',
                ], [], [
            'f_name' => 'اﻻﺳﻢ اﻻﻭﻝ',
            'l_name' => 'اﻻﺳﻢ اﻟﺜﺎﻧﻲ',
            'address' => 'العنوان',
            'phone' => 'ﺭﻗﻢ اﻟﺘﻠﻴﻔﻮﻥ',
            'email' => 'اﻻﻳﻤﻴﻞ',
            'company' => 'ﺷﺮﻛﺔ اﻟﺸﺤﻦ',
            'nonce' => 'طريقة الدفع',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v);
        }

        $hash = bin2hex(random_bytes(32));

        $address = Address::create([
                    'f_name' => $request->input('f_name'),
                    'l_name' => $request->input('l_name'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'company_id' => $request->input('company'),
                    'email' => $request->input('email'),
        ]);

        $items = $order->products;
        $new_order = $member->orders()->create([
            'hash' => $hash,
            'status' => 'pending',
            'code' => num_random(5),
            'address_id' => $address->id,
            'total' => $items->reduce(function ($total, $item) {
                        return $total + $item->getPivotTotal();
                    }) + Company::find($request->company)->price,
        ]);


        $new_order->products()->saveMany(
                $items, $this->getPivot($items, true)
        );

        switch ($request->nonce) {
            case 'on-delivary':
                return $this->processOnDelivary($new_order);
            default:
                return $this->processCard($new_order, $request);
        }
    }

    /**
     * Create the order.
     *
     * @param CartFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreate(Request $request) {

//        $v = validator($request->all(), [
//            'f_name' => 'required|min:3',
//            'l_name' => 'required|min:3',
//            'email' => 'required|email',
//            'company' => 'required|integer|exists:companies,id',
//            'phone' => 'required|phone',
//            'address' => 'required|min:5',
//            'nonce' => 'required',
//        ],[],[
//            'f_name' => 'اﻻﺳﻢ اﻻﻭﻝ',
//            'l_name' => 'اﻻﺳﻢ اﻟﺜﺎﻧﻲ',
//            'address' => 'العنوان',
//            'phone' => 'ﺭﻗﻢ اﻟﺘﻠﻴﻔﻮﻥ',
//            'email' => 'اﻻﻳﻤﻴﻞ',
//            'company' => 'ﺷﺮﻛﺔ اﻟﺸﺤﻦ',
//            'nonce' => 'طريقة الدفع',
//        ]);
//
//        if($v->fails()){
//            return back()->withErrors($v);
//        }

        $items = $this->getItemsToOrder();
        $allItemsCount = $this->basket->allItemsCount();
        $itemCount = $this->basket->itemCount();
        $hash = bin2hex(random_bytes(32));
        $member = auth()->guard('members')->user();


        $hash = bin2hex(random_bytes(32));
        $order = $member->orders()->create([
            'hash' => $hash,
            'status' => 'pending',
            'code' => num_random(5),
            'address_id' => 1, // $address->id,
            'total' => $this->getItemsTotalCoast()
        ]);





        foreach ($items as $product) {
            $order_product = new Order_product;
            $order_product->product_id = $product->id;
            $order_product->order_id = $order->id;
            $order_product->quantity = $product->count;
            $order_product->total = $product->count * $product->price;
            $order_product->save();
        }
//        die(var_dump('as'));

        $this->basket->clear();

        return $this->processOnDelivary($order);
    }

    protected function processOnDelivary($order) {
//        $order->payment()->updateOrCreate([], [
//            'failed' => true,
//            'method' => 'on-delivary',
//            'transaction_id' => '',
//        ]);
        Notification::send($order->member, 'payment.success', 'success');
//        die(var_dump('mn3m'));
        return redirect(route('site.orders.summary', ['hash' => $order->hash]))->withFancy([
                    'status' => 'success',
                    'title' => trans('notifications.payment.success.title'),
                    'msg' => trans('notifications.payment.success.msg')
        ]);
    }

    protected function processCard($order, Request $request) {

        if (!$request->input('nonce')) {
            Notification::send($order->member, 'payment.failed', 'danger');
            return redirect(route('site.home'))->withError('<strong>' . trans('notifications.payment.failed.title') . '</strong> ' . trans('notifications.payment.failed.msg'));
        }

        $result = \Braintree\Transaction::sale([
                    'amount' => $order->total,
                    'paymentMethodNonce' => $request->input('nonce'),
                    'options' => [
                        'submitForSettlement' => true,
                    ]
        ]);

        if (!$result->success) {
            // TODO: Find a way to attach listeners manually to the OrderWasCreated event.
            $order->payment()->updateOrCreate([], [
                'failed' => true,
                'method' => 'credit-card',
                'transaction_id' => '',
            ]);

            Notification::send($order->member, 'payment.failed', 'danger');
            return back()->withError('<strong>' . trans('notifications.payment.failed.title') . '</strong> ' . trans('notifications.payment.failed.msg'));
        } else {

            $order->payment()->updateOrCreate([], [
                'failed' => false,
                'method' => 'credit-card',
                'transaction_id' => $result->transaction->id,
            ]);

            Notification::send($order->member, 'payment.success', 'success');

            return redirect(route('site.orders.summary', ['hash' => $order->hash]))->withFancy([
                        'status' => 'success',
                        'title' => trans('notifications.payment.success.title'),
                        'msg' => trans('notifications.payment.success.msg')
            ]);
        }
    }

    /**
     * Get the quantity from each item inside the basket.
     *
     * @param  Array $items
     * @return Array
     */
    protected function getPivot($items, $from_pivot = false) {
        $pivots = [];
        foreach ($items as $item) {
            $pivots[] = ['quantity' => $from_pivot ? $item->pivot->quantity : $item->quantity, 'total' => $from_pivot ? $item->getPivotTotal() : $item->getTotal()];
            $item->stock -= $from_pivot ? $item->pivot->quantity : $item->quantity;
            $item->sold += $from_pivot ? $item->pivot->quantity : $item->quantity;
            $item->save();
        }
        return $pivots;
    }

}
