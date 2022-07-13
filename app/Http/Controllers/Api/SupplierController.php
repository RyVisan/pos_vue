<?php

namespace App\Http\Controllers\api;

use Image;
use App\Model\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
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