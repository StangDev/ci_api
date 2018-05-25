<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mssql_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->mssql = $this->load->database ( 'mssql', TRUE );
  }

  public function getListApi()
  {

    $this->mssql->select('SPECIFIC_NAME');
      $query   = $this->mssql->get('CRR03.information_schema.routines');
      $rowdata = $query->result_array();
      return $rowdata;
  }
  public function getApiByName($nameAPI)
  {
    $this->mssql->select('PARAMETER_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH')
              ->where('SPECIFIC_NAME',$nameAPI);
      $query   = $this->mssql->get('INFORMATION_SCHEMA.PARAMETERS');
      $rowdata = $query->result_array();
      return $rowdata;
  }
  public function getApiByPara($parameter)
  {
    $this->mssql->select('PARAMETER_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH')
              ->where('PARAMETER_NAME',$parameter);
      $query   = $this->mssql->get('INFORMATION_SCHEMA.PARAMETERS');
      $rowdata = $query->result_array();
      return $rowdata;
  }
}
