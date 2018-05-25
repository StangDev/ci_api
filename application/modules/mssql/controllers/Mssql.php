<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mssql extends MX_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->model('Mssql_model');
    
  }

  function index()
  {
    $this->load->view('index_view');
  }
  public function getAPI()
  {
    if ($_POST) {
        $data =  $this->Mssql_model->getApiByName($_POST['nameapi']);
        $myJSONString = json_encode($data);
        echo $myJSONString;
    }else {
      exit();
    }
  }
  public function getTable()
  {
    if ($_POST) {
      $arr = array();
      $data = json_decode($_POST['myJsonString']);
      for ($i=0; $i < count($data) ; $i++) {
        // code...getApiByPara
        $rowdata = $this->Mssql_model->getApiByPara($data[$i]);
        foreach ($rowdata as $key => $value) {
          $arr[$i]['ColumnName'] = $value['PARAMETER_NAME'];
          $arr[$i]['DataType'] = $this->cal_type($value['DATA_TYPE']);
          $arr[$i]['Size'] = $value['CHARACTER_MAXIMUM_LENGTH'];
          $arr[$i]['UI'] = $this->cal_ui($value['DATA_TYPE']);
        }
      }
      $json_arr =  array('table' => '','datajson' => $arr, );
      $json_arr['table'].= '<table class="table table-hover " id="myTable">
              <thead>
                <tr>
                  <th scope="col">Column Name</th>
                  <th scope="col">Data Type</th>
                  <th scope="col">Size</th>
                  <th scope="col">UI</th>
                </tr>
            </thead>
            <tbody>';
      foreach ($arr as $key => $value) {
      $json_arr['table'].= "<tr>";
      $json_arr['table'].= "<td>".$value['ColumnName']."</td>";
      $json_arr['table'].= "<td>".$value['DataType']."</td>";
      $json_arr['table'].= "<td>".$value['Size']."</td>";
      $json_arr['table'].= "<td>".$value['UI']."</td>";
      $json_arr['table'].= "</tr>";

      }
      $json_arr['table'].= "    </tbody>
            </table>";

        echo json_encode($json_arr);
    }
  }
  public function getExcel()
  {
    if ($_POST) {

      		$data = json_decode($_POST['myJsonString'],true);
      		  $this->excel = $this->load->library('PHPExcel');
             $this->excel->setActiveSheetIndex(0);
             $this->excel->getActiveSheet()->setTitle('Generate');

             $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
             $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
             $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
             $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
             $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
             $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
             $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
             $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
             $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
             $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);


      			 $BStyle = array(
      			 'borders' => array(
      				 'allborders' => array(
      					 'style' => PHPExcel_Style_Border::BORDER_THIN
      				 )
      			 )
      			);

      			$bgcolor = array(
      				'fill' => array(
      						'type' => PHPExcel_Style_Fill::FILL_SOLID,
      						'color' => array('rgb' => 'fbb166')
      				)
      			);
      			$this->excel->getActiveSheet()->getStyle("A1:J1")->applyFromArray($bgcolor);


      			$this->excel->setActiveSheetIndex(0)->setCellValue('A1', 'Column Name');
            $this->excel->setActiveSheetIndex(0)->setCellValue('B1', 'Data Type');
            $this->excel->setActiveSheetIndex(0)->setCellValue('C1', 'Size');
            $this->excel->setActiveSheetIndex(0)->setCellValue('D1', 'Primary Key');
            $this->excel->setActiveSheetIndex(0)->setCellValue('E1', 'FK');
            $this->excel->setActiveSheetIndex(0)->setCellValue('F1', 'UI');
            $this->excel->setActiveSheetIndex(0)->setCellValue('G1', 'Desc_TH');
            $this->excel->setActiveSheetIndex(0)->setCellValue('H1', 'Desc_EN');
            $this->excel->setActiveSheetIndex(0)->setCellValue('I1', 'FK2');
            $this->excel->setActiveSheetIndex(0)->setCellValue('J1', 'FK2Co');




            $n = 3;
            if(!empty($data))
              {
                $this->excel->getActiveSheet()->setCellValue('A2', 'id');
                $this->excel->getActiveSheet()->setCellValue('B2', 'string');
                $this->excel->getActiveSheet()->setCellValue('C2', '');
                $this->excel->getActiveSheet()->setCellValue('D2', 'yes');
                $this->excel->getActiveSheet()->setCellValue('E2', '');
                $this->excel->getActiveSheet()->setCellValue('F2', 'HiddenField');
                $this->excel->getActiveSheet()->setCellValue('G2', 'รหัส');
                $this->excel->getActiveSheet()->setCellValue('H2', 'id');
                $this->excel->getActiveSheet()->setCellValue('I2', '');
                $this->excel->getActiveSheet()->setCellValue('J2', '');

                  foreach ($data as $row => $value)
                  {
                     // Pass name of your tables field name in following $row[''] variable

                    $this->excel->getActiveSheet()->setCellValue('A'.$n, $value['ColumnName']);
                    $this->excel->getActiveSheet()->setCellValue('B'.$n, $value['DataType']);
                    $this->excel->getActiveSheet()->setCellValue('C'.$n, $value['Size']);
                    $this->excel->getActiveSheet()->setCellValue('D'.$n, '');
                    $this->excel->getActiveSheet()->setCellValue('E'.$n, '');
                    $this->excel->getActiveSheet()->setCellValue('F'.$n, $value['UI']);
                    $this->excel->getActiveSheet()->setCellValue('G'.$n, '');
                    $this->excel->getActiveSheet()->setCellValue('H'.$n, '');
                    $this->excel->getActiveSheet()->setCellValue('I'.$n, '');
                    $this->excel->getActiveSheet()->setCellValue('J'.$n, '');

                    $n++;
                  }
                }
      				$this->excel->getActiveSheet()->getStyle("A1:A".$n)->applyFromArray($BStyle);
      				$this->excel->getActiveSheet()->getStyle("B1:B".$n)->applyFromArray($BStyle);
      				$this->excel->getActiveSheet()->getStyle("C1:C".$n)->applyFromArray($BStyle);
      				$this->excel->getActiveSheet()->getStyle("D1:D".$n)->applyFromArray($BStyle);
      				$this->excel->getActiveSheet()->getStyle("E1:E".$n)->applyFromArray($BStyle);
      				$this->excel->getActiveSheet()->getStyle("F1:F".$n)->applyFromArray($BStyle);
      				$this->excel->getActiveSheet()->getStyle("G1:G".$n)->applyFromArray($BStyle);
      				$this->excel->getActiveSheet()->getStyle("H1:H".$n)->applyFromArray($BStyle);
      				$this->excel->getActiveSheet()->getStyle("I1:I".$n)->applyFromArray($BStyle);
      				$this->excel->getActiveSheet()->getStyle("J1:J".$n)->applyFromArray($BStyle);

                $filename='Generate.xls'; //save our workbook as this file name

                header('Content-Type: application/vnd.ms-excel'); //mime type

                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name

                header('Cache-Control: max-age=0'); //no cache

                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format

                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                //force user to download the Excel file without writing it to server's HD
                $objWriter->save('php://output');
    }
  }
  public function cal_type($type)
  {
    switch ($type) {
      case 'nvarchar':
        return 'string';
        break;
      case 'varchar':
        return 'string';
        break;
      case 'date':
        return 'datetime';
        break;
      case 'uniqueidentifier':
        return 'string';
        break;

      default:
        return $type;
        break;
    }
  }
  public function cal_ui($type)
  {
    switch ($type) {
      case 'nvarchar':
        return 'TextBox';
        break;
      case 'varchar':
        return 'TextBox';
        break;
      case 'uniqueidentifier':
       return 'TextBox';
        break;
      case 'date':
        return 'TextBoxDate';
        break;
      case 'int':
        return 'TextBoxNumeric';
        break;

      default:
        return 'undefined';
        break;
    }
  }

}
