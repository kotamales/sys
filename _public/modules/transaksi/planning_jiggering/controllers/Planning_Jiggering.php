<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Planning_Jiggering extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	var $output_parent=array();
	public function __construct()
	{
        parent::__construct();
		$this->combo_pabrik=$this->get_combo('pabrik');
		$this->set_Tbl_Master(_TBL_PLANNING_JIGGERING);
		$this->set_Table(_TBL_PABRIK);
		
		$this->set_Open_Tab('Data '.lang('msg_title'));
			$this->set_Open_Coloums('');
				$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
				$this->addField(array('field'=>'pabrik_no', 'input'=>'combo', 'combo'=>$this->combo_pabrik, 'required'=>true, 'search'=>true, 'size'=>100));
				$this->addField(array('field'=>'tgl_buat', 'input'=>'date', 'type'=>'date', 'required'=>true, 'search'=>true, 'size'=>10));
				$this->addField(array('field'=>'jam', 'search'=>true, 'size'=>10));
				$this->addField(array('field'=>'cycle', 'input'=>'float', 'type'=>'float', 'size'=>5));
				// $this->addField(array('field'=>'tgl_shift2', 'input'=>'date', 'type'=>'date', 'search'=>true, 'size'=>10));
			$this->set_Close_Coloums();
			
			$this->set_Open_Coloums('');
				$this->addField(array('field'=>'tgl_produksi', 'input'=>'date', 'type'=>'date', 'search'=>true, 'size'=>10));
				$this->addField(array('field'=>'revisi', 'size'=>10));
				$this->addField(array('field'=>'tgl_revisi', 'input'=>'date', 'type'=>'date', 'size'=>10));
				$this->addField(array('field'=>'jam_revisi', 'size'=>10));
				$this->addField(array('field'=>'note', 'input'=>'multitext', 'size'=>500));
			$this->set_Close_Coloums();
			
			$this->set_Open_Coloums_All('');
				$this->addField(array('field'=>'detail', 'type'=>'free', 'mode'=>'o'));
				$this->addField(array('field'=>'dibuat', 'size'=>20));
				$this->addField(array('field'=>'disetujui', 'default'=>$this->_Preference_['disetujui'], 'size'=>20));
				$this->addField(array('field'=>'diketahui', 'default'=>$this->_Preference_['diketahui'], 'size'=>20));
				$this->addField(array('field'=>'diterima', 'default'=>$this->_Preference_['diterima'], 'size'=>20));
			$this->set_Close_Coloums_All();
			
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master,'id_pk'=>'pabrik_no','sp'=>$this->tbl_pabrik,'id_sp'=>'id'));
		$this->addField(array('nmtbl'=>$this->tbl_pabrik, 'field'=>'pabrik', 'size'=>20, 'show'=>false));
		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'disetujui', 'readonly'=>true));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'diketahui', 'readonly'=>true));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'diterima', 'readonly'=>true));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_pabrik,'pabrik');
		$this->set_Table_List($this->tbl_master,'tgl_buat');
		$this->set_Table_List($this->tbl_master,'tgl_produksi');
		$this->set_Table_List($this->tbl_master,'jam');
		$this->set_Table_List($this->tbl_master,'cycle', '', 10, 'center');
		$this->set_Table_List($this->tbl_master,'dibuat');
		
		$this->set_Close_Setting();
	}
	
	function insertBox_DETAIL($field){
		$data['fields']=$this->data->get_data_jiggering();
		$result = $this->load->view('upload', $data,true);
		return $result;
	}
	
	function updateBox_DETAIL($field, $rows, $value){
		$data['fields']=$this->data->get_data_jiggering($rows['l_id'],$rows['l_pabrik_no']);
		$result = $this->load->view('upload', $data,true);
		return $result;
	}
	
	function detail_plan(){
		$id = $this->input->post('id');
		$data['fields']=$this->data->get_data_jiggering(0,$id);
		$result['combo'] = $this->load->view('upload', $data, true);
		$result['ket'] = 'Data Kode';
		echo json_encode($result);	
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$result = $this->data->save_detail($id , $new_data);
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$result = $this->data->save_detail($id , $new_data);
		return $result;
	}
	
	function PRINT_CUSTOM($rows){
		// $data['fields']=$this->data->get_data_jiggering($rows['l_id']);
		$data['fields'] = $this->db->where('planning_no', $rows['l_id'])->where('mesin_off','')->get(_TBL_VIEW_PLANNING_JIGGERING)->result_array();
		
		// Doi::dump($data['fields'][0]);die();
		$tgl_buat = $data['fields'][0]['tgl_buat'];
		$tgl_produksi = $data['fields'][0]['tgl_produksi'];
		$jam = $data['fields'][0]['jam'];
		$cycle = $data['fields'][0]['cycle'];
		$revisi = $data['fields'][0]['revisi'];
		$tgl_revisi = $data['fields'][0]['tgl_revisi'];
		$jam_revisi = $data['fields'][0]['jam_revisi'];
		$dibuat = $data['fields'][0]['dibuat'];
		$disetujui = $data['fields'][0]['disetujui'];
		$diketahui = $data['fields'][0]['diketahui'];
		$diterima = $data['fields'][0]['diterima'];
		$pabrik = $data['fields'][0]['pabrik'];
		$data['note'] = $data['fields'][0]['note'];
		$data['note1'] = $this->_Preference_['note1'];
		$data['note2'] = $this->_Preference_['note2'];
		
		header("Content-type:application/vnd.ms-excel");
		header("Cache-Control: max-age=0");
        header("content-disposition:attachment;filename=Planning-Jigging.xls");
		
		$html ="<table width='100%' border='0'>";
		$html .='<tr><td rowspan="6" width="15%"><img src="'.img_url('logo-lap.png').'"></td>';
		$html .="<td colspan='3'>".$this->_Preference_['nama_kantor']."</td></tr>";
		$html .="<tr><td colspan='3'>".$this->_Preference_['alamat_kantor']."</td></tr>";
		$html .="<tr><td colspan='3'>Telp : ".$this->_Preference_['telp_kantor']." Email : ".$this->_Preference_['email_kantor']."</td></tr>";
		$html .="<tr><td colspan='3'></td></tr>";
		$html .="<tr><td></td><td></td><td></td></tr></table>";
		$html .="<table><tr><td>Tanggal Buat</td><td>".$tgl_buat."</td><td></td><td></td><td>Jam Kerja</td><td>Cycle</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>Revisi</td><td>".$revisi."</td></tr>";
		$html .="<tr><td>Tanggal Produksi</td><td>".$tgl_produksi."</td><td></td><td></td><td>".$jam."</td><td>".$cycle."</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>Tanggal Revisi</td><td>".$tgl_revisi."</td></tr>";
		$html .="<tr><td>".$pabrik."</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>Jam Revisi</td><td>".$jam_revisi."</td></tr>";
		$html .="<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>Jam Revisi</td><td>".$jam_revisi."</td></tr>";
		
		$html .=$this->load->view("cjiggring", $data, true);
		$html .="<table><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>";
		$html .="<table><tr><td>Dibuat oleh:</td><td></td><td></td><td>Disetujui oleh:</td><td></td><td></td><td>Diketahui oleh:</td><td></td><td></td><td>Diterima oleh:</td></tr>";
		$html .="<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
		$html .="<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
		$html .="<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
		$html .="<tr><td>".$dibuat."</td><td></td><td></td><td>".$disetujui."</td><td></td><td></td><td>".$diketahui."</td><td></td><td></td><td>".$diterima."</td></tr>";
		
		echo $html;
		exit;
	}
	
	function list_MANIPULATE_PERSONAL_ACTIONX($tombol, $rows){
		$tgl=$rows['l_tgl_buat'];
		$now=date('Y-m-d');
		if ($tgl<$now){
			$tombol['edit']=array();
			$tombol['print']['default']=true;
		}
		
		return $tombol;
	}
}