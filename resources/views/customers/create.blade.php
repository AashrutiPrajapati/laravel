@extends('layouts.app')
@section('content')
<br><br>
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Customer</h2>
        </div>
        <div class="pull-right">
            <a onclick="object.setUrl('customer').setMethod('get').load();" href="javascript:void(0);" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input<br><br>
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

<form action="customers/store" id="form" method="POST">
    @csrf

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>First Name:</strong>
                <input type="text" name="firstName" class="form-control" placeholder="First Name">
            </div>
        @if ($errors->has('firstName'))
                    <span class="text-danger">{{ $errors->first('firstName') }}</span>
                @endif
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Last Name:</strong>
                <input type="text" name="lastName" class="form-control" placeholder="Last Name">
            </div>
                @if ($errors->has('lastName'))
                    <span class="text-danger">{{ $errors->first('lastName') }}</span>
                @endif
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
            @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Password:</strong>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                <select name="status" class="form-control">
                    <option>Enable</option>
                    <option>Disable</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <input type="button" onclick="object.setForm('form')" class="btn btn-primary" value="Submit" id="customerAdd">
        </div>
    </div>

</form>
@endsection
