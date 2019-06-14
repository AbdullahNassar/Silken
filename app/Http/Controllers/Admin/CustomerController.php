<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;

class CustomerController extends Controller
{
    //

    public function getIndex()
    {
        $customers = Customer::get();

        return view('admin.pages.customers.index' ,compact('customers'));
    }

    public function getEdit($id){
        $customer = Customer::find($id);

        return view('admin.pages.customers.edit' ,compact('customer'));
    }

    public function postIndex(Request $request)
    {
        $v = validator($request->all() ,[
            'title_en' => 'required',
            'title_ar' => 'required',
            'solution_id' => 'required',
        ] ,[
            'title_en.required' => 'برجاء ادخال عنوان العميل باللغه الانجليزيه',
            'title_ar.required' => 'برجاء ادخال عنوان العميل باللغه العربيه',
            'solution_id.required' => 'برجاء اختيار نوع الحل التابع له هذا العميل'
        ]);

        if ($v->fails()){
            return ['status' => false ,'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $customer = new Customer();

        $customer->solution_id = $request->solution_id;

        if ($customer->save()){
            $customer->details()->create([
                'title' => $request->title_en,
                'lang' => 'en'
            ]);
            $customer->details()->create([
                'title' => $request->title_ar,
                'lang' => 'ar'
            ]);
            $file = $request->file('img_name');
            if($file != null){
                foreach ($file as $image){
                    $destination = storage_path('uploads/customers');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move($destination, $imageName);
                    $customer->images()->create([
                        'image' => $imageName
                    ]);
                }
            }

            return ['status' => 'success' ,'data' => 'تم ادخال العميل بنجاح'];
        }

        return ['status' => false ,'data' => 'حدث خطا اثناء ادخال بيانات العميل'];
    }

    public function postEdit(Request $request ,$id)
    {
        $v = validator($request->all() ,[
            'title_en' => 'required',
            'title_ar' => 'required',
            'solution_id' => 'required',
        ] ,[
            'title_en.required' => 'برجاء ادخال عنوان العميل باللغه الانجليزيه',
            'title_ar.required' => 'برجاء ادخال عنوان العميل باللغه العربيه',
            'solution_id.required' => 'برجاء اختيار نوع الحل التابع له هذا العميل'
        ]);

        if ($v->fails()){
            return ['status' => false ,'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $customer = Customer::find($id);

        $customer->solution_id = $request->solution_id;

        $customer->english()->update([
            'title' => $request->title_en
        ]);
        $customer->arabic()->update([
            'title' => $request->title_ar
        ]);
        $file = $request->file('img_name');
        if($file != null){
            foreach ($file as $image){
                $destination = storage_path('uploads/customers');
                @unlink(storage_path('uploads/customers/' . $image->image));
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move($destination, $imageName);
                $customer->images()->create([
                    'image' => $imageName
                ]);
            }
        }

        if ($customer->save()){
            return ['status' => 'success' ,'data' => 'تم ادخال العميل بنجاح'];
        }

        return ['status' => false ,'data' => 'حدث خطا اثناء ادخال بيانات العميل'];
    }

    public function postDeleteImage($customer_id, $image_id)
    {
        $product = Customer::find($customer_id);
        if (!$product) {
            return back()->withWarning('الحل غير موجود', ['id' => $customer_id]);
        }
        $image = $product->images()->find($image_id);
        // if no image found
        if (!$image) {
            return back()->withError('الصوره غير موجوده', ['id' => $image_id]);
        }
        // physical delete from hard desk
        $file_path = storage_path("uploads/customers/$image->image");
        if (is_file($file_path)) {
            @unlink($file_path);
        }

        $image->delete();

        return [
            'status' => true,
            'msg' => 'تمت الاضافه بنجاح'];
    }

    public function getDelete($id = null){
        $solution = Customer::find($id);

        $solution->images()->delete();
        $solution->details()->delete();
        $solution->delete();

        return redirect()->back();
    }
}
