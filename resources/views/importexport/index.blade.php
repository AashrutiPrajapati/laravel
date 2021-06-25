@extends('layouts.app')
@section('content')
<center>
    <h3><strong>Import-Export</strong></h3>
</center>
<div id="wrap">
    <div class="container">
        <div class="row">
            <form class="form-horizontal" action="importexport/import" method="post" name="upload_excel" enctype="multipart/form-data" id="form1">
                @csrf
                <input type="file" name="image" id="image"><br>
                <input type="button" name="image" class="btn btn-primary" onclick="object.setImage('form1');" value="Upload"><br><br><br>
                
            </form>
        </div>
        <div>
            <form class="form-horizontal" action="importexport/exportIntoCSV" method="post" name="upload_excel" enctype="multipart/form-data" id="form2">
             @csrf
                <input type="button" name="Export" class="btn btn-success"  id="download" value="export to excel" />
            </form>
        </div>
    </div>
</div>
<script>
  $(document).ready(function(){
      $('#download').click(function() {
          $.ajax({
              url: "importexport/exportIntoCSV",
              type: "post",
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
              success:function(response) {
                  var file=new Blob([response],{
                      type:'text/csv'
                  });
                  var a = document.createElement('a');
                  a.style.display = 'none';
                  a.href = URL.createObjectURL(file);
                  a.download = 'data.csv';
                  document.body.appendChild(a);
                  a.click();
                  alert('your file has downloaded!');
                }
        });
    });
});
</script>
@endsection