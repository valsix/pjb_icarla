<? 
  include_once(APPPATH.'/models/Entity.php');

  class State extends Entity{ 

	var $query;

    function State()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("STATE_ID", $this->getNextId("STATE_ID","state"));

    	$str = "
    	INSERT INTO state
    	(
    		STATE_ID, NAMA, STATUS,TIPE_INPUT_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("STATE_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("TIPE_INPUT_ID")."
	    )"; 

	    $this->id= $this->getField("STATE_ID");
	    $this->query= $str;
					// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE state
		SET
		NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, TIPE_INPUT_ID= ".$this->getField("TIPE_INPUT_ID")."
		WHERE STATE_ID = '".$this->getField("STATE_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM state
		WHERE 
		STATE_ID = ".$this->getField("STATE_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY STATE_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
			, B.NAMA TIPE_INPUT_NAMA
		FROM state A 
		LEFT JOIN 
		(
				SELECT 
				 '0' TIPE_INPUT_ID
				 , 'Binary' NAMA
				UNION ALL
				SELECT TIPE_INPUT_ID,NAMA
				FROM
				TIPE_INPUT 
		) B  ON B.TIPE_INPUT_ID = A.TIPE_INPUT_ID
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