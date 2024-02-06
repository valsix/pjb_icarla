<? 
  include_once(APPPATH.'/models/Entity.php');

  class TipeInput extends Entity{ 

	var $query;

    function TipeInput()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("TIPE_INPUT_ID", $this->getNextId("TIPE_INPUT_ID","tipe_input"));

    	$str = "
    	INSERT INTO tipe_input
    	(
    		TIPE_INPUT_ID,NAMA, STATUS, FUNCTION_INPUT, KETERANGAN,STATUS_TABLE
    	)
    	VALUES 
    	(
	    	".$this->getField("TIPE_INPUT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("FUNCTION_INPUT")."'
	    	, '".$this->getField("KETERANGAN")."'
	    	, '".$this->getField("STATUS_TABLE")."'
	    )"; 

		$this->id= $this->getField("TIPE_INPUT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertdetail()
    {
    	$this->setField("TIPE_INPUT_DETAIL_ID", $this->getNextId("TIPE_INPUT_DETAIL_ID","tipe_input_detail"));

    	$str = "
    	INSERT INTO tipe_input_detail
    	(
    		TIPE_INPUT_DETAIL_ID,TIPE_INPUT_ID,TIPE_PENGUKURAN_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("TIPE_INPUT_DETAIL_ID")."
	    	, ".$this->getField("TIPE_INPUT_ID")."
	    	, ".$this->getField("TIPE_PENGUKURAN_ID")."
	    	
	    )"; 

		$this->id= $this->getField("TIPE_INPUT_DETAIL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE tipe_input
		SET
		TIPE_INPUT_ID= ".$this->getField("TIPE_INPUT_ID")."
		, STATUS= '".$this->getField("STATUS")."'
		, NAMA= '".$this->getField("NAMA")."'
		, FUNCTION_INPUT= '".$this->getField("FUNCTION_INPUT")."'
		, KETERANGAN= '".$this->getField("KETERANGAN")."'
		, STATUS_TABLE= '".$this->getField("STATUS_TABLE")."'
		WHERE TIPE_INPUT_ID = '".$this->getField("TIPE_INPUT_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM tipe_input
		WHERE 
		TIPE_INPUT_ID = ".$this->getField("TIPE_INPUT_ID")."
		;";

		$str .= "
		DELETE FROM tipe_input_detail
		WHERE 
		TIPE_INPUT_ID = ".$this->getField("TIPE_INPUT_ID")."
		"; 
 

	$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedetail()
	{
		$str = "
		DELETE FROM tipe_input_detail
		WHERE 
		TIPE_INPUT_ID = ".$this->getField("TIPE_INPUT_ID").""; 

	$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $jabatanment='', $sOrder="ORDER BY TIPE_INPUT_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
			,B.TIPE_PENGUKURAN_ID_INFO
			,B.NAMA_TIPE_PENGUKURAN
		FROM tipe_input A
		LEFT JOIN 
		(
			SELECT B.TIPE_INPUT_ID
			,STRING_AGG(A.TIPE_PENGUKURAN_ID::text, ', ') AS TIPE_PENGUKURAN_ID_INFO
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
		
		$str .= $jabatanment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsComboLawas($paramsArray=array(),$limit=-1,$from=-1, $tipe_pengukuranment='', $sOrder="ORDER BY TIPE_PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
		 '0' TIPE_INPUT_ID
		 , 'Binary' NAMA
		 , '0' TIPE_PENGUKURAN_ID
		 , 'Binary' NAMA_TIPE_PENGUKURAN
		 , 'BINARY' STATUS_TABLE
		WHERE 1=1
		UNION ALL
		SELECT 
			A.TIPE_INPUT_ID
			,A.NAMA
			,B.TIPE_PENGUKURAN_ID
			,B.NAMA_TIPE_PENGUKURAN
			,A.STATUS_TABLE
		FROM tipe_input A
		LEFT JOIN 
		(
			SELECT B.TIPE_INPUT_ID
			,STRING_AGG(A.TIPE_PENGUKURAN_ID::text, ', ') AS TIPE_PENGUKURAN_ID
			,STRING_AGG(A.NAMA, ', ') AS NAMA_TIPE_PENGUKURAN
			FROM TIPE_PENGUKURAN A
			LEFT JOIN TIPE_INPUT_DETAIL B ON B.TIPE_PENGUKURAN_ID = A.TIPE_PENGUKURAN_ID 
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


    function selectByParamsCombo($paramsArray=array(),$limit=-1,$from=-1, $tipe_pengukuranment='', $sOrder="ORDER BY TIPE_PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
			A.TIPE_INPUT_ID
			,A.NAMA
			,B.TIPE_PENGUKURAN_ID
			,B.NAMA_TIPE_PENGUKURAN
			,A.STATUS_TABLE
		FROM tipe_input A
		LEFT JOIN 
		(
			SELECT B.TIPE_INPUT_ID
			,STRING_AGG(A.TIPE_PENGUKURAN_ID::text, ', ') AS TIPE_PENGUKURAN_ID
			,STRING_AGG(A.NAMA, ', ') AS NAMA_TIPE_PENGUKURAN
			FROM TIPE_PENGUKURAN A
			LEFT JOIN TIPE_INPUT_DETAIL B ON B.TIPE_PENGUKURAN_ID = A.TIPE_PENGUKURAN_ID 
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

    function selectByParamsCetak($paramsArray=array(),$limit=-1,$from=-1, $tipe_pengukuranment='', $sOrder="ORDER BY TIPE_PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
		 '0' TIPE_INPUT_ID
		 , 'Binary' NAMA
		 , '0' TIPE_PENGUKURAN_ID
		 , 'Binary' NAMA_TIPE_PENGUKURAN
		 , '' FUNCTION_INPUT
		 , '' KETERANGAN
		WHERE 1=1
		UNION ALL
		SELECT 
			A.TIPE_INPUT_ID
			,A.NAMA
			,B.TIPE_PENGUKURAN_ID
			,B.NAMA_TIPE_PENGUKURAN
			,A.FUNCTION_INPUT
			,A.KETERANGAN
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

  } 
?>