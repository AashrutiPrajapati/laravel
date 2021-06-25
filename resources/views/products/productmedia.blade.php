@extends('layouts.app')
@section('content')
<div class="row">
<div class="col-10">
    <h1>
        <center>Product Media</center>
    </h1>
</div></div>
<form action="{{ url('products/mediaUpdate/'.$id) }}" enctype="multipart/form-data" method="POST" id="form2">
@csrf
    <table class="grid">
        <input type="button" class="btn btn-success" name="update" onclick="object.setForm('form2');" value="Update">&nbsp&nbsp
        <tr class="gridtr">
            <th style="text-align:center" class="gridth">Image</th>
            <th style="text-align:center" class="gridth">Label</th>
            <th style="text-align:center" class="gridth">Small</th>
            <th style="text-align:center" class="gridth">Thumb</th>
            <th style="text-align:center" class="gridth">Base</th>
            <th style="text-align:center" class="gridth">Gallery</th>
            <th style="text-align:center" class="gridth">Remove</th>
        </tr>
        <?php foreach($productMedia as $key=>$value):?>
            <tr class="gridtr">
                <td style="text-align:center" class="gridtd"><img src="{{ asset('image\product\\').$value->image }}" alt="{{ $value->image }}" height="100" , width="100"></td>
                <td style="text-align:center" class="gridtd"><input type="text" name="label[<?php echo $value->id ?>]" value="<?php echo $value->label;?>" required></td>
                <td style="text-align:center" class="gridtd"><input type="radio" name="small" value="<?php echo $value->id; ?>" <?php if($value->small){echo "checked";}?>></td>
                <td style="text-align:center" class="gridtd"><input type="radio" name="thumb" value="<?php echo $value->id; ?>" <?php if($value->thumb){echo "checked";}?>></td>
                <td style="text-align:center" class="gridtd"><input type="radio" name="base" value="<?php echo $value->id; ?>" <?php if($value->base){echo "checked";}?>></td>
                <td style="text-align:center" class="gridtd"><input type="checkbox" name="gallery[<?php echo $value->id; ?>]" <?php if($value->gallery){echo "checked";}?>></td>
                <td style="text-align:center" class="gridtd"><input type="checkbox" name="delete[<?php echo $value->id; ?>]"></td>
            </tr>
        <?php endforeach; ?>
    </table>
</form>
<form method="POST" action="{{ url('products/mediaSave/'.$id) }}" id="form1">
@csrf    
    <input type="file" name="image" id="image">
    <input type="button" name="image" class="btn btn-success" onclick="object.setImage('form1');" value="Upload">
</form>
@endsection