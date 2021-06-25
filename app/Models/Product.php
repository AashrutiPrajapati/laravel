<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table="product";
    protected $fillable=[
        'sku','name','category','price','discount','quantity','description','status'
    ];
}
