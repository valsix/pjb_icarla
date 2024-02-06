<? 
  include_once(APPPATH.'/models/Entity.php');

  class Distrik extends Entity{ 

	var $query;

    function Distrik()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("DISTRIK_ID", $this->getNextId("DISTRIK_ID","distrik"));

    	$str = "
    	INSERT INTO distrik
    	(
    		DISTRIK_ID, NAMA, KODE,PERUSAHAAN_EKSTERNAL_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("DISTRIK_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    )"; 

		$this->id= $this->getField("DISTRIK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE distrik
		SET
		NAMA= '".$this->getField("NAMA")."'
		, KODE= '".$this->getField("KODE")."'
		, PERUSAHAAN_EKSTERNAL_ID= ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
		WHERE DISTRIK_ID = '".$this->getField("DISTRIK_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM distrik
		WHERE 
		DISTRIK_ID = ".$this->getField("DISTRIK_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DISTRIK_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA NAMA_PERUSAHAAN
		FROM distrik A
		LEFT JOIN PERUSAHAAN_EKSTERNAL B ON  A.PERUSAHAAN_EKSTERNAL_ID = B.PERUSAHAAN_EKSTERNAL_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM distrik
		WHERE 1 = 1  "; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

  } 
?>