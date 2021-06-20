<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MainCategoriesController extends Controller
{
    public function index()
    {
        $admins = Admin::select('id','name')->get();
        $default_lang = get_default_lang();
        $categories = MainCategory::where('translation_language', $default_lang)->selection()->get();
        return view('admin.maincategories.index', compact('categories','admins'));
    }
    public function create()
    {
        return view('admin.maincategories.create');
    }

    public function store(MainCategoryRequest $request)
    {
        try {
            // default lang 
            $main_categories = collect($request->category);
            $filter = $main_categories->filter(function ($value, $key) {
                return $value['abbr'] == get_default_lang();
            });

            $default_category = array_values($filter->all())[0];
            //image upload
            $filePath = "";
            if ($request->has('photo')) {
                $filePath = uploadImage('maincategories', $request->photo);
            }
            DB::beginTransaction();
            $default_category_id = MainCategory::insertGetId([
                'translation_language' => $default_category['abbr'],
                'translation_of' => 0,
                'name' => $default_category['name'],
                'slug' => $default_category['name'],
                'photo' => $filePath,
                'active' => $default_category['active'],

            ]);
            // filter not default langs
            $categories = $main_categories->filter(function ($value, $key) {
                return $value['abbr'] !== get_default_lang();
            });
            // store other langs
            if (isset($categories) && $categories->count()) {
                $categories_arr = [];
                foreach ($categories as $category) {
                    $categories_arr[] = [
                        'translation_language' => $category['abbr'],
                        'translation_of' => $default_category_id,
                        'name' => $category['name'],
                        'slug' => $category['name'],
                        'photo' => $filePath,
                        'active' => $category['active'],
                    ];
                }
                MainCategory::insert($categories_arr);
            }
            DB::commit();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم الحفظ بنجاح']);
        } catch (\Throwable $th) {
            DB::rollBack();
            //return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطأ ما']);
            throw $th;
        }
    }
    public function edit($mainCat_id)
    {
        //get specific categories and its translations
        $mainCategory = MainCategory::with('categories')
            ->selection()
            ->find($mainCat_id);
        if (!$mainCategory)
            return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);
        return view('admin.maincategories.edit', compact('mainCategory'));
    }
    public function update($mainCat_id, MainCategoryRequest $request)
    {

        try {
            //return $request;
            $main_category = MainCategory::find($mainCat_id);
            if (!$main_category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);

            $category = array_values($request->category)[0];
            if (!$request->has('category.0.active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);


            MainCategory::where('id', $mainCat_id)
                ->update(
                    [
                        'name' => $category['name'],
                        'active' => $request->active,

                    ]
                );
            //image upload
            //$filePath = $main_category->photo;
            if ($request->has('photo')) {
                $filePath = uploadImage('maincategories', $request->photo);
                MainCategory::where('id', $mainCat_id)
                    ->update(
                        [
                            'photo' => $filePath,

                        ]
                    );
            }
            return redirect()->route('admin.maincategories')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Throwable $th) {

            return redirect()->route('admin.maincategories')->with(['erorr' => 'حدث خطأ ما']);
            //throw $th;
        }
    }
    public function destroy($id)
    {
        try {
            $mainCategory = MainCategory::find($id);
            if (!$mainCategory) {
                return redirect()->route('admin.maincategories', $id)->with(['error' => 'هذا القسم غير موجود']);
            }
            //check if cat has vendors 
            $vendors =$mainCategory->vendors();
            if (isset($vendors)&& $vendors->count()>0) {
                return redirect()->route('admin.maincategories', $id)->with(['error' => 'you canot delete this cat']);
            }
            $mainCategory->delete();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم الحذف بنجاح']);
        } catch (\Throwable $th) {
            throw $th;
            //return redirect()->route('admin.maincategories')->with(['error' => 'بهذه اللغه غير موجودبه']);
        }
    }
}
