@extends('layouts.app')
@section('content')
<br><br>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Customer Address</h2>
            </div>
        </div>
    </div>
    <form action="{{ url('customers/saveAddress/'.$customer->id) }}" method="POST" id="form3">
        @csrf
        <h2>Billing Address</h2>
        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Address:</strong>
                <input type="text" name="billing[address]" class="form-control" value="{{((isset($BillingAddress->address) && $BillingAddress['address'] != '') ? $BillingAddress['address'] : '' )}}" placeholder="Address">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>City:</strong>
                <input type="text" name="billing[city]" class="form-control" value="{{((isset($BillingAddress->city) && $BillingAddress['city'] != '') ? $BillingAddress['city'] : '' )}}" placeholder="City">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>State:</strong>
                <input type="text" name="billing[state]" class="form-control" value="{{((isset($BillingAddress->state) && $BillingAddress['state'] != '') ? $BillingAddress['state'] : '' )}}" placeholder="State">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Country:</strong>
                <input type="text" name="billing[country]" class="form-control" value="{{((isset($BillingAddress->country) && $BillingAddress['country'] != '') ? $BillingAddress['country'] : '' )}}" placeholder="Country">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Zip Code:</strong>
                <input type="text" name="billing[zipcode]" class="form-control" value="{{((isset($BillingAddress->zipcode) && $BillingAddress['zipcode'] != '') ? $BillingAddress['zipcode'] : '' )}}" placeholder="ZipCode">
            </div>
        </div>
        <h2>Shipping Address</h2>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Address:</strong>
                <input type="text" name="shipping[address]" class="form-control" value="{{((isset($ShippingAddress->address) && $ShippingAddress['address'] != '') ? $ShippingAddress['address'] : '' )}}" placeholder="Address">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>City:</strong>
                <input type="text" name="shipping[city]" class="form-control" value="{{((isset($ShippingAddress->city) && $ShippingAddress['city'] != '') ? $ShippingAddress['city'] : '' )}}" placeholder="City">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>State:</strong>
                <input type="text" name="shipping[state]" class="form-control" value="{{((isset($ShippingAddress->state) && $ShippingAddress['state'] != '') ? $ShippingAddress['state'] : '' )}}" placeholder="State">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Country:</strong>
                <input type="text" name="shipping[country]" class="form-control" value="{{((isset($ShippingAddress->country) && $ShippingAddress['country'] != '') ? $ShippingAddress['country'] : '' )}}" placeholder="Country">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Zip Code:</strong>
                <input type="text" name="shipping[zipcode]" class="form-control" value="{{((isset($ShippingAddress->zipcode) && $ShippingAddress['zipcode'] != '') ? $ShippingAddress['zipcode'] : '' )}}" placeholder="ZipCode">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <input type="button" onclick="object.setUrl('customers/saveAddress/{{ $customer->id }}').setForm('form3')"
                                              class="btn btn-primary" value="Submit">
        </div>
    </div>

    </form>
@endsection