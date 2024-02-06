<? 
  include_once(APPPATH.'/models/Entity.php');

  class Nameplate extends Entity{ 

	var $query;

    function Nameplate()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("NAMEPLATE_ID", $this->getNextId("NAMEPLATE_ID","nameplate"));

    	$str = "
    	INSERT INTO nameplate
    	(
    		NAMEPLATE_ID,NAMA,STATUS
    	)
    	VALUES 
    	(
	    	".$this->getField("NAMEPLATE_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    )"; 

		$this->id= $this->getField("NAMEPLATE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function insertdetil()
    {
    	$this->setField("NAMEPLATE_DETIL_ID", $this->getNextId("NAMEPLATE_DETIL_ID","nameplate_detil"));

    	$str = "
    	INSERT INTO nameplate_detil
    	(
    		NAMEPLATE_DETIL_ID,NAMEPLATE_ID,NAMA,NAMA_TABEL,STATUS,ISI
    	)
    	VALUES 
    	(
    		".$this->getField("NAMEPLATE_DETIL_ID")."
	    	, ".$this->getField("NAMEPLATE_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("NAMA_TABEL")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("ISI")."'
	    )"; 

		$this->id= $this->getField("NAMEPLATE_DETIL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE nameplate
		SET
		NAMEPLATE_ID= ".$this->getField("NAMEPLATE_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		WHERE NAMEPLATE_ID = '".$this->getField("NAMEPLATE_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatedetil()
	{
		$str = "
		UPDATE nameplate_detil
		SET
		NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		,  NAMA_TABEL= '".$this->getField("NAMA_TABEL")."'
		,  ISI= '".$this->getField("ISI")."'
		WHERE NAMEPLATE_DETIL_ID = '".$this->getField("NAMEPLATE_DETIL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM nameplate
		WHERE 
		NAMEPLATE_ID = ".$this->getField("NAMEPLATE_ID").";";
		$str .= "
		DELETE FROM nameplate_detil
		WHERE 
		NAMEPLATE_ID = ".$this->getField("NAMEPLATE_ID").";
		";  

		$this->query = $str;
		return $this->execQuery($str);
	}


    function deletedetil()
	{
		$str = "
		DELETE FROM nameplate_detil
		WHERE 
		NAMEPLATE_ID = ".$this->getField("NAMEPLATE_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function deletedetiltabel()
	{
		$str = "
		DELETE FROM nameplate_detil
		WHERE 
		NAMEPLATE_ID = ".$this->getField("NAMEPLATE_ID")."
		AND NAMEPLATE_DETIL_ID = ".$this->getField("NAMEPLATE_DETIL_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY NAMEPLATE_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
		FROM nameplate A
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

    function selectByParamsDetil($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY NAMEPLATE_DETIL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM NAMEPLATE_DETIL A
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

    function selectByParamsCheckTabel($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="",$sTabel='')
	{
		$str = "
		SELECT 
			A.*
		FROM ".$sTabel." A
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

    function selectByParamsCheckColumn($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="",$sTabel='')
	{
		$str = "
		SELECT *
		FROM information_schema.columns
		WHERE table_schema = 'public'
		AND table_name   = '".$sTabel."' 
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckTabelCount($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="",$sTabel='')
	{
		$str = "
		SELECT 
			COUNT(1) AS ROWCOUNT
		FROM ".$sTabel." A
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