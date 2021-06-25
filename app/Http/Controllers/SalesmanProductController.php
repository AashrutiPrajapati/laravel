<?php

namespace App\Http\Controllers;

use App\Models\SalesmanProduct;
use App\Models\SalesmanProductPrice;
use Illuminate\Http\Request;

class SalesmanProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = SalesmanProduct::LeftJoin('salesman_product_price', 'salesman_product_price.productId', '=', 'salesman_product.id')->select('salesman_product.id', 'salesman_product.sku', 'salesman_product.price', 'salesman_product_price.price', 'salesman_product_price.discount')->orderBy('id', 'ASC')->get();
        // // print_r($products);die;
        // $view = view('salesman.index', compact('products'))->render();
        // $response = [
        //     'element' => [
        //         [
        //             'success' => 'success',
        //             'name' => 'laravel',
        //             'selector' => '#content',
        //             'html' => $view
        //         ]
        //     ]
        // ];

        // header('content-type:application/json');
        // echo json_encode($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    // "<?phpif($value->id == $value1->productId){echo $value1->price;} "
    // <!-- "<?phpif($value->id == $value1->productId){echo $value1->discount;} -->


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesmanProduct  $salesmanProduct
     * @return \Illuminate\Http\Response
     */
    public function show(SalesmanProduct $salesmanProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesmanProduct  $salesmanProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesmanProduct $salesmanProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesmanProduct  $salesmanProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesmanProduct $salesmanProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesmanProduct  $salesmanProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesmanProduct $salesmanProduct)
    {
        //
    }
}
