<? 
include_once(APPPATH.'/models/Entity.php');

class Eam extends Entity { 

	var $query;

    function Eam()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("EAM_ID", $this->getNextId("EAM_ID","EAM"));

    	$str = "
    	INSERT INTO EAM
    	(
    		EAM_ID, NAMA, KETERANGAN , URL, STATUS
    	)
    	VALUES 
    	(
	    	'".$this->getField("EAM_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KETERANGAN")."'
	    	, '".$this->getField("URL")."'
	    	, '".$this->getField("STATUS")."'
	    )"; 

		$this->id= $this->getField("EAM_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE EAM
		SET
		NAMA= '".$this->getField("NAMA")."'
		, KETERANGAN= '".$this->getField("KETERANGAN")."'
		, URL= '".$this->getField("URL")."'
		, STATUS= '".$this->getField("STATUS")."'

		WHERE EAM_ID = '".$this->getField("EAM_ID")."'
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM EAM
		WHERE 
		EAM_ID = ".$this->getField("EAM_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY EAM_ID ASC")
	{
		$str = "
			SELECT 
				A.*
				, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
			FROM EAM A 
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

} 
?>