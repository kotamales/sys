<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Change_password extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		$this->tbl_master=$this->db->dbprefix('users');
		$this->addField(array('field'=>'id', 'show'=>false));
		$this->addField(array('field'=>'username', 'required'=>true, 'size'=>40));
		$this->addField(array('field'=>'password', 'input'=>'pass', 'size'=>20));
		$this->addField(array('field'=>'passwordc', 'type'=>'free', 'input'=>'pass', 'label'=>'l_passwordc'));
	
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		$this->set_Sort_Table($this->tbl_master,'nama_lengkap');
		
		$this->set_Table_List($this->tbl_master,'username');
		$this->set_Table_List($this->tbl_master,'password');
		
		$this->set_Close_Setting();	
		
		$this->_set_ACTION('edit');
		$this->_SET_PRIVILEGE('tombol_quit', false);
		$this->_SET_PRIVILEGE('tombol_save_quit', false);
		
		$js= script_tag(plugin_url("strongpass/strongpass.js"));
		$this->template->append_metadata($js);
	}
	
	public function index()
	{	
		$this->__edit($this->authentication->get_Info_User('identifier'));
	}
	
	function postData_SOURCE_UPDATE(){
		$result=$this->data->get_data($this->authentication->get_Info_User('identifier'),$this->tmp_data);
		return $result;
	}
	
	function POST_UPDATE_HANDLEx($data, $old_data){
		$result=true;
		if (!empty($new_data['l_password']))
			$result = $this->authentication->change_password($new_data['l_password'],$id);
		die("berhasil");
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$result=true;
		if (!empty($new_data['l_password']))
			$result = $this->authentication->change_password($new_data['l_password'],$id);
		return $result;
	}
	
	function POST_UPDATE_REDIRECT_URL($url){
		$url = base_url($this->_Snippets_['modul']);
		return $url;
	}
}