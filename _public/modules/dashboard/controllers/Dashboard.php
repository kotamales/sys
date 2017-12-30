<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Dashboard extends BackendController {
	var $tmp_data=array();
	var $data_fields=array();
	
	public function __construct()
	{
        parent::__construct();
	}
	
	public function index(){
		$dashboard = 'dash_ADMIN';//$this->authentication->get_Info_User('group');
		$this->$dashboard();
	}
	
	public function dash_ADMIN()
	{	
		$data=array();
		$this->template->build('dashboard', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */