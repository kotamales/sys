<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MX_Model extends CI_Model {
	
	protected $cbo_kategori;
	protected $module_name;
	protected $no_select=true;
	
	public function __construct()
    {
        parent::__construct();
		$this->cbo_kategori=array();
		
		$this->module_name = $this->router->fetch_module();
		$this->auth_config = $this->config->item('authentication');
		
		$this->cbo_kategori=array(0=>' - Parent - ');
		
	}
	
	function get_combo_model($kel, $param=''){
		$query="";
		$result=array();
		switch($kel){
			case "bahasa":
				$query="SELECT  `key` as id, title as name FROM "._TBL_BAHASA." where status=1 order by title";
				break;
			case "groups":
				$query="SELECT  id, group_name as name FROM "._TBL_GROUPS." where aktif=1 order by group_name";
				break;
			case "bahasa_harian":
				$query="SELECT  id, bahasa_harian as name FROM "._TBL_BAHASA_HARIAN." where aktif=1 order by urut";
				break;
			case "icon":
				$query="SELECT  font as id, title as name FROM "._TBL_FONT_ICON." where status=1 order by title";
				break;
			case "posisi-menu":
				$query=$this->auth_config['menu'];
				return $query;
				break;
			case "kode":
				$query="SELECT  id, concat(kode,' - ',keterangan) as name FROM "._TBL_KODE." where aktif=1 order by kode";
				break;
			case "mesin":
				$query="SELECT  id, concat(kode,' - ',mesin) as name FROM "._TBL_MESIN." order by kode, mesin";
				break;
			case "pabrik":
				$query="SELECT  id, pabrik as name FROM "._TBL_PABRIK." order by pabrik";
				break;
			case 'parent':
				$kategori=$this->get_combo_kategori();
				return $kategori;
				break;
			case 'parent-input':
				$kategori=$this->get_combo_kategori(1);
				return $kategori;
				break;
			case 'parent-input-all':
				$kategori=$this->get_combo_kategori(1, true);
				return $kategori;
				break;
		}
		if (!empty($query))
			$result = $this->get_cbo($query);
		
		return $result;
	}
	
	function get_cbo($select) {
		$query=$select;
		
		$data = $this->db->query($query);
		
		$d=$data->result();
		$combo[0]=" - select - ";
		foreach($d as $key=>$dt)
		{
			$combo[$dt->id]=$dt->name;
		}
		return $combo;
	}
	
	function get_combo_kategori($tipe=0, $sts_all=false){
		if ($tipe>0){ $this->cbo_kategori=array();}
		
		if (is_array($this->id_param_owner)){
			if ($this->id_param_owner['privilege_owner']['id']>1 && !$sts_all){
				$this->level=array();
				$this->get_parent($this->id_param_owner['owner']['parent_no']);
				$space=str_repeat('&nbsp;',count($this->level)*4);
				$this->cbo_kategori[$this->id_param_owner['owner']['owner_no']]= $space . $this->id_param_owner['owner']['name'];
				$this->get_combo_parent($this->id_param_owner['owner']['owner_no'],$sts_all);
			}else{
				$this->cbo_kategori=array(0=>' - Parent - ');
				$this->get_combo_parent(0,$sts_all);
			}
		}else{
			$this->cbo_kategori=array(0=>' - Parent - ');
			$this->get_combo_parent(0,$sts_all);
		}
		
		// Doi::dump($this->cbo_kategori);
		// die();
		return $this->cbo_kategori;
	}
	
	function get_combo_parent($parent=0, $sts_all=false){
		$this->level=array();
		$this->db->select('*');
		$this->db->from(_TBL_OWNER);
		$this->db->where('status',1);
		$this->db->where('parent_no',$parent);
		if (is_array($this->id_param_owner)){
			if ($this->id_param_owner['privilege_owner']['id'] > 1 && !$sts_all){
				$this->db->where_in('id',$this->id_param_owner['owner_child_array']);
			}
		}
		$this->db->order_by('name');
		$query=$this->db->get();
		$rows=$query->result();
		// Doi::dump($this->db->last_query());
		foreach($rows as $row){
			$this->level=array();
			$this->get_parent($row->parent_no);
			$space=str_repeat('&nbsp;',count($this->level)*4);
			$this->cbo_kategori[$row->id]=$space . $row->name;
			$this->get_combo_parent($row->id, $sts_all);
		}
	}
	
	function get_parent($parent=0){
		$this->db->select('*');
		$this->db->from(_TBL_OWNER);
		$this->db->where('id',$parent);
		$this->db->where('status',1);
		$this->db->order_by('name');
		$query=$this->db->get();
		$rows=$query->result();
		foreach($rows as $row){
			$this->level[]=$row->name;
			if ($row->parent_no>0)
				$this->get_parent($row->parent_no);
		}
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */