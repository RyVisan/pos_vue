<?php

namespace App\Model;

use App\Model\Salary;
use App\Model\Employee;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $guarded = [];

    public function employee(){
        return $this->hasMany(Employee::class, 'employee_id');
    }
}