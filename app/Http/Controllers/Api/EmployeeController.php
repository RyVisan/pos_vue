<?php

namespace App\Http\Controllers\Api;

use Image;
use App\Model\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        return response()->json($employee);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:employees|email',
            'phone' => 'required|',
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
            // $employee = new Employee;
            // $employee->name = $request->name;
            // $employee->email = $request->email;
            // $employee->address = $request->address;
            // $employee->phone = $request->phone;
            // $employee->salary = $request->salary;
            // $employee->joining_date = $request->joining_date;
            // $employee->nid = $request->nid;
            // $employee->save();
                    
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}