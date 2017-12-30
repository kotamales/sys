<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Credit extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	var $output_parent=array();
	public function __construct()
	{
        parent::__construct();
		$this->set_Tbl_Master(_TBL_CREDIT);

		$this->set_Open_Tab('Data Module');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'vendor', 'size'=>100));
			$this->addField(array('field'=>'url', 'size'=>20));
			$this->addField(array('field'=>'keterangan', 'input'=>'multitext', 'size'=>250));
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_master,'vendor','',15);
		$this->set_Table_List($this->tbl_master,'url','',10,'center');
		$this->set_Table_List($this->tbl_master,'keterangan');
		
		$this->_SET_PRIVILEGE('add', false);
		$this->_SET_PRIVILEGE('delete', false);
		$this->_SET_PRIVILEGE('cetak', false);
		
		$this->_setActionprivilege(false);
		$this->set_Close_Setting();
	}
	
	function listBox_URL($rows, $value){
		$url = '<a href="'.$value.'" target="_blank"> Link </a>';
		return $url;
	}
	
}