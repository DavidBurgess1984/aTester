<?php 
class Project_model extends CI_Model {

    function __construct()
    {
        parent::__construct();;
    }
    
    function getCollaborationID($projectID){
        $sql = ' SELECT idCollaboration as `collaborationID` FROM Collaboration WHERE cIdProject = %1$d';
        
        $sql = sprintf($sql, $projectID);
        
        $query = $this->db->query($sql);
        
        $result = $query->row();
        
        return $result->collaborationID;
    }
    
    function getCollaborators($userID, $projectID){
        
        
        $sql = '
                    SELECT 
                        u.idUser as \'id\',
                        u.uEmail as \'email\'
                        
                    FROM 
                        UserCollaboration uc
                    INNER JOIN Collaboration c
                        ON c.idCollaboration = uc.ucIdCollaboration
                    INNER JOIN user u
                        ON u.idUser = uc.ucIdUser
                    WHERE c.cIdProject = %2$d AND uc.ucIdUser != %1$d';
    	
        $sql = sprintf($sql,intval(mysqli_real_escape_string($this->db->conn_id,$userID)),$projectID);
    	
        //echo $sql;
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
    
    function insertNewProject($title, $manager,$company,$desc, $deadline){
		
   	$title = mysqli_real_escape_string($this->db->conn_id,$title);
        $manager = intval(mysqli_real_escape_string($this->db->conn_id,$manager));
        $company = mysqli_real_escape_string($this->db->conn_id,$company);
        
        if(isset($company) && strlen($company) >0){
            $company = "'".mysqli_real_escape_string($this->db->conn_id,$company)."'";
        } else{
            $company = 'NULL';
        }

        $desc = mysqli_real_escape_string($this->db->conn_id,$desc);

        $deadline = mysqli_real_escape_string($this->db->conn_id,$deadline);
        
    	$sql = "INSERT INTO `Project` (pName,pUserManager,pCompany,pDescription,pDeadline, pDateInserted,pStatus) VALUES ( ";
		$sql .= ' \'%1$s\' ,%2$s,%3$s,\'%4$s\',\'%5$s\',NOW(),0 ';
    	$sql .= " ) ";
    	
    	$sql = sprintf($sql, $title,$manager,$company,$desc,$deadline);
    	$query= $this->db->query($sql);
    	
    	if(!$query){
    		return false;
    	} else {
    		return true;
    	}
    }
    
    public function getProjectsForUser($userID){
        $sql = 'SELECT 
                    idProject as `id`,
                    pName as `title`
                FROM
                    Project p
                   INNER JOIN
                Collaboration c
                    ON c.cIdProject = p.idProject
                INNER JOIN
                    UserCollaboration uc
                ON c.idCollaboration = uc.ucIdCollaboration
                WHERE uc.ucIdUser = %1$d 
               
                    UNION DISTINCT 
                SELECT idProject as `id`,
                    pName as `title`
                FROM
                    Project WHERE pUserManager =%1$d ';
    	
        $sql = sprintf($sql,intval(mysqli_real_escape_string($this->db->conn_id,$userID)));
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
    
    public function getProjectManager($projectID){
        $sql = 'SELECT 
                    u.idUser AS `id`,
                    u.uEmail AS `email`
                FROM
                    Project p
                INNER JOIN
                    user u
                ON p.pUserManager = u.idUser
                WHERE idProject = %1$d ';
        
        $sql = sprintf($sql,$projectID);
    	$res = $this->db->query($sql);

    	if ($res->num_rows() > 0)
    	{
    		$row = $res->row();
    		
    	} else {
    		return false;
    	}
    	
    	return $row;
    }
    
    public function getProject($projectID){
        $sql = 'SELECT 
                    idProject as `id`,
                    pName as `title`,
                    pStatus AS `statusID`,
                    CASE pStatus WHEN 0 THEN "Open" WHEN 1 THEN "Closed" END AS `status`,
                    pDeadline as `deadline`
                FROM
                    Project 
                WHERE idProject = %1$d ';
    	
        $sql = sprintf($sql,$projectID);
    	$res = $this->db->query($sql);

    	if ($res->num_rows() > 0)
    	{
    		$row = $res->row();
    		
    	} else {
    		return false;
    	}
    	
    	return $row;
    
    }
}

?>