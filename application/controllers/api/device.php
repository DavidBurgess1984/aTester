<?php
define('DIR', dirname(dirname(__FILE__)));
require_once(DIR.'/REST_Controller.php');

class device extends REST_Controller
{
  public function index_get()
  {
    // Display all books
  }

  public function index_post()
  {
    // Create a new book
  }
  
  public function update_post($deviceID){
  	$sql = 'UPDATE Device SET dDescription = %1$s, dDateUpdated = NOW() WHERE idDevice = %2$s';
  	
  	$newDesc = $this->db->escape($this->input->post('newDesc'));
  	$sql = sprintf($sql, $newDesc, $deviceID);
  	$update = $this->db->query($sql);
  	
  	if(!$update){
  		$errorArray = array();
  		$errorArray['status'] = 'error';
  		$errorArray['title'] = 'db error';
  		$errorArray['msg'] = 'unable to update the device description';
  		$this->response($errorArray);
  	} else {
  		$successArray = array();
  		$successArray['status'] = 'success';
  		$successArray['msg'] = $this->input->post('newDesc');
  		$this->response($successArray);
  	}
  }
  
  public function delete_post($deviceID){
  	$sql = 'DELETE FROM Device WHERE idDevice = %1$s';
  	
  	$sql = sprintf($sql,$deviceID);
  	$delete = $this->db->query($sql);
  	
  	if(!$delete){
  		$errorArray = array();
  		$errorArray['status'] = 'error';
  		$errorArray['title'] = 'db error';
  		$errorArray['msg'] = 'unable to delete the device';
  		$this->response($errorArray);
  	} else {
  		$successArray = array();
  		$successArray['status'] = 'success';
  		$this->response($successArray);
  	}
  }
  
  
}

?>