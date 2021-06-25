@extends('layouts.app')
@section('content')
<br><br>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
@if ($message = Session::get('error'))
<div class="alert alert-danger">
    <p>{{ $message }}</p>
</div>
@endif
<br>
<div class="row">
    <div class="pull-left">
        <form action="{{ url('cart/selectcustomer') }}" metthod="post" id="customer"> 
            <select name="customerId">
                <option selected disabled>Select Customer</option>
                @foreach($customer as $value)
                <option value="{{ $value->id }}" <?php if ($value->id == session('customerId'))echo 'selected';?>>{{ $value->firstName }}</option>
                @endforeach
            </select>
            <input type="button" class="btn btn-primary" value="Go" onclick="object.setForm('customer');">
        </form>
    </div>
</div>
<br>
<input type="button" value="Add Product" class="btn btn-success" id="add_product">
<div class="col-md d-n" id="product">
    <form action="{{ url('cart/add_product') }}" method="post" id="procart">
        @csrf
        <table class="table table-bordered table-responsive-lg">
            <thead>
                <tr>
                    <th scope="col">ProductId</th>
                    <th scope="col">SKU</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Add Item to Cart</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td><?= $product->id ?></td>
                    <td><?= $product->sku ?></td>
                    <td><?= $product->name ?></td>
                    <td><?= $product->price ?></td>
                    <td><?= $product->discount ?></td>
                    <td><?= $product->quantity ?></td>
                    <td>
                        <input name="product[add_to_cart][]" value="{{ $product->id }}" type="checkbox" class="form-check-input" id="exampleCheck1">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table><br><br>
        <input type="button" class="btn btn-success" value="Add To Cart" id="add_to_cart" onclick="object.setForm('procart');">
    </form>
</div>
<br><br><br><br>
<div class="col-md">
    <a href="{{url('cart/clearCart')}}" class="btn btn-danger" onclick="mage.setUrl('cart/clearCart').setMethod('get').load();">Clear Cart</a>
    <br><br>
    <form action="{{ url('cart/updateQuantity') }}" method="post" id="cart_item">
        <input type="button" class="btn btn-success" value="Update" id="update" onclick="object.setForm('cart_item');">
        <input type="button" class="btn btn-danger" value="Delete Item" onclick="object.setForm('cart_item');">
        @csrf
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
                    <th scope="col">Total Amount</th>
                    <th scope="col">Remove</th>
                </tr>
            </thead>
            <tbody>
                @if ($cartItem !=NULL)
                @foreach ($cartItem as $item)
                <tr>
                    <td><?= $item->cartId ?></td>
                    <td><?= $item->productId ?></td>
                    @foreach ($products as $product)
                    @if ($product->id == $item->productId)
                    <td><?= $product->name ?></td>
                    @endif
                    @endforeach
                    <td><input type="number" name="quantity[{{$item->productId}}]" id="quantity" min="1" value={{$item->quantity}}></td>
                    <td><?= $item->basePrice ?></td>
                    <td><?= $item->price ?></td>
                    <td><?= $item->discount ?></td>
                    <td><?= $item->price-$item->discount ?></td>
                    <td><input type="checkbox" name="remove[{{$item->id}}]" id="remove_item" value={{$item->id}}></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table><br><br>
    </form>
