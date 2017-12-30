<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Data_Head extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	var $output_parent=array();
	public function __construct()
	{
        parent::__construct();
		$this->combo_code=$this->get_combo('kode');
		$this->set_Tbl_Master(_TBL_HEAD);
		$this->set_Table(_TBL_KODE);
		
		$this->set_Open_Tab('Data Module');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'item_no', 'input'=>'combo:search', 'combo'=>$this->combo_code, 'search'=>true, 'size'=>100));
			$this->addField(array('field'=>'head', 'required'=>true, 'search'=>true, 'size'=>60));
			$this->addField(array('field'=>'aktif', 'input'=>'boolean', 'size'=>20));
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'item_no','sp'=>$this->tbl_kode,'id_sp'=>'id'));
		$this->addField(array('nmtbl'=>$this->tbl_kode, 'field'=>'kode', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_kode, 'field'=>'keterangan', 'size'=>20, 'show'=>false));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_kode,'keterangan');
		$this->set_Table_List($this->tbl_master,'head');
		$this->set_Table_List($this->tbl_master,'aktif','',7, 'center');
		
		$this->set_Close_Setting();
	}
	
	function list_MANIPULATE_ACTION(){
		$tombol=array();
		$tombol['right'][]='<span class="btn btn-danger" data-url="'.base_url($this->modul_name.'/import-data').'" data-toggle="popover" data-content="Import Data" id="import_data"><i class="fa fa-list"></i> Import Data </span>';
		return $tombol;
	}
	
	function view_upload(){
		
		$result['combo'] = $this->load->view('upload', array(), true);
		$result['ket'] = 'Upload Data Head';
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
				$data_master_item=$this->data->get_master_item();
				for ($row = $start_row; $row <= $highestRow; ++$row	){ 
					$col=0;
					$upt = array();
					$kode = $objWorksheet->getCellByColumnAndRow(0,$row)->getValue();
					$nama = $objWorksheet->getCellByColumnAndRow(1,$row)->getValue();
					$id='';
					if (!array_key_exists($kode, $data_master_item))
						$id=$data_master_item[$kode];
					
					if (!empty($id)){
						$upt['kode'] = $id;
						$upt['mesin'] = $nama;
						if (!in_array($id.$nama, $data_master))
							$arr_upt[]=$upt;
					}
				}
				if (count($arr_upt)>0)
					$this->db->insert_batch(_TBL_HEAD, $arr_upt);
			}
		}
		header('location:'.base_url($this->modul_name));
	}
	
	function POST_CHECK_BEFORE_INSERT($data){
		$rows = $this->db->where('item_no', $data['l_item_no'])->where('head', $data['l_head'])->get(_TBL_HEAD)->row();
		if ($rows){
			$this->_set_pesan('Data Head sudah ada dalam database');
			return false;
		}else{
			return true;
		}
	}
	
}