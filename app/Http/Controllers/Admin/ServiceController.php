<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;

class ServiceController extends Controller
{
    //
    public function getIndex()
    {
        $services = Service::get();

        return view('admin.pages.services.index' ,compact('services'));
    }

    public function getEdit($id){
        $service = Service::find($id);

        return view('admin.pages.services.edit' ,compact('service'));
    }

    public function postIndex(Request $request)
    {
        $v = validator($request->all() ,[
            'ar_title' => 'required',
            'en_title' => 'required',
            'desc1' => 'required',
            'desc2' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:200000'
        ] ,[
            'image.required' => 'برجاء ادخال صوره الخدمه',
            'image.image' => 'برجاء اختيار صوره وليس ملف',
            'image.mimes' => 'نوع الصوره يجب ان يكون : jpeg,jpg,png,gif',
            'image.max' => 'حجم الصوره لا يجب ان يزيد عن 20 ميجا',
            'ar_title.required' => 'برجاء ادخال عنوان الخدمه باللغه العربيه',
            'en_title.required' => 'برجاء ادخال عنوان الخدمه باللغه الانجليزيه',
            'desc1.required' => 'برجاء ادخال محتوي الخدمه باللغه العربيه',
            'desc2.required' => 'برجاء ادخال محتوي الخدمه باللغه الانجليزيه'
        ]);

        if ($v->fails()){
            return ['status' => false , 'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $service = new Service();

        $destination = storage_path('uploads/services');
        if ($request->image) {
            $service->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $service->image);
        }

        if ($service->save()){
            $service->details()->create([
                'title' => $request->en_title,
                'description' => $request->desc2,
                'lang' => 'en'
            ]);
            $service->details()->create([
                'title' => $request->ar_title,
                'description' => $request->desc1,
                'lang' => 'ar'
            ]);

            return ['status' => 'success' ,'data' => 'تم ادخال بيانات الخدمه بنجاح'];
        }
        return ['status' => false ,'data' => 'حدث خطا اثناء اضافه الخدمه برجاء المحاوله مره اخري لاحقا'];
    }

    public function postEdit(Request $request ,$id)
    {
        $v = validator($request->all() ,[
            'ar_title' => 'required',
            'en_title' => 'required',
            'desc1' => 'required',
            'desc2' => 'required'
        ] ,[
            'ar_title.required' => 'برجاء ادخال عنوان الخدمه باللغه العربيه',
            'en_title.required' => 'برجاء ادخال عنوان الخدمه باللغه الانجليزيه',
            'desc1.required' => 'برجاء ادخال محتوي الخدمه باللغه العربيه',
            'desc2.required' => 'برجاء ادخال محتوي الخدمه باللغه الانجليزيه'
        ]);

        if ($v->fails()){
            return ['status' => false , 'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $service = Service::find($id);

        $destination = storage_path('uploads/services');
        if ($request->image) {
            if (is_file($destination . "/{$service->image}")) {
                @unlink($destination . "/{$service->image}");
            }
            $service->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $service->image);
        }

        $service->english()->update([
            'title' => $request->en_title,
            'description' => $request->desc2
        ]);
        $service->arabic()->update([
            'title' => $request->ar_title,
            'description' => $request->desc1
        ]);

        if ($service->save()){
            return ['status' => 'success' ,'data' => 'تم تعديل بيانات الخدمه بنجاح'];
        }
        return ['status' => false ,'data' => 'حدث خطا اثناء تعديل الخدمه برجاء المحاوله مره اخري لاحقا'];
    }

    public function getDelete($id){
        $service = Service::find($id);

        $service->details()->delete();
        $service->delete();

        return redirect()->back();
    }
}
