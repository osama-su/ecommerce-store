<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Http\Requests\LanguageRequest;
use App\Models\Admin;

class LanguagesController extends Controller
{
    public function index()
    {
        $admins = Admin::select('id', 'name')->get();
        $languages = Language::select()->paginate(PAGINATION_COUNT);
        return view('admin.languages.index', compact('languages', 'admins'));
    }
    public function create()
    {

        return view('admin.languages.create');
    }
    public function
    store(LanguageRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            Language::create($request->except(['_token']));
            return redirect()->route('admin.languages')->with(['success' => 'تم الحفظ بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطأ']);
        }
    }

    public function edit($id)
    {
        $language = Language::select()->find($id);
        if (!$language) {
            return redirect()->route('admin.languages')->with(['error' => 'هذه اللغه غير موجوده']);
        }
        return view('admin.languages.edit', compact('language'));
    }
    public function update($id, LanguageRequest $request)
    {
        try {
            $language = Language::find($id);
            if (!$language) {
                return redirect()->route('admin.languages.edit', $id)->with(['error' => 'هذه اللغه غير موجوده']);
            }
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);

            $language->update($request->except('_token'));
            return redirect()->route('admin.languages')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Throwable $th) {
            return redirect()->route('admin.languages', $id)->with(['error' => 'بهذه اللغه غير موجوده']);
        }
    }
    public function destroy($id)
    {
        try {
            $language = Language::find($id);
            if (!$language) {
                return redirect()->route('admin.languages', $id)->with(['error' => 'هذه اللغه غير موجوده']);
            }
            $language->delete();
            return redirect()->route('admin.languages')->with(['success' => 'تم الحذف بنجاح']);
        } catch (\Throwable $th) {
            return redirect()->route('admin.languages')->with(['error' => 'بهذه اللغه غير موجودبه']);
        }
    }
}
