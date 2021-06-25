<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';

    public function getTotal($items)
    {
        $total = 0;
        foreach ($items as $key => $item) {
            $total += $item->price;
        }
        // print_r($total);die;
        $order = self::where('customerId', '=', session('customerId'))->first();
        $order->total = $total;
        $order->save();
        return $total;
    }

    public function getTotalDiscount($items)
    {
        $discount = 0;
        foreach ($items as $key => $item) {
            $discount += $item->discount;
        }
        $order = self::where('customerId', '=', session('customerId'))->first();
        $order->discount = $discount;
        $order->save();
        return $discount;
    }

    public function getFinalPrice($items)
    {
        $finalPrice = 0;
        $order = self::where('customerId', '=', session('customerId'))->first();
        $finalPrice += ($this->getTotal($items) - $this->getTotalDiscount($items) + $order->shippingAmount);
        return $finalPrice;
    }

}
