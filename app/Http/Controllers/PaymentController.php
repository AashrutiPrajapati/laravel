<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentController extends Controller
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
        $count = Payment::count();
        $limit = session('paginate');
        $offset = ($current_page - 1) * $limit;
        $allPayments = Payment::all();
        $payments = Payment::orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();

        if ($limit > 0) {
            $totalPage = ceil($count / $limit);
        } else {
            $totalPage = 0;
        }
        $view = view('payment.index', compact('totalPage', 'limit', 'offset', 'allPayments', 'recordsPerPage', 'payments'))->render();
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
        $view = \view('payment.create')->render();
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
        $payment = $request->input('code');
        $payments = Payment::get();
        foreach ($payments as $value) {
            if ($value->code ==$payment) {
                return redirect('payment/create')->with('error', 'Code Was Already Exist For Payment..');
            }
        }
        if(isset($post['name'])&& isset($post['code']) && isset($post['description'])&& isset($post['status'])){
            $payment=new Payment;
            $payment->name = $request->input('name');
            $payment->code= $request->input('code');
            $payment->description = $request->input('description');
            $payment->status = $request->input('status');
            $payment->updated_at=NULL;
            $payment->save();

            return redirect('/payment')
                ->with('success', 'Payment created successfully.');
            }
        return redirect('payment/create')
            ->with('error', 'Please Fill The All Filed.');   

    }

    public function edit(Payment $payment, $id)
    {
        $payment = Payment::find($id);
        $view = \view('payment.edit', compact('payment'))->render();
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

    public function update(Request $request, Payment $payment)
    {
        $payment = Payment::find($request->id);
        $payment->name = $request->input('name');
        $payment->code = $request->input('code');
        $payment->description = $request->input('description');
        $payment->status = $request->input('status');
        $payment->updated_at = Carbon::now();

        $payment->save();

        return redirect('payment')
            ->with('success', 'Payment updated successfully');
    }

    public function status($id, Request $request)
    {
        $payment = Payment::find($id);
        if ($payment->status == 'Disable') {
            $payment->status = 'Enable';
        } else {
            $payment->status ='Disable';
        }
        $payment->save();
        return redirect('payment')->with('success', 'Payment Status Changed successfully');
    }

    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();
        return \redirect('payment')
            ->with('success', 'Payment deleted successfully');
    }

}
