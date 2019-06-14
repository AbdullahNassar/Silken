<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Solution;
use SMKFontAwesome\SMKFontAwesome;

class SolutionController extends Controller
{
    //
    public function getIndex()
    {
        $solutions = Solution::get();

        return view('admin.pages.solutions.index' ,compact('solutions'));
    }

    public function getEdit($id)
    {
        $solution = Solution::find($id);

        return view('admin.pages.solutions.edit' ,compact('solution'));
    }

    public function postIndex(Request $request)
    {
//        dd($request->all());
        $v = validator($request->all() ,[
            'title_en' => 'required',
            'title_ar' => 'required',
            'desc1' => 'required',
            'desc2' => 'required',
        ] ,[
            'title_en.required' => 'برجاء اضافه عنوان الخدمه باللغه الانجليزيه',
            'title_ar.required' => 'برجاء اضافه عنوان الخدمه باللغه العربيه',
            'desc1.required' => 'برجاء اضافه محتوي الخدمه باللغه الانجليزيه',
            'desc2.required' => 'برجاء اضافه محتوي الخدمه باللغه الانجليزيه',
        ]);

        if ($v->fails()){
            return ['status' => false ,'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $solution = new Solution();

        $solution->slug = str_slug($request->title_en);
        $destination = storage_path('uploads/solutions');
        if ($request->icon) {
            $solution->icon = $request->icon->getClientOriginalName();
            $request->icon->move($destination, $solution->icon);
        }

        if ($solution->save()){
            $solution->details()->create([
                'title' => $request->title_en,
                'description' => $request->desc1,
                'lang' => 'en'
            ]);
            $solution->details()->create([
                'title' => $request->title_ar,
                'description' => $request->desc2,
                'lang' => 'ar'
            ]);

            $file = $request->file('img_name');
            if($file != null){
                foreach ($file as $image){
                    $destination = storage_path('uploads/solutions');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move($destination, $imageName);
                    $solution->images()->create([
                        'image' => $imageName
                    ]);
                }
            }

            return ['status' => 'success' ,'data' => 'تم ادخال الحل بنجاح'];
        }

        return ['status' => false ,'data' => 'حدث خطا اثناء اضافه الحل'];
    }

    public function postEdit(Request $request ,$id)
    {
        $v = validator($request->all() ,[
            'title_en' => 'required',
            'title_ar' => 'required',
            'desc1' => 'required',
            'desc2' => 'required'
        ] ,[
            'title_en.required' => 'برجاء اضافه عنوان الخدمه باللغه الانجليزيه',
            'title_ar.required' => 'برجاء اضافه عنوان الخدمه باللغه العربيه',
            'desc1.required' => 'برجاء اضافه محتوي الخدمه باللغه الانجليزيه',
            'desc2.required' => 'برجاء اضافه محتوي الخدمه باللغه الانجليزيه'
        ]);

        if ($v->fails()){
            return ['status' => false ,'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $solution = Solution::find($id);

//        dd($solution);
        $destination = storage_path('uploads/solutions');

        if ($request->icon) {
            @unlink($destination . "/{$solution->icon}");
            $solution->icon = $request->icon->getClientOriginalName();
            $request->icon->move($destination, $solution->icon);
        }

        $file = $request->file('img_name');
        if($file != null){
            foreach ($file as $image){
                $destination = storage_path('uploads/solutions');
                //                dd($destination);
                @unlink(storage_path('uploads/solutions/' . $image->image));
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move($destination, $imageName);
                $solution->images()->create([
                    'image' => $imageName
                ]);
            }
        }
        $solution->english()->update([
            'title' => $request->title_en,
            'description' => $request->desc1
        ]);
        $solution->arabic()->update([
            'title' => $request->title_ar,
            'description' => $request->desc2
        ]);


        if ($solution->save()){
            return ['status' => 'success' ,'data' => 'تم تعديل الحل بنجاح'];
        }

        return ['status' => false ,'data' => 'حدث خطا اثناء تعديل الحل'];
    }

    public function postDeleteImage($solution_id, $image_id)
    {
        $product = Solution::find($solution_id);
        if (!$product) {
            return back()->withWarning('الحل غير موجود', ['id' => $solution_id]);
        }
        $image = $product->images()->find($image_id);
        // if no image found
        if (!$image) {
            return back()->withError('الصوره غير موجوده', ['id' => $image_id]);
        }
        // physical delete from hard desk
        $file_path = storage_path("uploads/solutions/$image->image");
        if (is_file($file_path)) {
            @unlink($file_path);
        }

        $image->delete();

        return [
            'status' => true,
            'msg' => 'تمت الاضافه بنجاح'];
    }

    public function getDelete($id = null){
        $solution = Solution::find($id);

        $solution->images()->delete();
        $solution->details()->delete();
        $solution->delete();

        return redirect()->back();
    }

}
