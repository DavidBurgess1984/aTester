<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
                $this->load->library('session');
                $this->load->helper(array('form', 'url'));
                $this->load->library('form_validation');
	}
	
        /*public function validateUserCreation(){
            $this->form_validation->set_rules('email', 'email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required|matches[password]');
            //$this->form_validation->set_rules('password1', 'password', 'required');
            
            if ($this->form_validation->run() == FALSE)
		{
                    $this->session->set_flashdata('error', validation_errors());
                    redirect('/createUser');
                }
            
        }*/
        
        
        public function create(){
            $error = strlen($this->session->flashdata('error')) ? $this->session->flashdata('error') : '';
            $data = array();
            $data['error'] = $error;
            $data['email'] = $this->input->post('email');
            $this->load->view('login/header_login');



            $this->load->view('login/createUser',$data);
            $this->load->view('login/footer');
	}
        
        public function validateUserCreation(){
            $this->form_validation->set_rules('email', 'email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required|matches[password1]');
            $this->form_validation->set_rules('password1', 'password', 'required');
            
            $email = mysqli_real_escape_string($this->db->conn_id, $this->input->post('email') );
            $password = mysqli_real_escape_string($this->db->conn_id, $this->input->post('password') );
            $password1 = mysqli_real_escape_string($this->db->conn_id, $this->input->post('password1') );
            
            if ($this->form_validation->run() == FALSE)
		{
                    $this->session->set_flashdata('error', validation_errors());
                    $this->index();
                } else {
                    if($this->user_model->loginExists($email)){
                       $this->session->set_flashdata('error', 'Email address already exists');
                       $this->index(); 
                    } else {
                        $userInserted = $this->user_model->createUserAccount($email,$password,$password1);
                        if(!$userInserted){
                            $this->session->set_flashdata('error', 'Database Error');
                            $this->index(); 
                        } else{
                            $this->redirectToLogin($email,$password);
                        }
                    }
                }
            
        }
        
        function redirectToLogin($email, $password){
            if(!$loginDetails = $this->user_model->getLoginAccount($email)){
                $this->session->set_flashdata('error', 'incorrectUserName');
                redirect(base_url('index.php/login'));
            }



            $loggedIn = $this->user_model->validateLogin($password, $loginDetails->uPassword, $loginDetails->uCreatedDateTime);

            if(!$loggedIn){
                $this->session->set_flashdata('error', 'incorrectUserName');
                redirect(base_url('index.php/login'));
            } elseif($loginDetails->uAdmin !== '1'){
                $this->session->set_flashdata('error', 'incorrectPrivileges');
                redirect(base_url('index.php/login'));
            } else {
                $_SESSION['logged_in'] = array('userID' => $loginDetails->idUser, 'userEmail'=> $loginDetails->uEmail);
                $_SESSION['logged_in_time'] = time();
                /**do session variables and ip address check */
                redirect(base_url('index.php/dash'));
            }
        }
        
	public function validateLogin(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		if(!$loginDetails = $this->user_model->getLoginAccount($email)){
                    $this->session->set_flashdata('error', 'incorrectUserName');
                    redirect(base_url('index.php/login'));
		}
		
                
                
		$loggedIn = $this->user_model->validateLogin($password, $loginDetails->uPassword, $loginDetails->uCreatedDateTime);
		
		if(!$loggedIn){
                    $this->session->set_flashdata('error', 'incorrectUserName');
                    redirect(base_url('index.php/login'));
		} /*elseif($loginDetails->uAdmin !== '1'){
                    $this->session->set_flashdata('error', 'incorrectPrivileges');
                    redirect(base_url('index.php/login'));
                } */else {
                    $_SESSION['logged_in'] = array('userID' => $loginDetails->idUser, 'userEmail'=> $loginDetails->uEmail);
                    $_SESSION['logged_in_time'] = time();
                    /**do session variables and ip address check */
                    redirect(base_url('index.php/dash'));
		}
		
	}
	
	/*public function generateUserAccount(){
		
		
		$firstName = 'David';
		$surname = 'Burgess';
		$email = 'davidsdasas1984@gmail.com';
		$password = '123456';
		
		$passwordCreated = $this->user_model->createUserAccount($firstName,$surname,$email,$password);
		
		if($passwordCreated){
			echo "Success!";
		} else {
			echo "Whoops!!!";
		}
	}*/
	
	// DO IP Address validation and User Agent test!!!

            function logout(){
                session_destroy();
                $_SESSION = array();
                if (!headers_sent()) {
                    redirect(base_url('index.php/login'));
                }
            }
}

?>