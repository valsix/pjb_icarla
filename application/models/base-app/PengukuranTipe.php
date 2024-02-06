<? 
  include_once(APPPATH.'/models/Entity.php');

  class PengukuranTipe extends Entity{ 

	var $query;

    function PengukuranTipe()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PENGUKURAN_TIPE_ID", $this->getNextId("PENGUKURAN_TIPE_ID","pengukuran_tipe"));

    	$str = "
    	INSERT INTO pengukuran_tipe
    	(
    		PENGUKURAN_TIPE_ID, PENGUKURAN_ID, TIPE_INPUT_DETAIL_ID, TIPE_INPUT_ID, 
            NAMA, ROWSPAN, COLSPAN, STATUS_TABEL, PENGUKURAN_TIPE_HEADER_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGUKURAN_TIPE_ID")."
	    	, ".$this->getField("PENGUKURAN_ID")."
	    	, ".$this->getField("TIPE_INPUT_DETAIL_ID")."
	    	, ".$this->getField("TIPE_INPUT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("ROWSPAN")."
	    	, ".$this->getField("COLSPAN")."
	    	, ".$this->getField("STATUS_TABEL")."
	    	, ".$this->getField("PENGUKURAN_TIPE_HEADER_ID")."
	    )"; 

		$this->id= $this->getField("PENGUKURAN_TIPE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertheader()
    {
    	// $this->setField("PENGUKURAN_TIPE_HEADER_ID", $this->getNextId("PENGUKURAN_TIPE_HEADER_ID","pengukuran_tipe_header"));

    	$str = "
    	INSERT INTO pengukuran_tipe_header
    	(
    		PENGUKURAN_TIPE_HEADER_ID, PENGUKURAN_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGUKURAN_TIPE_HEADER_ID")."
	    	, ".$this->getField("PENGUKURAN_ID")."
	    )"; 

		$this->id= $this->getField("PENGUKURAN_TIPE_HEADER_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE pengukuran_tipe
		SET
		 PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID")."
		, TIPE_INPUT_DETAIL_ID = ".$this->getField("TIPE_INPUT_DETAIL_ID")."
		, TIPE_INPUT_ID = ".$this->getField("TIPE_INPUT_ID")."
		, NAMA = '".$this->getField("NAMA")."'
		, ROWSPAN = ".$this->getField("ROWSPAN")."
		, COLSPAN = ".$this->getField("COLSPAN")."
		, STATUS_TABEL = ".$this->getField("STATUS_TABEL")."
		, PENGUKURAN_TIPE_HEADER_ID = ".$this->getField("PENGUKURAN_TIPE_HEADER_ID")."
		
		WHERE PENGUKURAN_TIPE_ID = '".$this->getField("PENGUKURAN_TIPE_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function delete()
	{
		$str = "
		DELETE FROM pengukuran_tipe
		WHERE 
		PENGUKURAN_TIPE_ID = ".$this->getField("PENGUKURAN_TIPE_ID")."
		;"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deleteheader()
	{
		$str = "
		DELETE FROM PENGUKURAN_TIPE_HEADER
		WHERE 
		PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID")."
		AND PENGUKURAN_TIPE_HEADER_ID = ".$this->getField("PENGUKURAN_TIPE_HEADER_ID")."
		;"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deleteallheader()
	{
		$str = "
		DELETE FROM PENGUKURAN_TIPE_HEADER
		WHERE 
		 PENGUKURAN_TIPE_HEADER_ID = ".$this->getField("PENGUKURAN_TIPE_HEADER_ID")."
		;";

		$str .= "
		DELETE FROM pengukuran_tipe
		WHERE 
		 PENGUKURAN_TIPE_HEADER_ID = ".$this->getField("PENGUKURAN_TIPE_HEADER_ID")."
		;"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function selectByParamsHeader($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT * 
		FROM PENGUKURAN_TIPE_HEADER A
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


    function selectByParamsHeaderIsi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT A.*, B.NAMA,B.ROWSPAN,B.COLSPAN,B.PENGUKURAN_TIPE_ID
		FROM PENGUKURAN_TIPE_HEADER A
		INNER JOIN PENGUKURAN_TIPE B ON B.PENGUKURAN_TIPE_HEADER_ID = A.PENGUKURAN_TIPE_HEADER_ID
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