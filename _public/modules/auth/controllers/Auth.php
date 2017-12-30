<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends BackendController {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct()
	{
        parent::__construct();
    }
	
	public function index()
	{
		
		if (!$this->authentication->is_loggedin())
		{
			$this->template->set_layout('login');
			$dt=array();
			$data['header']=$this->load->view("header",$dt, true);
			$data['menu']=$this->load->view("menu",$dt, true);
			$data['about']=$this->load->view("about",$dt, true);
			$data['contact']=$this->load->view("contact",$dt, true);
			$data['footer']=$this->load->view("footer",$dt, true);
			$this->template->build('auth', $data); 
		}else{
			header('location:'.base_url().'dashboard');
		}
	}
	
	public function login()
	{
		if (!$this->authentication->is_loggedin())
		{
			$x=$this->input->post();
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$hasil=$this->form_validation->run();
			
			if ($hasil == FALSE)
			{
				header('location:'.base_url().'auth');
				$this->template->set_layout('login');
				$this->template->build('auth'); 
			}
			else
			{
				if ($this->authentication->login($this->input->post('username'), $this->input->post('password'))){
					// $redirec=$this->authentication->get_Info_User('last_visit');
					$default_modul=$this->authentication->get_Info_User('default_modul');
					$x=$this->session->userdata('user_info');
					if (empty($default_modul)){
						header('location:'.base_url('dashboard'));
					}else{
						header('location:'.base_url('dashboard'));
					}
				} else {
					header('location:'.base_url('auth'));
				}
			}
		}else{
			header('location:'.base_url().'dashboard');
		}
	}
	
	public function logout()
	{
		$redirect_to = isset($_GET["redirect_to"])?$_GET["redirect_to"]:uri_string();
		if(!empty($redirect_to)){
			$redirect_to = urldecode($redirect_to);
		}else{
			$redirect_to = 'dashboard';
		}
		
		$this->logdata->_log_data('modul', 'login');
		$this->logdata->_log_data('kel', 'Logout');
		$this->logdata->_msg_log_perda_bg('logout dari sistem');
		$this->logdata->_save_log_data();
		if ($this->authentication->logout($redirect_to))
		{
			header('location:'.base_url());
		}
	}
	
	public function language()
	{
		$redirect_to = isset($_GET["redirect_to"])?$_GET["redirect_to"]:"";
		if(!empty($redirect_to)){
			$redirect_to = urldecode($redirect_to);
		}else{
			$redirect_to = base_url();
		}
	
		$bahasa=$this->_Snippets_['uri'][2];;
		$this->session->set_userdata(array('bahasa' => $bahasa));
		
		header('location:'.$redirect_to);
	}
	
	public function faq()
	{
		$this->template->set_layout('login');
		$this->template->build('auth_faq'); 
	}
	
	public function daftar()
	{
		if (!$this->authentication->is_loggedin())
		{
			$user=$this->input->post('username');
			if (!empty($user))
			{
				if ($this->authentication->create_user($this->input->post('username'),$this->input->post('password')))
				{
					$this->session->set_flashdata('result_login', "Pendaftaran berhasil, silahkan anda login");
					header('location:'.base_url().'auth');
				}else{
					$this->session->set_flashdata('result_login', "Maaf, Pendaftaran anda gagal, silahkan coba kembali");
					$this->template->set_layout('login');
					$this->template->build('auth_daftar'); 
				}
			}else{
				$this->template->set_layout('login');
				$this->template->build('auth_daftar'); 
			}
		}else{
			header('location:'.base_url().'dashboard');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */