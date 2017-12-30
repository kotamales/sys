<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	
	public function __construct()
    {
        parent::__construct();
		
	}
	
	function get_data(){
		$this->db->select('*');
		$this->db->from(_TBL_PREFERENCE);
		$query=$this->db->get();
		$result=array();
		if($query){
			$rows=$query->result();
			$data=array('l_id'=>0);
			foreach($rows as $key=>$row){
				$data['l_'.$row->uri_title]=$row->value;
			}
			$result['fields']=$data;
		}
		return $result;
	}
	
	function save_data($data, $old_data){
		// Doi::dump($old_data);
		foreach($data['fields'] as $key=>$row)
		{
			if ($row['show']){
				// echo $data['data']['l_'.$row['field']] . '!==' . $old_data['l_'.$row['field']] . "<br/>";
				if ($data['data']['l_'.$row['field']] !== $old_data['l_'.$row['field']]){
					$old_upd['value'] = $old_data['l_'.$row['field']];
					$upd['value'] = $data['data']['l_'.$row['field']];
					$where['uri_title'] = $row['field'];
					$this->crud->crud_data(array('table'=>_TBL_PREFERENCE, 'field'=>$upd, 'old_field'=>$old_upd, 'where'=>$where,'type'=>'update'));
					$upd=array();
				}
			}
		}
		// die();
		$this->session->set_userdata(array('result_proses'=>lang('msg_success_save_edit')));
		$this->authentication->set_Preference();
		return true;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */