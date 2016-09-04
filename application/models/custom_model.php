<?php 
class Custom_model extends CI_Model {

    function __construct()
    {
        parent::__construct();;
    }
    
    function getProjectIDByTestsheet($testsheet){
        $sql = 'SELECT 
                    tsIdProject as `id`
                FROM
                    TestSheet
                WHERE 
                    idTestSheet = %1$d';
    	
        $sql = sprintf($sql,$testsheet);
        
        //echo $sql;
    	$res = $this->db->query($sql);
    	
    	$dataArray = array();
    	if ($res->num_rows() > 0)
    	{
            $result = $res->row();
            return $result->id;
    	} else {
            return false;
    	}
    }
    
    function isCustomTestsheet($testsheetID){
        $sql = ' SELECT tsIdTestSheetTemplate FROM  TestSheet WHERE idTestsheet = %1$d';
        
        $sql = sprintf($sql, $testsheetID);
        
        $query = $this->db->query($sql);
        
        $result = $query->row();
        
        return (intval($result->collaborationID) === 255) ? true : false;
    }
    
    function loadTestsheetsByProject($projectID){
    	$sql = 'SELECT 
                    idTestSheet as `id`,
                    tsTitle as `title`
                FROM
                    TestSheet
                WHERE 
                    tsIdProject = %1$s';
    	
        $sql = sprintf($sql,$projectID);
    	$res = $this->db->query($sql);
    	
    	$dataArray = array();
    	if ($res->num_rows() > 0)
    	{
            foreach ($res->result() as $row)
            {
                array_push($dataArray, $row);
            }
    	} else {
            return false;
    	}
    	
    	return $dataArray;
    }
    
    function createTestsheet($projectID, $isCustom,$testSheetTitle){
        
        if(!$isCustom){
            $this->createSmartphoneTestsheet($projectID,$testSheetTitle);
            return true;
        } else {
            $this->createCustomTestsheet($projectID,$testSheetTitle);
            return true;
        }
    }
    
    function createCustomTestSheet($projectID,$testSheetTitle){
        
        $this->db->trans_start();
        
        $sql = ' INSERT INTO TestSheet(tsIdTestSheetTemplate, tsTitle,tsDateInserted,tsIdProject,tsStatus)'
                . ' VALUES '
                . '(255, \'%1$s\', NOW(),%2$s,0)';
        
        $sql = sprintf($sql, $testSheetTitle,$projectID);
        
        $this->db->query($sql);
        
        $this->db->trans_complete();
    }
    
    function createSmartphoneTestSheet($projectID,$testSheetTitle){
        $this->db->trans_start();
        
        $sql = ' INSERT INTO TestSheet(tsIdTestSheetTemplate, tsTitle,tsDateInserted,tsIdProject,tsStatus)'
                . ' VALUES '
                . '(1, \'%1$s\', NOW(),%2$s,0)';
        
        $sql = sprintf($sql, $testSheetTitle,$projectID);
        
        $this->db->query($sql);
        
        $testSheetID = $this->db->insert_id();
        
        $sql = 'INSERT INTO TestSheetQuestion 
                    (tsqIdQuestion,tsqStatus,tsqDateInserted,tsqIdTestSheet) 
                SELECT idQuestion, 0,NOW(), %1$d FROM Question';
        
        $sql = sprintf($sql, $testSheetID);
        
        $this->db->query($sql);
        
        $this->db->trans_complete();
        
        return true;
    }
    
    /*function loadDevices(){
    	$sql = "SELECT 
    				idDevice as 'id',
    				dDescription as 'description'
    			FROM
    				Device";
    	
    	$res = $this->db->query($sql);
    	
    	$dataArray = array();
    	if ($res->num_rows() > 0)
    	{
    		foreach ($res->result() as $row)
    		{
    			array_push($dataArray, $row);
    		}
    	} else {
    		return false;
    	}
    	
    	return $dataArray;
    }*/
    
   
    /*
    function insertNewDevice($title){
		
   	
    	$sql = "INSERT INTO `Device` (dDescription, dDateInserted) VALUES ( ";
		$sql .= ' \'%1$s\' , NOW() ';
    	$sql .= " ) ";
    	
    	$sql = sprintf($sql, $title);
    	$query= $this->db->query($sql);
    	
    	if(!$query){
    		return false;
    	} else {
    		return true;
    	}
    }*/
    
    /*
    public function getDevice($deviceID){
        $sql = 'SELECT 
    				idDevice as `id`,
    				dDescription as `description`
    			FROM
    				Device WHERE idDevice = \'%1$s\' ';
    	
        $sql = sprintf($sql,$deviceID);
    	$res = $this->db->query($sql);
    	
    	$dataArray = array();
    	if ($res->num_rows() > 0)
    	{
    		$row = $res->row();
    		
    	} else {
    		return false;
    	}
    	
    	return $row;
    
    }*/
}

?>