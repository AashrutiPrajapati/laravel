<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\OrderComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request,$page_no=null)
    {
        if ($request->records_per_page) {
            session(['records_per_page' => $request->records_per_page]);
        }
        if ($page_no) {
            session(['page' => $page_no]);
        } else {
            session(['page' => 1]);
        }
        $current_page = session('page');
        $customerId = $request->customerId;
        session(['customerId' => $customerId]);
        if($customerId){
            $count = Order::where('customerId', '=', $customerId)->count();
            if (session('records_per_page')) {
                $limit = session('records_per_page');
            } else {
                $limit = $count;
            }
            $offset = ($current_page - 1) * $limit;
            $orders = Order::orderBy('id', 'DESC')->where('customerId', '=', $customerId)->offset($offset)->limit($limit)->get();
        }else{
            $orderItem=OrderItem::get();
            $count = Order::count();
            if (session('records_per_page')) {
                $limit = session('records_per_page');
            } else {
                $limit = $count;
            }
            $offset = ($current_page - 1) * $limit;
            $orders = Order::orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
        }
        if ($limit > 0) {
            $totalPage = ceil($count / $limit);
        } else {
            $totalPage = 0;
        }
        $products=Product::where('status','=','Enable')->get();
        $customers=Customer::where('status','=','Enable')->get();
        $view= view('order.index',compact('orders','products','customers', 'totalPage', 'limit', 'offset'))->render();
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

    public function show($id)
    {
        $model = new Order;
        $products = Product::all();
        $order = Order::find($id);
        $comments = DB::select('select * from `order_comments` where `orderId` = ? ORDER BY `id` DESC', [$order->id]);
        if (!$comments) {
            $comments = null;
        }
        $customerName = Customer::find($order->customerId);
        $orderItem = OrderItem::where('orderId', '=', $id)->get();
        $payment = Payment::find($order->paymentMethodId);
        $shipping = Shipping::find($order->shippingMethodId);
        $orderBillingAddress = OrderAddress::where('orderId', '=', $id)->where('addressType', '=', 'billing')->first();
        $orderShippingAddress = OrderAddress::where('orderId', '=', $id)->where('addressType', '=', 'shipping')->first();
        $view = view('order.show', compact('comments', 'products', 'customerName', 'orderItem', 'orderBillingAddress', 'orderShippingAddress', 'model', 'payment', 'shipping', 'order'))->render();
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

    public function comments(Request $request,$id)
    {
        $comments = $request->comments;
        $comment = new OrderComments;
        $commentId = $comment->insertGetId([
            'orderId' => $id,
            'comment' => $comments['comment'],
            'status' => $comments['status'],
            'created_at' => Carbon::now(),
        ]);
        
        return redirect('order')->with('success', 'Order status successfully changed.');
    }
}
