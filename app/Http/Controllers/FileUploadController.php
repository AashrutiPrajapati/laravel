<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FileUploadController extends Controller
{
    protected $data=[];
    protected $header=[];
    public function index()
    {
        $view=view('fileupload.index')->render();
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

    public function import()
    {
        $filename=$_FILES['image']['tmp_name'];
        $filepath=fopen($filename,'r');
        while($row=fgetcsv($filepath,10000,',','"','\\')){
            if(!$this->header){
                $this->header=$row;
            }
            else{
                $this->data[]=array_combine($this->header,$row);
                // print_r($this->data);die;
            }
        }
        // die;
        $this->insert();
        fclose($filepath);
        return redirect('fileupload')->with('success','FileUpload SuccesFully.');
    }

    public function insert()
    {
        foreach ($this->data as $key => $value) {
            // print_r($value);die;
            $product=Product::where('sku','=',$value['sku'])->first();
            if($value['status']=='Enable'){
                $value['status']=1;
            }
            else{
                $value['status']=0;
            }
            if($product){
                $product->sku=$value['sku'];
                $product->name=$value['name'];
                $product->category=$value['category'];
                $product->price=$value['price'];
                $product->discount=$value['discount'];
                $product->quantity=$value['quantity'];
                $product->description=$value['description'];
                $product->status=$value['status'];
                $product->save();
            }else{
                $product=new Product;
                $product->sku=$value['sku'];
                $product->name=$value['name'];
                $product->category=$value['category'];
                $product->price=$value['price'];
                $product->discount=$value['discount'];
                $product->quantity=$value['quantity'];
                $product->description=$value['description'];
                $product->status=$value['status'];
                $product->save();
            }
        }
    }

    public function export()
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output=fopen("php://output","w");

        $product=Product::all();
        $abc=false;
        $header=['id','sku','name','category','price','discount','quantity','description','status'];
        foreach ($product as $key => $value) {
            if(!$abc){
                fputcsv($output,$header);
                $abc=true;
            }
            if($value['status']=='1'){
                $value['status']='Enable';
            }
            else{
                $value['status']='Disable';
            }
            $upload=[
                $value['id'],
                $value['sku'],
                $value['name'],
                $value['category'],
                $value['price'],
                $value['discount'],
                $value['quantity'],
                $value['description'],
                $value['status']
            ];
            // print_r($upload);die;
            fputcsv($output,$upload);
        }
        fclose($output);
    }
}
