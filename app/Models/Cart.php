<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table="cart";
    protected $fillable=[
        'customerId','total','discount','paymentMethodId','shippingMethodId','shippingAmount'
    ];

    public function getTotal($items)
    {
        $total = 0;
        if($items){
            foreach ($items as $key => $item) {
                $total += $item->price;
            }
            $cart = self::where('customerId', '=', session('customerId'))->first();
            $cart->total = $total;
            $cart->save();
        }
        return $total;
    }

    public function getTotalDiscount($items)
    {
        $discount = 0;
        if($items){
            foreach ($items as $key => $item) {
                $discount += $item->discount;
            }
            $cart = self::where('customerId', '=', session('customerId'))->first();
            $cart->discount = $discount;
            $cart->save();
        }
        return $discount;
    }

    public function getFinalPrice($items)
    {
        $finalPrice = 0;
        if($items){
            $cart = self::where('customerId', '=', session('customerId'))->first();
            $finalPrice += ($this->getTotal($items) - $this->getTotalDiscount($items) + $cart->shippingAmount);
        }
        return $finalPrice;
    }

}
