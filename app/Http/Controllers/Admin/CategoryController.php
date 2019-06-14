<?php

namespace App\Http\Controllers\Admin;

use App\_Category;
use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CategoryController extends Controller {

    /**
     * Render The Main or Sub Categories Page
     * @return View
     */
    public function getIndex($type) {
        switch ($type) {
            case 'main':
                $categories = Category::where('parent_id', 0)->latest()->paginate(10);
                return view('admin.pages.categories.main-categories.index', compact('categories'));
            case 'sub':
                $categories = Category::where('parent_id', '<>', 0)->latest()->paginate(10);
                return view('admin.pages.categories.sub-categories.index', compact('categories'));
            case 'subsub':
                $products = Product::latest();
                $categories = $this->getCategories();
                
                $subsub = Category::select('categories.*')->join('categories as cat2', 'cat2.id', '=', 'categories.parent_id')->join('categories as cat3', 'cat3.id', '=', 'cat2.parent_id')->latest('categories.created_at')->paginate(10);

                return view('admin.pages.categories.sub-sub-categories.index', compact('products', 'categories', 'subsub'));

            default:
                abort(404);
        }
    }

    protected function getCategories() {
//        die('');
        $categories['main'] = $categories['other'] = [];
        Category::get()->map(function ($category) use (&$categories) {
            if ($category->isSub()) {
                return;
            }

            if ($category->subCategories->count()) {
                $categories['main'][] = $category;
            } else {
                $categories['other'][] = $category;
            }
        });
//        die(var_dump($categories));
        return $categories;
    }

    /**
     * Fetch Information about some category
     * @param  number $id [description]
     * @return json     [description]
     */
    public function postInfosub($id) {
        $cat = Category::find($id);
//        die(var_dump($category->parent_id));
        $categories = $this->getCategories();
        if (!$cat) {
            return [
                'status' => false,
                'title' => 'فشل',
                'data' => 'لا يوجد بيانات لهذا القسم',
                'content' => '',
            ];
        }

        return view('admin.pages.categories.sub-sub-categories.edit', compact('cat','categories'));
    }

    /**
     * Fetch Information about some category
     * @param  number $id [description]
     * @return json     [description]
     */
    public function postInfo($id) {
        $category = Category::find($id);
        if (!$category) {
            return [
                'status' => false,
                'title' => 'فشل',
                'data' => 'لا يوجد بيانات لهذا القسم',
                'content' => '',
            ];
        }
        // compile the edit modal view
        if ($category->isMain()) {
            return view('admin.pages.categories.main-categories.edit', compact('category'));
        } else {
            return view('admin.pages.categories.sub-categories.edit', compact('category'));
        }
    }

    /**
     * Edit Sub or Main Category.
     *
     * @param  string  $type    [description]
     * @param  number  $id      [description]
     * @param  Request $request [description]
     * @return json           [description]
     */
    public function postEdit($type, $id, Request $request) {
        // basic validation rules
        $v = validator($request->all(), [
            'en_name' => 'required|min:2',
            'ar_name' => 'required|min:2',
            'active' => 'required|digits_between:0,1',
                ], [
            'en_name.required' => 'اسم القسم مطلوب.',
            'en_name.min' => 'لا يمكن ان يقل اسم القسم عن حرفين.',
            'ar_name.required' => 'اسم القسم مطلوب.',
            'ar_name.min' => 'لا يمكن ان يقل اسم القسم عن حرفين.',
            'active.required' => 'حالة القسم مطلوبه',
            'active.digits_between' => 'حالة القسم لا يمكن ان تكون قيمه غير فعال او غير فعال.',
        ]);

        // if the validation has been failed return the error msgs
        if ($v->fails()) {
            return [
                'status' => false,
                'title' => 'بيانات خاظئه',
                'data' => implode(PHP_EOL, $v->errors()->all()),
                'content' => '',
            ];
        }
        //get the data for the id
        $category = Category::find($id);

        if (!$category) {
            return [
                'status' => false,
                'title' => 'بيانات خاظئه',
                'data' => 'لا يوجد هناك قسم بهذا الاسم ليتم تعديله',
                'content' => '',
            ];
        }
        switch ($type) {
            case 'main':
                return $this->editMainCategory($request, $category);
            case 'sub':
                return $this->editSubCategory($request, $category);
            default :
                return [
                    'status' => false,
                    'title' => 'بيانات خاظئه',
                    'data' => 'لا يوجد هناك تصنيف بهذا الاسم ليتم تعديله',
                    'content' => '',
                ];
        }
    }

    /**
     * Edit main category.
     *
     * @param  Request  $request  [description]
     * @param  Category $category [description]
     * @return [type]             [description]
     */
    protected function editMainCategory(Request $request, Category $category) {
        if (!$category->isMain()) {
            return [
                'status' => false,
                'title' => 'بيانات خاظئه',
                'data' => 'لا يوجد هناك قسم رئيسي يطابق هذه البيانات',
                'content' => '',
            ];
        }

        $category->active = $request->active;
        $category->translated('en')->update([
            'name' => $request->en_name,
        ]);
        $category->translated('ar')->update([
            'name' => $request->ar_name,
        ]);

        if ($category->save()) {
            return [
                'status' => true,
                'title' => 'نجاح',
                'data' => 'تم تعديل القسم بنجاح.',
                'content' => '',
            ];
        }

        return [
            'status' => false,
            'title' => 'فشل',
            'data' => 'تم فشل عمليه التعديل . حاول مره لاحقه.',
            'content' => '',
        ];
    }

    /**
     * Edit sub category.
     *
     * @param  Request  $request  [description]
     * @param  Category $category [description]
     * @return [type]             [description]
     */
    protected function editSubCategory(Request $request, Category $category) {
        if (!$category->isSub()) {
            return [
                'status' => false,
                'title' => 'بيانات خاظئه',
                'data' => 'لا يوجد هناك قسم فرعي يطابق هذه البيانات',
                'content' => '',
            ];
        }

        // if(!$request->parent_id){
        //     return [
        //         'status' => 'error',
        //         'title' => 'بيانات خاظئه',
        //         'msg' => 'التصنيف الرئيسي لا يمكن ان يكون فارغ',
        //         'content' => '',
        //     ];
        // }


        $category->active = $request->active;
        $category->parent_id = $request->parent_id;
        // $category->parent_id = $request->parent_id;
        $category->translated('en')->update([
            'name' => $request->en_name,
        ]);
        $category->translated('ar')->update([
            'name' => $request->ar_name,
        ]);

        if ($category->save()) {
            return [
                'status' => true,
                'title' => 'نجاح',
                'data' => 'تم تعديل القسم بنجاح.',
                'content' => '',
            ];
        }

        return [
            'status' => false,
            'title' => 'فشل',
            'data' => 'تم فشل عمليه التعديل . حاول مره لاحقه.',
            'content' => '',
        ];
    }

    /**
     * Add new Sub or Main Category.
     *
     * @param  string  $type    [description]
     * @param  number  $id      [description]
     * @param  Request $request [description]
     * @return json           [description]
     */
    public function postAdd($type, Request $request) {
        // basic validation rules
        $v = validator($request->all(), [
            'en_name' => 'required|min:2',
            'ar_name' => 'required|min:2',
            'active' => 'required|digits_between:0,1',
                ], [
            'en_name.required' => 'اسم القسم مطلوب.',
            'en_name.min' => 'لا يمكن ان يقل اسم القسم عن حرفين.',
            'ar_name.required' => 'اسم القسم مطلوب.',
            'ar_name.min' => 'لا يمكن ان يقل اسم القسم عن حرفين.',
            'active.required' => 'حالة القسم مطلوبه',
            'active.digits_between' => 'حالة القسم لا يمكن ان تكون قيمه غير فعال او غير فعال.',
        ]);
        // if the validation has been failed return the error msgs
        if ($v->fails()) {
            return [
                'status' => false,
                'title' => 'بيانات خاظئه',
                'data' => implode(PHP_EOL, $v->errors()->all()),
                'content' => '',
            ];
        }

        //get new category
        $category = new Category();

        switch ($type) {
            case 'main':
                return $this->addMainCategory($request, $category);
            case 'sub':
                return $this->addSubCategory($request, $category);
            default :
                return [
                    'status' => false,
                    'title' => 'بيانات خاظئه',
                    'data' => 'لا يوجد هناك تصنيف بهذا الاسم ليتم تعديله',
                    'content' => '',
                ];
        }
    }

    /**
     * Add main category.
     *
     * @param  Request  $request  [description]
     * @param  Category $category [description]
     * @return [type]             [description]
     */
    protected function addMainCategory(Request $request, Category $category) {

        $category->parent_id = 0;
        $category->active = $request->active;
        if ($category->save()) {

            $category->details()->create([
                'name' => $request->en_name,
                'slug' => $this->generateSlug($request->en_name),
                'locale_id' => 1 // for en
            ]);
            $category->details()->create([
                'name' => $request->ar_name,
                'slug' => $this->generateSlug($request->ar_name),
                'locale_id' => 2 // for en
            ]);

            return [
                'status' => true,
                'title' => 'نجاح',
                'data' => 'تم اضافة القسم بنجاح.',
                'content' => '',
            ];
        }

        return [
            'status' => false,
            'title' => 'فشل',
            'data' => 'تم فشل عمليه الاضافه . حاول مره لاحقه.',
            'content' => '',
        ];
    }

    /**
     * Add sub category.
     *
     * @param  Request  $request  [description]
     * @param  Category $category [description]
     * @return [type]             [description]
     */
    protected function addSubCategory(Request $request, Category $category) {



        if (!$request->parent_id) {
            return [
                'status' => false,
                'title' => 'بيانات خاظئه',
                'data' => 'التصنيف الرئيسي لا يمكن ان يكون فارغ',
                'content' => '',
            ];
        }

        $category->active = $request->active;
        $category->parent_id = $request->parent_id;

        if ($category->save()) {

            $category->details()->create([
                'name' => $request->en_name,
                'slug' => $this->generateSlug($request->en_name),
                'locale_id' => 1 // for en
            ]);
            $category->details()->create([
                'name' => $request->ar_name,
                'slug' => $this->generateSlug($request->ar_name),
                'locale_id' => 2 // for en
            ]);

            return [
                'status' => true,
                'title' => 'نجاح',
                'data' => 'تم اضافة القسم بنجاح.',
                'content' => '',
            ];
        }

        return [
            'status' => false,
            'title' => 'فشل',
            'data' => 'تم فشل عمليه الاضافه . حاول مره لاحقه.',
            'content' => '',
        ];
    }

    public function postChange($type, $id, Request $request) {
        $category = Category::find($id);

        switch ($type) {
            case 'main':
                return $this->changeMainCategory($request, $category);
            case 'sub':
                return $this->changeSubCategory($request, $category);
        }
    }

    /**
     * Edit main category.
     *
     * @param  Request  $request  [description]
     * @param  Category $category [description]
     * @return [type]             [description]
     */
    protected function changeMainCategory(Request $request, $category) {
        if (!$category) {
            return back()->withError('لا يوجد هناك قسم بهذا الاسم ليتم تعديله.');
        }

        if (!$category->isMain()) {
            return back()->withError('لا يوجد هناك قسم رئيسي يطابق هذه البيانات.');
        }

        if (!$request->parent_id) {
            return back()->withError('التصنيف الرئيسي لا يمكن ان يكون فارغ.');
        }

        if ($category->id == $request->parent_id) {
            return back()->withWarning('التصنيف لايمكن ان يكون فرعي من نفسه.');
        }

        $category->parent_id = $request->parent_id;

        if ($category->save()) {
            return back()->withSuccess('تم تعيين القسم بنجاح.');
        }

        return back()->withWarning('تم فشل عمليه التعيين . حاول مره لاحقه.');
    }

    /**
     * Edit sub category.
     *
     * @param  Request  $request  [description]
     * @param  Category $category [description]
     * @return [type]             [description]
     */
    protected function changeSubCategory(Request $request, $category) {
        if (!$category->isSub()) {
            return [
                'status' => false,
                'title' => 'بيانات خاظئه',
                'data' => 'لا يوجد هناك قسم فرعي يطابق هذه البيانات',
                'content' => '',
            ];
        }

        $category->parent_id = 0;

        if ($category->save()) {
            return [
                'status' => true,
                'title' => 'نجاح',
                'data' => 'تم تعيين القسم بنجاح.',
                'content' => '',
            ];
        }

        return [
            'status' => false,
            'title' => 'فشل',
            'data' => 'تم فشل عمليه التعيين . حاول مره لاحقه.',
            'content' => '',
        ];
    }

    protected function generateSlug($title) {
        $slug = $temp = slugify($title);
        while (_Category::where('slug', $slug)->first()) {
            $slug = $temp . "-" . rand(1, 1000);
        }
        return $slug;
    }

    public function getDelete($id) {
        $category = Category::find($id);
        if (!$category) {
            return back()->withError('لا يوجد قسم يطابق هذه البيانات ليتم حذفه.');
        }
        $this->autoDelete($id);
        return back()->withSuccess('تمت عمليه الحذف بنجاح.');
    }

    public function autoDelete($id) {
        if (Category::find($id)->subCategories) {
            foreach (Category::find($id)->subCategories as $sub) {
                $this->autoDelete($sub->id);
                $sub->details()->delete();
                $sub->delete();
            }
            $category = Category::find($id);
            $category->details()->delete();
            $category->delete();
        }
        return true;
    }

}
