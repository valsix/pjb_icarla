<? 
include_once(APPPATH.'/models/Entity.php');

class TPengukuran extends Entity { 

	var $query;

    function TPengukuran()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("T_PENGUKURAN_ID", $this->getNextId("T_PENGUKURAN_ID","T_PENGUKURAN"));

    	$str = "
    	INSERT INTO T_PENGUKURAN
    	(
    		T_PENGUKURAN_ID, NOMOR_PENGUKURAN, MANUFAKTUR_ID, INSPEKSI, TANGGAL, QP_NO, FU_NO
    		, QEM_DOC_NO, REF_TAMBAHAN, CATATAN, REKOMENDASI, MEASURING_TOOLS_ID, APPROVAL_ID, PLAN_RLA_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("T_PENGUKURAN_ID")."'
	    	, '".$this->getField("NOMOR_PENGUKURAN")."'
	    	, ".$this->getField("MANUFAKTUR_ID")."
	    	, '".$this->getField("INSPEKSI")."'
	    	, ".$this->getField("TANGGAL")."
	    	, '".$this->getField("QP_NO")."'
	    	, '".$this->getField("FU_NO")."'
	    	, '".$this->getField("QEM_DOC_NO")."'
	    	, '".$this->getField("REF_TAMBAHAN")."'
	    	, '".$this->getField("CATATAN")."'
	    	, '".$this->getField("REKOMENDASI")."'
	    	, ".$this->getField("MEASURING_TOOLS_ID")."
	    	, ".$this->getField("APPROVAL_ID")."
	    	, ".$this->getField("PLAN_RLA_ID")."
	    )"; 

		$this->id= $this->getField("T_PENGUKURAN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
			UPDATE T_PENGUKURAN
			SET
			NOMOR_PENGUKURAN= '".$this->getField("NOMOR_PENGUKURAN")."'
			, MANUFAKTUR_ID= ".$this->getField("MANUFAKTUR_ID")."
			, INSPEKSI= '".$this->getField("INSPEKSI")."'
			, TANGGAL= ".$this->getField("TANGGAL")."
			, QP_NO= '".$this->getField("QP_NO")."'
			, FU_NO= '".$this->getField("FU_NO")."'
			, QEM_DOC_NO= '".$this->getField("QEM_DOC_NO")."'
			, REF_TAMBAHAN= '".$this->getField("REF_TAMBAHAN")."'
			, CATATAN= '".$this->getField("CATATAN")."'
			, REKOMENDASI= '".$this->getField("REKOMENDASI")."'
			, MEASURING_TOOLS_ID= ".$this->getField("MEASURING_TOOLS_ID")."
			, APPROVAL_ID= ".$this->getField("APPROVAL_ID")."
			, PLAN_RLA_ID= ".$this->getField("PLAN_RLA_ID")."

			WHERE T_PENGUKURAN_ID = '".$this->getField("T_PENGUKURAN_ID")."'
		"; 

		$this->query = $str;
		// echo $str;exit;

		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
			DELETE FROM T_PENGUKURAN
			WHERE 
			T_PENGUKURAN_ID = ".$this->getField("T_PENGUKURAN_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY T_PENGUKURAN_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.KODE MANUFAKTUR_KODE,B.NAMA MANUFAKTUR_NAMA,C.KODE MEASURING_TOOLS_KODE,C.NAMA MEASURING_TOOLS_NAMA
			FROM T_PENGUKURAN A
			LEFT JOIN MANUFAKTUR B ON B.MANUFAKTUR_ID = A.MANUFAKTUR_ID
			LEFT JOIN MEASURING_TOOLS C ON C.MEASURING_TOOLS_ID = A.MEASURING_TOOLS_ID   
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


	function selectByParamsDetailPlan($paramsArray=array(),$limit=-1,$from=-1, $statement='',$statementdetil='', $sOrder="ORDER BY B.FORM_UJI_ID_INFO ASC")
	{
		$str = "
		SELECT  
		A.PLAN_RLA_ID
		, B.FORM_UJI_ID_INFO
		, B.NAMA_FORM
		, B.NAMA_JENIS
		, B.JENIS_PENGUKURAN_ID
		, C.NAMA NAMA_DETIL
		, C.HASIL HASIL_DETIL
		, D.NAMA KOMENTAR_DETIL
		, B.FORM_UJI_ID
		, C.T_PENGUKURAN_DETAIL_ID
		, C.STATUS
		, CASE WHEN C.STATUS = 1 THEN 'Normal' 
		  WHEN C.STATUS = 2 THEN 'Alarm'
		  END STATUS_INFO
		FROM plan_rla A
		LEFT JOIN 
		(
			SELECT B.PLAN_RLA_ID
			, A.FORM_UJI_ID  FORM_UJI_ID_INFO
			, A.NAMA  NAMA_FORM
			, C.NAMA NAMA_JENIS
			, C.JENIS_PENGUKURAN_ID
			, A.FORM_UJI_ID
			FROM FORM_UJI A
			INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID 
			LEFT JOIN JENIS_PENGUKURAN C ON C.FORM_UJI_ID = A.FORM_UJI_ID
		) B ON B.PLAN_RLA_ID = A.PLAN_RLA_ID
		LEFT JOIN T_PENGUKURAN_DETAIL C ON A.PLAN_RLA_ID = C.PLAN_RLA_ID  AND C.FORM_UJI_ID = B.FORM_UJI_ID ".$statementdetil."
		LEFT JOIN KOMENTAR D ON D.KOMENTAR_ID = C.KOMENTAR_ID
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