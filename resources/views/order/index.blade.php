@extends('layouts.app')
@section('content')
<h1><strong>Order Page</strong></h1><br>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<div class="row">
    <div class="pull-left">
    <form id="select_customer" action="{{ url('order') }}" method="get">
            @csrf
        <select name="customerId" class="form-control"
        onchange="object.setForm('select_customer')">
            <option value="0" selected disabled>Select Customer</option>
            @foreach ($customers as $value)
            <option value="{{ $value->id }}" <?php if ($value->id == session('customerId'))echo 'selected';?>>{{ $value->firstName }}</option>
            @endforeach
       </select>
    </form>
    </div>
</div>
<br>
<div>
<table class="table table-bordered table-responsive-lg">
    <thead>
        <tr>
            <th scope="col">OrderId</th>
            <th scope="col">CustomerId</th>
            <th scope="col">Total</th>
            <th scope="col">Discount</th>
            <th scope="col">Shipping Amount</th>
            <th scope="col">CreatedAt</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($orders !=NULL)
        @foreach ($orders as $order)
        <tr>
            <td><?= $order->id ?></td>
            <td><?= $order->customerId ?></td>
            <td><?= $order->total?></td>
            <td><?= $order->discount ?></td>
            <td><?= $order->shippingAmount ?></td>
            <td><?= $order->created_at ?></td>
            <td><input type="button" class="btn btn-success" value="Order Details" onclick="object.setUrl('order/show/{{$order->id}}').setMethod('get').load();"></td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table><br><br>
</div>
<div class="row">
        <div class="col-md-6">
            <form id="paginate" action="{{ url('order') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="records_per_page">Records Per Page</label>
                            <select name="records_per_page" id="records_per_page" onchange="object.setForm('paginate')">
                                <option value="Select" {{ session('paginate') < 3 ? 'selected' : '' }}>Select</option>
                                <option value="1" {{ session('paginate') == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ session('paginate') == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ session('paginate') == 3 ? 'selected' : '' }}>3</option>
                                <option value="5" {{ session('paginate') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ session('paginate') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ session('paginate') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ session('paginate') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ session('paginate') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            @for ($i = 1; $i <= $totalPage; $i++)
                <a href="javascript:void(0)" name="page" value="{{ $i }}"
                    onclick="object.setUrl('order/page={{ $i }}').setMethod('get').load();"
                    id="{{ $i }}" onclick="pagination()" class="btn btn-primary">{{ $i }}</a>
            @endfor
        </div>
    </div>
@endsection