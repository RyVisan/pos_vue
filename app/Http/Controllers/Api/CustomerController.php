<?php

namespace App\Http\Controllers\Api;

use Image;
use App\Model\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return response()->json($customers);
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
            'name' => 'required|unique:customers',
            'phone' => 'required|integer|unique:customers',
            'address' => 'required'
        ]);
        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_part = 'public/backend/customer/';
            $image_url = $upload_part.$name;
            $img->save($image_url);
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'photo' => $image_url
            ]);
        }else{
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
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
        $data['phone'] = $request->phone;
        $image = $request->newphoto;
        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($image)->resize(240, 200);
            $upload_part = 'public/backend/customer/';
            $image_url = $upload_part.$name;
            $success = $img->save($image_url);
            if ($success) {
                $data['photo'] = $image_url;
                $img = DB::table('customers')->where('id', $id)->first();
                $image_path = $img->photo;
                $done = unlink($image_path);
                $user = DB::table('customers')->where('id', $id)->update($data);
            }
        }else{  
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
            $user = DB::table('customers')->where('id', $id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $photo = $customer->photo;
        if ($photo) {
            unlink($photo);
            Customer::find($id)->delete();
        }else{
            Customer::find($id)->delete();
        }
    }
}