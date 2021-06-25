@extends('layouts.app')

@section('content')
<br><br>
@if (isset($customer->id))
    <?php $id = $customer->id;?>
        @endif
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Customer</h2>
            </div>
            <div>
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
            Customer Information
             </a>
             <a onclick="object.setUrl('customers/address/{{$id}}').setMethod('Get').load()"
                                                href="javascript:void(0)" class="list-group-item list-group-item-action">Customer Address</a>
            </div>
            <div class="pull-right">
            <a onclick="object.setUrl('customer').setMethod('get').load();" href="javascript:void(0);" class="btn btn-primary">Back</a>
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
    <form action="{{ url('customers/update/'.$customer->id) }}" method="POST" id="form">
        @csrf
        @method('POST')

        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>First Name:</strong>
                <input type="text" name="firstName" class="form-control" value="{{ $customer->firstName }}" placeholder="First Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Last Name:</strong>
                <input type="text" name="lastName" class="form-control" value="{{ $customer->lastName }}" placeholder="Last Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                <input type="email" name="email" class="form-control" value="{{ $customer->email }}" placeholder="Email">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Password:</strong>
                <input type="password" name="password" class="form-control" value="{{ $customer->password }}" placeholder="Password">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                <select name="status" class="form-control">
                <option value="Enable" <?php if($customer->status == "Enable"){echo "selected";}?>>Enable</option>
                <option value="Disable" <?php if($customer->status == "Disable"){echo "selected";}?>>Disable</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <input type="button" onclick="object.setUrl('customers/update/{{ $customer->id }}').setForm('form')"
                                              class="btn btn-primary" value="Submit">
        </div>
    </div>

    </form>
@endsection