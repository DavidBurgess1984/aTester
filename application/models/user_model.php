<?php 
class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    public function create_hash($string, $created_date, $hash_method = 'sha1') {
    	// the salt will be the reverse of the user's created date
    	// in seconds since the epoch
    	$salt = strrev(date('U', strtotime($created_date)));
    	
    	if (function_exists('hash') && in_array($hash_method, hash_algos())) {
    		return hash($hash_method, $salt.$string);
    	}
    	return sha1($salt.$string);
    }
    

    
    public function createUserAccount($email,$password,$password1){
    	
    	$email = mysqli_real_escape_string($this->db->conn_id, $email);
    	$password = mysqli_real_escape_string($this->db->conn_id, $password);
        $password1 = mysqli_real_escape_string($this->db->conn_id, $password1);
    	$currentTimestamp = time();
    	
        if($password !== $password1){
            return false;
        }
        
    	$password = $this->user_model->create_hash($password, $currentTimestamp);
    	
    	$sql = "INSERT INTO `user`
    					( uEmail, uPassword, uCreatedDatetime, uAdmin,uDateInserted, uAllowCollaboration) 
    				VALUES 
    					( '{$email}','{$password}', {$currentTimestamp}, 0, NOW(), 1 )";
		
		$res = $this->db->query($sql);
		
		if(!$res){
			return false;
		} else {
			return true;
		}
    }

    /**
     * @param string $pass The user submitted password
    * @param string $hashed_pass The hashed password pulled from the database
    * @param string $created_date The user's created date pulled from the database
    * @param string $hash_method The hashing method used to generate the hashed password
    */
    function validateLogin($pass, $hashed_pass, $created_date, $hash_method = 'sha1') {
    	$salt = strrev(date('U', strtotime($created_date)));
    	if (function_exists('hash') && in_array($hash_method, hash_algos())) {
    		$test = hash($hash_method, $salt . $pass);
    		return ($hashed_pass === hash($hash_method, $salt . $pass));
    	}
    	return ($hashed_pass === sha1($salt . $pass));
    }
    
    function getLoginAccount($email){
    	$username = mysqli_real_escape_string($this->db->conn_id, $email);
    	
    	$sql = 'SELECT * FROM `user` WHERE uEmail = "%s" LIMIT 1';
    	
    	$sql = sprintf($sql, $username);
    	
    	$query = $this->db->query($sql);
    	
    	if($query->num_rows() === 1){
    		$loginDetails = $query->row();
    	} else {
    		return false;
    	}
    	
    	return $loginDetails;
    }
    
    function loginExists($email){
    	$username = mysqli_real_escape_string($this->db->conn_id, $email);
    	
    	$sql = 'SELECT * FROM `user` WHERE uEmail = "%s" LIMIT 1';
    	
    	$sql = sprintf($sql, $username);
    	
    	$query = $this->db->query($sql);
    	
    	if($query->num_rows() === 1){
    		$loginDetails = $query->row();
    	} else {
    		return false;
    	}
    	
    	return true;
    }
    
}

?>