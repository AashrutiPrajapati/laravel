<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use App\Models\ProductMedia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request, $page_no = null)
    {
        if (!$page_no) {
            $page_no = 1;
        }
        $current_page = $page_no;
        $recordsPerPage = $request->records_per_page;
        if ($recordsPerPage) {
            session(['paginate' => $recordsPerPage]);
        }
        if ($current_page == 1) {
            $recordsPerPage = session('paginate');
            if (!$recordsPerPage) {
                $recordsPerPage = 1;
            }
            session(['paginate' => $recordsPerPage]);
        }
        $count = Product::count();
        $limit = session('paginate');
        $offset = ($current_page - 1) * $limit;
        $allProducts = Product::all();
        $products = Product::orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();

        if ($limit > 0) {
            $totalPage = ceil($count / $limit);
        } else {
            $totalPage = 0;
        }
        $view = view('products.index', compact('totalPage', 'limit', 'offset', 'allProducts', 'recordsPerPage', 'products'))->render();
        $response = [
            'element' => [
                [
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];
        header('content-type:application/json');
        echo json_encode($response);
    }
    public function get_ajax_data(Request $request)
    {
        if ($request->ajax()) {
            $recordsPerPage = $request->get('records_per_page');
            if (empty($recordsPerPage)) {
                $recordsPerPage = 1;
            }
            session(['paginate' => $recordsPerPage]);
            $allProducts = Product::all();
            $products = Product::paginate(session('paginate'));
            return view('products.index', compact('allProducts', 'recordsPerPage', 'products'))->render();
        }
    }

    public function create()
    {
        $category = Category::all();
        $view = \view('products.create', compact('category'))->render();
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

    public function store(Request $request)
    {
        $product = $request->product;
        $products = Product::get();
        foreach ($products as $value) {
            if ($value->sku ==$product['sku']) {
                return redirect('products/create')->with('success', 'Sku Must Be Unique For Product..');
            }
        }
        if($product['price'] < 0 ){
            return redirect('products/create')->with('error', 'Price Value Must Be Positive..');
        }
        if($product['quantity'] < 0 ){
            return redirect('products/create')->with('error', 'Quantity Value Must Be Positive..');
        }
        if($product['discount'] < 0){
            return redirect('products/create')->with('error', 'Discount Value Must Be Positive..');
        }
        if($product['discount']==''){
            return redirect('products/create')->with('error', 'Discount Not Empty..');
        }
        $post = $request->product;
        if($post['sku']&&$post['category']&& $post['name'] && $post['price']&&($post['discount']>=0)&& $post['quantity']&&$post['description']){
        $post['created_at'] = Carbon::now();
        Product::insertGetId($post);

        return redirect('product')
            ->with('success', 'Product Inserted SuccesFully.');
        }
        return redirect('products/create')
        ->with('error','Please Fill The Form All Fileds Are Required..');
    }

    public function edit(Product $product, $id)
    {
        $product = Product::find($id);
        $category = Category::all();
        $view = \view('products.edit', compact('product', 'category'))->render();
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

    public function status($id, Request $request)
    {
        $product = Product::find($id);
        if ($product->status == 'Disable') {
            $product->status = 'Enable';
        } else {
            $product->status ='Disable';
        }
        $product->save();
        return redirect('product')->with('success', 'Product Status Changed successfully');
    }


    public function update(Request $request, Product $product)
    {
        $product = Product::find($request->id);
        $product->sku = $request->input('sku');
        $product->name = $request->input('name');
        $product->category = $request->input('category');
        $product->price = $request->input('price');
        $product->discount = $request->input('discount');
        $product->quantity = $request->input('quantity');
        $product->description = $request->input('description');
        $product->status = $request->input('status');

        $product->save();

        return redirect('product')
            ->with('success', 'Product Updated successfully');
    }

    public function destroy(Product $product, $id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('product')
            ->with('success', 'Product Deleted successfully');
    }

    public function media($id)
    {
        $product = Product::find($id);
        $productMedia = ProductMedia::where('productId', '=', $id)->get();
        $view = view('products.productmedia', compact('productMedia', 'product', 'id'))->render();
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

    public function mediaSave(Request $request, $id)
    {
        $productMedia = new ProductMedia;
        $image = $request->file('image');
        $name = $_FILES['image']['name'];
        $input['photo'] = $name;
        $Path = public_path('\image\product\\');
        if ($image->move($Path, $input['photo'])) {
            $productMedia->image = $input['photo'];
            $productMedia->label = $name;
            $productMedia->productId = $id;
        }
        $productMedia->save();
        return redirect('products/media/' . $id);
    }

    public function mediaUpdate(Request $request, $id)
    {
        if ($request->file('image')) {
        }
        $productMedia = $request->all();
        if (array_key_exists('small', $productMedia)) {
            $radio['small'] = $productMedia['small'];
        }
        if (array_key_exists('thumb', $productMedia)) {
            $radio['thumb'] = $productMedia['thumb'];
        }
        if (array_key_exists('base', $productMedia)) {
            $radio['base'] = $productMedia['base'];
        }
        if (isset($radio)) {
            foreach ($productMedia['label'] as $key => $value) {
                DB::update('update product_media set label = ? where id = ?', [$value, $key]);
                foreach ($radio as $key2 => $value2) {
                    if ($value2 == $key) {
                        DB::update('update product_media set ' . $key2 . '= ? where id = ?', [1, $key]);
                    } else {
                        DB::update('update product_media set ' . $key2 . ' = ? where id = ?', [0, $key]);
                    }
                }
            }
        }
        if (array_key_exists('gallery', $productMedia)) {
            foreach ($productMedia['gallery'] as $key => $value) {
                DB::update('update product_media set gallery = ? where id = ?', [1, $key]);
            }
        }
        if (array_key_exists('delete', $productMedia)) {
            $delete = $productMedia['delete'];
            foreach ($delete as $mediaid => $value) {
                $productMedia = ProductMedia::where('id', '=', $mediaid)->first();
                if (unlink('image\product\\' . $productMedia->image)) {
                    $productMedia->delete();
                }
            }
        }
        return redirect('products/media/' . $id);
    }
}
