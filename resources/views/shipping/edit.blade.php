@extends('layouts.app')

@section('content')
<br><br>
@if (isset($customer->id))
    <?php $id = $customer->id;?>
        @endif
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Shipping</h2>
            </div>
            <div class="pull-right">
            <a onclick="object.setUrl('shipping').setMethod('get').load();" href="javascript:void(0);" class="btn btn-primary">Back</a>
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
    <form action="{{ url('shipping/update/'.$shipping->id) }}" method="POST" id="form">
        @csrf
        @method('POST')

        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" value="{{ $shipping->name }}" placeholder=" Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Code:</strong>
                <input type="text" name="code" class="form-control" value="{{ $shipping->code }}" placeholder="Code">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Amount:</strong>
                <input type="number" name="amount" class="form-control" value="{{ $shipping->amount }}" placeholder="Amount">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <input type="text" name="description" class="form-control" value="{{ $shipping->description }}" placeholder="Description">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                <select name="status" class="form-control">
                <option value="Enable" <?php if($shipping->status == "Enable"){echo "selected";}?>>Enable</option>
                <option value="Disable" <?php if($shipping->status == "Disable"){echo "selected";}?>>Disable</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <input type="button" onclick="object.setUrl('shipping/update/{{ $shipping->id }}').setForm('form')"
                                              class="btn btn-primary" value="Submit">
        </div>
    </div>

    </form>
@endsection