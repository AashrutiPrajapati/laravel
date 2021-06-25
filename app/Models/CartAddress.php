<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAddress extends Model
{
    use HasFactory;

    protected $table="cartaddress";
    protected $fillable=[
        'cartId','addressType','address','city','state','country','zipcode','same_as_billing'
    ];
}
