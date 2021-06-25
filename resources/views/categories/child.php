<!DOCTYPE html>
<html>

<head>
    <title>Category</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="/css/treeview.css" rel="stylesheet">
    <link href="/css/compact.css" rel="stylesheet">
</head>

<body>
    <a href="/" class="btn btn-primary">Go Back</a>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Manage Category</h3>
                        <ul id="tree1">
                            @foreach($categories as $category)
                            <li>
                                <p onclick="myFunction()" id="{{ $category->id }}">{{ $category->name }}</p>
                                @if(count($category->childs))
                                @include('categories/manageChild',['childs' => $category->childs])
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <button id="form" class="btn btn-success">Add SubCategory</button>
                        <div id="form1" class="c1 col-md-6">
                            <h3>Update Category</h3>
                            <form action="{{url('category/update/'.$id)}}" method="POST">
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
                                        <div><button type="submit" class="btn btn-primary">Submit</button>
                                            <a class="btn btn-danger" href="{{ url('category/destroy/'.$id)}}">Delete</a>
                                        </div>
                                    </div>
                            </form>
                        </div>
                        <div id="form2" class="c2 d-n col-md-6">
                            <h3>Add Sub Category</h3>
                            <form action="{{ url('category/addSubCategory')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Catgory Name:</strong>
                                            <input type="text" name="name" class="form-control" placeholder="Address">
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
                                            <textarea name="description" style="width:238px; height:200px;" class="form-control" placeholder="Category Description"></textarea>
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
                                        <div><button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/treeview.js"></script>

    <script>
        function myFunction() {
            console.log(event, event.srcElement);
            window.location = "{{ url('category/edit/'.$category->id)}}";
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        $('#form').click(function() {
            $('#form1').addClass('d-n');
            $('#form2').removeClass('d-n');
        });
    </script>
</body>

</html>