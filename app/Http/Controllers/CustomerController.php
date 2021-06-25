<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Customer_address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerController extends Controller
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
                $recordsPerPage = 2;
            }
            session(['paginate' => $recordsPerPage]);
        }
        $count = Customer::count();
        $limit = session('paginate');
        $offset = ($current_page - 1) * $limit;
        $customers = Customer::LeftJoin('customer_address', 'customer_address.customerId', '=', 'customer.id')->select('customer.id', 'customer.firstName', 'customer.lastName', 'customer.email', 'customer.password', 'customer.status','customer.created_at','customer.updated_at', 'customer_address.address', 'customer_address.city', 'customer_address.state', 'customer_address.country', 'customer_address.zipcode', 'customer_address.addressType')->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
        // print_r($customers);die;
        if ($limit > 0) {
            $totalPage = ceil($count / $limit);
        } else {
            $totalPage = 0;
        }
        $view = \view('customers.index', compact('totalPage', 'count', 'customers', 'limit', 'offset'))->render();
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
        // die();
    }

    public function create()
    {
        $view = \view('customers.create')->render();
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
        if(isset($post['firstName'])&& isset($post['lastName']) && isset($post['email'])&& isset($post['password'])){
            $customer=new Customer;
            $customer->firstName = $request->input('firstName');
            $customer->lastName = $request->input('lastName');
            $customer->email = $request->input('email');
            $customer->password = $request->input('password');
            $customer->status = $request->input('status');
            $customer->created_at = Carbon::now();
            $customer->updated_at=NULL;
            $customer->save();

            return redirect('/customer')
                ->with('success', 'Customer created successfully.');
            }
        return redirect('customers/create')
            ->with('error', 'Please Fill The All Filed.');   

    }

    public function edit(Customer $customer, $id)
    {
        $customer = Customer::find($id);
        $view = \view('customers.edit', compact('customer'))->render();
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

    public function update(Request $request, Customer $customer)
    {
        $customer = Customer::find($request->id);
        $customer->firstName = $request->input('firstName');
        $customer->lastName = $request->input('lastName');
        $customer->email = $request->input('email');
        $customer->password = $request->input('password');
        $customer->status = $request->input('status');
        $customer->updated_at = Carbon::now();

        $customer->save();

        return redirect('customer')
            ->with('success', 'Customer updated successfully');
    }

    public function status($id, Request $request)
    {
        $customer = Customer::find($id);
        if ($customer->status == 'Disable') {
            $customer->status = 'Enable';
        } else {
            $customer->status ='Disable';
        }
        $customer->save();
        return redirect('customer')->with('success', 'Customer Status Changed successfully');
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return \redirect('customer')
            ->with('success', 'Customer deleted successfully');
    }

    public function address($id)
    {
        $customer = Customer::find($id);
        $BillingAddress = Customer_address::where('customerId', '=', $id)->where('addressType', '=', "Billing")->first();
        $ShippingAddress = Customer_address::where('customerId', '=', $id)->where('addressType', '=', "Shipping")->first();
        $view = \view('customers.address', compact('customer', 'BillingAddress', 'ShippingAddress'))->render();
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

    public function saveAddress(Request $request, $id)
    {
        // print_r($id);die;
        $billing = Customer_address::where('customerId', '=', $id)->where('addressType', '=', "Billing")->first();
        $shipping = Customer_address::where('customerId', '=', $id)->where('addressType', '=', "Shipping")->first();

        if (!$billing) {
            $billing = new Customer_address;
        }
        if (!$shipping) {
            $shipping = new Customer_address;
        }

        $billing->address = $request->billing['address'];
        $billing->city = $request->billing['city'];
        $billing->state = $request->billing['state'];
        $billing->country = $request->billing['country'];
        $billing->zipcode = $request->billing['zipcode'];
        $billing->addressType = "Billing";
        $billing->customerId = $id;

        $shipping->address = $request->shipping['address'];
        $shipping->city = $request->shipping['city'];
        $shipping->state = $request->shipping['state'];
        $shipping->country = $request->shipping['country'];
        $shipping->zipcode = $request->shipping['zipcode'];
        $shipping->addressType = "Shipping";
        $shipping->customerId = $id;

        $shipping->save();
        $billing->save();
        return redirect('customer')
            ->with('success', 'Customer Address Saved Successfully');
    }
}
