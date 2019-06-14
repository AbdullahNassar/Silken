<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sproduct;
use SMKFontAwesome\SMKFontAwesome;

class SproductController extends Controller
{
    //
    public function getIndex()
    {
        $products = Sproduct::get();
        $icons = SMKFontAwesome::getArray();

        return view('admin.pages.sproducts.index' ,compact('products' ,'icons'));
    }

    public function getEdit($id){
        $product = Sproduct::find($id);
        $icons = SMKFontAwesome::getArray();

        return view('admin.pages.sproducts.edit' ,compact('product' ,'icons'));
    }

    public function postIndex(Request $request){
        $v = validator($request->all() ,[
            'ar_title' => 'required',
            'en_title' => 'required',
            'desc1' => 'required',
            'desc2' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:20000',
            'icon' => 'required|image|mimes:jpeg,jpg,png,gif|max:20000'
        ] ,[
            'image.required' => 'برجاء ادخال صوره المنتج',
            'image.image' => 'برجاء اختيار صوره وليس ملف',
            'image.mimes' => 'نوع الصوره يجب ان يكون : jpeg,jpg,png,gif',
            'image.max' => 'حجم الصوره لا يجب ان يزيد عن 20 ميجا',
            'icon.required' => 'برجاء ادخال صوره الايقونه',
            'icon.image' => 'برجاء اختيار صوره وليس ملف',
            'icon.mimes' => 'نوع الصوره يجب ان يكون : jpeg,jpg,png,gif',
            'icon.max' => 'حجم الصوره لا يجب ان يزيد عن 20 ميجا',
            'ar_title.required' => 'برجاء ادخال عنوان المنتج باللغه العربيه',
            'en_title.required' => 'برجاء ادخال عنوان المنتج باللغه الانجليزيه',
            'desc1.required' => 'برجاء ادخال محتوي المنتج باللغه العربيه',
            'desc2.required' => 'برجاء ادخال محتوي المنتج باللغه الانجليزيه',
        ]);

        if ($v->fails()){
            return ['status' => false , 'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $product = new Sproduct();

        $destination = storage_path('uploads/products');
        if ($request->image) {
            $product->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $product->image);
        }
        $destination = storage_path('uploads/products');
        if ($request->icon) {
            $product->icon = $request->icon->getClientOriginalName();
            $request->icon->move($destination, $product->icon);
        }

        if ($product->save()){
            $product->details()->create([
                'title' => $request->en_title,
                'description' => $request->desc2,
                'lang' => 'en'
            ]);
            $product->details()->create([
                'title' => $request->ar_title,
                'description' => $request->desc1,
                'lang' => 'ar'
            ]);

            return ['status' => 'success' ,'data' => 'تم ادخال بيانات المنتج بنجاح'];
        }

        return ['status' => false ,'data' => 'حدث خطا اثناء اضافه المنتج برجاء المحاوله مره اخري لاحقا'];
    }

    public function postEdit(Request $request ,$id)
    {
        $v = validator($request->all() ,[
            'ar_title' => 'required',
            'en_title' => 'required',
            'desc1' => 'required',
            'desc2' => 'required'
        ] ,[
            'ar_title.required' => 'برجاء ادخال عنوان المقال باللغه العربيه',
            'en_title.required' => 'برجاء ادخال عنوان المقال باللغه الانجليزيه',
            'desc1.required' => 'برجاء ادخال محتوي المقاله باللغه العربيه',
            'desc2.required' => 'برجاء ادخال محتوي المقاله باللغه الانجليزيه'
        ]);

        if ($v->fails()){
            return ['status' => false , 'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $product = Sproduct::find($id);
        
        $destination = storage_path('uploads/products');
        if ($request->image) {
            if (is_file($destination . "/{$product->image}")) {
                @unlink($destination . "/{$product->image}");
            }
            $product->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $product->image);
        }
        $destination = storage_path('uploads/products');
        if ($request->icon) {
            if (is_file($destination . "/{$product->icon}")) {
                @unlink($destination . "/{$product->icon}");
            }
            $product->icon = $request->icon->getClientOriginalName();
            $request->icon->move($destination, $product->icon);
        }

        $product->english()->update([
            'title' => $request->en_title,
            'description' => $request->desc2
        ]);
        $product->arabic()->update([
            'title' => $request->ar_title,
            'description' => $request->desc1
        ]);

        if ($product->save()){
            return ['status' => 'success' ,'data' => 'تم نحديث بيانات المنتج بنجاح'];
        }

        return ['status' => false ,'data' => 'حدث خطا اثناء تحديث المنتج برجاء المحاوله مره اخري لاحقا'];
    }

    public function getDelete($id)
    {
        $Product = Sproduct::find($id);

        $Product->details()->delete();
        $Product->delete();

        return redirect()->back();
    }
}
