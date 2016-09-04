<?php 
class Question_model extends CI_Model {

    function __construct()
    {
        parent::__construct();;
    }
    
    function getQuestionsGroupedIntoCategories($deviceID){
        
        $sql = "SELECT 
                    idCategory AS 'id',
                    cDescription AS 'category' 
                FROM Category";
        
        /*if(isset($deviceID)){
            switch($deviceID){
                case 1 ://general
                default :
                    $sql .= " WHERE cDeviceSpecific IS NULL ";
                    break;
                case 2://Apple
                case 3://Android
                   $sql .= " WHERE cDeviceSpecific = ".mysqli_real_escape_string($this->db->conn_id, $deviceID);
                   break; 
            }
        }*/
        
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
    	
    	$dataset = array();
        
        foreach($dataArray as $categoryObj){
            $categoryGroup = array();
            $categoryGroup['category'] = $categoryObj->category;
            $categoryGroup['questions'] = $this->getAllQuestions($deviceID, $categoryObj->id);
            array_push($dataset,$categoryGroup);
            
        }
        
        return $dataset;
    }
    
    function getAllQuestions($testsheetID, $categoryID = 1){
    	$sql = 'SELECT '
                . ' q.idQuestion AS `id`,'
                . ' q.qTitle AS `title`,'
                . ' tsq.idTestSheetQuestion AS `idTestSheetQuestion`,'
                . ' tsq.tsqStatus AS `status` '
                . 'FROM '
                . 'Question q '
                . 'LEFT JOIN TestSheetQuestion tsq '
                . 'ON tsq.tsqIdQuestion = q.idQuestion '
                . 'LEFT JOIN Category c '
                . 'ON q.qIdCategory = c.idCategory '
                . 'WHERE tsq.tsqIdTestSheet = %1$d ';
    	
        $sql = sprintf($sql, $testsheetID, $categoryID);
        
        if(isset($categoryID)){
            $sql .= " AND q.qIdCategory = ".mysqli_real_escape_string($this->db->conn_id, $categoryID);
        }
        
        //echo $sql;
        
    	$res = $this->db->query($sql);
    	
    	$dataArray = array();
    	if ($res->num_rows() > 0)
    	{
            foreach ($res->result() as $row)
            {
                $row->responses = false;
                $row->responses = $this->getResponsesForTestSheetQuestion($row->idTestSheetQuestion);
                array_push($dataArray, $row);
            }
    	} else {
            return false;
    	}
    	
    	return $dataArray;
    }
    
    function getResponsesForTestSheetQuestion($testSheetQuestionId){
        $sql = 'SELECT '
                . ' r.idResponse AS `id`,'
                . ' r.rContent AS `content`,'
                . ' u.uEmail AS `email`, '
                . ' u.idUser as `userID`'
                . 'FROM Response r '
                . 'LEFT JOIN `user` u '
                . 'ON r.rIdUser = u.idUser '
                . 'WHERE '
                . 'r.rIdTestSheetQuestion = %1$d '
                . 'ORDER BY '
                . 'r.rOrder ASC';
        
        $sql = sprintf($sql, $testSheetQuestionId);
        
        $query = $this->db->query($sql);
        $responseArray = array();
        if ($query->num_rows() > 0)
    	{
            foreach ($query->result() as $row)
            {
                    array_push($responseArray, $row);
            }
            return $responseArray;
    	} else {
            return false;
    	}
        
        
    }
    
    function insertNewQuestion($title,$deviceId,$categoryId){
		
   	
    	$sql = "INSERT INTO `Question` (qDescription, qDateInserted,qIdDevice,qIdCategory) VALUES ( ";
		$sql .= ' \'%1$s\' , NOW(),%2$s,%3$s ';
    	$sql .= " ) ";
    	
    	$sql = sprintf($sql, mysqli_real_escape_string($this->db->conn_id, $title),$deviceId,$categoryId);
    	$query= $this->db->query($sql);
    	
    	if(!$query){
            return false;
    	} else {
            return true;
    	}
    }
    
    function deleteCustomQuestion($questionID){
        
        $this->db->trans_start();
        $sql = 'DELETE FROM Response WHERE rIdTestSheetQuestion = %1$d ';
    	
    	$sql = sprintf($sql, mysqli_real_escape_string($this->db->conn_id, $questionID));
    	$query= $this->db->query($sql);
    	
    	$sql = 'DELETE FROM TestSheetQuestion WHERE tsqIdQuestion = %1$d ';
    	
    	$sql = sprintf($sql, mysqli_real_escape_string($this->db->conn_id, $questionID));
    	$query= $this->db->query($sql);
        
        $sql = 'DELETE FROM Question WHERE idQuestion = %1$d ';
    	
    	$sql = sprintf($sql, mysqli_real_escape_string($this->db->conn_id, $questionID));
    	$query= $this->db->query($sql);
        
        $this->db->trans_complete();
        
        return true;
    }
}

?>