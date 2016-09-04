<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	
    public function __construct(){
		parent::__construct();
                $this->load->library('session');
                
                
                
	}
        
	public function index(){
                $error = strlen($this->session->flashdata('error')) ? $this->session->flashdata('error') : '';
		$data = array();
		switch($error){
                    case 'incorrectUserName':
                        $data['error'] = array('title' => 'Error', 'message' => 'Username/password combination not recognised in DB');
                        break;
                    case 'incorrectPrivileges':
                        $data['error'] = array('title' => 'Error', 'message' => 'Only admin users have permission to log in');
                        break;
                }
                
                $this->load->view('login/header_login');
                
                
                
		$this->load->view('login/bs_login',$data);
		$this->load->view('login/footer');
	}
}

?>