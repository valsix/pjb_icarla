<? 
  include_once(APPPATH.'/models/Entity.php');

  class Uom extends Entity{ 

	var $query;

    function Uom()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("UOM_ID", $this->getNextId("UOM_ID","uom"));

    	$str = "
    	INSERT INTO uom
    	(
    		UOM_ID,NAMA, STATUS, FUNCTION_INPUT, KETERANGAN
    	)
    	VALUES 
    	(
	    	".$this->getField("UOM_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("FUNCTION_INPUT")."'
	    	, '".$this->getField("KETERANGAN")."'
	    )"; 

		$this->id= $this->getField("UOM_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function update()
	{
		$str = "
		UPDATE uom
		SET
		UOM_ID= ".$this->getField("UOM_ID")."
		, STATUS= '".$this->getField("STATUS")."'
		, NAMA= '".$this->getField("NAMA")."'
		, FUNCTION_INPUT= '".$this->getField("FUNCTION_INPUT")."'
		, KETERANGAN= '".$this->getField("KETERANGAN")."'
		WHERE UOM_ID = '".$this->getField("UOM_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM uom
		WHERE 
		UOM_ID = ".$this->getField("UOM_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}



    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $jabatanment='', $sOrder="ORDER BY UOM_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
		FROM uom A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $jabatanment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

  } 
?>