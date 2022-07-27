<?php

namespace App\Model;

use App\Model\Salary;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $guarded = [];

    public function employee(){
        return $this->hasMany(Salary::class);
    }
}