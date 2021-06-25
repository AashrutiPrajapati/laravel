@extends('layouts.app')
@section('content')
<br><br>
<a href="javascript:void(0)" onclick="object.setUrl('order').setMethod('get').load();" class="btn btn-success">Back</a>
    <h3>Hello {{$customerName->firstName}} {{$customerName->lastName}} Order Details</h3>
    <div class="col-md">
        <table  class="table table-bordered table-responsive-lg">
            <thead>
                <tr>
                    <th scope="col">CustomerId</th>
                    <th scope="col">FirstName</th>
                    <th scope="col">LastName</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $customerName->id }}</td>
                    <td>{{ $customerName->firstName }}</td>
                    <td>{{ $customerName->lastName }}</td>
                    <td>{{ $customerName->email }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md">
        <br><br>
        <table class="table table-bordered table-responsive-lg">
            <thead>
                <tr>
                    <th scope="col">OrderId</th>
                    <th scope="col">ProductId</th>
                    <th scope="col">ProductName</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Base Price</th>
                    <th scope="col">Price</th>
                    <th scope="col">Discount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItem as $item)
                    <tr>
                        <td>{{ $item->orderId }}</td>
                        <td>{{ $item->productId }}</td>
                        @foreach ($products as $product)
                            @if ($product->id == $item->productId)
                                <td>{{ $product->name }}</td>
                            @endif
                        @endforeach
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->basePrice }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->discount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table><br><br>
    </div>
    <br><br><br><br>
    <div class="col-md">
        <div class="row">
            <div class="col-md-5 float-left">
                <h3>Billing Address</h3>
                <table class="table table-bordered table-responsive-lg">
                    <tbody>
                        <tr>
                            <td scope="col">Address</td>
                            <td>{{ $orderBillingAddress->address }}</td>
                        </tr>
                        <tr>
                            <td scope="col">City</td>
                            <td>{{ $orderBillingAddress->city }}</td>
                        </tr>
                        <tr>
                            <td scope="col">State</td>
                            <td>{{ $orderBillingAddress->state }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Country</td>
                            <td>{{ $orderBillingAddress->country }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Zipcode</td>
                            <td>{{ $orderBillingAddress->zipcode }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5 float-right">
                <h3>Shipping Address</h3>
                <table class="table table-bordered table-responsive-lg">
                    <tbody>
                        <tr>
                            <td scope="col">Address</td>
                            <td>{{ $orderShippingAddress->address }}</td>
                        </tr>
                        <tr>
                            <td scope="col">City</td>
                            <td>{{ $orderShippingAddress->city }}</td>
                        </tr>
                        <tr>
                            <td scope="col">State</td>
                            <td>{{ $orderShippingAddress->state }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Country</td>
                            <td>{{ $orderShippingAddress->country }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Zipcode</td>
                            <td>{{ $orderShippingAddress->zipcode }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br><br><br>
        <div class="row">
            <div class="col-md-5 float-left">
                <h3>
                    <center>Payment Method</center>
                </h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ $payment->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5 float-right">
                <h3>
                    <center>Shipping Method</center>
                </h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ $shipping->name }} => {{ $shipping->description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br><br><br>
        <div class="row">
            <div class="col-md-6 float-left">
                <table class="table table-bordered table-responsive-lg ">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center">
                                Order Status
                            </th>
                        </tr>
                        <tr>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($comments)
                            @foreach ($comments as $comment)
                                <tr>
                                    <td>
                                        {{ $comment->comment ? $comment->comment : '-' }}
                                    </td>
                                    <td>
                                        {{ $comment->status }}
                                    </td>
                                    <td>
                                        {{ $comment->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td colspan="3">
                                <form action="{{ url('order/comments/' . $order->id) }}" method="post" id="comments">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="comment">Comment</label>
                                            <textarea class="form-control" name="comments[comment]" id="comment" rows="2" style="resize: none"></textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="status">Select Status</label>
                                            <select class="form-control" name="comments[status]" id="status">
                                                <option selected disabled>Select Status</option>
                                                <option value="pending">Pending</option>
                                                <option value="processing">Processing</option>
                                                <option value="shipped">Shipped</option>
                                                <option value="delivered">Delivered</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <input type="button" onclick="object.setForm('comments');"
                                                class="btn btn-primary" value="Save Comment">
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 float-right">
                <table class="table table-bordered table-responsive-lg">
                    <tbody>
                        <tr>
                            <td scope="row">Total Price</td>
                            <td>{{ $order->total }}</td>
                        </tr>
                        <tr>
                            <td scope="row">Total Discount</td>
                            <td>{{ $order->discount }}</td>
                        </tr>
                        <tr>
                            <td scope="row">Shipping Charge</td>
                            <td>{{ $shipping->amount}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Final Price</td>
                            <td>{{($order->total+$shipping->amount)-$order->discount}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br><br><br>
@endsection

