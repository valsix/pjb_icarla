<? 
  include_once(APPPATH.'/models/Entity.php');

  class TipePengukuran extends Entity{ 

	var $query;

    function TipePengukuran()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("TIPE_PENGUKURAN_ID", $this->getNextId("TIPE_PENGUKURAN_ID","tipe_pengukuran"));

    	$str = "
    	INSERT INTO tipe_pengukuran
    	(
    		TIPE_PENGUKURAN_ID, NAMA
    	)
    	VALUES 
    	(
	    	".$this->getField("TIPE_PENGUKURAN_ID")."
	    	, '".$this->getField("NAMA")."'
	    )"; 

		$this->id= $this->getField("TIPE_PENGUKURAN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE tipe_pengukuran
		SET
		TIPE_PENGUKURAN_ID= ".$this->getField("TIPE_PENGUKURAN_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		WHERE TIPE_PENGUKURAN_ID = '".$this->getField("TIPE_PENGUKURAN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM tipe_pengukuran
		WHERE 
		TIPE_PENGUKURAN_ID = ".$this->getField("TIPE_PENGUKURAN_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $tipe_pengukuranment='', $sOrder="ORDER BY TIPE_PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM tipe_pengukuran A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $tipe_pengukuranment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsCombo($paramsArray=array(),$limit=-1,$from=-1, $tipe_pengukuranment='', $sOrder="ORDER BY TIPE_PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
		 '0' TIPE_INPUT_ID
		 , 'Binary' NAMA
		 , '0' TIPE_PENGUKURAN_ID
		 , 'Binary' NAMA_TIPE_PENGUKURAN
		WHERE 1=1
		UNION ALL
		SELECT 
			A.TIPE_INPUT_ID,A.NAMA
			,B.TIPE_PENGUKURAN_ID
			,B.NAMA_TIPE_PENGUKURAN
		FROM tipe_input A
		INNER JOIN 
		(
			SELECT B.TIPE_INPUT_ID
			,STRING_AGG(A.TIPE_PENGUKURAN_ID::text, ', ') AS TIPE_PENGUKURAN_ID
			,STRING_AGG(A.NAMA, ', ') AS NAMA_TIPE_PENGUKURAN
			FROM TIPE_PENGUKURAN A
			INNER JOIN TIPE_INPUT_DETAIL B ON B.TIPE_PENGUKURAN_ID = A.TIPE_PENGUKURAN_ID 
			GROUP BY B.TIPE_INPUT_ID
		) B ON B.TIPE_INPUT_ID = A.TIPE_INPUT_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $tipe_pengukuranment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function getCountByParamsTree($paramsArray=array(), $statement='')
    {
    	$str = "
    	SELECT COUNT(1) AS ROWCOUNT
    	FROM 
    	TIPE_PENGUKURAN A
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