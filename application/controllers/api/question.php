<?php
define('DIR', dirname(dirname(__FILE__)));
require_once(DIR.'/REST_Controller.php');

class question extends REST_Controller
{
  public function index_get()
  {
    // Display all books
  }

  public function index_post()
  {
    // Create a new book
  }
  
  public function update_post($questionID){
  	$sql = 'UPDATE Question SET qDescription = %1$s , qIdCategory = %2$d, qDateUpdated = NOW() WHERE idQuestion = %3$s';
  	
  	$newDesc = $this->db->escape($this->input->post('newDesc'));
        $newCategory = intval($this->input->post('newCategory'));
  	$sql = sprintf($sql, $newDesc, $newCategory, $questionID);
  	$update = $this->db->query($sql);
  	
  	if(!$update){
  		$errorArray = array();
  		$errorArray['status'] = 'error';
  		$errorArray['title'] = 'db error';
  		$errorArray['msg'] = 'unable to update the question description';
  		$this->response($errorArray);
  	} else {
  		$successArray = array();
  		$successArray['status'] = 'success';
  		$successArray['msg'] = $this->input->post('newDesc');
  		$this->response($successArray);
  	}
  }
  
  public function delete_post($deviceID){
  	$sql = 'DELETE FROM Question WHERE idQuestion = %1$s';
  	
  	$sql = sprintf($sql,$deviceID);
  	$delete = $this->db->query($sql);
  	
  	if(!$delete){
  		$errorArray = array();
  		$errorArray['status'] = 'error';
  		$errorArray['title'] = 'db error';
  		$errorArray['msg'] = 'unable to delete the question';
  		$this->response($errorArray);
  	} else {
  		$successArray = array();
  		$successArray['status'] = 'success';
  		$this->response($successArray);
  	}
  }
}

?>