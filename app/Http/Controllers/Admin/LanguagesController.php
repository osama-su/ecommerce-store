<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Http\Requests\LanguageRequest;

class LanguagesController extends Controller
{
    public function index()
    {
        $languages = Language::select()->paginate(PAGINATION_COUNT);
        return view('admin.languages.index',compact('languages'));
    }
    public function create()
    {
        
        return view('admin.languages.create');
    }
    public function store(LanguageRequest $request)
    {
        try{
        Language::create($request->except(['_token']));
        return redirect()->route('admin.languages')->with(['success'=>'تم الحفظ بنجاح']);

        }catch (\Exception $ex){
            return redirect()->route('admin.languages')->with(['error'=>'هناك خطأ']);
        }

    }
}
