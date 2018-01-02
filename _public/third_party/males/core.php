<?php

class Males
{
	protected $data;
	protected $result;

	protected $pfd;
	protected $carry;
	protected $siklus;

	protected $header;

	protected $datasheet;
	protected $sheet;

	protected $table = '';
	protected $thead = '';


	function __construct(array $data)
	{
		$this->data = $data;
		$this->remove_line()
			->parse_pfd()
			->parse_siklus()
			->make_header()
			->get_carryover()
			->build_sheet()
			->build_thead()
			->build_table();
	}


	protected function create_datasheet()
	{
		foreach ($this->data as $key => $value) {
			if ($key > 5 && $key < (count($this->data) -1)) {
				$this->datasheet[]= array_values($value);
			}
		}
		return $this;
	}

	protected function remove_line()
	{
		if (strpos($this->data[0][0], 'LINE LOAD') !== false) {
		    unset($this->data[0]);
		}
		$this->data = array_values($this->data);
		return $this->create_datasheet();
	}

	protected function parse_pfd()
	{
		$this->result['pfd'] = $this->data[0];
		return $this->count_pfd();
	}

	protected function count_pfd()
	{
		$jml = array_filter($this->result['pfd'], function($x){
			return strlen($x) > 0;
		});
		$this->pfd = $jml;
		return $this;
	}

	protected function count_siklus()
	{
		$jml = array_filter($this->result['siklus'], function($x){
			return strlen($x) > 0;
		});

		$dt = array_map(function($k, $v)
		{
			return [$k=>$v];
		}, array_keys($jml), $jml);
		$this->siklus = $dt;
		return $this;
	}

	protected function parse_siklus()
	{
		$this->result['siklus'] = $this->data[1];
		return $this->count_siklus();
	}

	protected function get_carryover()
	{
		if (strpos($this->data[5][4], 'Carry') !== false) {
		    $this->carry = 4;
			return $this;
		}
	}

	protected function make_header()
	{
		$pfd = $this->pfd;
		foreach ($this->siklus as $key => $value) {
			$val = [trim($value[key($value)])];
			foreach ($pfd as $kp => $vp) {
				if ($key == count($this->siklus)-1) {
						
						$val['child']['p'.$kp] = $pfd[$kp];
						unset($pfd[$kp]);
					
				} else {
					if ($kp >= key($value) AND $kp < key($this->siklus[$key+1])) {
						$val['child']['p'.$kp] = $pfd[$kp];
						unset($pfd[$kp]);
					}
				}
			}
			$this->header[$key] = $val;
		}
		return $this;
	}

	public function build_sheet()
	{
		$tempkey = ['carry'];
		foreach ($this->pfd as $k => $v) {
			array_push($tempkey, 'p'.$k);
		}

		$row = array_map(function($x) use ($tempkey) {
			$jmlcolom = count($x);
			foreach ($tempkey as $i => $v) {
				if ($v == 'carry') {
					$new[$v] = round($x[$this->carry]); 
				}
				else if ($i == count($tempkey)-1) {
					$start = substr($v, 1);
					$end = $jmlcolom-1;
					$new[$v] = round($this->sumArray($x, $start, $end)); 
				}
				else {
					$start = substr($v, 1);
					$end = substr($tempkey[$i+1],1);
					$new[$v] = round($this->sumArray($x, $start, $end));	
				}

			}
			return $new;
		}, $this->datasheet);

		$row = array_map(function($x){
			$new['carry'] = $x['carry'];
			foreach ($this->header as $key => $value) {
				$total = 0;
				foreach ($value['child'] as $k=>$v) {
					$total = $total + $x[$k];
					$new[$k] = $x[$k];
				}
				if ($key == 0) {
					$new['total'.$key] = $new['carry'] + $total;
				} else {
					$new['total'.$key] =$total;
				}
			}
			return $new;			
		},$row);


		$this->sheet = $row;
		return $this;

	}


	public function render($data = 'sheet')
	{
		return isset($this->{$data}) ? $this->{$data} : NULL;
	}

	protected function sumArray($array, $min, $max) {
	   $sum = 0;
	   foreach ($array as $k => $a) {
	      if ($k >= $min && $k < $max) {
	         $sum += $a;
	      }
	   }
	   return $sum;
	}

	protected function array_insert (&$array, $position, $insert_array) { 
	  $first_array = array_splice ($array, 0, $position); 
	  $array = array_merge ($first_array, $insert_array, $array); 
	} 

	protected function build_thead()
	{
		$this->thead .= '<thead>';
		$this->thead .= '<tr>';
		$this->thead .= '<th>';
		$this->thead .= '</th>';
		foreach ($this->header as $key => $value) {
			$colspan = "colspan=" .(count($value['child'])+1);
			$this->thead .= '<th '.$colspan.'>'; 
			$this->thead .= $value[0]; 
			$this->thead .= '</th>'; 
		}
		$this->thead .= '</tr>';
		$this->thead .= '<tr>';
		$this->thead .= '<th>Carryover</th>';
		foreach ($this->header as $key => $value) {
			foreach ($value['child'] as $v) {
				$this->thead .= '<th>'; 
				$this->thead .= $v; 
				$this->thead .= '</th>';	
			}
			$this->thead .= '<th>'; 
			$this->thead .= 'Total'; 
			$this->thead .= '</th>'; 
		}
		$this->thead .= '</tr>';
		$this->thead .= '</thead>';
		return $this;
	}

	protected function build_table()
	{
		$this->table .= $this->thead;
		$this->table .= '<tbody>';
		foreach ($this->sheet as $sheet) {
			$this->table .= '<tr>';
			foreach ($sheet as $key => $value) {
				$this->table .= '<td classs="'.$key.'">'.$value.'</td>';
			}
			$this->table .= '</tr>';
		}
		$this->table .= '</tbody>';
		return $this;
	}
}