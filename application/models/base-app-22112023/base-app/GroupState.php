<? 
include_once(APPPATH.'/models/Entity.php');

class GroupState extends Entity { 

	var $query;

    function GroupState()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("GROUP_STATE_ID", $this->getNextId("GROUP_STATE_ID","GROUP_STATE"));

    	$str = "
    	INSERT INTO GROUP_STATE
    	(
    		GROUP_STATE_ID, NAMA, STATUS
    	)
    	VALUES 
    	(
	    	'".$this->getField("GROUP_STATE_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    )"; 

		$this->id= $this->getField("GROUP_STATE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE GROUP_STATE
		SET
		NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'

		WHERE GROUP_STATE_ID = '".$this->getField("GROUP_STATE_ID")."'
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM GROUP_STATE
		WHERE 
		GROUP_STATE_ID = ".$this->getField("GROUP_STATE_ID").";
		"; 


		$str .= "
		DELETE FROM GROUP_STATE_DETAIL
		WHERE 
		GROUP_STATE_ID = ".$this->getField("GROUP_STATE_ID")."
		"; 

		// echo $str;exit;

		$this->query = $str;
		return $this->execQuery($str);
	}

	function insertDetail()
    {
    	$this->setField("GROUP_STATE_DETAIL_ID", $this->getNextId("GROUP_STATE_DETAIL_ID","GROUP_STATE_DETAIL"));

    	$str = "
    	INSERT INTO GROUP_STATE_DETAIL
    	(
    		GROUP_STATE_DETAIL_ID, GROUP_STATE_ID, STATE_ID, TIPE, URUT
    	)
    	VALUES 
    	(
	    	'".$this->getField("GROUP_STATE_DETAIL_ID")."'
	    	, '".$this->getField("GROUP_STATE_ID")."'
	    	, '".$this->getField("STATE_ID")."'
	    	, '".$this->getField("TIPE")."'
	    	, '".$this->getField("URUT")."'
	    )"; 

		$this->id= $this->getField("GROUP_STATE_DETAIL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateDetail()
	{
		$str = "
		UPDATE GROUP_STATE_DETAIL
		SET
		GROUP_STATE_ID= '".$this->getField("GROUP_STATE_ID")."'
		, STATE_ID= '".$this->getField("STATE_ID")."'
		, TIPE= '".$this->getField("TIPE")."'
		, URUT= '".$this->getField("URUT")."'

		WHERE GROUP_STATE_DETAIL_ID = '".$this->getField("GROUP_STATE_DETAIL_ID")."'
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deleteDetail()
	{
		$str = "
		DELETE FROM GROUP_STATE_DETAIL
		WHERE 
		GROUP_STATE_DETAIL_ID = ".$this->getField("GROUP_STATE_DETAIL_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY GROUP_STATE_ID ASC")
	{
		$str = "
			SELECT 
				A.*
				, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
			FROM GROUP_STATE A 
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

	function selectByParamsDetail($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY GROUP_STATE_DETAIL_ID ASC")
	{
		$str = "
			SELECT 
				A.*
				, B.NAMA NAMA_GROUP_STATE, C.NAMA NAMA_STATE
				, CASE WHEN A.TIPE = '2' THEN 'Alarm' ELSE 'Normal' END INFO_TIPE
			FROM GROUP_STATE_DETAIL A 
			LEFT JOIN GROUP_STATE B ON B.GROUP_STATE_ID = A.GROUP_STATE_ID
			LEFT JOIN STATE C ON C.STATE_ID = A.STATE_ID
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