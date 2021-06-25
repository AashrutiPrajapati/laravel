@extends('layouts.app');
@section('content')
<br><br><h3>FileUpload Process</h3>
<form method="post" action="fileupload/import" enctype="multipart/form-data" id="form1">
    @csrf
    <input type="file" name="image" id="image"><br>
    <input type="button" name="image" class="btn btn-primary" onclick="object.setImage('form1');" Value="Upload">
</form>
<br><br>
<form method="post" action="fileupload/export" enctype="multipart/form-data" id="form1">
    @csrf
    <input type="button" name="Export" id="download" class="btn btn-success" Value="Export To Excel">
</form>
<script>
$(document).ready(function(){
    $('#download').click(function() {
        $.ajax({
            url:"fileupload/export",
            type:"post",
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                var file=new Blob(
                    [response],{type:'text/csv'
                });
                var a = document.createElement('a');
                a.style.display='none';
                a.href=URL.createObjectURL(file);
                a.download="data.csv";
                document.body.appendChild(a);
                a.click();
                alert("Your File Was Downloaded SuccesFully.");
            }
        })
    })
})

</script>
@endsection