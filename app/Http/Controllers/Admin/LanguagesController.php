<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;

class LanguagesController extends Controller
{
    public function index()
    {
        $languages = Language::select()->paginate(PAGINATION_COUNT);
        return view('admin.languages.index',compact('languages'));
    }
}
