<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	var $arr_statistik_wilayah=array();
	public function __construct()
    {
        parent::__construct();
		ini_set('max_execution_time', 0); 
	}
	
	function get_statistik(){
		$rows = $this->db->get(_TBL_VIEW_STATISTIK)->row();
		$this->get_statistik_wilayah();
		return (array) $rows;
	}
	
	function get_statistik_wilayah(){
		$rows = $this->db->select('kd_propinsi as nama, count(puskesmas) as jml')->where('aktif','Y')->group_by('kd_propinsi')->order_by('kd_propinsi')->get(_TBL_VIEW_PUSKESMAS)->result_array();
		
		$arr_propinsi=array();
		foreach($rows as $row){
			$arr_propinsi[$row['nama']]=$row['jml'];
		}
		$this->arr_statistik_wilayah=$arr_propinsi;
	}
	
	function get_data_lengkap($param=array()){
		$arr_labels=array();
		
		$stored_pocedure = "CALL ewarn_pro_statistik_datareport(?,?,?,?,?,?,?,?,?) ";
		if (!$param){
			$rows = $this->db->query($stored_pocedure,array(_TAHUN_, _MINGGU_,_MINGGU_,1,0,0,0,0,0))->result_array();
			mysqli_next_result( $this->db->conn_id );
			$hasil['title'] = "Kelengkapan Puskesmas Menurut Provinsi Minggu "._MINGGU_;
		}else{
			if (intval($param['cboPuskesmas'])>0){
				$rows = $this->db->select('puskesmas as nama, count(puskesmas) as jml')->where('id_distrik',$param['cboDistrik'])->where('aktif','Y')->group_by('puskesmas')->order_by('puskesmas')->get(_TBL_VIEW_PUSKESMAS)->result_array();
		
				$arr_propinsi=array();
				foreach($rows as $row){
					$arr_propinsi[$row['nama']]=$row['jml'];
				}
				$this->arr_statistik_wilayah=$arr_propinsi;
				
				$kel=2;
				$hasil['title'] = "Kelengkapan Laporan Puskesmas  Menurut Kecamatan Minggu "._MINGGU_;
			}elseif (intval($param['cboDistrik'])>0){
				$rows = $this->db->select('puskesmas as nama, count(puskesmas) as jml')->where('id_distrik',$param['cboDistrik'])->where('aktif','Y')->group_by('puskesmas')->order_by('puskesmas')->get(_TBL_VIEW_PUSKESMAS)->result_array();
		
				$arr_propinsi=array();
				foreach($rows as $row){
					$arr_propinsi[$row['nama']]=$row['jml'];
				}
				$this->arr_statistik_wilayah=$arr_propinsi;
				
				$kel=2;
				$hasil['title'] = "Kelengkapan Laporan Puskesmas  Menurut Kecamatan Minggu "._MINGGU_;
			}elseif (intval($param['cboKota'])>0){
				$rows = $this->db->select('distrik as nama, count(puskesmas) as jml')->where('id_kota',$param['cboKota'])->where('aktif','Y')->group_by('distrik')->order_by('distrik')->get(_TBL_VIEW_PUSKESMAS)->result_array();
		
				$arr_propinsi=array();
				foreach($rows as $row){
					$arr_propinsi[$row['nama']]=$row['jml'];
				}
				$this->arr_statistik_wilayah=$arr_propinsi;
				
				$kel=3;
				$hasil['title'] = "Kelengkapan Laporan Puskesmas  Menurut Kota Minggu "._MINGGU_;
			}elseif (intval($param['cboPropinsi'])>0){
				$rows = $this->db->select('kota as nama, count(puskesmas) as jml')->where('id_prop',$param['cboPropinsi'])->where('aktif','Y')->group_by('kota')->order_by('kota')->get(_TBL_VIEW_PUSKESMAS)->result_array();
		
				$arr_propinsi=array();
				foreach($rows as $row){
					$arr_propinsi[$row['nama']]=$row['jml'];
				}
				$this->arr_statistik_wilayah=$arr_propinsi;
				
				$kel=4;
				$hasil['title'] = "Kelengkapan Laporan Puskesmas  Menurut Provinsi Minggu "._MINGGU_;
			}else{
				$kel=1;
				$hasil['title'] = "Kelengkapan Laporan Puskesmas  Menurut Provinsi Minggu Minggu "._MINGGU_;
			}
			if (intval($param['cboMinggu2'])==0)
				$param['cboMinggu2']=$param['cboMinggu'];
			$rows = $this->db->query($stored_pocedure,array($param['cboTahun'], $param['cboMinggu'], $param['cboMinggu2'],$kel,$param['cboPropinsi'],$param['cboKota'],$param['cboDistrik'],$param['cboPuskesmas'],$param['cboPenyakit']))->result_array();
			mysqli_next_result( $this->db->conn_id );
		}
		
		$data_sudah=array();
		$arr_perSudah=array();
		$arr_warna=array();
		$data_belum=array();
		$arr_propinsi=array();
		$rekap=array();
		foreach($this->arr_statistik_wilayah as $key=>$wil){
			$sudah=0;
			$belum=0;
			foreach($rows as $row){
				if ($key==$row['nama']){
					$sudah=intval($row['jml']);
					$belum=intval($wil) - intval($row['jml']);
					break;
				}
			}
			$perSudah=0;
			$perBelum=0;
			if ($sudah>0)
				$perSudah=number_format(($sudah/$wil)*100);
			
			if ($belum>0)
				$perBelum=number_format(($belum/$wil)*100);
			$rekap[]=array('data'=>$key, 'total'=>$wil, 'sudah'=>$sudah, 'belum'=>$belum, 'perSudah'=>$perSudah, 'perBelum'=>$perBelum);
			$arr_propinsi[$key]=$sudah;
			
			// if ($sudah>0){
				$data_sudah[] =$sudah; 
				$arr_perSudah[] =$perSudah; 
				if ($perSudah>=85)
					$arr_warna[] ='#3C8DBC'; 
				else
					$arr_warna[] ='#DD4B39'; 
				$data_belum[] =$belum; 
				$arr_labels[]=$key;
			// }
		}
		$this->arr_statistik_wilayah=$arr_propinsi;
		
		$chartData = array(
					'labels'=>$arr_labels,
					'datasets'=>array(array('label'=>'Kelengkapan','backgroundColor'=>$arr_warna,'data'=>$arr_perSudah)));
					
		$hasil['data'] = $chartData;
		$hasil['info-table'] = $rekap;
		$hasil['nil-mak'] = 120;
		return $hasil;
	}
	
	function get_data_tepat($param=array()){
		$arr_labels=array();
		
		$stored_pocedure = "CALL ewarn_pro_statistik_datareport_tepat(?,?,?,?,?,?,?,?,?) ";
		// $rows = $this->db->query($stored_pocedure,array(_TAHUN_, _MINGGU_,1,0,0,0,0,0))->result_array();
		// mysqli_next_result( $this->db->conn_id );
			
		$hasil['title'] = "Ketepatan Laporan Puskesmas Menurut Provinsi Minggu "._MINGGU_;
		
		if (!$param){
			$rows = $this->db->query($stored_pocedure,array(_TAHUN_, _MINGGU_,_MINGGU_,1,0,0,0,0,0))->result_array();
			mysqli_next_result( $this->db->conn_id );
			$hasil['title'] = "Ketepatan Puskesmas Menurut Provinsi Minggu "._MINGGU_;
		}else{
			if (intval($param['cboPuskesmas'])>0){
				$rows = $this->db->select('puskesmas as nama, count(puskesmas) as jml')->where('id_distrik',$param['cboDistrik'])->where('aktif','Y')->group_by('puskesmas')->order_by('puskesmas')->get(_TBL_VIEW_PUSKESMAS)->result_array();
		
				$arr_propinsi=array();
				foreach($rows as $row){
					$arr_propinsi[$row['nama']]=$row['jml'];
				}
				$this->arr_statistik_wilayah=$arr_propinsi;
				
				$kel=2;
				$hasil['title'] = "Ketepatan Laporan Puskesmas  Menurut Kecamatan Minggu "._MINGGU_;
			}elseif (intval($param['cboDistrik'])>0){
				$rows = $this->db->select('puskesmas as nama, count(puskesmas) as jml')->where('id_distrik',$param['cboDistrik'])->where('aktif','Y')->group_by('puskesmas')->order_by('puskesmas')->get(_TBL_VIEW_PUSKESMAS)->result_array();
		
				$arr_propinsi=array();
				foreach($rows as $row){
					$arr_propinsi[$row['nama']]=$row['jml'];
				}
				$this->arr_statistik_wilayah=$arr_propinsi;
				
				$kel=2;
				$hasil['title'] = "Ketepatan Laporan Puskesmas  Menurut Kecamatan Minggu "._MINGGU_;
			}elseif (intval($param['cboKota'])>0){
				$rows = $this->db->select('distrik as nama, count(puskesmas) as jml')->where('id_kota',$param['cboKota'])->where('aktif','Y')->group_by('distrik')->order_by('distrik')->get(_TBL_VIEW_PUSKESMAS)->result_array();
		
				$arr_propinsi=array();
				foreach($rows as $row){
					$arr_propinsi[$row['nama']]=$row['jml'];
				}
				$this->arr_statistik_wilayah=$arr_propinsi;
				
				$kel=3;
				$hasil['title'] = "Ketepatan Laporan Puskesmas  Menurut Kota Minggu "._MINGGU_;
			}elseif (intval($param['cboPropinsi'])>0){
				$rows = $this->db->select('kota as nama, count(puskesmas) as jml')->where('id_prop',$param['cboPropinsi'])->where('aktif','Y')->group_by('kota')->order_by('kota')->get(_TBL_VIEW_PUSKESMAS)->result_array();
		
				$arr_propinsi=array();
				foreach($rows as $row){
					$arr_propinsi[$row['nama']]=$row['jml'];
				}
				$this->arr_statistik_wilayah=$arr_propinsi;
				
				$kel=4;
				$hasil['title'] = "Ketepatan Laporan Puskesmas  Menurut Provinsi Minggu "._MINGGU_;
			}else{
				$kel=1;
				$hasil['title'] = "Ketepatan Laporan Puskesmas  Menurut Provinsi Minggu Minggu "._MINGGU_;
			}
			if (intval($param['cboMinggu2'])==0)
				$param['cboMinggu2']=$param['cboMinggu'];
			$rows = $this->db->query($stored_pocedure,array($param['cboTahun'], $param['cboMinggu'], $param['cboMinggu2'],$kel,$param['cboPropinsi'],$param['cboKota'],$param['cboDistrik'],$param['cboPuskesmas'],$param['cboPenyakit']))->result_array();
			mysqli_next_result( $this->db->conn_id );
		}
		
		// $arr_propinsi=array();
		
		// foreach($rows as $row){
			// $key=$row['nama'];
			// $sudah=intval($row['jml']);
			// $arr_propinsi[$key]=$sudah;
		// }
		
		// $stored_pocedure = "CALL ewarn_pro_statistik_datareport_tepat(?, ?) ";
		// $rows = $this->db->query($stored_pocedure,array(_TAHUN_, _MINGGU_))->result_array();
		// mysqli_next_result( $this->db->conn_id );
		
		$hasil['title'] = "Ketepatan Laporan Puskesmas  Menurut Provinsi Minggu "._MINGGU_;
		
		$data_sudah=array();
		$data_belum=array();
		$arr_perSudah=array();
		$arr_warna=array();
		$rekap=array();
		foreach($this->arr_statistik_wilayah as $key=>$wil){
			$sudah=0;
			$belum=0;
			foreach($rows as $row){
				if ($key==$row['nama']){
					$sudah=intval($row['jml']);
					$belum=intval($wil) - intval($row['jml']);
					break;
				}
			}
			$perSudah=0;
			$perBelum=0;
			if ($sudah>0)
				$perSudah=number_format(($sudah/$wil)*100);
			
			if ($belum>0)
				$perBelum=number_format(($belum/$wil)*100);
			$rekap[]=array('data'=>$key, 'total'=>$wil, 'sudah'=>$sudah, 'belum'=>$belum, 'perSudah'=>$perSudah, 'perBelum'=>$perBelum);
			
			if ($sudah>0){
				$data_sudah[] =$sudah; 
				$arr_perSudah[] =$perSudah; 
				if ($perSudah>=85)
					$arr_warna[] ='#3C8DBC'; 
				else
					$arr_warna[] ='#DD4B39'; 
				$data_belum[] =$belum; 
				$arr_labels[]=$key;
			}
		}
		
		$chartData = array(
					'labels'=>$arr_labels,
					'datasets'=>array(array('label'=>'Ketepatan','backgroundColor'=>$arr_warna,'data'=>$arr_perSudah)));
					
		$hasil['data'] = $chartData;
		$hasil['info-table'] = $rekap;
		$hasil['nil-mak'] = 120;
		return $hasil;
	}
	
	function get_data_alert($param=array()){
		$arr_labels=array();
		
		$rows = $this->db->select('kd_propinsi as nama, count(kd_propinsi) as jml')->where('sts_verifikasi',1)->where('minggu',_MINGGU_)->where('tahun',_TAHUN_)->group_by('kd_propinsi')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
		$verif=array();
		foreach($rows as $row){
			$verif[$row['nama']] = $row['jml'];
		}
		
		$rows = $this->db->select('kd_propinsi as nama, count(kd_propinsi) as jml')->where('tahun',_TAHUN_)->where('minggu',_MINGGU_)->order_by('kd_propinsi')->group_by('kd_propinsi')->get(_TBL_VIEW_ALERT_GROUP)->result_array();
		
		$hasil['title'] = "Peringatan Dini Puskesmas Menurut Provinsi Minggu "._MINGGU_;
		
		$data_sudah =array(); 
		$data_verif =array(); 
		$rekap =array(); 
		$nilMak=0;
		foreach($rows as $row){
			$sudah=0;
			if (array_key_exists($row['nama'], $verif)){
				$sudah=$verif[$row['nama']];
				$data_verif[]=$sudah;
			}else{
				$data_verif[]=0;
			}
			$data_sudah[] = $row['jml']-$sudah; 
			$arr_labels[]=$row['nama'];			
			$rekap[]=array('data'=>$row['nama'], 'alert'=>$row['jml'], 'verif'=>$sudah, 'belum'=>$row['jml']-$sudah);
			if (intval($row['jml'])>$nilMak){
				$nilMak=intval($row['jml']);
			}
			
		}
		
		$chartData = array(
					'labels'=>$arr_labels,
					'datasets'=>array(array('label'=>'Belum Terverifikasi','backgroundColor'=>'#DD4B39','data'=>$data_sudah), array('label'=>'Sudah Terverifikasi','backgroundColor'=>'#3C8DBC','data'=>$data_verif)));
					
		$hasil['data'] = $chartData;
		$hasil['info-table'] = $rekap;
		$hasil['nil-mak'] = $nilMak+20;
		return $hasil;
	}
	
	function get_data_personal_alert($id){
		$rows = $this->db->where('id',$id)->get(_TBL_VIEW_ALERT)->row();
		if ($rows)
			return (array) $rows;
		else
			return array();
	}
	
	function get_lokasi_alert($id=0){
		if ($id>0)
			$rows = $this->db->where('tahun',_TAHUN_)->where('minggu',_MINGGU_)->where('id_prop',$id)->get(_TBL_VIEW_ALERT)->result_array();
		else
			$rows = $this->db->where('tahun',_TAHUN_)->where('minggu',_MINGGU_)->get(_TBL_VIEW_ALERT)->result_array();
		return $rows;
	}
	
	function simpan_verifikasi($data){
		$upd['sts_verifikasi']=$data['sts_verifikasi'];
		$upd['note']=$data['note'];
		$upd['tgl_verif']=date('Y-m-d', strtotime($data['tgl_verif']));
		$upd['petugas']=_USER_NAME_COMPLETE_;
		$upd['jml_kematian']=$data['jml_kematian'];
		$upd['temuan']=$data['temuan'];
		$upd['klb']=$data['sts_klb'];
		$upd['respon24']=$data['sts_respon'];
		$upd['update_date']=Doi::now();
		$upd['update_user']=_USER_NAME_;
		
		$result=$this->crud->crud_data(array('table'=>_TBL_LAP_ALERT, 'field'=>$upd,'type'=>'update', 'where'=>array('id'=>$data['id_edit'])));
	}
}

/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */