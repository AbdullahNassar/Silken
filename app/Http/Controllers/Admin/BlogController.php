<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blog;
use Auth;

class BlogController extends Controller
{
    //
    public function getIndex()
    {
        $blogs = Blog::get();

        return view('admin.pages.blogs.index' ,compact('blogs'));
    }

    public function getEdit($id)
    {
        $blog = Blog::find($id);

        return view('admin.pages.blogs.edit' ,compact('blog'));
    }

    public function postIndex(Request $request){
        $v = validator($request->all() ,[
            'ar_title' => 'required',
            'en_title' => 'required',
            'desc1' => 'required',
            'desc2' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:20000',
        ] ,[
            'image.required' => 'برجاء ادخال صوره المقال',
            'image.image' => 'برجاء اختيار صوره وليس ملف',
            'image.mimes' => 'نوع الصوره يجب ان يكون : jpeg,jpg,png,gif',
            'image.max' => 'حجم الصوره لا يجب ان يزيد عن 20 ميجا',
            'ar_title.required' => 'برجاء ادخال عنوان المقال باللغه العربيه',
            'en_title.required' => 'برجاء ادخال عنوان المقال باللغه الانجليزيه',
            'desc1.required' => 'برجاء ادخال محتوي المقاله باللغه العربيه',
            'desc2.required' => 'برجاء ادخال محتوي المقاله باللغه الانجليزيه',
        ]);

        if ($v->fails()){
            return ['status' => false , 'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $blog = new Blog();

        $blog->slug = str_slug($request->en_title);
        $blog->user_id = Auth::guard('admins')->user()->id;

        $destination = storage_path('uploads/blogs');
        if ($request->image) {
            $blog->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $blog->image);
        }

        if ($blog->save()){
            $blog->details()->create([
                'title' => $request->en_title,
                'description' => $request->desc2,
                'lang' => 'en'
            ]);
            $blog->details()->create([
                'title' => $request->ar_title,
                'description' => $request->desc1,
                'lang' => 'ar'
            ]);

            return ['status' => 'success' ,'data' => 'تم ادخال بيانات المقال بنجاح'];
        }

        return ['status' => false ,'data' => 'حدث خطا اثناء اضافه المقال برجاء المحاوله مره اخري لاحقا'];
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
            'desc2.required' => 'برجاء ادخال محتوي المقاله باللغه الانجليزيه',
        ]);

        if ($v->fails()){
            return ['status' => false , 'data' => implode(PHP_EOL ,$v->errors()->all())];
        }

        $blog = Blog::find($id);

        $blog->slug = str_slug($request->en_title);

        $destination = storage_path('uploads/blogs');
        if ($request->image) {
            if (is_file($destination . "/{$blog->image}")) {
                @unlink($destination . "/{$blog->image}");
            }
            $blog->image = $request->image->getClientOriginalName();
            $request->image->move($destination, $blog->image);
        }

        $blog->english()->update([
            'title' => $request->en_title,
            'description' => $request->desc2
        ]);

        $blog->arabic()->update([
            'title' => $request->ar_title,
            'description' => $request->desc1
        ]);

        if ($blog->save()){
            return ['status' => 'success' ,'data' => 'تم تحديث بيانات المقال بنجاح'];
        }

        return ['status' => false ,'data' => 'حدث خطا اثناء تحديث المقال برجاء المحاوله مره اخري لاحقا'];
    }

    public function getDelete($id)
    {
        $blog = Blog::find($id);

        $blog->details()->delete();
        $blog->delete();

        return redirect()->back();
    }
}
