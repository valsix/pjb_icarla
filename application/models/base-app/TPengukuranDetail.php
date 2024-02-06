<? 
include_once(APPPATH.'/models/Entity.php');

class TPengukuranDetail extends Entity { 

	var $query;

    function TPengukuranDetail()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("T_PENGUKURAN_DETAIL_ID", $this->getNextId("T_PENGUKURAN_DETAIL_ID","T_PENGUKURAN_DETAIL"));

    	$str = "
    	INSERT INTO T_PENGUKURAN_DETAIL
    	(
    		T_PENGUKURAN_DETAIL_ID, T_PENGUKURAN_ID, FORM_UJI_ID, JENIS_PENGUKURAN_ID,PLAN_RLA_ID, NAMA, HASIL, KOMENTAR_ID,STATUS
    	)
    	VALUES 
    	(
	    	".$this->getField("T_PENGUKURAN_DETAIL_ID")."
	    	, ".$this->getField("T_PENGUKURAN_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, ".$this->getField("JENIS_PENGUKURAN_ID")."
	    	, ".$this->getField("PLAN_RLA_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("HASIL")."'
	    	, ".$this->getField("KOMENTAR_ID")."
	    	, ".$this->getField("STATUS")."
	    )"; 

		$this->id= $this->getField("T_PENGUKURAN_DETAIL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
			UPDATE T_PENGUKURAN_DETAIL
			SET
			NAMA= '".$this->getField("NAMA")."'
			, HASIL= '".$this->getField("HASIL")."'
			, KOMENTAR_ID= ".$this->getField("KOMENTAR_ID")."
			, STATUS= ".$this->getField("STATUS")."

			WHERE T_PENGUKURAN_DETAIL_ID = '".$this->getField("T_PENGUKURAN_DETAIL_ID")."'
		"; 

		$this->query = $str;
		// echo $str;exit;

		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
			DELETE FROM T_PENGUKURAN_DETAIL
			WHERE 
			T_PENGUKURAN_DETAIL_ID = ".$this->getField("T_PENGUKURAN_DETAIL_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY T_PENGUKURAN_DETAIL_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.NAMA FORM_UJI_INFO,C.NAMA JENIS_PENGUKURAN_INFO
			FROM T_PENGUKURAN_DETAIL A
			LEFT JOIN FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
			LEFT JOIN JENIS_PENGUKURAN C ON C.JENIS_PENGUKURAN_ID = A.JENIS_PENGUKURAN_ID
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


	function selectByParamsDetil($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY JENIS_PENGUKURAN_ID ASC")
	{
		$str = "
		 SELECT A.FORM_UJI_ID,A.KODE KD_FORM,A.NAMA NM_FORM,B.JENIS_PENGUKURAN_ID,B.KODE KD_JENIS, B.NAMA NM_JENIS,B.REFERENSI,B.CATATAN 
		 FROM FORM_UJI A
		 LEFT JOIN JENIS_PENGUKURAN B ON B.FORM_UJI_ID = A.FORM_UJI_ID
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