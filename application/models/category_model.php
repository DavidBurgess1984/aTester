<?php 
class Category_model extends CI_Model {

    function __construct()
    {
        parent::__construct();;
    }
    
    function loadAllCategories($testsheetID){
    	$sql = 'SELECT 
                    idCategory as \'id\',
                    cTitle as \'description\'
                FROM 
                    Category c
    	        LEFT JOIN
                    TestSheetTemplate tst ON c.cIdTestSheetTemplate = tst.idTestSheetTemplate
                LEFT JOIN
                    TestSheet ts ON ts.tsIdTestSheetTemplate = tst.idTestSheetTemplate
                WHERE ts.idTestSheet = %1$d ';
        
        $sql = sprintf($sql,$testsheetID);
        
        
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
    
    function loadAllCustomCategories($testsheetID){
    	$sql = 'SELECT 
                    idCategory as \'id\',
                    cTitle as \'description\'
                FROM 
                    Category c
    	     
                WHERE c.cIdTestSheet = %1$d';
        
        $sql = sprintf($sql,$testsheetID);
        
        
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
    
    function loadCategoryNameById($categoryID){
        
        $sql = 'SELECT cTitle AS `description` FROM Category where idCategory = %1$d';
        $sql = sprintf($sql,$categoryID);
    	$res = $this->db->query($sql);
    	
    	$dataArray = array();
    	if ($res->num_rows() > 0)
    	{
            $row = $res->row();	
    	} else {
            return false;
    	}
    	
    	return $row->description;
    }
    
    public function getCategoriesByTestSheet($testSheetID){
        
    }
    
    public function insertNewCategory($testsheetID, $text){
        
        $sql = "INSERT INTO `Category` (cTitle,cIdTestsheetTemplate,cIdTestsheet,cDateInserted) VALUES ( ";
		$sql .= ' \'%1$s\' ,255,%2$d,NOW() ';
    	$sql .= " ) ";
    	
    	$sql = sprintf($sql,$text,$testsheetID);
    	$query= $this->db->query($sql);
    	
    	if(!$query){
    		return false;
    	} else {
    		return true;
    	}
        
        
    }
    
    public function updateNewCategory($categoryID, $categoryTitle){
        
        $sql = 'UPDATE `Category` SET cTitle = \'%1$s\' WHERE idCategory = %2$d';
    	
    	$sql = sprintf($sql,$categoryTitle,$categoryID);
    	$query= $this->db->query($sql);
    	
    	if(!$query){
    		return false;
    	} else {
    		return true;
    	}
    }
        
    public function loadQuestionsByCategory($categoryID){
        $sql = 'SELECT 
                    idQuestion as `id`,
                    qTitle as `title`
                From Question
                WHERE qIdCategory = %1$d';
        
        $sql = sprintf($sql,$categoryID);
        
        
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


    public function insertNewQuestion($categoryID, $text, $testsheetID){
        
        $this->db->trans_start();
        $sql = "INSERT INTO `Question` (qTitle,qIsCustom,qDateInserted,qIdCategory) VALUES ( ";
		$sql .= ' \'%1$s\' ,1,NOW(), %2$d ';
    	$sql .= " ) ";
    	
    	$sql = sprintf($sql,$text,$categoryID);
    	$query= $this->db->query($sql);
        
        $qnID = $this->db->insert_id();
        
        $sql = "INSERT INTO `TestSheetQuestion` (tsqIdQuestion,tsqStatus,tsqDateInserted,tsqIdTestSheet) VALUES ( ";
		$sql .= ' %1$s ,0,NOW(),%2$d ';
    	$sql .= " ) ";
    	
    	$sql = sprintf($sql,$qnID, $testsheetID);
    	$query= $this->db->query($sql);
        
        $this->db->trans_complete();
    	
    	if(!$query){
    		return false;
    	} else {
    		return true;
    	}
        
        
    }
    
    public function updateQuestion($questionID, $questionTitle){
        
        $sql = 'UPDATE `Question` SET qTitle = \'%1$s\', qDateUpdated = NOW() WHERE idQuestion = %2$d';
    	
    	$sql = sprintf($sql,$questionTitle,$questionID);
    	$query= $this->db->query($sql);
    	
    	if(!$query){
    		return false;
    	} else {
    		return true;
    	}
    }
    
    public function deleteCategory($testsheetID, $categoryID){
        $this->db->trans_start();
            
            $sql = 'SELECT idQuestion as `id` FROM Question WHERE qIdCategory = %1$d ';
            $sql = sprintf($sql, mysqli_real_escape_string($this->db->conn_id, $categoryID));
            $query= $this->db->query($sql);
            
            $res = $this->db->query($sql);
    	
            $dataArray = array();
            if ($res->num_rows() > 0)
            {
                foreach ($res->result() as $row)
                {
                        array_push($dataArray, $row->id);
                }
            } else {
                $this->db->trans_complete();
                return true;
            }
            
            $questionIdStr = implode(',' , $dataArray);
            
            $sql = 'DELETE FROM Response WHERE rIdTestSheetQuestion IN ( %1$s) ';

            $sql = sprintf($sql, $questionIdStr);
            $query= $this->db->query($sql);

            $sql = 'DELETE FROM TestSheetQuestion WHERE tsqIdQuestion IN ( %1$s )';

            $sql = sprintf($sql, $questionIdStr);
            $query= $this->db->query($sql);

            $sql = 'DELETE FROM Question WHERE idQuestion IN ( %1$s ) ';

            $sql = sprintf($sql, mysqli_real_escape_string($this->db->conn_id, $questionIdStr));$sql = sprintf($sql, $questionIdStr);    $query= $this->db->query($sql);

            $sql = 'DELETE FROM Category WHERE idCategory = %1$d ';

            $sql = sprintf($sql,$categoryID);
            $query= $this->db->query($sql);
            
            $this->db->trans_complete();
        
        return true;
    }
}
?>