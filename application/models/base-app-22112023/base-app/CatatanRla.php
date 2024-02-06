<? 
include_once(APPPATH.'/models/Entity.php');

class CatatanRla extends Entity { 

	var $query;

    function CatatanRla()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("CATATAN_RLA_ID", $this->getNextId("CATATAN_RLA_ID","CATATAN_RLA"));

    	$str = "
    	INSERT INTO CATATAN_RLA
    	(
    		CATATAN_RLA_ID, NAMA, TANGGAL, CATATAN, PLAN_RLA_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("CATATAN_RLA_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("TANGGAL")."
	    	, '".$this->getField("CATATAN")."'
	    	, ".$this->getField("PLAN_RLA_ID")."
	    )"; 

		$this->id= $this->getField("CATATAN_RLA_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
			UPDATE CATATAN_RLA
			SET
			NAMA= '".$this->getField("NAMA")."'
			, TANGGAL= ".$this->getField("TANGGAL")."
			, CATATAN= '".$this->getField("CATATAN")."'
			, PLAN_RLA_ID= ".$this->getField("PLAN_RLA_ID")."
			WHERE CATATAN_RLA_ID = '".$this->getField("CATATAN_RLA_ID")."'
		"; 

		$this->query = $str;
		// echo $str;exit;

		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
			DELETE FROM CATATAN_RLA
			WHERE 
			CATATAN_RLA_ID = ".$this->getField("CATATAN_RLA_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY CATATAN_RLA_ID ASC")
	{
		$str = "
			SELECT 
				A.*
			FROM CATATAN_RLA A 
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