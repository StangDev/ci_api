<!doctype html>
<html lang="en">
  <head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="<?=base_url()?>assets/lib/css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
      <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  </head>
  <body>
    <nav class="navbar navbar-light bg-light">
      <span class="navbar-brand mb-0 h1">API MSSQL V0.1</span>
    </nav>

    <div class="container">
      <div class="card mt-5">
        <div class="card-header">
          SPECIFIC_NAME
        </div>
        <div class="card-body">
          <div class="input-group">
            <select class="custom-select" id="inputSelectAPI">
              <option selected>Choose...</option>
              <?php $rowdata =  $this->Mssql_model->getListApi(); ?>
              <?php foreach ($rowdata as $key => $value):?>
                <option value="<?=$value['SPECIFIC_NAME']?>"><?=$value['SPECIFIC_NAME']?></option>
              <?php endforeach; ?>
            </select>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary ml-3" type="button" onclick="getAPI()">Get</button>
            </div>
          </div>
        </div>
      </div>
      <div class="card mt-5">
        <div class="card-header header-custom">
          Parameter
        </div>
        <div class="card-body row">
          <div class="col-md select-custom">

          </div>
          <div class="col-md select-custom-input">

          </div>
      </div>

      <div class="select-custom-button">

      </div>
    </div>
    <div class="card mt-5" style="margin-bottom:10em;">
      <div class="card-header">
        Table View
      </div>
      <div class="card-body table-custom">

      </div>
  </div>
  <form id="formpost" class="" action="<?=base_url()?>api/excel" method="post">
    <input type="text" name="myJsonString" value="" id="myJsonString" hidden>
  </form>
</div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="<?=base_url()?>/assets/lib/js/jquery.multi-select.js"></script>
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">

      function getAPI() {
        var nameapi = $('#inputSelectAPI').val();
        var option ='';
        $.post( "<?=base_url()?>/mssql/getAPI",{nameapi:nameapi}, function( data ) {
          data = $.parseJSON(data);

           $.each(data, function(i, item) {
                option += "<option value='"+item.PARAMETER_NAME+"'>"+item.PARAMETER_NAME+"</option>";
            });
          $( "div.header-custom" ).html('Parameter of '+nameapi);
          $( "div.select-custom" ).html( '<select multiple="multiple" onchange="getval();" id="my-select" name="my-select[]">'+ option+'</select>');
          $( "div.select-custom-button" ).html('<button type="button" onclick="exel_export()" class="btn btn-success btn-lg btn-block fixed-bottom" ><i class="far fa-file-excel"></i> Export</button>');
          $('#my-select').multiSelect()
        });
      }
      function getval()
      {
        var data =  $('select#my-select').val()
        var myJsonString = JSON.stringify(data);
        $.post( "<?=base_url()?>/mssql/getTable",{myJsonString}, function( data ) {
          data = $.parseJSON(data);
          $( "div.table-custom" ).html(data.table);
          var myJsonString = JSON.stringify(data.datajson);
          $("#myJsonString").val(myJsonString);
          $('#myTable').DataTable();
        });
      }
      function exel_export() {
          $("#formpost").submit();
      }
    </script>
  </body>
</html>
