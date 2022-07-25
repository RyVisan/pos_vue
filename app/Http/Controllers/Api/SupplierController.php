<?php

namespace App\Http\Controllers\api;

use Image;
use App\Model\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = Supplier::all();
        return response()->json($supplier);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $validation = $request->validate([
            'name' => 'required|unique:suppliers,name|max:100',
            'email' => 'required|max:100',
            'phone' => 'required|unique:suppliers,phone|max:20',
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_part = 'public/backend/supplier/';
            $image_url = $upload_part.$name;
            $img->save($image_url);

            $supplier = Supplier::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'shopname' => $request->shopname,
                'phone' => $request->phone,
                'photo' => $image_url
            ]);
        }else{                    
            $supplier = Supplier::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'shopname' => $request->shopname,
                'phone' => $request->phone
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);
        return response()->json($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['shopname'] = $request->shopname;
        $data['phone'] = $request->phone;
        $image = $request->newphoto;
        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($image)->resize(240, 200);
            $upload_part = 'public/backend/supplier/';
            $image_url = $upload_part.$name;
            $success = $img->save($image_url);
            if ($success) {
                $data['photo'] = $image_url;
                $img = DB::table('suppliers')->where('id', $id)->first();
                $image_path = $img->photo;
                $done = unlink($image_path);
                $user = DB::table('suppliers')->where('id', $id)->update($data);
            }
        }else{  
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
            $user = DB::table('suppliers')->where('id', $id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $photo = $supplier->photo;
        if($photo){
            unlink($photo);
            Supplier::find($id)->delete();
        }else{
            Supplier::find($id)->delete();
        }
    }
}