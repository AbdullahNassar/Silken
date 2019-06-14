<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
public function getIndex(){
        $clients = Client::get();

        return view('admin.pages.clients.index' ,compact('clients'));
    }

    public function getEdit($id){
        $client = Client::find($id);

        return view('admin.pages.clients.edit' ,compact('client'));
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

        $Client = new Client();

        $destination = storage_path('uploads/clients');
        if ($request->image) {
            $Client->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $Client->image);
        }

        if ($Client->save()){
            return ['status' => 'success' ,'data' => 'تم ادخال بيانات العميل بنجاح'];
        }
        return ['status' => false ,'data' => 'حدث خطا اثناء اضافه العميل برجاء المحاوله مره اخري لاحقا'];
    }

    public function postEdit(Request $request ,$id){

        $Client = Client::find($id);

        $destination = storage_path('uploads/clients');
        if ($request->image) {
            if (is_file($destination . "/{$Client->image}")) {
                @unlink($destination . "/{$Client->image}");
            }
            $Client->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $Client->image);
        }

        if ($Client->save()){
            return ['status' => 'success' ,'data' => 'تم تعديل بيانات العميل بنجاح'];
        }
        return ['status' => false ,'data' => 'حدث خطا اثناء تعديل العميل برجاء المحاوله مره اخري لاحقا'];
    }

    public function getDelete($id){
        $Client = Client::find($id);

        $Client->delete();

        return redirect()->back();
    }
}
