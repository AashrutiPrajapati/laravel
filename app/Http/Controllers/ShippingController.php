<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;
use Carbon\Carbon;

class ShippingController extends Controller
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
        $count = Shipping::count();
        $limit = session('paginate');
        $offset = ($current_page - 1) * $limit;
        $allshippings = Shipping::all();
        $shippings = Shipping::orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();

        if ($limit > 0) {
            $totalPage = ceil($count / $limit);
        } else {
            $totalPage = 0;
        }
        $view = view('shipping.index', compact('totalPage', 'limit', 'offset', 'allshippings', 'recordsPerPage', 'shippings'))->render();
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

    public function create()
    {
        $view = \view('shipping.create')->render();
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
        $post=$request->all();
        $shipping = $request->input('code');
        $shippings = Shipping::get();
        foreach ($shippings as $value) {
            if ($value->code ==$shipping) {
                return redirect('shipping/create')->with('error', 'Code Was Already Exist For Shipping..');
            }
        }
        if($request->input('amount') < 0){
            return redirect('shipping/create')->with('error', 'Amount Value Must Be Positive..');
        }
        if($request->input('amount')==''){
            return redirect('shipping/create')->with('error', 'Amount Not Empty..');
        }
        if($post['name']&&$post['code'] && ($post['amount']>=0)&& $post['description']&&$post['status']){
            $shipping=new Shipping;
            $shipping->name = $request->input('name');
            $shipping->code= $request->input('code');
            $shipping->amount= $request->input('amount');
            $shipping->description = $request->input('description');
            $shipping->status = $request->input('status');
            $shipping->updated_at=NULL;
            $shipping->save();

            return redirect('/shipping')
                ->with('success', 'Shipping created successfully.');
            }
        return redirect('shipping/create')
            ->with('error', 'Please Fill The All Filed.');   

    }

    public function edit(Shipping $shipping, $id)
    {
        $shipping = Shipping::find($id);
        $view = \view('shipping.edit', compact('shipping'))->render();
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

    public function update(Request $request, Shipping $shipping)
    {
        $shipping = Shipping::find($request->id);
        $shipping->name = $request->input('name');
        $shipping->code = $request->input('code');
        $shipping->amount = $request->input('amount');
        $shipping->description = $request->input('description');
        $shipping->status = $request->input('status');
        $shipping->updated_at = Carbon::now();

        $shipping->save();

        return redirect('shipping')
            ->with('success', 'Shipping updated successfully');
    }


    public function status($id, Request $request)
    {
        $shipping = Shipping::find($id);
        if ($shipping->status == 'Disable') {
            $shipping->status = 'Enable';
        } else {
            $shipping->status ='Disable';
        }
        $shipping->save();
        return redirect('shipping')->with('success', 'Shipping Status Changed successfully');
    }

    public function destroy($id)
    {
        $shipping = Shipping::find($id);
        $shipping->delete();
        return \redirect('shipping')
            ->with('success', 'Shipping deleted successfully');
    }

}
