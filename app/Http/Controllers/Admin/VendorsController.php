<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\MainCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    public function index()
    {
        $vendors = Vendor::selection()->paginate(PAGINATION_COUNT);
        return view('admin.vendors.index', compact($vendors));
    }
    public function create()
    {
        $categories = MainCategory::where('translation_of', 0)->active()->get();
        return view('admin.vendors.create', compact('categories'));
    }
    public function store(VendorRequest $request)
    {
        try {
            //make validation

            //insert into database

            //redirect
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function edit()
    {
    }
    public function update()
    {
    }
    public function changeStatus()
    {
    }
}
