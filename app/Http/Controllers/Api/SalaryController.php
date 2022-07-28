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
            ->select('employees.name', 'salaries.*')
            ->where('salaries.salary_month',$month)
            ->get();
        // $view = Salary::query()
        //     ->with(array(
        //         'employee' => function($query) {
        //             $query->select('id','name');
        //         }
        //     ))->get();
        return response()->json($view);
    }

    //EditSalary
    public function EditSalary($id){
        $view = DB::table('salaries')
            ->join('employees', 'salaries.employee_id', 'employees.id')
            ->select('employees.name', 'employees.email', 'salaries.*')
            ->where('salaries.id',$id)
            ->first();
            return response()->json($view);
    }

    //UpdateSalary
    public function UpdateSalary(Request $request, $id){
        $salary = Salary::find($id)->update([
            'employee_id' => $request->employee_id,
            'amount' => $request->amount,
            'salary_month' => $request->salary_month
        ]);
        return response()->json($salary);
    }
}