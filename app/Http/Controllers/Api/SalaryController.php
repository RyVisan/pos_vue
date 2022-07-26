<?php

namespace App\Http\Controllers\Api;

use App\Model\Salary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    public function paid(Request $request, $id){
        $validation = $request->validate([
            'salary_month' => 'required'
        ]);

        $month = $request->salary_month;
        $check = Salary::find($id)->where('employee_id',$id)->where('salary_month', $month)->first();
        if($check){
            return response()->json('Salary Already Paid');
        }else{
            Salary::create([
                'employee_id' => $id,
                'amount' => $request->salary,
                'salary_date' => date('d/m/Y'),
                'salary_month' => $month,
                'salary_year' => date('Y'),
            ]);
        }
    }
}