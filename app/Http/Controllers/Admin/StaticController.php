<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Statics;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    //
    public function getIndex(){
        $statics = Statics::get();

        return view('admin.pages.statics.index' ,compact('statics'));
    }

    public function getEdit($id){
        $static = Statics::find($id);

        return view('admin.pages.statics.edit' ,compact('static'));
    }

    public function postEdit(Request $request ,$id){
        $static = Statics::find($id);

        $static->english()->update([
            'title' => $request->en_title,
            'description' => $request->desc2
        ]);

        $static->arabic()->update([
            'title' => $request->ar_title,
            'description' => $request->desc1
        ]);

        return ['status' => 'success' ,'data' => 'تم تحديث البيانات بنجاح'];
    }
}
