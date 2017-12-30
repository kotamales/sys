<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function get_master_data(){
		$rows = $this->db->get(_TBL_MESIN)->result_array();
		
		$data=array();
		foreach($rows as $row){
			$data[] = $row['kode'].$row['mesin'];
		}
		return $data;
	}
	
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */