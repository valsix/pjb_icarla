<? 
include_once(APPPATH.'/models/Entity.php');

class WorkRequest extends Entity { 

	var $query;

    function WorkOrder()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("WORK_REQUEST_ID", $this->getNextId("WORK_REQUEST_ID","WORK_REQUEST"));

    	$str = "
    	INSERT INTO WORK_REQUEST
    	(
    		WORK_REQUEST_ID, ASSET_NUM, DESCRIPTION, OPRGROUP, FAULTTYPE,STATUS,SITE_ID,EQUIPMENT_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("WORK_REQUEST_ID")."
	    	, '".$this->getField("ASSET_NUM")."'
	    	, '".$this->getField("DESCRIPTION")."'
	    	, '".$this->getField("OPRGROUP")."'
	    	, '".$this->getField("FAULTTYPE")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("SITE_ID")."'
	    	, ".$this->getField("EQUIPMENT_ID")."
	    )"; 

		$this->id= $this->getField("WORK_REQUEST_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
			UPDATE WORK_REQUEST
			SET
			ASSET_NUM= '".$this->getField("ASSET_NUM")."'
			, DESCRIPTION= '".$this->getField("DESCRIPTION")."'
			, OPRGROUP= '".$this->getField("OPRGROUP")."'
			, FAULTTYPE= '".$this->getField("FAULTTYPE")."'
			, STATUS= '".$this->getField("STATUS")."'
			, SITE_ID= '".$this->getField("SITE_ID")."'
			, EQUIPMENT_ID= ".$this->getField("EQUIPMENT_ID")."
			WHERE ASSET_NUM = '".$this->getField("ASSET_NUM")."'
		"; 

		$this->query = $str;
		// echo $str;exit;

		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY WO ASC")
	{
		$str = "
			SELECT 
				A.*
			FROM WORK_REQUEST A 
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