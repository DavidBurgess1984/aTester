<?php



class MY_Controller extends CI_Controller {
    public function __construct() {
       parent::__construct();
       
       @$this->validateUserIpAddress();
       @$this->validateUserAgent();
    }

    public function getIPAddress(){
		
		//$ip = '122.122.1.112';
		
		/**
		 * Trims the ip address and returns as xxx.xxx.xxx.0
		 */
		
		$ip_keys = array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
		
		foreach($ip_keys as $key){
			if(array_key_exists($key, $_SERVER) === true){
				foreach($_SERVER[$key] as $ip){
					$ip = $this->trim($ip);
					
					if($this->validate_ip($ip)){
						return $ip;
					}
				}
			}
		}
		
		return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
	}
	
	private function trimIP($ip){
		
		$pos = strrpos($ip, '.');
		
		if($pos !== false){
			$ip = substr($ip,0, $pos+1);
		}
		
		return $ip.'.0';
	}
	
	/**
	 * Ensures an ip address is both a valid IP and does not fall within
	 * a private network range.
	 */
	private function validate_ip($ip)
	{
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
			return false;
		}
		return true;
	}
	
	function validateUserAgent(){
		// assumes you have set the session variable logged_in to a boolean value depending on login status
		if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
			$_SESSION['user_agent'] = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
		} else {
			// if the user agent doesnt validate, destroy the session and force relogin
			if (!isset($_SERVER['HTTP_USER_AGENT']) || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
				// destroy
				session_destroy();
				$_SESSION = array();
				if (!headers_sent()) {
					// set a flash and redirect to the login page
					redirect(base_url('index.php/login'));
					exit;
				} else {
					// throw an error message
					exit;
				}
			}
		}
	}
        
        function validateUserIpAddress(){
            if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
                    $_SESSION['ip_address'] = $this->getIPAddress();
            } else {
                    if($_SESSION['ip_address'] !== $this->getIPAddress()){
                            //destroy
                            session_destroy();
                            $_SESSION = array();

                            if(!headers_sent()){
                                    redirect(base_url('index.php/login'));
                                    exit;

                            } else {
                                    exit;
                            }
                    }
            }

            
        }
}

class MY_Admin_Controller extends MY_Controller {
    public function __construct() {
       parent::__construct();
       
       @$this->checkLogin();
       @$this->checkSessionExpired();
       
    }
    
    public function checkLogin(){
        if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false){
            session_destroy();
            $_SESSION = array();
            if (!headers_sent()) {
                    // set a flash and redirect to the login page
                    redirect(base_url('index.php/login'));
                    exit;
            }
        }
    }
    
    public function getLoginUserID(){
        if(isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== false){
            return $_SESSION['logged_in']['userID'];
        }
        
    }
    
    public function getLoginUserEmail(){
        if(isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== false){
            return $_SESSION['logged_in']['userEmail'];
        }
        
    }
    
    public function checkSessionExpired(){
        if(!isset($_SESSION['logged_in_time']) || ($_SESSION['logged_in_time']- time() > 1800) ){
            session_destroy();
            $_SESSION = array();
            if (!headers_sent()) {
                    // set a flash and redirect to the login page
                    redirect(base_url('index.php/login'));
                    exit;
            }
        } else {
            $_SESSION['logged_in_time'] = time();
        }
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

