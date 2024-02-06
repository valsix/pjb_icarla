<? 
  include_once(APPPATH.'/models/Entity.php');

  class PerusahaanEksternal extends Entity{ 

	var $query;

    function PerusahaanEksternal()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PERUSAHAAN_EKSTERNAL_ID", $this->getNextId("PERUSAHAAN_EKSTERNAL_ID","perusahaan_eksternal"));

    	$str = "
    	INSERT INTO perusahaan_eksternal
    	(
    		PERUSAHAAN_EKSTERNAL_ID, NAMA, KODE
    	)
    	VALUES 
    	(
	    	'".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    )"; 

		$this->id= $this->getField("PERUSAHAAN_EKSTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE perusahaan_eksternal
		SET
		NAMA= '".$this->getField("NAMA")."'
		, KODE= '".$this->getField("KODE")."'
		WHERE PERUSAHAAN_EKSTERNAL_ID = '".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM perusahaan_eksternal
		WHERE 
		PERUSAHAAN_EKSTERNAL_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $perusahaan_eksternalment='', $sOrder="ORDER BY PERUSAHAAN_EKSTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM perusahaan_eksternal A 
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $perusahaan_eksternalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

  } 
?>