</div>
<div class="col md-6">
    <table>
        <tr>
            <td>
                <div>
                    <form action="{{ url('cart/billingAddress') }}" method="post" id="payment">
                        @csrf
                        <table width="70%" height="70%" class="table table-bordered table-responsive-lg">
                            <tr>
                                <th colspan=2>Billing Address</th>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td><input type="text" name="billing[address]" value="{{ isset($billingAddress->address) && $billingAddress->address != '' ? $billingAddress->address : '' }}"></td>
                            </tr>                                                           
                            <tr>
                                <td>City</td>
                                <td><input type="text" name="billing[city]" value="{{ isset($billingAddress->city) && $billingAddress->city != '' ? $billingAddress->city : '' }}"></td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td><input type="text" name="billing[state]" value="{{ isset($billingAddress->state) && $billingAddress->state != '' ? $billingAddress->state : '' }}"></td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td><input type="text" name="billing[country]" value="{{ isset($billingAddress->country) && $billingAddress->country != '' ? $billingAddress->country : '' }}"></td>
                            </tr>
                            <tr>
                                <td>Zip Code</td>
                                <td><input type="text" name="billing[zipcode]" value="{{ isset($billingAddress->zipcode) && $billingAddress->zipcode != '' ? $billingAddress->zipcode : '' }}"></td>
                            </tr>
                            <tr>
                                <td>Save to Address Book</td>
                                <td><input type=checkbox name=billingSave ></td>
                            </tr>
                            <tr colspan="2">
                                <td></td>
                                <td>
                                    <input class="btn btn-success" type="button" value="Save" onclick="object.setForm('payment');">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
            <td>
                <div>
                    <form action="{{ url('cart/shippingAddress') }}" method="post" id="shipping">
                        @csrf
                        <table width="70%" height="70%" class="table table-bordered table-responsive-lg">
                            <tr>
                                <th colspan=2>Shipping Address</th>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td><input type="text" name="shipping[address]" value="{{ isset($shippingAddress->address) && $shippingAddress->address != '' ? $shippingAddress->address : '' }}"></td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td><input type="text" name="shipping[city]" value="{{ isset($shippingAddress->city) && $shippingAddress->city != '' ? $shippingAddress->city : '' }}"></td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td><input type="text" name="shipping[state]" value="{{ isset($shippingAddress->state) && $shippingAddress->state != '' ? $shippingAddress->state : '' }}"></td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td><input type="text" name="shipping[country]" value="{{ isset($shippingAddress->country) && $shippingAddress->country != '' ? $shippingAddress->country : '' }}"></td>
                            </tr>
                            <tr>
                                <td>Zip Code</td>
                                <td><input type="text" name="shipping[zipcode]" value="{{ isset($shippingAddress->zipcode) && $shippingAddress->zipcode != '' ? $shippingAddress->zipcode : '' }}"></td>
                            </tr>
                            <tr>
                                <td>Same As Billing</td>
                                <td><input type=checkbox name=sameAsBilling></td>
                            </tr>
                            <tr>
                                <td>Save to Address Book</td>
                                <td><input type=checkbox name=shippingSave></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-success" type="button" value="Save" onclick="object.setForm('shipping');">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
        </tr>
    </table>
</div>

<div>
<form action="{{ url('cart/payment') }}" method="post" id="paymentMethod">
@csrf
<table width="70%" height="70%" class="table table-bordered table-responsive-lg">
    <tr>
        <th>Payment Method</th>
    </tr>
    <?php foreach($payment as $key=>$value): ?>
        <tr>
            <td>
                <input type="radio" name="payment[<?php echo $cart->id; ?>]" <?php if($value->id == $cart->paymentMethodId)echo "checked" ?> value="<?php echo $value->id; ?>">&nbsp;&nbsp;&nbsp;
                <?php echo $value->name ;?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td><input type="button" class="btn btn-success" value="Save" onclick="object.setForm('paymentMethod');"></td>
    </tr>
</table>
</form>
</div>
<div>
<form action="{{ url('cart/shipping') }}" method="post" id="shippingMethod">
@csrf
<table width="70%" height="70%" class="table table-bordered table-responsive-lg">
    <tr>
        <th>Shipping Charge</th>
    </tr>
    <?php foreach($shipping as $xyz): ?>
        <tr>
            <td><input type="radio" name="shipping" value="{{$xyz['id']}}" <?php if($xyz['id'] == $cart->shippingMethodId)echo "checked" ?>>&nbsp;{{ $xyz['name']}} => {{$xyz['description']}}</td>
            <td>Charge : <?php echo $xyz['amount']; ?>$</td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td><input type="button" class="btn btn-success" value="Save" onclick="object.setForm('shippingMethod');"></td>
    </tr>
</table>
</form>
</div>
<div class="col-lg-12 margin-tb">
<div class="pull-right">
<form>
@csrf
<table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Total Price</th>
            <td><?php echo $cart->getTotal($cartItem); ?></td>
        </tr>
        <tr>
            <th>Total Discount</th>
            <td><?php echo $cart->getTotalDiscount($cartItem); ?></td>
        </tr>
        <tr>
            <th>Shipping Charge</th>
            <td><?php echo $cart->shippingAmount; ?></td>
        </tr>
        <tr>
            <th>Final Price</th>
            <td><?php echo $cart->getFinalPrice($cartItem); ?></td>
        </tr>
    </table>
</form>
</div><br><br><br><br><br><br><br><br><br>
<div class="pull-right">
<form action="{{url('cart/placeOrder')}}" method="POST" id="order">
@csrf
<input type="button" class="btn btn-warning" Value="Place Order" onclick="object.setForm('order');">
</form>
</div></div>
<script>
    $('#add_product').click(function() {
        $('#product').removeClass('d-n');
    });
    $('#add_to_cart').click(function() {
        $('#product').addClass('d-n');
    });
</script>
@endsection