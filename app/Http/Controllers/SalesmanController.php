<?php

namespace App\Http\Controllers;

use App\Models\Salesman;
use App\Models\SalesmanProduct;
use App\Models\SalesmanProductPrice;
use Illuminate\Http\Request;

class SalesmanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // print_r(session::all());
        // die;
        // Session::save();
        // die;
        $sal = $request->input('search');
        if ($sal) {
            session(['search' => $sal]);
            $salesman = Salesman::where('name', 'LIKE', "%" . session('search') . "%")->get();
        }
        // print_r($request->session()->all());die;
        else {
            $sal = session('search');
            if ($sal) {
                $salesman = Salesman::where('name', 'LIKE', "%" . session('search') . "%")->get();
            } else {
                $salesman = Salesman::all();
                if (!$salesman) {
                    $salesman = NULL;
                }
            }
        }
        $id = session('id');
        if (!$id) {
            $id = null;
        }
        $sales = SalesMan::find($id);
        if (!$sales) {
            $sales = null;
        }
        $products = SalesmanProduct::select('salesman_product_price.price as spp', 'salesman_product_price.discount', 'salesman_product_price.salesmanId', 'salesman_product_price.productId', 'salesman_product.price', 'salesman_product.sku', 'salesman_product.id')
            ->leftJoin('salesman_product_price', function ($join) use ($id) {
                $join->on('salesman_product_price.productId', '=', 'salesman_product.id');
                $join->where('salesman_product_price.salesmanId', '=', $id);
            })->get();
        $view = view('salesman.index', compact('salesman', 'products', 'id', 'sales'))->render();
        $response = [
            'element' => [
                [
                    'success' => 'success',
                    'name' => 'laravel',
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];

        header('content-type:application/json');
        echo json_encode($response);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $sales = new Salesman;
        $sales->name = $request->input('search');
        $salesman = Salesman::where('name', '=', $sales->name)->first();
        if ($salesman) {
            return redirect('salesman')->with('error', 'Salesman Name already exist.');
        } else {
            $sales->save();
            return redirect('salesman')->with('success', 'Salesman Inserted SuccessFully.');
        }
    }

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
     * @param  \App\Models\Salesman  $salesman
     * @return \Illuminate\Http\Response
     */
    public function product(Request $request)
    {
        // print_r($request->session()->all());
        // die;
        $products = SalesmanProduct::all();
        foreach ($products as $key => $value) {
            if ($value->sku == $request->input('sku')) {
                return redirect('salesman')->with('error', 'Sku Must be Unique.');
            }
        }
        if ($request->input('price') < 0 || $request->input('price') == 0) {
            return redirect('salesman')->with('error', 'Price Must Be Positive.');
        }
        $product = new SalesmanProduct;
        $product->sku = $request->input('sku');
        $product->price = $request->input('price');
        $product->save();
        return redirect('salesman')->with('success', 'SalesmanProduct Inserted SuccessFully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salesman  $salesman
     * @return \Illuminate\Http\Response
     */
    public function edit(Salesman $salesman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salesman  $salesman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salesman $salesman, $id)
    {
        // print_r($request->session()->all());
        // die;
        $price = $request->input('sprice');
        $discount = $request->input('sdiscount');
        // print_r($price);
        // print_r($discount);die;
        if ($price) {
            foreach ($price as $key => $value) {
                $product = SalesManProduct::find($key);
                if ($value >= $product->price) {
                    $salesman = SalesmanProductPrice::where([['salesmanId', '=', $id], ['productId', '=', $key]])->first();
                    if ($salesman) {
                        $salesman->price = $value;
                        $salesman->save();
                    } else {
                        $salesman = new SalesmanProductPrice;
                        $salesman->price = $value;
                        $salesman->salesmanId = $id;
                        $salesman->productId = $key;
                        $salesman->save();
                    }
                }
            }
        }
        if ($discount) {
            foreach ($discount as $key1 => $value1) {
                $product = SalesmanProduct::find($key1);
                $salesman = SalesmanProductPrice::where([['salesmanId', '=', $id], ['productId', '=', $key1]])->first();
                if ($salesman) {
                    if ($salesman->price) {
                        $salesman->discount = $value1;
                    }
                    $salesman->save();
                }
            }
        }
        return redirect('salesman')->with('success', 'SalesmanProductPrice Updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salesman  $salesman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salesman $salesman, $id)
    {
        // echo $id;die;
        $salesman = Salesman::find($id);
        $salesman->delete();
        return redirect('salesman')->with('success', 'Salesman Deleted SuccessFully.');
    }

    public function saleid($id, Request $request)
    {
        session(['id' => $id]);
        session(['show' => 1]);
        return redirect('salesman');
    }

    public function clear()
    {
        session()->forget('search');
        session(['show'=>0]);
        session()->forget('id');
        return redirect('salesman');
    }
}
