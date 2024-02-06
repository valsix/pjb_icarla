<? 
  include_once(APPPATH.'/models/Entity.php');

  class Manufaktur extends Entity{ 

	var $query;

    function Manufaktur()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("MANUFAKTUR_ID", $this->getNextId("MANUFAKTUR_ID","manufaktur"));

    	$str = "
    	INSERT INTO manufaktur
    	(
    		MANUFAKTUR_ID,KODE,NAMA,STATUS
    	)
    	VALUES 
    	(
	    	".$this->getField("MANUFAKTUR_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    )"; 

		$this->id= $this->getField("MANUFAKTUR_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE manufaktur
		SET
		MANUFAKTUR_ID= ".$this->getField("MANUFAKTUR_ID")."
		, KODE= '".$this->getField("KODE")."'
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		WHERE MANUFAKTUR_ID = '".$this->getField("MANUFAKTUR_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM manufaktur
		WHERE 
		MANUFAKTUR_ID = ".$this->getField("MANUFAKTUR_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY MANUFAKTUR_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
		FROM manufaktur A
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