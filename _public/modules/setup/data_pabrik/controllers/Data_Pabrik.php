<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Data_Pabrik extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		
		$this->set_Tbl_Master(_TBL_PABRIK);
		
		$this->set_Open_Tab('Data Code');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>15));
			$this->addField(array('field'=>'pabrik', 'search'=>true, 'size'=>15));
			$this->addField(array('field'=>'keterangan', 'search'=>true, 'size'=>60));
			$this->addField(array('field'=>'aktif', 'type'=>'string', 'input'=>'boolean', 'search'=>false, 'size'=>20));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));		
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_master,'pabrik');
		$this->set_Table_List($this->tbl_master,'keterangan');
		$this->set_Table_List($this->tbl_master,'aktif','',10, 'center');
		
		$this->set_Close_Setting();
	}
}