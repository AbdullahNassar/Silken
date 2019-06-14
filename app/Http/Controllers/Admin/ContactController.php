<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
use SMKFontAwesome\SMKFontAwesome;

class ContactController extends Controller
{
    //
    public function getIndex(){
        $data = Contact::get();
        $icons = SMKFontAwesome::getArray();

        return view('admin.pages.contact.index' ,compact('data' ,'icons'));
    }

    public function getEdit($id){
        $data = Contact::find($id);
        $icons = SMKFontAwesome::getArray();

        return view('admin.pages.contact.edit' ,compact('data' ,'icons'));
    }

    public function postIndex(Request $request){
        $v = validator($request->all() ,[
            'ar_title' => 'required',
            'en_title' => 'required',
            'desc1' => 'required',
            'desc2' => 'required',
            'icon' => 'required'
        ] ,[
            'ar_title.required' => 'برجاء ادخال العنوان باللغه العربيه',
            'en_title.required' => 'برجاء ادخال العنوان باللغه الانجليزيه',
            'desc1.required' => 'برجاء ادخال المحتوي باللغه العربيه',
            'desc2.required' => 'برجاء ادخال المحتوي باللغه الانجليزيه',
            'icon.required' => 'برجاء اختيار الايقونه'
        ]);

        if ($v->fails()){
            return ['status' => false , 'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $data = new Contact();

        $data->icon = $request->icon;

        if ($data->save()){

            $data->details()->create([
                'title' => $request->en_title,
                'description' => $request->desc2,
                'lang' => 'en'
            ]);
            $data->details()->create([
                'title' => $request->ar_title,
                'description' => $request->desc1,
                'lang' => 'ar'
            ]);

            return ['status' => 'success' ,'data' => 'تم ادخال البيانات بنجاح'];
        }

        return ['status' => false ,'data' => 'حدث خطا اثناء ادخال البيانات برجاء المحاوله لاحقا'];
    }

    public function postEdit(Request $request ,$id){
        $v = validator($request->all() ,[
            'ar_title' => 'required',
            'en_title' => 'required',
            'desc1' => 'required',
            'desc2' => 'required',
            'icon' => 'required'
        ] ,[
            'ar_title.required' => 'برجاء ادخال العنوان باللغه العربيه',
            'en_title.required' => 'برجاء ادخال العنوان باللغه الانجليزيه',
            'desc1.required' => 'برجاء ادخال المحتوي باللغه العربيه',
            'desc2.required' => 'برجاء ادخال المحتوي باللغه الانجليزيه',
            'icon.required' => 'برجاء اختيار الايقونه'
        ]);

        if ($v->fails()){
            return ['status' => false , 'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $data = Contact::find($id);

        $data->icon = $request->icon;

        $data->english()->update([
            'title' => $request->en_title,
            'description' => $request->desc2
        ]);
        $data->arabic()->update([
            'title' => $request->ar_title,
            'description' => $request->desc1
        ]);

        if ($data->save()){
            return ['status' => 'success' ,'data' => 'تم تعديل البيانات بنجاح'];
        }

        return ['status' => false ,'data' => 'حدث خطا اثناء تعديل البيانات برجاء المحاوله لاحقا'];
    }

    public function getDelete($id){
        $data = Contact::find($id);

        $data->details()->delete();
        $data->delete();

        return redirect()->back();
    }
}
