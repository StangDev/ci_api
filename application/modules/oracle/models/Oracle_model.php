<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Oracle_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->oci = $this->load->database ( 'oracle', TRUE );
    }
    public function getProcedure()
    {
        //$data = $this->oci->query("SELECT owner, object_name FROM dba_objects WHERE object_type = 'GET_STUDENT'and owner='ZT_SCHEMA'");
   
        $data = $this->oci->query("SELECT owner, object_name FROM dba_objects WHERE object_type = 'PROCEDURE'and owner='ZT_SCHEMA'");
        return $data->result_array();
    }
    public function getArgument($val)
    {
        $data = $this->oci->query("SELECT ARGUMENT_NAME,DATA_TYPE,PLS_TYPE,A1.* FROM all_arguments A1 where OBJECT_NAME='$val'");
        return $data->result_array();
    }
 
}

/* End of file Oracle_model.php */
