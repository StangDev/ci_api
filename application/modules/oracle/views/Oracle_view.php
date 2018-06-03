<!DOCTYPE html>
<html lang="en">
<head>
<title><?=$title?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="<?=base_url()?>assets/lib/css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
</head>
<body>
<nav class="navbar navbar-light bg-light">
      <span class="navbar-brand mb-0 h1"><?=$title?> V0.1</span>
    </nav>

<div class="container">
    <div class="card mt-5">
        <div class="card-header">
        OBJECT_NAME
        </div>
        <div class="card-body d-flex flex-column">
          <div class="input-group">
            <select multiple="multiple" class="custom-select" id="inputSelectAPI"  name="my-select[]" style="width:500px; height:300px;">
              <?php foreach ($rowdata as $key => $value): ?>
                    <option><?=$value['OBJECT_NAME']?></option>
                <?php endforeach; ?>
            </select>
            <div class="input-group-append ">
              <button class="btn btn-outline-secondary ml-3" type="button" onclick="getAPI()">Get</button>
            </div>
          </div>
        </div>
    </div>
    <div class="card mt-5 mb-5">
        <div class="card-header">
        DATA_TYPE
        </div>
        <div class="card-body data-type">
        
        </div>
    </div>
    <button id="btnGen" type="button" class="btn btn-primary btn-lg float-right" onclick="gen()" >Generate</button>
</div>
<div class="modal fade" id="UrlModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">URL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>
</body>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="<?=base_url()?>/assets/lib/js/jquery.multi-select.js"></script>
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
     $( "#btnGen" ).hide();
    $( document ).ready(function() {
        $('#inputSelectAPI').multiSelect()
    });
    function getAPI() {
        var nameapi = $('#inputSelectAPI').val();
        var nav ='';
        var body ='';
        var full ='';
        $.post( "<?=base_url()?>/oracle/getAPI",{nameapi:nameapi}, function( data ) {
            data = $.parseJSON(data);
            nav += '<nav><div class="nav nav-tabs" id="nav-tab" role="tablist"> ';
            body += '<div class="tab-content" id="nav-tabContent">';
           $.each(data, function(i,key) {
            nav += ' <a class="nav-item nav-link" id="'+i+'-tab" data-toggle="tab" href="#'+i+'" role="tab" aria-controls="'+i+'" aria-selected="true">'+i+'</a>';
                body += '<div class="tab-pane fade" id="'+i+'" role="tabpanel" aria-labelledby="nav-profile-tab"><table class="table table-hover"><thead><tr><th scope="col">ARGUMENT_NAME</th><th scope="col">DATA_LENGTH</th><th scope="col">DATA_TYPE</th></tr></thead><tbody>';
                $.each(key, function(index,item) {
                    body += '<tr>';
                    body += '<td>'+item.ARGUMENT_NAME+'</td>';
                    body += '<td>'+item.DATA_LENGTH+'</td>';
                    body += '<td>'+item.DATA_TYPE+'</td>';
                    body += '</tr>';
                });
                body += '</tbody></table></div>';
            });
            nav += '</div></nav>';  
            body += '</div>';    
            full += nav;
            full += body;
            $( "div.data-type").html(full);
            $( "#btnGen" ).show();
            
        });
      }
      function gen() {
        var nameapi = $('#inputSelectAPI').val();
        $.post( "<?=base_url()?>/oracle/generate",{nameapi:nameapi}, function( data ) {
            console.log(data);
             $( "div.modal-body").html('<a href="<?= base_url() ?>oracle_g/" ><?= base_url() ?>oracle_g/</a>');
            $('#UrlModel').modal('show')
        });
      }
    </script>
</html>