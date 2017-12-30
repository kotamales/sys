<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Data_Kode extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		
		$this->set_Tbl_Master(_TBL_KODE);
		
		$this->set_Open_Tab('Data Code');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'kode', 'search'=>true, 'size'=>15));
			$this->addField(array('field'=>'keterangan', 'search'=>true, 'size'=>60));
			$this->addField(array('field'=>'aktif', 'type'=>'string', 'input'=>'boolean', 'search'=>false, 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'kode', 'align'=>'center'));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_master,'kode','',10, 'center');
		$this->set_Table_List($this->tbl_master,'keterangan');
		$this->set_Table_List($this->tbl_master,'aktif','',10, 'center');
		
		$this->set_Close_Setting();
	}
	
	function list_MANIPULATE_ACTION(){
		$tombol=array();
		$tombol['right'][]='<span class="btn btn-danger" data-url="'.base_url($this->modul_name.'/import-data').'" data-toggle="popover" data-content="Import Data" id="import_data"><i class="fa fa-list"></i> Import Data </span>';
		return $tombol;
	}
	
	function view_upload(){
		
		$result['combo'] = $this->load->view('upload', array(), true);
		$result['ket'] = 'Data Kode';
		echo json_encode($result);	
	}
	
	function proses_import(){
		$msg="";
		$id=$this->uri->segment(3);
		$this->load->library('PHPExcel');
		$inputFileName = $_FILES['file_import']['name'];
		
		$upload=upload_image_new(array('nm_random'=>false,'type'=>'xls|xlsx','nm_file'=>'file_import','path'=>'import','thumb'=>false));
		if($upload){
			$inputFileName = import_path_relative($upload['file_name']);
			$fileName = $upload['file_name'];
			
			if($upload['file_ext'] == '.xlsx' || $upload['file_ext'] == '.xls'){
				$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
				// $objReader= PHPExcel_IOFactory::createReader('Excel2007');	// For excel 2007 	  
				$objReader->setReadDataOnly(true); 		  
				$objPHPExcel=$objReader->load($inputFileName);		 
				$totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel      	 
				$totalcols=$objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();   //Count Numbe of rows avalable in excel      	 
				$objWorksheet=$objPHPExcel->setActiveSheetIndex(0);   //Count Numbe of rows avalable in excel      	 
				
				$sheet = $objPHPExcel->getSheet(0);
				$highestRow = $sheet->getHighestRow(); 
				$highestColumn = $sheet->getHighestColumn();
				
				$no=0;
				$start_row=6;
				$arr_upt=array();
				$data_master=$this->data->get_master_data();
				for ($row = $start_row; $row <= $highestRow; ++$row	){ 
					$col=0;
					$upt = array();
					$kode = $objWorksheet->getCellByColumnAndRow(0,$row)->getValue();
					$nama = $objWorksheet->getCellByColumnAndRow(1,$row)->getValue();
					$upt['kode'] = $kode;
					$upt['keterangan'] = $nama;
					if (!in_array($kode, $data_master))
						$arr_upt[]=$upt;
				}
				if (count($arr_upt)>0)
					$this->db->insert_batch(_TBL_KODE, $arr_upt);
			}
		}
		header('location:'.base_url($this->modul_name));
	}
	
	function POST_CHECK_BEFORE_INSERT($data){
		$rows = $this->db->where('kode', $data['l_kode'])->get(_TBL_KODE)->row();
		if ($rows){
			$this->_set_pesan('Data Kode sudah ada dalam database');
			return false;
		}else{
			return true;
		}
	}
}