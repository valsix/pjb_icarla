<? 
  include_once(APPPATH.'/models/Entity.php');

  class MeasuringTools extends Entity{ 

	var $query;

    function MeasuringTools()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("MEASURING_TOOLS_ID", $this->getNextId("MEASURING_TOOLS_ID","measuring_tools"));

    	$str = "
    	INSERT INTO measuring_tools
    	(
    		MEASURING_TOOLS_ID,KODE,NAMA,STATUS
    	)
    	VALUES 
    	(
	    	".$this->getField("MEASURING_TOOLS_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    )"; 

		$this->id= $this->getField("MEASURING_TOOLS_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE measuring_tools
		SET
		MEASURING_TOOLS_ID= ".$this->getField("MEASURING_TOOLS_ID")."
		, KODE= '".$this->getField("KODE")."'
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		WHERE MEASURING_TOOLS_ID = '".$this->getField("MEASURING_TOOLS_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM measuring_tools
		WHERE 
		MEASURING_TOOLS_ID = ".$this->getField("MEASURING_TOOLS_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY MEASURING_TOOLS_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
		FROM measuring_tools A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $unitment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

  } 
?>