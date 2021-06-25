@extends('layouts.app')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<a class="btn btn-success" href="#">Add Root Category</a>
			<h3>ManageCategory</h3>
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
			<h3>Add Root Category</h3>
			<form action="{{ url('category/addCategory')}}" method="POST" id="form">
				@csrf
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Catgory Name:</strong>
							<input type="text" name="name" class="form-control" placeholder="Category Name">
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Category Description:</strong>
							<textarea name="description" style="width:438px; height:200px;" class="form-control" placeholder="Category Description" required></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="form-group">
							<strong>Status:</strong>
							<select name="status" class="form-control">
								<option>Enable</option>
								<option>Disable</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<input type="button" onclick="object.setUrl('categorys/addCategory').setForm('form')" class="btn btn-primary" value="Submit">
					</div>
			</form>
		</div>
	</div>
	@endsection