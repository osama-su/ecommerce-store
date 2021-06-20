<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\Admin;
use App\Models\MainCategory;
use App\Models\Vendor;
use App\Notifications\VendorCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class VendorsController extends Controller
{
    public function index()
    {
        $admins = Admin::select('id', 'name')->get();
        $vendors = Vendor::selection()->paginate(PAGINATION_COUNT);
        return view('admin.vendors.index', compact('vendors', 'admins'));
    }
    public function create()
    {
        $categories = MainCategory::where('translation_of', 0)->active()->get();
        return view('admin.vendors.create', compact('categories'));
    }
    public function store(VendorRequest $request)
    {
        try {
            //check box 
            if (!$request->has('active')) {
                $request->request->add(['active' => 0]);
            } else
                $request->request->add(['active' => 1]);
            //upload logo
            $filePath = "";
            if ($request->has('logo')) {
                $filePath = uploadImage('vendors', $request->logo);
            }
            //save to database
            $vendor = Vendor::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'password' => $request->password,
                'active' => $request->active,
                'address' => $request->address,
                'logo' => $filePath,
                'category_id' => $request->category_id,
            ]);
            // send notification 
            //Notification::send($vendor, new VendorCreated($vendor));

            //redirect
            return redirect()->route('admin.vendors')->with(['success' => 'تم الحفظ بنجاح']);
        } catch (\Throwable $th) {
            //return redirect()->route('admin.vendors')->with(['error' => 'حدث خطأ ما']);

            throw $th;
        }
    }
    public function edit($id)
    {
        try {
            $vendor = Vendor::Selection()->find($id);
            if (!$vendor) {
                return redirect()->route('admin.vendors')->with(['error' => 'هذا المتجر غير موجود ']);
            }
            $categories = MainCategory::where('translation_of', 0)->active()->get();
            return view('admin.vendors.edit', compact('vendor', 'categories'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update($id, VendorRequest $request)
    {
        try {
            //check if vendor exist
            $vendor = Vendor::Selection()->find($id);
            if (!$vendor) {
                return redirect()->route('admin.vendors')->with(['error' => 'هذا المتجر غير موجود ']);
            }

            DB::beginTransaction();

            // update logo image if request has it
            if ($request->has('logo')) {
                $filePath = uploadImage('vendors', $request->logo);
                Vendor::where('id', $id)
                    ->update([
                        'logo' => $filePath,
                    ]);
            }

            $data = $request->except('_token', 'id', 'logo', 'pssword');

            // include password if request has it 
            if ($request->has('password') && !is_null($request->  password)) {
                $data['password'] = $request->password;
            }
            //update db
            Vendor::where('id', $id)
                ->update($data);
            DB::commit();
            //redirect
            return redirect()->route('admin.vendors')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function destroy($id)
    {
        try {
            $vendor = Vendor::find($id);
            if (!$vendor) {
                return redirect()->route('admin.vendors', $id)->with(['error' => 'هذا القسم غير موجود']);
            }
             //delete the logo from folder
            
             unlink(base_path('assets/'. Str::after($vendor->logo,'assets/')));

            $vendor->delete();
            return redirect()->route('admin.vendors')->with(['success' => 'تم الحذف بنجاح']);
        } catch (\Throwable $th) {
            
            //return redirect()->route('admin.maincategories')->with(['error' => 'بهذه اللغه غير موجودبه']);
        }
    }
    public function changeStatus()
    {
    }
}
