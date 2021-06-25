@extends('layouts.app')

@section('content')

<body>

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
    <?php $v = session('search'); ?>
    <div class="row">
        <div class="col-md-6">
            <h3>Manage Salesman</h3>
            <form action="salesman/search" method="post" id="form1">
                @csrf
                <table>
                    <input type="search" name="search" style="width:130px;" value="<?php echo $v; ?>">
                    <input type="button" class="btn btn-primary" onclick="object.setForm('form1')" value="Search">&nbsp;
                    <input type="button" class="btn btn-success" id="add" value="Add">&nbsp;
                    <input type="button" class="btn btn-info" id="clear" value="Clear">
                </table>
            </form>
            @if($salesman)
            <table class="table table-bordered table-responsive-lg">
                <tbody>
                    @foreach($salesman as $key =>$value)
                    <tr>
                        <td>{{ $value->name }}</td>
                        <td><button class="btn btn-danger" onclick="object.setUrl('salesman/destroy/{{ $value->id }}').setMethod('get').load()">Delete</button></td>
                        <td class="{{($id==$value->id)?'selected':''}}"><button id="button" class="price btn btn-success" onclick="object.setUrl('salesman/saleid/{{ $value->id }}').setMethod('get').load(); document.getElementById('button').style.color = 'black';" id="{{$value->id}}">Pricing</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <tr>
                <center>
                    <strong>
                        No Data Avaliable.
                    </strong>
                </center>
            </tr>
            @endif
        </div>
        <div class="col-md-6" id="product">
            @if (!$sales)
            <center>
                <strong>
                    No SalesMan Selected.
                </strong>
            </center>
            @else
            <h3>Manage Product</h3>
            <form action="salesman/product" method="POST" id="form2" style="width:40px; height:10px">
                @csrf
                <input type="button" class="btn btn-success" id="update" value="Update">
                <br><br>
                <table class="table table-bordered table-responsive-lg" style="width:50px;">
                    <tr style="width:50px;">
                        <td>Id</td>
                        <td>SKU</td>
                        <td>Price</td>
                        <td>S.Price</td>
                        <td>S.Discount</td>
                    </tr>
                    <tr style="width:50px;">
                        <td></td>
                        <td><input type="textbox" name="sku" style="width:60px;"></td>
                        <td><input type="textbox" name="price" style="width:60px;"></td>
                        <td colspan="2"><input type="button" class="btn btn-primary" onclick="object.setForm('form2')" height="100" value="Add"></td>
                    </tr>
                    @if($products)
                    @foreach($products as $key => $value)
                    <tr id="{{ $value->price }}" style="width:50px;">
                        <td>{{$value->id}}</td>
                        <td>{{$value->sku}}</td>
                        <td class="prices" id="{{$value->price}}">{{$value->price}}</td>
                        <td><input type="number" class="sprice" style="width:60px;" id="{{ $value->salesmanId == $id ? $value->spp : '' }}" name="sprice[{{ $value->id }}]" value="{{ $value->salesmanId == $id ? $value->spp : '' }}">
                        </td>
                        <td><input type="number" style="width:60px;" name="sdiscount[{{$value->id}}]" value="{{ $value->salesmanId == $id ? $value->discount : 0 }}"></td>
                    </tr>
                    @endforeach
                    @endif
                </table>
            </form>
            @endif
        </div>
    </div>
    <?php if (!$show = session('show')) {
        $show = 0;
    }
    ?>
</body>
<script>
    $('#add').click(function() {
        $('#form1').attr('action', 'salesman/create');
        $('#form1').attr('onclick', object.setForm('form1'));
    })
    if (<?php echo $show; ?>) {
        $('#product').show();
    } else {
        $('#product').hide();
    }
    $('#update').click(function(e) {
        var sprice = [];
        var price = [];
        $(".sprice").each(function(i) {
            sprice.push($($(".sprice")[i]).val());
        });
        $(".prices").each(function(i) {
            price.push($($(".prices")[i]).text());
        });
        var i=0; 
        var a="success";
        while (i < price.length) {
            if (parseInt(price[i]) > parseInt(sprice[i])) {
                $($('.sprice')[i]).css("background-color", "#c2d4dd");
                alert("Salesman Price Must Be Grater Then Price..");
                a="error";
            } else {
                $($('.sprice')[i]).css("background-color", "");
                if(a=="success"){
                    a="success";
                }
            }
            i++;
        }
        if(a=="success"){
            $('#form2').attr('action', 'salesman/update/<?= $id ?>');
            $('#form2').attr('onclick', object.setForm('form2'));
        }
    })
    $('#clear').click(function(e) {
        $('#form1').attr('action', 'salesman/clear');
        $('#form1').attr('onclick', object.setForm('form1'));
    })
</script>
@endsection
