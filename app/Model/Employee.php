<?php

namespace App\Model;

use App\Model\Salary;
use App\Model\Employee;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function salary(){
        return $this->belongsTo(Salary::class, 'employee_id');
    }
}