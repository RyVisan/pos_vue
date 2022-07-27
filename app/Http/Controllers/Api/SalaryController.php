<?php

namespace App\Http\Controllers\Api;

use App\Model\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    //paid
    public function Paid(Request $request, $id){
        $request->validate([
            'salary_month' => 'required'
        ]);

        $month = $request->salary_month;
        $check = Salary::where('employee_id',$id)->where('salary_month', $month)->first();
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

    //AllSalary
    public function AllSalary(){
        $salaries = Salary::select('salary_month')->groupBy('salary_month')->get();
        return response()->json($salaries);
    }

    //ViewSalary
    public function ViewSalary($id){
        $month = $id;
        $view = DB::table('salaries')
            ->join('employees', 'salaries.employee_id', 'employees.id')
            ->where('salaries.salary_month',$month)
            ->select('employees.name', 'salaries.*')
            ->get();
        // $view = Salary::with('employee')->where('salary_month',$month)->get();
        // $view = Salary::with(array('employee'=>function($query){
        //     $query->select('id','name');
        // }))->get();
        return response()->json($view);
    }
}