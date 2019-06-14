<?php

namespace App\Http\Controllers\Site;

use App\Product;
use App\Company;
use App\Http\Requests;
use App\Basket\Basket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller {

    /**
     * Instance of Basket.
     *
     * @var Basket
     */
    protected $basket;

    /**
     * Create a new CartController instance.
     *
     * @param Basket  $basket
     * @param Product $product
     */
    public function __construct(Basket $basket) {
        $this->basket = $basket;
    }

    /**
     * Show all items in the Basket.
     *
     */
    public function getIndex() {
        $items = $this->getItemsToOrder();
        $allItemsCount = $this->basket->allItemsCount();
        $itemCount = $this->basket->itemCount();



        return view('site.pages.cart.index', compact('items', 'allItemsCount'));
    }

    public function getCheckout($id = '') {
        if ($id) {
            $order = \App\Order::find($id);

            if (!$order) {
                return back()->withFancy([
                            'title' => 'Failure',
                            'status' => 'warning',
                            'msg' => 'There\'s no order with ID #' . $id,
                ]);
            }

            return view('site.pages.checkout.re-order', compact('order'));
        } else {
            $items = $this->getItemsToOrder();
            $allItemsCount = $this->basket->allItemsCount();
            $itemCount = $this->basket->itemCount();


//            $this->basket->refresh();
            return view('site.pages.checkout.index', compact('items', 'allItemsCount'));
        }
    }

    /**
     * Add items to the Basket.
     *
     * @param $slug
     * @param $quantity
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postAdd($id, Request $request) {
////        session()->put('key', 'sa');
////        session()->save();
//        $value = session()->get('key');
//        var_dump($value);
//        die();
        $product = Product::where('id', $id)->first();

        if (!$product) {
            return [
                'status' => 'error',
                'msg' => trans('global.cart.notfound', ['slug' => $product->slug]),
            ];
        }

//        var_dump($this->basket->add($product, $request->quantity));
//        die('');
//        return [];
//        $product = $product->master;
        if (!$this->basket->add($product, $request->quantity)) {
            return [
                'status' => 'warning',
                'msg' => 'fali',
            ];
        }


        return [
            'status' => 'success',
            'msg' => trans('global.cart.add', ['name' => $product->translated()->name]),
            'count' => $this->basket->itemCount()
        ];
    }

    public function postMin($id, Request $request) {
////        session()->put('key', 'sa');
////        session()->save();
//        $value = session()->get('key');
//        var_dump($value);
//        die();
        $product = Product::where('id', $id)->first();

        if (!$product) {
            return [
                'status' => 'error',
                'msg' => trans('global.cart.notfound', ['slug' => $product->slug]),
            ];
        }

//        var_dump($this->basket->add($product, $request->quantity));
//        die('');
//        return [];
//        $product = $product->master;
        if (!$this->basket->min($product)) {
            return [
                'status' => 'warning',
                'msg' => 'fali',
            ];
        }


        return [
            'status' => 'success',
            'msg' => trans('global.cart.add', ['name' => $product->translated()->name]),
            'count' => $this->basket->itemCount()
        ];
    }

    /*
     * 
     */

    public function postDelete($id, Request $request) {
////        session()->put('key', 'sa');
////        session()->save();
//        $value = session()->get('key');
//        var_dump($value);
//        die();
        $product = Product::where('id', $id)->first();

        if (!$product) {
            return [
                'status' => 'error',
                'msg' => trans('global.cart.notfound', ['slug' => $product->slug]),
            ];
        }

//        var_dump($this->basket->add($product, $request->quantity));
//        die('');
//        return [];
//        $product = $product->master;
        if (!$this->basket->delete($product)) {
            return [
                'status' => 'warning',
                'msg' => 'fali',
            ];
        }


        return [
            'status' => 'success',
            'msg' => trans('global.cart.remove', ['name' => $product->translated()->name]),
            'count' => $this->basket->itemCount()
        ];
    }

    /**
     * Update the Basket items.
     *
     * @param         $slug
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\QuantityExceededException
     */
    public function postUpdate($slug, Request $request) {
        $product = _Product::where('slug', $slug)->first();

        if (!$product) {
            return [
                'status' => 'error',
                'msg' => trans('global.cart.notfound', ['slug' => $slug]),
            ];
        }

        $product = $product->master;

        try {
            $this->basket->update($product, $request->quantity);
        } catch (QuantityExceededException $e) {
            return [
                'status' => 'warning',
                'msg' => $e->message,
            ];
        }
        $name = $product->translated()->name;
        $status = 'success';
        $msg = trans('global.cart.update', ['name' => $name]);

        if (!$request->quantity) {
            $status = 'information';
            $msg = trans('global.cart.remove', ['name' => $name]);
        }

        return [
            'status' => $status,
            'msg' => $msg,
        ];
    }

    public function getItemsToOrder() {
        $items_ = $this->basket->all();
        if (isset($items_['items'])) {
            $items_ = $items_['items'];
        }
        $items = array();
        foreach ($items_ as $product_id => $count) {
            $product = Product::where('id', $product_id)->first();
//            die(var_dump($items_));
            if ($count && $product) {
                $product->count = $count;
                $items[] = $product;
            }
        }
        return $items;
    }

    public function getCartTopMenu() {

        $items = $this->getItemsToOrder();
        $allItemsCount = $this->basket->allItemsCount();
        $itemCount = $this->basket->itemCount();

//        die(var_dump($allItemsCount));
//        return $items;

        return [
            'itemCount' => $itemCount,
            'html' => view('site.pages.cart.getCartTopMenu', compact('items', 'allItemsCount'))->render()
        ];

//        var_dump($items);
//        die('');
    }

    public function getCartTotal($company_id = 0) {
        $company = Company::find($company_id);
        if (!$company) {
            $shipping_price = 0;
        } else {
            $shipping_price = $company->price;
        }
        return view('site.pages.checkout.templates.cart-total', compact('shipping_price'))->render();
    }

}
