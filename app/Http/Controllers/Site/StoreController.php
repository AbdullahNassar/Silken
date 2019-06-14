<?php

namespace App\Http\Controllers\Site;

use App\_Category;
use App\Category;
use App\Product;
use App\_Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use Session;

class StoreController extends Controller {

    //
    public function getIndex(Request $request) {

        if ($request->ajax()) {
            return $this->filterProducts($request);
        }
        $col_price = 'price';
        if (auth()->guard('members')->check() && auth()->guard('members')->user()->membershiptype == 'trader') {
            $col_price = 'price_trader';
        }


        $max = Product::max($col_price);
        $min = Product::min($col_price);
//        die(var_dump($max));
        $products = Product::latest()->paginate(3);
        $categories = $this->getCategories();
        $cats = Category::get()->where('active', '=', 1)->where('parent_id', 0);

        foreach ($cats as $sub) {
            foreach ($sub->subCategories as $subsub) {
//                (var_dump(count($subsub)));
//                echo '<br>';
            }
//            (var_dump(count($sub->subCategories)));
//            echo '<br>';
        }
//        die('');
//        die(var_dump(count($cats)));
        return view('site.pages.store.index', compact('products', 'categories', 'max', 'min','cats'));
    }

    protected function getCategories() {
        $categories['main'] = $categories['other'] = [];
        Category::get()->where('active', '=', 1)->map(function ($category) use (&$categories) {
            if ($category->isSub()) {
                return;
            }

            if ($category->subCategories->count()) {
                $categories['main'][] = $category;
            } else {
                $categories['other'][] = $category;
            }
        });

        return $categories;
    }

    protected function filterProducts(Request $request) {
        $col_price = 'price';
        $el_count = 6;
        if ($request->el_count) {
            $el_count = $request->el_count;
        }
        if (auth()->guard('members')->check() && auth()->guard('members')->user()->membershiptype == 'trader') {
            $col_price = 'price_trader';
        }
        if ($request->order_by == 'price_desc') {
            $products = Product::latest($col_price);
        } elseif ($request->order_by == 'price_asc') {
            $products = Product::oldest($col_price);
        } else {
            $products = Product::latest();
        }

        if ($request->first_limit) {
            $products = $products->where($col_price, '>=', $request->first_limit);
        }
        if ($request->last_limit) {
            $products = $products->where($col_price, '<=', $request->last_limit);
        }
        if ($request->cats && count($request->cats)) {
            $products = $products->whereIn('category_id', $request->cats);

//            $products = Product::latest()->whereIn('category_id', $request->cats)->paginate(3);
        } else {
//            $products = Product::latest()->paginate(3);
        }
        $products = $products->paginate($el_count);


        $paginator = $products;

        return view('site.pages.store.products', compact('products', 'paginator'))->render();
    }

}
