<? 
  include_once(APPPATH.'/models/Entity.php');

  class TabelTemplate extends Entity{ 

	var $query;

    function TabelTemplate()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("TABEL_TEMPLATE_ID", $this->getNextId("TABEL_TEMPLATE_ID","tabel_template"));

    	$str = "
    	INSERT INTO tabel_template
    	(
    		TABEL_TEMPLATE_ID,NAMA, TOTAL,NOTE_ATAS,NOTE_BAWAH,STATUS
    	)
    	VALUES 
    	(
	    	".$this->getField("TABEL_TEMPLATE_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("TOTAL")."
	    	, '".$this->getField("NOTE_ATAS")."'
	    	, '".$this->getField("NOTE_BAWAH")."'
	    	, '".$this->getField("STATUS")."'
	    )"; 

		$this->id= $this->getField("TABEL_TEMPLATE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertdetil()
    {
    	$this->setField("TABEL_DETIL_ID", $this->getNextId("TABEL_DETIL_ID","tabel_detil"));

    	$str = "
    	INSERT INTO tabel_detil
    	(
    		TABEL_DETIL_ID, BARIS, TABEL_TEMPLATE_ID, 
            NAMA, ROWSPAN, COLSPAN
    	)
    	VALUES 
    	(
	    	".$this->getField("TABEL_DETIL_ID")."
	    	, ".$this->getField("BARIS")."
	    	, ".$this->getField("TABEL_TEMPLATE_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("ROWSPAN")."
	    	, ".$this->getField("COLSPAN")."
	    )"; 

		$this->id= $this->getField("TABEL_DETIL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function copy()
    {
    	$this->setField("TABEL_TEMPLATE_ID", $this->getNextId("TABEL_TEMPLATE_ID","tabel_template"));

    	$str = "
    	
    	INSERT INTO tabel_template
    	(
    		TABEL_TEMPLATE_ID, NAMA, TOTAL, 
            NOTE_ATAS, NOTE_BAWAH,STATUS
    	)
    	(
    		SELECT 
    		".$this->getField("TABEL_TEMPLATE_ID")." 
    		, '".$this->getField("NAMA")."'
    		, total
    		, note_atas 
    		, note_bawah
    		, '2' 
    		FROM tabel_template 
    		WHERE tabel_template_id = ".$this->getField("TABEL_ID")."
    	)
	    ;";

	    $str .= "

	    INSERT INTO tabel_detil
    	(
    		TABEL_DETIL_ID, BARIS, TABEL_TEMPLATE_ID, 
            NAMA, ROWSPAN, COLSPAN
    	)
    	(
    		SELECT 
    		 (
    		 SELECT COALESCE(MAX(TABEL_DETIL_ID),0) FROM tabel_detil ) + row_number() over (order by TABEL_DETIL_ID)
    		, BARIS
    		, ".$this->getField("TABEL_TEMPLATE_ID")." 
    		, NAMA 
    		, ROWSPAN
    		, COLSPAN 
    		FROM tabel_detil 
    		WHERE tabel_template_id = ".$this->getField("TABEL_ID")."
    	)

	    ;";  

		$this->id= $this->getField("TABEL_TEMPLATE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function copymaster()
    {
    	$this->setField("TABEL_TEMPLATE_ID", $this->getNextId("TABEL_TEMPLATE_ID","tabel_template"));

    	$str = "
    	
    	INSERT INTO tabel_template
    	(
    		TABEL_TEMPLATE_ID, NAMA, TOTAL, 
            NOTE_ATAS, NOTE_BAWAH,STATUS
    	)
    	(
    		SELECT 
    		".$this->getField("TABEL_TEMPLATE_ID")." 
    		, NAMA
    		, total
    		, note_atas 
    		, note_bawah
    		, '2'  
    		FROM tabel_template 
    		WHERE tabel_template_id = ".$this->getField("TABEL_ID")."
    	)
	    ;";

	    $str .= "

	    INSERT INTO tabel_detil
    	(
    		TABEL_DETIL_ID, BARIS, TABEL_TEMPLATE_ID, 
            NAMA, ROWSPAN, COLSPAN
    	)
    	(
    		SELECT 
    		 (
    		 SELECT COALESCE(MAX(TABEL_DETIL_ID),0) FROM tabel_detil ) + row_number() over (order by TABEL_DETIL_ID)
    		, BARIS
    		, ".$this->getField("TABEL_TEMPLATE_ID")." 
    		, NAMA 
    		, ROWSPAN
    		, COLSPAN 
    		FROM tabel_detil 
    		WHERE tabel_template_id = ".$this->getField("TABEL_ID")."
    	)

   
	    ;";  

		$this->id= $this->getField("TABEL_TEMPLATE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function update()
	{
		$str = "
		UPDATE tabel_template
		SET
		TABEL_TEMPLATE_ID= ".$this->getField("TABEL_TEMPLATE_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, TOTAL= ".$this->getField("TOTAL")."
		, NOTE_ATAS= '".$this->getField("NOTE_ATAS")."'
		, NOTE_BAWAH= '".$this->getField("NOTE_BAWAH")."'
		, STATUS= '".$this->getField("STATUS")."'
		WHERE TABEL_TEMPLATE_ID = '".$this->getField("TABEL_TEMPLATE_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updatedetil()
	{
		$str = "
		UPDATE tabel_detil
		SET
		TABEL_TEMPLATE_ID = ".$this->getField("TABEL_TEMPLATE_ID")."
		, BARIS = ".$this->getField("BARIS")."
		, NAMA = '".$this->getField("NAMA")."'
		, ROWSPAN = ".$this->getField("ROWSPAN")."
		, COLSPAN = ".$this->getField("COLSPAN")."
		
		WHERE TABEL_DETIL_ID = '".$this->getField("TABEL_DETIL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM tabel_template
		WHERE 
		TABEL_TEMPLATE_ID = ".$this->getField("TABEL_TEMPLATE_ID")."
		;";

		$str .= "
		DELETE FROM tabel_detil
		WHERE 
		TABEL_TEMPLATE_ID = ".$this->getField("TABEL_TEMPLATE_ID")."
		;";

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function deleteisi()
	{
		$str = "
		DELETE FROM tabel_detil
		WHERE 
		TABEL_TEMPLATE_ID = ".$this->getField("TABEL_TEMPLATE_ID")."
		AND TABEL_DETIL_ID = ".$this->getField("TABEL_DETIL_ID")."
		AND BARIS = ".$this->getField("BARIS")."
		;"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function deleteheader()
	{
		$str = "
		DELETE FROM tabel_detil
		WHERE 
		TABEL_TEMPLATE_ID = ".$this->getField("TABEL_TEMPLATE_ID")."
		AND BARIS = ".$this->getField("BARIS")."
		;"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $jabatanment='', $sOrder="ORDER BY TABEL_TEMPLATE_ID ASC")
	{
		$str = "
		SELECT A.*
		,
		CASE
		WHEN EXISTS (select master_tabel_id
		from pengukuran_tipe_input B
		where b.master_tabel_id = A.tabel_template_id)
		THEN '1'
		ELSE '0' 
		END PENGUKURAN_CHECK
		FROM tabel_template A
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

    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM tabel_template A
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

    function selectByParamsDetil($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY TABEL_DETIL_ID ASC")
	{
		$str = "
		SELECT A.*, B.NAMA NAMA_TEMPLATE,B.ROWSPAN,B.COLSPAN,B.TABEL_DETIL_ID,B.BARIS
		FROM TABEL_TEMPLATE A
		INNER JOIN TABEL_DETIL B ON B.TABEL_TEMPLATE_ID = A.TABEL_TEMPLATE_ID
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

    function selectByParamsMaxBaris($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT MAX(BARIS)  
		FROM TABEL_DETIL A  WHERE  1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDetilBaris($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT BARIS  
		FROM TABEL_DETIL A  WHERE  1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY BARIS ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT *  
		FROM TABEL_TEMPLATE A  
		WHERE  1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

   


  } 
?>