<? 
  include_once(APPPATH.'/models/Entity.php');

  class EnjiniringUnit extends Entity{ 

	var $query;

    function EnjiniringUnit()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("ENJINIRINGUNIT_ID", $this->getNextId("ENJINIRINGUNIT_ID","enjiniringunit"));

    	$str = "
    	INSERT INTO enjiniringunit
    	(
    		ENJINIRINGUNIT_ID, NAMA, STATUS, KODE
    	)
    	VALUES 
    	(
	    	'".$this->getField("ENJINIRINGUNIT_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("KODE")."'
	    )"; 

		$this->id= $this->getField("ENJINIRINGUNIT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE enjiniringunit
		SET
		NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, KODE= '".$this->getField("KODE")."'
		
		WHERE ENJINIRINGUNIT_ID = '".$this->getField("ENJINIRINGUNIT_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM enjiniringunit
		WHERE 
		ENJINIRINGUNIT_ID = ".$this->getField("ENJINIRINGUNIT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY ENJINIRINGUNIT_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
		FROM enjiniringunit A 
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