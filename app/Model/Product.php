<?php

namespace App\Model;

use App\Model\Category;
use App\Model\Supplier;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

}