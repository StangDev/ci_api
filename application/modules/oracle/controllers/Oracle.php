<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class oracle extends CI_Controller {

    public function __construct()
    {
      parent::__construct();
      $this->load->helper('url');
      $this->load->model('Oracle_model');
      $this->load->helper('file');
    }
    public function index()
    {
     $rowdata = $this->Oracle_model->getProcedure();
     //$this->generate();
     //$rowdataw2 = $this->Oracle_model->test01();
       $data['rowdata'] = $rowdata;
       $data['title'] = "Oracle API";
       $this->load->view('Oracle_view',$data);
    }
    public function getApi()
    {
      if($_POST){
        foreach ($_POST['nameapi'] as $key => $value) {
          $rowdata[$value] = $this->Oracle_model->getArgument($value);
        }
        echo json_encode($rowdata);
      }
    }
    
    public function generate()
    {
      $dataCon = '<?php
      class oracle_g extends MX_Controller {
        public function __construct()
    {
      parent::__construct();
      $this->load->helper("url");
    }
        public function index()
        {
          $this->load->view("oracle_g_view");
        }
      }
      ';
      $dataView = $this->indexOracle($_POST['nameapi']);
      $this->mkFolder();
      $this->mkController($dataCon);
      $this->mkView('oracle_g_view',$dataView);
      
      
    }
    public function mkFolder()
    {
      if (!file_exists('../application/modules/oracle_g')) {
        mkdir('../application/modules/oracle_g', 0777, true);
      }
      if (!file_exists('../application/modules/oracle_g/controllers')) {
        mkdir('../application/modules/oracle_g/controllers', 0777, true);
      }
      if (!file_exists('../application/modules/oracle_g/models')) {
        mkdir('../application/modules/oracle_g/models', 0777, true);
      }
      if (!file_exists('../application/modules/oracle_g/views')) {
        mkdir('../application/modules/oracle_g/views', 0777, true);
      }
    }
    public function mkController( $data)
    {
      if ( ! write_file('../application/modules/oracle_g/controllers/Oracle_g.php', $data))
      {
              echo 'Unable to write the file';
      }
      else
      {
              echo 'File written!';
      }
    }
    public function mkModel( $data)
    {
      if ( ! write_file('../application/modules/oracle_g/models/Oracle_g_model.php', $data))
      {
              echo 'Unable to write the file';
      }
      else
      {
              echo 'File written!';
      }
    }
    public function mkView($view,$data)
    {
      if ( ! write_file('../application/modules/oracle_g/views/'.$view.'.php', $data))
      {
              echo 'Unable to write the file';
      }
      else
      {
              echo 'File written!';
      }
    }
    public function indexOracle($arr=array())
    {
      $body = '
              <!DOCTYPE html>
        <html lang="th">
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
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <a class="navbar-brand" href="#">Oracle-g</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
      ';
      foreach ($arr as $key => $value) {
            $body .= '<li class="nav-item">
            <a class="nav-link" href="#">'.$value.'</a>
          </li>';
      }
       $body .= '
            </body>
            <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
            <script src="<?=base_url()?>/assets/lib/js/jquery.multi-select.js"></script>
            <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

        </html>
      ';
      
      return $body;
    }

}

/* End of file oracle.php */
