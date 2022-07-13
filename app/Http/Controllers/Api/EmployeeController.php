<?php

namespace App\Http\Controllers\Api;

use Image;
use App\Model\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee = Employee::all();
        return response()->json($employee);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:employees,email|max:100',
            'phone' => 'required|max:20',
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_part = 'public/backend/employee/';
            $image_url = $upload_part.$name;
            $img->save($image_url);

            $employees = Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'salary' => $request->salary,
                'joining_date' => $request->joining_date,
                'nid' => $request->nid,
                'phone' => $request->phone,
                'photo' => $image_url
            ]);
        }else{                    
            $employees = Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'salary' => $request->salary,
                'joining_date' => $request->joining_date,
                'nid' => $request->nid,
                'phone' => $request->phone
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
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
        $data['salary'] = $request->salary;
        $data['phone'] = $request->phone;
        $data['nid'] = $request->nid;
        $data['joining_date'] = $request->joining_date;
        $image = $request->newphoto;
        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($image)->resize(240, 200);
            $upload_part = 'public/backend/employee/';
            $image_url = $upload_part.$name;
            $success = $img->save($image_url);
            if ($success) {
                $data['photo'] = $image_url;
                $img = DB::table('employees')->where('id', $id)->first();
                $image_path = $img->photo;
                $done = unlink($image_path);
                $user = DB::table('employees')->where('id', $id)->update($data);
            }
        }else{  
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
            $user = DB::table('employees')->where('id', $id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $photo = $employee->photo;
        if($photo){
            unlink($photo);
            Employee::find($id)->delete();
        }else{
            Employee::find($id)->delete();
        }
    }
}