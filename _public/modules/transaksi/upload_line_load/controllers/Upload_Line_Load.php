<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_Line_Load extends BackendController {

	public function __construct()
	{
        parent::__construct();

        //delete uploaded file after 24 hour
        $this->_delete_tmp();
	}
	
	public function index()
	{
		$this->template->build('upload');
	}

	public function preview()
	{

		$config = array(
            'upload_path'   => APPPATH .'tmp',
            'allowed_types' => 'xlsx|xls'
        );
        $config['encrypt_name'] = TRUE;

		if (isset($_FILES['file']['name'])) {

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
                echo $this->upload->display_errors();
            } else {

            	$upload_data = $this->upload->data();
                
            	return $this->_preview(APPPATH .'tmp/' . $upload_data['file_name']);	
            }

        } else {
            echo 'Please choose a file';
        }
	}

	public function proses()
	{

		$config = array(
            'upload_path'   => APPPATH .'tmp',
            'allowed_types' => 'xlsx|xls'
        );
        $config['encrypt_name'] = TRUE;

		if (isset($_FILES['file']['name'])) {

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
                echo $this->upload->display_errors();
            } else {

            	$upload_data = $this->upload->data();
                
            	return $this->_proses(APPPATH .'tmp/' . $upload_data['file_name']);	
            }

        } else {
            echo 'Please choose a file';
        }
	}

	protected function _preview($excel)
	{
		require APPPATH . 'third_party/males/php-excel-reader/excel_reader2.php';
		require APPPATH . 'third_party/males/SpreadsheetReader.php';
		require APPPATH . 'third_party/males/core.php';

		$Reader = new SpreadsheetReader($excel);
		$data = [];
		foreach ($Reader as $Row)
		{
			$data[]= $Row;
		}

		$tbody = array_reduce($data, function($a, $b) {
			return $a.="<tr><td>".implode("</td><td>",$b)."</td></tr>";
		});
		

		echo "<div class=\"table-responsive\"><table class='table table-bordered table-striped table-hover table-small-font'>\n$tbody\n</table></div>";
	}

	protected function _proses($excel)
	{
		require APPPATH . 'third_party/males/php-excel-reader/excel_reader2.php';
		require APPPATH . 'third_party/males/SpreadsheetReader.php';
		require APPPATH . 'third_party/males/core.php';

		$Reader = new SpreadsheetReader($excel);
		$data = [];
		foreach ($Reader as $Row)
		{
			$data[]= $Row;
		}
		
		$result = new Males($data);


		$table = $result->render('table');
		

		echo "<div class=\"table-responsive\"><table class='table table-bordered table-striped table-hover table-small-font'>\n$table\n</table></div>";
	}

	public function _delete_tmp()
	{
		$dir = APPPATH . 'tmp/';

		/*** cycle through all files in the directory ***/
		foreach (glob($dir."*") as $file) {

			/*** if file is 24 hours (86400 seconds) old then delete it ***/
			if(time() - filectime($file) > 86400){
		    	unlink($file);
		    }
		}
	}
}