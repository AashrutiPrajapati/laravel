@extends('layouts.app')
@section('content')
    <h1>Hello {{$customerName->firstName}} {{$customerName->lastName}}</h1>
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
                    <th scope="col">CartId</th>
                    <th scope="col">ProductId</th>
                    <th scope="col">ProductName</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Base Price</th>
                    <th scope="col">Price</th>
                    <th scope="col">Discount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItem as $item)
                    <tr>
                        <td>{{ $item->cartId }}</td>
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
                            <td>{{ $billingAddress->address }}</td>
                        </tr>
                        <tr>
                            <td scope="col">City</td>
                            <td>{{ $billingAddress->city }}</td>
                        </tr>
                        <tr>
                            <td scope="col">State</td>
                            <td>{{ $billingAddress->state }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Country</td>
                            <td>{{ $billingAddress->country }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Zipcode</td>
                            <td>{{ $billingAddress->zipcode }}</td>
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
                            <td>{{ $shippingAddress->address }}</td>
                        </tr>
                        <tr>
                            <td scope="col">City</td>
                            <td>{{ $shippingAddress->city }}</td>
                        </tr>
                        <tr>
                            <td scope="col">State</td>
                            <td>{{ $shippingAddress->state }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Country</td>
                            <td>{{ $shippingAddress->country }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Zipcode</td>
                            <td>{{ $shippingAddress->zipcode }}</td>
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
                            <td>{{ $paymentMethod->name }}</td>
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
                            <td>{{ $shippingMethod->name }} => {{ $shippingMethod->description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br><br><br>
        <div class="row">
            <div class="col-md-6 float-left">
            </div>
            <div class="col-md-6 float-right">
                <table class="table table-bordered table-responsive-lg">
                    <tbody>
                        <tr>
                            <td scope="row">Total Price</td>
                            <td>{{ $model->getTotal($cartItem) }}</td>
                        </tr>
                        <tr>
                            <td scope="row">Total Discount</td>
                            <td>{{ $model->getTotalDiscount($cartItem) }}</td>
                        </tr>
                        <tr>
                            <td scope="row">Shipping Charge</td>
                            <td>{{ $shippingMethod->amount}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Final Price</td>
                            <td>{{ $model->getFinalPrice($cartItem) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br><br><br>
@endsection

