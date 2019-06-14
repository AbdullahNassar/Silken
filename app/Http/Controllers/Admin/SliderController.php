<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Slider;

class SliderController extends Controller
{
    public function getIndex()
    {
        $sliders = Slider::get();

        return view('admin.pages.sliders.index' ,compact('sliders'));
    }

    public function getEdit($id){
        $slider = Slider::find($id);

        return view('admin.pages.sliders.edit' ,compact('slider'));
    }

    public function postIndex(Request $request)
    {
        $v = validator($request->all() ,[
            'ar_title1' => 'required',
            'ar_title2' => 'required',
            'ar_title3' => 'required',
            'en_title1' => 'required',
            'en_title2' => 'required',
            'en_title3' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:20000'
        ] ,[
            'image.required' => 'برجاء ادخال الصوره',
            'image.image' => 'برجاء اختيار صوره وليس ملف',
            'image.mimes' => 'نوع الصوره يجب ان يكون : jpeg,jpg,png,gif',
            'image.max' => 'حجم الصوره لا يجب ان يزيد عن 20 ميجا',
            'ar_title1.required' => 'برجاء ادخال العنوان الاول باللغه العربيه',
            'en_title1.required' => 'برجاء ادخال العنوان الاول باللغه الانجليزيه',
            'ar_title2.required' => 'برجاء ادخال العنوان الثاني باللغه العربيه',
            'en_title2.required' => 'برجاء ادخال العنوان الثاني باللغه الانجليزيه',
            'ar_title3.required' => 'برجاء ادخال العنوان الثالث باللغه العربيه',
            'en_title3.required' => 'برجاء ادخال العنوان الثالث باللغه الانجليزيه'
        ]);

        if ($v->fails()){
            return ['status' => false , 'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $slider = new Slider();

        $destination = storage_path('uploads/sliders');
        if ($request->image) {
            $slider->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $slider->image);
        }

        if ($slider->save()){
            $slider->details()->create([
                'title1' => $request->en_title1,
                'title2' => $request->en_title2,
                'title3' => $request->en_title3,
                'lang' => 'en'
            ]);
            $slider->details()->create([
                'title1' => $request->ar_title1,
                'title2' => $request->ar_title2,
                'title3' => $request->ar_title3,
                'lang' => 'ar'
            ]);

            return ['status' => 'success' ,'data' => 'تم ادخال بيانات الصوره بنجاح'];
        }
        return ['status' => false ,'data' => 'حدث خطا اثناء اضافه الصوره برجاء المحاوله مره اخري لاحقا'];
    }

    public function postEdit(Request $request ,$id)
    {
        $v = validator($request->all() ,[
            'ar_title1' => 'required',
            'ar_title2' => 'required',
            'ar_title3' => 'required',
            'en_title1' => 'required',
            'en_title2' => 'required',
            'en_title3' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:20000'
        ] ,[
            'image.required' => 'برجاء ادخال الصوره',
            'image.image' => 'برجاء اختيار صوره وليس ملف',
            'image.mimes' => 'نوع الصوره يجب ان يكون : jpeg,jpg,png,gif',
            'image.max' => 'حجم الصوره لا يجب ان يزيد عن 20 ميجا',
            'ar_title1.required' => 'برجاء ادخال العنوان الاول باللغه العربيه',
            'en_title1.required' => 'برجاء ادخال العنوان الاول باللغه الانجليزيه',
            'ar_title2.required' => 'برجاء ادخال العنوان الثاني باللغه العربيه',
            'en_title2.required' => 'برجاء ادخال العنوان الثاني باللغه الانجليزيه',
            'ar_title3.required' => 'برجاء ادخال العنوان الثالث باللغه العربيه',
            'en_title3.required' => 'برجاء ادخال العنوان الثالث باللغه الانجليزيه'
        ]);

        if ($v->fails()){
            return ['status' => false , 'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $slider = Slider::find($id);

        $destination = storage_path('uploads/sliders');
        if ($request->image) {
            if (is_file($destination . "/{$slider->image}")) {
                @unlink($destination . "/{$slider->image}");
            }
            $slider->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $slider->image);
        }

        $slider->english()->update([
            'title1' => $request->en_title1,
            'title2' => $request->en_title2,
            'title3' => $request->en_title3
        ]);
        $slider->arabic()->update([
            'title1' => $request->ar_title1,
            'title2' => $request->ar_title2,
            'title3' => $request->ar_title3
        ]);

        if ($slider->save()){
            return ['status' => 'success' ,'data' => 'تم تعديل بيانات الصوره بنجاح'];
        }
        return ['status' => false ,'data' => 'حدث خطا اثناء تعديل الصوره برجاء المحاوله مره اخري لاحقا'];
    }

    public function getDelete($id){
        $slider = Slider::find($id);

        $slider->details()->delete();
        $slider->delete();

        return redirect()->back();
    }
}
