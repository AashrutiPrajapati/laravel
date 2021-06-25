@extends('layouts.app')

@section('content')
<br><br>
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Product</h2>
        </div><br>
        <div class="pull-right">
            <a onclick="object.setUrl('product').setMethod('get').load();" href="javascript:void(0);" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger">
    <p>{{ $message }}</p>
</div>
@endif
<form action="products/store" id="form" method="POST">
    @csrf

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Sku:</strong>
                <input type="text" name="product[sku]" class="form-control" placeholder="SKU" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Category Name:</strong>
                <select name="product[category]" class="form-control" required>
                    <option disabled>Select Category</option>
                    @foreach($category as $item)
                    <option value="{{$item->name}}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="product[name]" class="form-control" placeholder="Name" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Price:</strong>
                <input type="number" min="1" name="product[price]" class="form-control" placeholder="Price" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Discount:</strong>
                <input type="number" name="product[discount]" class="form-control" placeholder="Discount" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Quantity:</strong>
                <input type="number" min="1" name="product[quantity]" class="form-control" placeholder="Quantity" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <input type="text" name="product[description]" class="form-control" placeholder="Description" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                <select name="product[status]" class="form-control" required>
                    <option>Enable</option>
                    <option>Disable</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <input type="button" onclick="object.setUrl('products/store').setForm('form')"
                                              class="btn btn-primary" value="Submit">
        </div>
    </div>

</form>
@endsection