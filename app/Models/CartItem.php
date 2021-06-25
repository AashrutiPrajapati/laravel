<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table="cart_item";
    protected $fillable=[
        'cartId','productId','quantity','basePrice','price','discount'
    ];

    public function totalAmount()
    {
        $cartItem=self::all();
        foreach ($cartItem as $key => $value) {
            echo $amount=($value['price'])-($value['discount']);
        }
        return $amount;
    }
}
