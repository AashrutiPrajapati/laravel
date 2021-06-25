@extends('layouts.app')
@section('content')
<h2>Category Tree</h2>
<?php //echo "123";die;?>
<div class="row">
    <button id="show" class="btn btn-success">Add SubCategory</button>
    <div class="col-md-6">
        <h3>Manage Category</h3>
        <ul id="tree1">
            @foreach($categories as $category)
            <li>
                <a onclick="object.setUrl('category/edit/{{$category->id}}').setMethod('get').load();" href="javascript:void(0)">{{ $category->name }}</a>
                @if(count($category->childs))
                @include('categories/manageChild',['childs' => $category->childs])
                @endif
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-md-6">
        <div class="center hideform">
            <h3>Add Sub Category</h3>
            <form action="{{ url('category/addSubCategory')}}" method="POST" id="form1" style="width:400px;">
                @csrf<br>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Catgory Name:</strong>
                            <input type="text" name="name" class="form-control" placeholder="SubCategory Name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12" style="display:none">
                        <div class="form-group">
                            <strong>Parent Category:</strong>
                            <select name="parent_id" class="form-control">
                                <option value="{{$currentCategory->id}}" <?php if ($currentCategory->parent_id) {
                                                                                echo "selected";
                                                                            } ?>>{{$currentCategory->name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Category Description:</strong>
                            <textarea name="description" style="width:238px; height:200px;" class="form-control" placeholder="Category Description" required></textarea>
                        </div>
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
                        <div><input type="button" onclick="object.setUrl('categorys/addSubCategory').setForm('form1')" class="btn btn-primary" value="Submit"></div>
                    </div>
            </form>
        </div>
    </div>
    <div id="update" class="col-md-6">
        <h3>Update Category</h3>
        <form action="{{url('category/update/'.$id)}}" method="POST" id="categoryUpdate">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Catgory Name:</strong>
                        <input type="text" name="name" class="form-control" value="{{$currentCategory->name }}" placeholder="Address">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12" style="display:none">
                    <div class="form-group">
                        <strong>Parent Category:</strong>
                        <select name="parent_id" class="form-control" >
                        <option value="0" <?php if ($currentCategory->parent_id == 0) {
                                                                            echo "selected";
                                                                        } ?>>Root Category</option>
                        @foreach($allCategories as  $value)
                            <option value="{{$value->id}}" <?php if ($currentCategory->parent_id == $value->id) {
                                                                            echo "selected";
                                                                        } ?>>{{$value->name}}</option>
                                                                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Category Description:</strong>
                        <textarea name="description" style="width:538px; height:200px;" class="form-control" placeholder="Category Description">{{ $currentCategory->description }}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Status:</strong>
                        <select name="status" class="form-control">
                            <option value="Enable" <?php if ($currentCategory->status == "Enable") {
                                                        echo "selected";
                                                    } ?>>Enable</option>
                            <option value="Disable" <?php if ($currentCategory->status == "Disable") {
                                                        echo "selected";
                                                    } ?>>Disable</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <div> <input type="button" onclick="object.setUrl('category/update/{{$id}}').setForm('categoryUpdate')" class="btn btn-primary" value="Submit">
                        <input type="button" onclick="object.changeAction('categoryUpdate','category/destroy/{{$id}}')" value="Delete" class="btn btn-danger">
                    </div>
                </div>
        </form>
    </div>
</div>
</div>
@endsection
<script>
    $('#show').on('click', function() {
        $('.center').show();
        $(this).hide();
    })

    $('#close').on('click', function() {
        $('.center').hide();
        $('#show').show();
    });
    $('#show').on('click', (function() {
        $('#update').addClass('hideform');
    }));
</script>