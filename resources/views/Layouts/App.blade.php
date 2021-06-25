<html>

<head>
    <title>Laravel Modules @yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="/css/compact.css" rel="stylesheet">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>
    <script src="{{asset('js/mage.js')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/jquery-3.6.0.js')}}"></script>
    <script src="{{asset('js/treeview.js')}}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="/css/treeview.css" rel="stylesheet">

    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #9C27B0;
            color: white;
            text-align: center;
        }
    </style>

</head>

<body>
    <div id="content">
    <nav class="navbar navbar-expand-sm bg-dark navbar-light">
            <a class="navbar-brand mb-0 h1" style="width: 10rem;" onclick="object.setUrl('customer').setMethod('get').load();" href="javascript:void(0);">Customer</a>
            <a class="navbar-brand mb-0 h1" style="width: 10rem;" onclick="object.setUrl('product').setMethod('get').load();" href="javascript:void(0);">Product</a>
            <a class="navbar-brand mb-0 h1" style="width: 10rem;" onclick="object.setUrl('category').setMethod('get').load();" href="javascript:void(0);">Category</a>
            <a class="navbar-brand mb-0 h1" style="width: 10rem;" onclick="object.setUrl('payment').setMethod('get').load();" href="javascript:void(0);">Payment</a>
            <a class="navbar-brand mb-0 h1" style="width: 10rem;" onclick="object.setUrl('shipping').setMethod('get').load();" href="javascript:void(0);">Shipping</a>
            <a class="navbar-brand mb-0 h1" style="width: 10rem;" onclick="object.setUrl('cart').setMethod('get').load();" href="javascript:void(0);">Cart</a>
            <a class="navbar-brand mb-0 h1" style="width: 10rem;" onclick="object.setUrl('order').setMethod('get').load();" href="javascript:void(0);">Order</a>
            <a class="navbar-brand mb-0 h1" style="width: 10rem;" onclick="object.setUrl('salesman').setMethod('get').load();" href="javascript:void(0);">Salesman</a>
            <a class="navbar-brand mb-0 h1" style="width: 10rem;" onclick="object.setUrl('fileupload').setMethod('get').load();" href="javascript:void(0);">FileUpload</a>
        </nav>
        @show

        <div class="container">
            @yield('content')
        </div>
    </div>
</body>

</html>