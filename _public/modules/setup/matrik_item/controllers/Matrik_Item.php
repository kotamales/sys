<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Matrik_Item extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	var $output_parent=array();
	public function __construct()
	{
        parent::__construct();
		$this->combo_code=$this->get_combo('kode');
		$this->combo_mesin=$this->get_combo('mesin');
		$this->combo_pabrik=$this->get_combo('pabrik');
		$this->combo_head=array(1=>1, 2=>2);
		$this->set_Tbl_Master(_TBL_MATRIK_MESIN);
		$this->set_Table(_TBL_KODE);
		$this->set_Table(_TBL_PABRIK);
		
		$this->set_Open_Tab('Data Module');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'pabrik_no', 'input'=>'combo:search', 'combo'=>$this->combo_pabrik, 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'mesin_no', 'input'=>'combo:search', 'combo'=>$this->combo_mesin, 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'head_no', 'input'=>'combo', 'combo'=>$this->combo_head, 'search'=>true, 'size'=>30));
			$this->addField(array('field'=>'item_no', 'input'=>'combo:search', 'combo'=>$this->combo_code, 'search'=>true, 'size'=>100));
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'item_no','sp'=>$this->tbl_kode,'id_sp'=>'id'));
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'pabrik_no','sp'=>$this->tbl_pabrik,'id_sp'=>'id'));
		$this->addField(array('nmtbl'=>$this->tbl_pabrik, 'field'=>'pabrik', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_kode, 'field'=>'kode', 'size'=>20, 'show'=>false));
		$this->addField(array('nmtbl'=>$this->tbl_kode, 'field'=>'keterangan', 'size'=>20, 'show'=>false));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_pabrik,'pabrik');
		$this->set_Table_List($this->tbl_master,'mesin_no','',15, 'center');
		$this->set_Table_List($this->tbl_master,'head_no','',15, 'center');
		$this->set_Table_List($this->tbl_kode,'keterangan');
		
		$this->set_Close_Setting();
	}
	
	function listBox_MESIN_NO($rows, $value){
		if (array_key_exists($value, $this->combo_mesin))
			$value = $this->combo_mesin[$value];
		return $value;
	}
}