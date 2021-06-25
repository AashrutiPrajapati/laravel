@extends('layouts.app')

@section('content')
<br><br>
@if (isset($product->id))
        <?php $id = $product->id;?>
        @endif
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Customer</h2>
            </div><br><br><br><br> 
            <div class="pull-left"> 
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
            Product
             </a>
             <input type="button" value="Product Media"
                      onclick="object.setUrl('products/media/{{ $id }}').setMethod('get').load();" class="list-group-item list-group-item-action">
            </div>
            <div class="pull-right">
              <a onclick="object.setUrl('product').setMethod('get').load();" href="javascript:void(0);" class="btn btn-primary">Back</a>
        </div>
        </div>
    </div>
    <br><br>
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

    <form action="{{ url('products/update/'.$product->id) }}" id="form" method="POST">
        @csrf
        @method('POST')

        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Sku:</strong>
                <input type="text" name="sku" class="form-control" value="{{ $product->sku }}" placeholder="SKU" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Category Name:</strong>
                <select name="category" class="form-control" required>
                    <option disabled>Select Category</option>
                    @foreach($category as $item)
                    <option value="{{$item->name}}" <?php if($item->name==$product->category){echo 'selected';}?>>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" placeholder="Name" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Price:</strong>
                <input type="number" name="price" class="form-control" value="{{ $product->price }}" placeholder="Price" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Discount:</strong>
                <input type="number" name="discount" class="form-control" value="{{ $product->discount }}" placeholder="Discount" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Quantity:</strong>
                <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}" placeholder="Quantity" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <input type="text" name="description" class="form-control" value="{{ $product->description }}" placeholder="Description" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                <select name="status" class="form-control" required>
                <option value="Enable" <?php if($product->status == "Enable"){echo "selected";}?>>Enable</option>
                <option value="Disable" <?php if($product->status == "Disable"){echo "selected";}?>>Disable</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <input type="button" onclick="object.setUrl('products/update/{{ $product->id }}').setForm('form')"
                                              class="btn btn-primary" value="Submit">
        </div>
    </div>

    </form>
@endsection