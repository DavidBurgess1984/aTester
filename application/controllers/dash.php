<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends MY_Admin_Controller {
	
    public function __construct(){
		parent::__construct();
                $this->load->library('session');
                
                
                
	}
        
	public function index(){
                
            $data['page']='dash';
            //$data['navigationView']=$this->load->view('user/navigation/main',$metadata, true);
		$this->load->view('user/header');
                $this->load->view('user/main-nav',$data);
                $this->load->view('user/dashboard/content',$data);
                $this->load->view('user/jsfiles');
		$this->load->view('user/footer');
	}
}

?>