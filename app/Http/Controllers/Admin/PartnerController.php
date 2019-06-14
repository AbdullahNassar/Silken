<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Partner;

class PartnerController extends Controller
{
    //
    public function getIndex(){
        $partners = Partner::get();

        return view('admin.pages.partners.index' ,compact('partners'));
    }

    public function getEdit($id){
        $partner = Partner::find($id);

        return view('admin.pages.partners.edit' ,compact('partner'));
    }

    public function postIndex(Request $request){
        $v = validator($request->all() ,[
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:20000'
        ] ,[
            'image.required' => 'برجاء ادخال صوره',
            'image.image' => 'برجاء اختيار صوره وليس ملف',
            'image.mimes' => 'نوع الصوره يجب ان يكون : jpeg,jpg,png,gif',
            'image.max' => 'حجم الصوره لا يجب ان يزيد عن 20 ميجا'
        ]);

        if ($v->fails()){
            return ['status' => false , 'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $partner = new Partner();

        $destination = storage_path('uploads/partners');
        if ($request->image) {
            $partner->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $partner->image);
        }

        if ($partner->save()){
            return ['status' => 'success' ,'data' => 'تم ادخال بيانات الشريك بنجاح'];
        }
        return ['status' => false ,'data' => 'حدث خطا اثناء اضافه الشريك برجاء المحاوله مره اخري لاحقا'];
    }

    public function postEdit(Request $request ,$id){

        $partner = Partner::find($id);

        $destination = storage_path('uploads/partners');
        if ($request->image) {
            if (is_file($destination . "/{$partner->image}")) {
                @unlink($destination . "/{$partner->image}");
            }
            $partner->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $partner->image);
        }

        if ($partner->save()){
            return ['status' => 'success' ,'data' => 'تم تعديل بيانات الشريك بنجاح'];
        }
        return ['status' => false ,'data' => 'حدث خطا اثناء تعديل الشريك برجاء المحاوله مره اخري لاحقا'];
    }

    public function getDelete($id){
        $partner = Partner::find($id);

        $partner->delete();

        return redirect()->back();
    }
}
