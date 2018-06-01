<?php
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
      