@extends('layouts.app')

@section('content')
<br><br>
<h2>Payment Module</h2>
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <a class="btn btn-success" onclick="object.setUrl('payment/create').setMethod('get').load()" href="javascript:void(0);" title="Create Payments">
                <h5>Create Payment</h5>
            </a>
        </div>
    </div>
</div>
<br>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<table class="table table-bordered table-responsive-lg">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Code</th>
        <th>Description</th>
        <th>Status</th>
        <th>Date Created</th>
        <th width="200px">Action</th>
    </tr>
    </thead>
    @if (count($payments) <= 0) <tr>
        <td colspan="9">No Data available.</td>
        </tr>
        @else
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <td>{{$payment->id}}</td>
                <td>{{$payment->name}}</td>
                <td>{{$payment->code}}</td>
                <td>{{$payment->description}}</td>
                <td>
                    @if($payment->status == 'Enable')
                    <a onclick="object.setUrl('payment/status/{{$payment->id}}').setMethod('get').load();" href="javascript:void(0);" class="btn btn-success">Enable</a>
                        @else
                        <a onclick="object.setUrl('payment/status/{{$payment->id}}').setMethod('get').load();" href="javascript:void(0);" class="btn btn-danger">Disable</a>
                    @endif
                </td>
                <td>{{$payment->created_at}}</td>
                <td>
                    <input type="button" class="btn btn-success" onclick="object.setUrl('payment/edit/{{$payment->id}}').setMethod('get').load();" value="Edit">
                </td>
                <td>
                    <input type="button" class="btn btn-danger" onclick="object.setUrl('payment/destroy/{{$payment->id}}').setMethod('get').load();" value="Delete">
                </td>
            </tr>
            @endforeach
        </tbody>
        @endif
</table>
</div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form id="paginate" action="{{ url('payment') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="records_per_page">Records Per Page</label>
                            <select name="records_per_page" id="records_per_page" onchange="object.setForm('paginate')">
                                <option value="Select" {{(session('paginate') < 3 ? 'selected' : '')}}>Select</option>
                                <option value="1" {{(session('paginate') == 1 ? 'selected' : '')}}>1</option>
                                <option value="2" {{(session('paginate') == 2 ? 'selected' : '')}}>2</option>
                                <option value="3" {{(session('paginate') == 3 ? 'selected' : '')}}>3</option>
                                <option value="5" {{(session('paginate') == 5 ? 'selected' : '')}}>5</option>
                                <option value="10" {{(session('paginate') == 10 ? 'selected' : '')}}>10</option>
                                <option value="25" {{(session('paginate') == 25 ? 'selected' : '')}}>25</option>
                                <option value="50" {{(session('paginate') == 50 ? 'selected' : '')}}>50</option>
                                <option value="100" {{(session('paginate') == 100 ? 'selected' : '')}}>100</option>
                            </select>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
    <div class="container">
        <div class="col-md-6">
            @for ($i = 1; $i <= $totalPage; $i++) <a href="javascript:void(0)" name="page" value="{{$i}}" onclick="object.setUrl('payments/page={{$i}}').setMethod('get').load();" id="{{$i}}" onclick="pagination()" class="btn btn-primary">{{$i}}</a>
                @endfor
        </div>
    </div>
    @endsection