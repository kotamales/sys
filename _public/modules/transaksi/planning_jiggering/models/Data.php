<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	public function __construct()
    {
        parent::__construct();
	}
	
	function get_master_data(){
		$rows = $this->db->get(_TBL_HEAD)->result_array();
		
		$data=array();
		foreach($rows as $row){
			$data[] = $row['item_no'].$row['head'];
		}
		return $data;
	}
	
	function get_master_item(){
		$rows = $this->db->get(_TBL_KODE)->result_array();
		
		$data=array();
		foreach($rows as $row){
			$data[$row['keterangan']] = $row['id'];
		}
		return $data;
	}
	
	function get_data_jiggering($id=0, $pabrik=0){
		$rows = $this->db->where('planning_no', $id)->get(_TBL_VIEW_PLANNING_JIGGERING)->result_array();
		$arr=array();
		foreach($rows as $row){
			$arr[$row['mesin_no'].$row['head_no'].$row['item_no']]=$row;
		}
		$rows = $this->db->where('pabrik_no', $pabrik)->get(_TBL_VIEW_MATRIK)->result_array();
		
		foreach ($rows as &$row){
			$kode = $row['mesin_no'].$row['head_no'].$row['item_no'];
			$ada=false;
			if (array_key_exists($kode, $arr)){
				$ada=true;
			}
				
			$row['id_edit']=($ada)?$arr[$kode]['id']:'0';
			$row['jenis_no']=($ada)?$arr[$kode]['jenis_no']:'';
			$row['mould_std']=($ada)?$arr[$kode]['mould_std']:$row['mould_std'];
			$row['mould_akt']=($ada)?$arr[$kode]['mould_akt']:'';
			$row['jml_cycle']=($ada)?$arr[$kode]['jml_cycle']:'';
			$row['shift']=($ada)?$arr[$kode]['shift']:'';
			$row['plan_down']=($ada)?$arr[$kode]['plan_down']:'5';
			$row['total_target']=($ada)?$arr[$kode]['total_target']:'';
			$row['total_hasil']=($ada)?$arr[$kode]['total_hasil']:'';
			$row['yield']=($ada)?$arr[$kode]['yield']:'';
			$row['lulus_target']=($ada)?$arr[$kode]['lulus_target']:'';
			$row['lulus_hasil']=($ada)?$arr[$kode]['lulus_hasil']:'';
			$row['ganti_head']=($ada)?$arr[$kode]['ganti_head']:'';
			$row['shift1']=($ada)?$arr[$kode]['shift1']:'';
			$row['mesin_off']=($ada)?$arr[$kode]['mesin_off']:'';
			$row['shift2']=($ada)?$arr[$kode]['shift2']:'';
			$row['keterangan']=($ada)?$arr[$kode]['keterangan']:'';
			$row['cboItem'] = $this->get_combo_item($row['mesin_no'], $row['head_no']);
		}
		unset($row);
		return $rows;
	}
	
	function get_combo_item($mesin, $head){
		$kodes = $this->db->where('mesin_no', $mesin)->where('head_no', $head)->get(_TBL_VIEW_MATRIK)->result_array();
		$result = array();
		foreach($kodes as $kode){
			$result[$kode['item_no']] = $kode['item_ket'];
		}
		
		return $result;
	}
	
	function save_detail($id, $data){
		$result=true;
		// Doi::dump($data);
		foreach($data['id_edit'] as $key=>$row){
			$id_edit=$data['id_edit'][$key];
			$upd=array();
			$upd['planning_no'] = $id;
			$upd['mesin_no'] = $data['mesin_no'][$key];
			$upd['head_no'] = $data['head_no'][$key];
			$upd['item_no'] = $data['item_no'][$key];
			$upd['mould_std'] = $data['mould_std'][$key];
			$upd['mould_akt'] = $data['mould_akt'][$key];
			$upd['jml_cycle'] = $data['jml_cycle'][$key];
			$upd['shift'] = $data['shift'][$key];
			$upd['plan_down'] = $data['plan_down'][$key];
			$upd['total_target'] = $data['total_target'][$key];
			$upd['total_hasil'] = $data['total_hasil'][$key];
			$upd['yield'] = $data['yield'][$key];
			$upd['lulus_target'] = $data['lulus_target'][$key];
			$upd['lulus_hasil'] = $data['lulus_hasil'][$key];
			$upd['ganti_head'] = $data['ganti_head'][$key];
			// $upd['shift1'] = $data['shift1'][$key];
			$upd['mesin_off'] = $data['mesin_off'][$key];
			// $upd['shift2'] = $data['shift2'][$key];
			$upd['keterangan'] = $data['keterangan'][$key];
			// Doi::dump($upd);
			if ($id_edit>0){
				$result=$this->crud->crud_data(array('table'=>_TBL_PLANNING_JIGGERING_DETAIL, 'field'=>$upd,'where'=>array('id'=>$id_edit),'type'=>'update'));
			}else{
				$result=$this->crud->crud_data(array('table'=>_TBL_PLANNING_JIGGERING_DETAIL, 'field'=>$upd,'type'=>'add'));
			}
		}
		return $result;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */