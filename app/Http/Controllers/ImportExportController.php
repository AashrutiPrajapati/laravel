<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Exports\ProductExport;
use Carbon\Carbon;

class ImportExportController extends Controller
{
    protected $data = [];
    protected $header = [];
    public function index()
    {
        $view=view('importexport.index')->render();
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

    // public function import()
    // {
    //     $filename=$_FILES["image"]["tmp_name"]; 
    //     $file = fopen($filename, 'r');
    //     while ($row = fgetcsv($file, 10000, ',', '"', '\\')) {
    //         // print_r($row);die;
    //         if (!$this->header) {
    //             $this->header = $row;
    //         } else {
    //             $this->data[] = array_combine($this->header, $row);
    //         }
    //     }
    //     $this->insert();
    //     fclose($file);
    //     return redirect('importexport')->with('success','CSV File SuccessFully Imported...');
    // }
    
    // public function insert()
    // {
    //     foreach ($this->data as $key => $value) {
    //         $product = Product::where('sku', '=', $value['sku'])->first();
    //         if($value['status']=='Enable'){
    //             $value['status']=1;
    //         }
    //         else{
    //             $value['status']=0;
    //         }
    //         if ($product) {
    //             $product->sku=$value['sku'];
    //             $product->name=$value['name'];
    //             $product->category=$value['category'];
    //             $product->price=$value['price'];
    //             $product->discount=$value['discount'];
    //             $product->quantity=$value['quantity'];
    //             $product->description=$value['description'];
    //             $product->status=$value['status'];
    //             $product->updated_at=Carbon::now();
    //             $product->save();
    //         }
    //         else{
    //             $product = new Product;
    //             $product->sku=$value['sku'];
    //             $product->name=$value['name'];
    //             $product->category=$value['category'];
    //             $product->price=$value['price'];
    //             $product->discount=$value['discount'];
    //             $product->quantity=$value['quantity'];
    //             $product->description=$value['description'];
    //             $product->status=$value['status'];
    //             $product->created_at=Carbon::now();
    //             $product->save();
    //         }
    //     }
    // }

    // public function export()
    // {
    //     header('Content-Type: text/csv; charset=utf-8');
    //     header('Content-Disposition: attachment; filename=data.csv');
    //     $output = fopen("php://output", "w");

    //     $product=Product::all();
    //     $xyz=false;
    //     $header=['id','sku','name','category','price','discount','quantity','description','status'];  
    //     foreach ($product as $key => $value) {
    //         if(!$xyz){
    //             fputcsv($output,$header);
    //             $xyz=true;
    //         }
    //         fputcsv($output,$value->getAttributes());
    //     }
    //     fclose($output);
    // }

    public function import(Request $request)
    {
        // print_r($request->image);die;
        Excel::import(new ProductImport,$request->image);
        return redirect('importexport')->with('success','CSV File Imported SucceFully.');
    }

    public function exportIntoCSV()
    {
        return Excel::download(new ProductExport,'productlist.csv');
    }
}
