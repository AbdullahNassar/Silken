<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\_Product;
use DB;
use App\Category;
use Carbon\Carbon;

class ProductController extends Controller {

    protected $uploadDestination = 'products';

    /**
     * Render the all products pages.
     *
     * @return View
     */
    public function getIndex() {
        $products = Product::latest()->paginate(15);
        $categories = $this->getCategories();
        if (request()->ajax()) {
            return view('admin.pages.products.templates.products-table', compact('products'))->render();
        }


        $cats = Category::get()->where('active', '=', 1)->where('parent_id', 0);
        return view('admin.pages.products.index', compact('products', 'categories','cats'));
    }

    //add files to dropzone
    public function dropzoneStore(Request $request) {
//        die(var_dump($request->file('file')));
        $destination = storage_path("uploads/products");
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move($destination, $imageName);
        return response()->json(['success' => $imageName]);
    }

    //delete image from dropzone
    public function dropzoneDelete(Request $request) {
        unlink(storage_path('uploads/products/' . $request->name));
        return response()->json(['name' => $request->name]);
    }

    /**
     * render the add product page.
     *
     * @return View
     */
    public function getAdd() {
        $categories = $this->getCategories();
        return view('admin.pages.products.add-product', compact('categories'));
    }

    /**
     * Classify categories based on their types.
     *
     * @return array array of categories
     */
    protected function getCategories() {
        $categories['main'] = $categories['other'] = [];
        Category::get()->map(function ($category) use (&$categories) {
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

    /**
     * render the edit product page.
     *
     * @return View
     */
    public function getEdit($id) {
        $product = Product::find($id);
//        die(var_dump(json_decode($product->translated('ar')->fields)));
        if (!$product) {
            return back()->withWarning(trans('products.id_not_found', ['id' => $id]));
        }

        $categories = $this->getCategories();
        $subsub = Category::select('categories.*')->join('categories as cat2', 'cat2.id', '=', 'categories.parent_id')->join('categories as cat3', 'cat3.id', '=', 'cat2.parent_id')->latest('categories.created_at')->paginate(10);
$cats = Category::get()->where('active', '=', 1)->where('parent_id', 0);
//        die(var_dump(count($subsub)));

        return view('admin.pages.products.edit', compact('categories', 'product', 'subsub','cats'));
    }

    /**
     * Add new product into database
     * @param  Request $r
     * @return json
     */
    public function postAdd(Request $r) {
        // validate data and return errors
        $v = validator($r->all(), [
//            'image' => 'required|array',
            'en_name' => 'required|min:2',
            'ar_name' => 'required|min:2',
            'price' => 'required|numeric|greater_than:0',
            'price_trader' => 'required|numeric|greater_than:0',
//            'stock' => 'required|numeric|greater_than:0',
//            'discount' => 'numeric|greater_than:0',
//            'discount_date' => 'date',
            'desc1' => 'required|min:2',
            'desc2' => 'required|min:2',
            'desc3' => 'required|min:2',
            'desc4' => 'required|min:2',
            'category_id' => 'required|integer',
            'active' => 'required|digits_between:0,1',
        ]);

        // setting custom attribute names
        $v->setAttributeNames([
            'en_name' => trans('products.en_name_header'),
            'ar_name' => trans('products.ar_name_header'),
            'price' => trans('products.price_header'),
            'price_trader' => trans('products.price_trader_header'),
//            'stock' => trans('products.stock_header'),
//            'discount' => trans('products.discount_header'),
//            'discount_date' => trans('products.offer_header'),
            'desc1' => trans('products.en_description_header'),
            'desc2' => trans('products.ar_description_header'),
            'desc3' => trans('products.ar_description_header'),
            'desc4' => trans('products.ar_description_header'),
            'category_id' => trans('products.category_col'),
            'active' => trans('products.status_col'),
        ]);
        // return error msgs if validation is failed
        if ($v->fails()) {
            return ['status' => false, 'data' => implode("\n", $v->errors()->all())];
        }

        // check if the category exists
        if (!Category::find($r->category_id)) {
            return ['status' => false, 'data' => trans('products.category_not_found', ['id' => $r->category_id])];
        }

        /*
          //validate if there's an offer
          if (!empty($r->input('discount')) && empty($r->input('discount_date'))) {
          return ['status' => false, 'data' => trans('validation.required', ['attribute' => trans('products.offer_header')])];
          }

          //validate if there's an offer
          if (empty($r->input('discount')) && !empty($r->input('discount_date'))) {
          return ['status' => false, 'data' => trans('validation.required', ['attribute' => trans('products.discount_header')])];
          }

         */
        // instanciate new product and save its data
        $product = new Product();
        $product->active = $r->active;
        $product->category_id = $r->category_id;
        $product->price = $r->price;
        $product->price_trader = $r->price_trader;

//        $product->stock = $r->stock;

        /*
          //if there is an offer
          if (!empty($r->input('discount'))) {
          $product->discount = $r->input('discount');
          $product->discount_date = Carbon::createFromFormat('m/d/Y', $r->input('discount_date'))->toDateString();
          } else {
          $product->discount = null;
          $product->discount_date = null;
          }


         */

        if ($product->save()) {

            $groupEn = array();
            $groupAr = array();

            foreach ($r->group as $group) {
                $groupEn[] = array($group['fieldsen'], $group['valuesen']);
                $groupAr[] = array($group['fieldsar'], $group['valuesar']);
            }
            // save the Product details
            $product->details()->create([
                'name' => $r->en_name,
                'description' => $r->desc1,
                'details' => $r->desc3,
                'fields' => json_encode($groupEn),
                'slug' => $this->generateSlug($r->en_name),
                'locale_id' => 1
            ]);

            $product->details()->create([
                'name' => $r->ar_name,
                'description' => $r->desc2,
                'details' => $r->desc4,
                'fields' => json_encode($groupAr),
                'slug' => $this->generateSlug($r->ar_name),
                'locale_id' => 2
            ]);

            // store the product images
            if ($r->image) {
                foreach ($r->image as $img) {
                    $product->images()->create([
                        'name' => $img
                    ]);
                }
            }
        }

        return ['status' => true, 'data' => 'Save Successfully'];
    }

    /**
     * Edit product into database
     * @param  Request $r
     * @return json
     */
    public function postEdit($id, Request $r) {
//        die(var_dump($r->subsubcat));
//        die(var_dump($r));
        $product = Product::find($id);
        // if no product found
        if (!$product) {
            return msg('error.edit', [
                'msg' => trans('products.id_not_found', ['id' => $id]),
            ]);
        }
        // validate data and return errors
        $v = validator($r->all(), [
//            'image' => 'required|array',
            'en_name' => 'required|min:2',
            'ar_name' => 'required|min:2',
            'price' => 'required|numeric|greater_than:0',
//            'stock' => 'required|numeric|greater_than:0',
//            'discount' => 'numeric|greater_than:0',
//            'discount_date' => 'date',
            'desc1' => 'required|min:2',
            'desc2' => 'required|min:2',
            'desc3' => 'required|min:2',
            'desc4' => 'required|min:2',
            'category_id' => 'required|integer',
            'active' => 'required|digits_between:0,1',
        ]);

        // setting custom attribute names
        $v->setAttributeNames([
            'en_name' => trans('products.en_name_header'),
            'ar_name' => trans('products.ar_name_header'),
            'price' => trans('products.price_header'),
//            'stock' => trans('products.stock_header'),
//            'discount' => trans('products.discount_header'),
//            'discount_date' => trans('products.offer_header'),
            'desc1' => trans('products.en_description_header'),
            'desc2' => trans('products.ar_description_header'),
            'desc3' => trans('products.en_details_header'),
            'desc4' => trans('products.ar_details_header'),
            'category_id' => trans('products.category_col'),
            'active' => trans('products.status_col'),
        ]);

        // return error msgs if validation is failed
        if ($v->fails()) {
            return ['status' => false, 'data' => implode("\n", $v->errors()->all())];
        }

        // check if the category exists
        if (!Category::find($r->category_id)) {
            return ['status' => false, 'data' => trans('products.category_not_found', ['id' => $r->category_id])];
        }
        /*
          //validate if there's an offer
          if (!empty($r->input('discount')) && empty($r->input('discount_date'))) {
          return ['status' => false, 'data' => trans('validation.required', ['attribute' => trans('products.offer_header')])];
          }

          //validate if there's an offer
          if (empty($r->input('discount')) && !empty($r->input('discount_date'))) {
          return ['status' => false, 'data' => trans('validation.required', ['attribute' => trans('products.discount_header')])];
          }
         */
        //  save product data
        $product->active = $r->active;
        $product->category_id = $r->category_id;
        if ($r->subsubcat) {
            $product->category_id = $r->subsubcat;
//            die('yes');
        }
        $product->price = $r->price;
        $product->price_trader = $r->price_trader;

//        $product->stock = $r->stock;

        /*
          //if there is an offer
          if (!empty($r->input('discount'))) {
          $product->discount = $r->input('discount');
          $product->discount_date = Carbon::createFromFormat('m/d/Y', $r->input('discount_date'))->toDateString();
          } else {
          $product->discount = null;
          $product->discount_date = null;
          }
         */
        if ($product->save()) {
            $groupEn = array();
            $groupAr = array();

            foreach ($r->group as $group) {
                $groupEn[] = array($group['fieldsen'], $group['valuesen']);
                $groupAr[] = array($group['fieldsar'], $group['valuesar']);
            }

//            die(var_dump($groupEn));
            // save the Product details
            $product->translated('en')->update([
                'name' => $r->en_name,
                'description' => $r->desc1,
                'details' => $r->desc3,
                'fields' => json_encode($groupEn),
                'slug' => $this->generateSlug($r->en_name),
            ]);

            $product->translated('ar')->update([
                'name' => $r->ar_name,
                'description' => $r->desc2,
                'details' => $r->desc4,
                'fields' => json_encode($groupAr),
                'slug' => $this->generateSlug($r->ar_name),
            ]);
//            die(var_dump($r->image));
            // store the product images
//            $product->details()->create([
//                'name' => $r->ar_name,
//                'description' => $r->desc2,
//                'details' => $r->desc4,
//                'slug' => $this->generateSlug($r->ar_name),
//                'locale_id' => 2
//            ]);
            $imgs = array();
            foreach ($product->images as $image) {
                $imgs[] = $image->name;
            }
//            die(var_dump($imgs));

            if ($r->image) {
                foreach ($r->image as $img) {

                    if (!in_array($img, $imgs)) {
                        $product->images()->create([
                            'name' => $img
                        ]);
                    }


//                    die(var_dump($img));
                }
            }
            return ['status' => true, 'data' => 'Save Successfully'];
        }

        return ['status' => false, 'data' => 'Save Successfully'];
    }

    public function getSearch($q = null) {
        if (!empty($q)) {
            $cols = (new _Product)->getTableColumns();
            $_products = _Product::latest();
            $_products->where('id', 'LIKE', "%$q%");
            foreach ($cols as $col) {
                if (in_array($col, ['id', 'created_at', 'updated_at'])) {
                    continue;
                }
                $_products->orWhere($col, 'LIKE', "%$q%");
            }
            $products = Product::whereIn('id', $_products->get()->pluck('product_id'));
        } else {
            $products = Product::latest();
        }
        $products = $products->paginate(15);

        return view('admin.pages.products.templates.products-table', compact('products'))->render();
    }

    public function postAction($action, Request $r) {
        $state = 0;
        switch ($action) {
            case 'active':
                $state = 1;
                break;
            case 'rejected':
                $action = 'active';
                $state = 0;
                break;
            case 'deleted':
                $action = 'deleted';
                break;
            default :
                $data = [
                    'status' => 'warning',
                    'title' => trans('msgs.error.edit.title'),
                    'msg' => trans('admin_global.msg_action_not_supported'),
                ];
                return $data;
        }

        if ($r->has('ids')) {
            $ids = $r->input('ids');
            foreach ($ids as $id) {
                $this->_action($id, $action, $state);
            }
            $data = msg('success.edit');
        } else {
            $data = [
                'status' => 'warning',
                'title' => trans('msgs.error.edit.title'),
                'msg' => trans('admin_global.msg_mark_at_least'),
            ];
        }

        return $data;
    }

    protected function _action($id, $action, $state) {
        $product = Product::find($id);
        if ($action === 'deleted') {
            $product->trash();
            return;
        }

        $product->$action = $state;
        $product->save();
    }

    public function getFilter($filter) {
        $products = Product::latest();
        $products = $this->_filter($products, $filter)->paginate(15);
        return view('admin.pages.products.templates.products-table', compact('products'))->render();
    }

    protected function _filter(&$products, $filter) {
        switch ($filter) {
            case 'all':
                return $products;
            case 'active':
                return $products->where('active', 1);
            case 'rejected':
                return $products->where('active', 0);
            case 'in_stock':
                return $products->where('stock', '>', 5);
            case 'low_of_stock':
                return $products->where('stock', '<=', 5)->where('stock', '>', 0);
            case 'out_of_stock':
                return $products->where('stock', 0);
            case 'today':
                return $products->where('created_at', '>=', Carbon::today()->toDateString());
        }
    }

    protected function generateSlug($title) {
        $slug = $temp = slugify($title);
        while (_Product::where('slug', $slug)->first()) {
            $slug = $temp . "-" . rand(1, 1000);
        }
        return $slug;
    }

    public function getDelete($id) {
        $product = Product::find($id);

        if (!$product) {
            return back()->withWarning(trans('products.id_not_found', ['id' => $id]));
        }

        $product->trash();

        return back()->withSuccess(msg('success.delete.msg'));
    }

    public function postDeleteImage($product_id, $image_id) {
        $product = Product::find($product_id);

        // if no product found
        if (!$product) {
            return msg('error.delete', [
                'msg' => trans('products.id_not_found', ['id' => $product_id]),
            ]);
        }

        $image = $product->images()->find($image_id);

        // if no image found
        if (!$image) {
            return msg('error.delete', [
                'msg' => trans('products.image_not_found', ['id' => $image_id]),
            ]);
        }

        // physical delete from hard desk
        $file_path = storage_path("uploads/$this->uploadDestination/$image->name");
        if (is_file($file_path)) {
            @unlink($file_path);
        }

        $image->delete();

        return msg('success.delete');
    }

}
