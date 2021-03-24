<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use Illuminate\Support\Facades\Config;

class MainCategoriesController extends Controller
{
    public function index()
    {
       $default_lang = get_default_lang();
       $categories = MainCategory::where('translation_language',$default_lang)->selection()->get();

       return view('admin.maincategories.index',compact($categories));
    }
}
