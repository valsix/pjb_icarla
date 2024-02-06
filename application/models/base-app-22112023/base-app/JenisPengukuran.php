<? 
  include_once(APPPATH.'/models/Entity.php');

  class JenisPengukuran extends Entity{ 

	var $query;

    function JenisPengukuran()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("JENIS_PENGUKURAN_ID", $this->getNextId("JENIS_PENGUKURAN_ID","jenis_pengukuran"));

    	$str = "
    	INSERT INTO jenis_pengukuran
    	(
    		JENIS_PENGUKURAN_ID,FORM_UJI_ID, KODE, NAMA, REFERENSI, CATATAN
    	)
    	VALUES 
    	(
	    	".$this->getField("JENIS_PENGUKURAN_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("REFERENSI")."'
	    	, '".$this->getField("CATATAN")."'
	    )"; 

		$this->id= $this->getField("JENIS_PENGUKURAN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE jenis_pengukuran
		SET
		JENIS_PENGUKURAN_ID= ".$this->getField("JENIS_PENGUKURAN_ID")."
		, FORM_UJI_ID= ".$this->getField("FORM_UJI_ID")."
		, KODE= '".$this->getField("KODE")."'
		, NAMA= '".$this->getField("NAMA")."'
		, REFERENSI= '".$this->getField("REFERENSI")."'
		, CATATAN= '".$this->getField("CATATAN")."'
		WHERE JENIS_PENGUKURAN_ID = '".$this->getField("JENIS_PENGUKURAN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM jenis_pengukuran
		WHERE 
		JENIS_PENGUKURAN_ID = ".$this->getField("JENIS_PENGUKURAN_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $jenis_pengukuranment='', $sOrder="ORDER BY JENIS_PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA FORM_NAMA,B.KODE || '-' || B.NAMA FORM_INFO
		FROM jenis_pengukuran A
		LEFT JOIN FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $jenis_pengukuranment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function getCountByParamsTree($paramsArray=array(), $statement='')
    {
    	$str = "
    	SELECT COUNT(1) AS ROWCOUNT
    	FROM 
    	JENIS_PENGUKURAN A
    	WHERE 1=1

    	".$statement;
    	while(list($key,$val)=each($paramsArray))
    	{
    		$str .= " AND $key = '$val' ";
    	}
    	$this->query = $str;
    	$this->select($str); 

    	if($this->firstRow()) 
    		return $this->getField("ROWCOUNT"); 
    	else 
    		return 0; 
    }

  } 
?>