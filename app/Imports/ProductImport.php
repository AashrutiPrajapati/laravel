<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // print_r($row);die;
        if($row['sku']){
            $product=Product::where('sku','=',$row['sku'])->first();
            if($product){
                $product->update($row);
                return $product;
            }
            return new Product([
                'sku'=>$row['sku'],
                'name'=>$row['name'],
                'category'=>$row['category'],
                'price'=>$row['price'],
                'discount'=>$row['discount'],
                'quantity'=>$row['quantity'],
                'description'=>$row['description'],
                'status'=>$row['status'],
                ]);
            }
    }
}
