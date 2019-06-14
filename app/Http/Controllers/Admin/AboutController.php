<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\About;

class AboutController extends Controller
{
    //
    public function getIndex(){
        $abouts = About::get();

        return view('admin.pages.about.index' ,compact('abouts'));
    }

    public function getEdit($id){
        $about = About::find($id);

        return view('admin.pages.about.edit' ,compact('about'));
    }

    public function postEdit(Request $request ,$id){
        $about = About::find($id);

        $destination = storage_path('uploads/about');
        if ($request->image) {
            if (is_file($destination . "/{$about->image}")) {
                @unlink($destination . "/{$about->image}");
            }
            $about->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $about->image);
        }

        $about->english()->update([
            'title' => $request->en_title,
            'description' => $request->desc2
        ]);

        $about->arabic()->update([
            'title' => $request->ar_title,
            'description' => $request->desc1
        ]);

        if ($about->save()){
            return ['status' => 'succes' ,'data' => 'تم تحديث البيانات بنجاح'];
        }

        return ['status' => false ,'data' => 'حدث خطا اثناء تحديث البيانات برجاء المحاوله لاحقا'];
    }


}
