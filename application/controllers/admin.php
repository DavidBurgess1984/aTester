<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Admin_Controller {
	
    public function __construct(){
		parent::__construct();
                $this->load->library('session');
                
                
                
	}
        
	public function index(){
                
		$this->load->view('template/header');

		$this->load->view('template/footer');
	}
}

?>