<?php

namespace App\Http\Controllers\Site;

use App\_Product;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Locale;
use App\Review;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller {

    //
    public function getIndex(Request $request) {
        if ($request->ajax()) {
//            dd('mohamed');
            return $this->filterProducts($request);
        }

        $max_price = Product::max('price');
        $min_price = Product::min('price');
        $base_url = route('site.products');

        return view('site.pages.products.index', compact('max_price', 'min_price', 'products', 'base_url'));
    }

    public function getOnly($slug) {
        $product = _Product::where('slug', $slug)->first();

//        die(var_dump($product->master->getImages()[1]->url));
//        die(var_dump($product->master->translated(app()->getLocale())->fields));
//        die(var_dump($product->master->getImages()[0]->url));
//        $product = $product->master;
//        var_dump($product->master->translated(app()->getLocale()));//->description);
//        die();
//        $product->getDescription();
//        die(var_dump($product->translated()));
//        $category_id = Product::where('id' ,$product->product_id)->value('category_id');
//        $relatedProducts = Product::where('category_id' ,$category_id)->get();
        $reviews = Review::where('product_id', $product->id)->get();
//        die(var_dump($product->master->reviews()));
        return view('site.pages.products.only', compact('product', 'reviews'));
    }

    protected function filterProducts(Request $request) {
        $per_page = $request->per_page;
        $order = $request->order;
        $first_limit = floatval(str_replace('$', '', $request->first_limit));
        $last_limit = floatval(str_replace('$', '', $request->last_limit));
        $products = Product::whereBetween('price', [$first_limit, $last_limit]);

        switch ($order) {
            case 'price':
                $products->orderBy('price');
                break;
            case 'date':
                $products->orderBy('created_at');
                break;
            case 'name':
                $products = Product::join('__products', '__products.product_id', '=', 'products.id')
                        ->where('__products.locale_id', Locale::where('name', app()->getLocale())->first()->id)
                        ->whereBetween('products.price', [$first_limit, $last_limit])
                        ->orderBy('__products.name')
                        ->select('products.*');
                break;
        }

        $products = $products->paginate($per_page);

        return view('site.pages.products.templates.products', compact('products'))->render();
    }

    public function postReview(Request $r) {
        $product = _Product::where('product_id', $r->product_id)->first();


        if (!auth()->guard('members')->check()) {
            return ['status' => 'error', 'msg' => 'Please Login First'];
        }
        $v = validator($r->all(), [
            "review" => "required|min:2"
                ], [
            "review.required" => "Please enter your review"
        ]);

        if ($v->fails()) {
            return ['status' => 'error', 'msg' => implode(PHP_EOL, $v->errors()->all())];
        }

        $onlyReview = Review::where('member_id', Auth::guard('members')->user()->id)->value('id');

        if (sizeof($onlyReview) > 0) {
            $review = Review::where('member_id', Auth::guard('members')->user()->id)->first();
            $review->review = $r->review;

            $rate = $r->rate;

            if (is_array($rate)) {
                foreach ($rate as $value) {
                    if ($value == 'rate1') {
                        $review->rate = '1';
                    } elseif ($value == 'rate2') {
                        $review->rate = '2';
                    } elseif ($value == 'rate3') {
                        $review->rate = '3';
                    } elseif ($value == 'rate4') {
                        $review->rate = '4';
                    } elseif ($value == 'rate5') {
                        $review->rate = '5';
                    }
                }
            }
            if ($review->save()) {

                return ['response' => 'success', 'msg' => 'Your review has been updated successfully', 'html' => view('site.pages.products.templates.review-template', compact('product'))->render()];
            } else {
                return ['status' => 'error', 'msg' => 'There\'re some errors, please try again later.'];
            }
        } else {
            $review = new Review();

            $review->member_id = Auth::guard('members')->user()->id;
            $review->product_id = $r->product_id;
            $review->review = $r->review;

            $rate = $r->rate;

            if (is_array($rate)) {
                foreach ($rate as $value) {
                    if ($value == 'rate1') {
                        $review->rate = '1';
                    } elseif ($value == 'rate2') {
                        $review->rate = '2';
                    } elseif ($value == 'rate3') {
                        $review->rate = '3';
                    } elseif ($value == 'rate4') {
                        $review->rate = '4';
                    } elseif ($value == 'rate5') {
                        $review->rate = '5';
                    }
                }
            }

            if ($review->save()) {

                return ['response' => 'success', 'msg' => 'Your review has been added successfully', 'html' => view('site.pages.products.templates.review-template', compact('product'))->render()];
            } else {
                return ['status' => 'error', 'msg' => 'There\'re some errors, please try again later.'];
            }
        }
    }

}
