<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ProductExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return[
            'id',
            'sku',
            'name',
            'category',
            'price',
            'discount',
            'quantity',
            'description',
            'status',
            'created_at',
            'updated_at',
        ];
    }

    public function collection()
    {
        // print_r(Product::all());die;
        return Product::where('price','>',300)->where('status','=','Enable')->get();
        // print_r($p);die;
        // return $p;
        // return Product::get($p);
    }
}
