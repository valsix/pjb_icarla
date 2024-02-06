<? 
  include_once(APPPATH.'/models/Entity.php');

  class PlanRlaFormUjiDinamis extends Entity{ 

	var $query;

    function PlanRlaFormUjiDinamis()
	{
      $this->Entity(); 
    }
	function insert()
    {
    	$this->setField("PLAN_RLA_FORM_UJI_DINAMIS_ID", $this->getNextId("PLAN_RLA_FORM_UJI_DINAMIS_ID","plan_rla_form_uji_dinamis"));

    	$str = "
    	INSERT INTO plan_rla_form_uji_dinamis
    	(
    		PLAN_RLA_FORM_UJI_DINAMIS_ID, FORM_UJI_DETIL_DINAMIS_ID, PLAN_RLA_ID, FORM_UJI_ID, PENGUKURAN_ID, 
            TIPE_INPUT_ID, TABEL_TEMPLATE_ID,BARIS, NAMA,KELOMPOK_EQUIPMENT_ID,STATUS_TABLE,LINK_FILE, PENGUKURAN_TIPE_INPUT_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID")."
	    	, ".$this->getField("FORM_UJI_DETIL_DINAMIS_ID")."
	    	, ".$this->getField("PLAN_RLA_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, ".$this->getField("PENGUKURAN_ID")."
	    	, ".$this->getField("TIPE_INPUT_ID")."
	    	, ".$this->getField("TABEL_TEMPLATE_ID")."
	    	, ".$this->getField("BARIS")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("KELOMPOK_EQUIPMENT_ID")."
	    	, '".$this->getField("STATUS_TABLE")."'
	    	, '".$this->getField("LINK_FILE")."'
	    	, ".$this->getField("PENGUKURAN_TIPE_INPUT_ID")."
	    )"; 

		$this->id= $this->getField("PLAN_RLA_FORM_UJI_DETIL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertdetil()
    {
    	$this->setField("PLAN_RLA_FORM_UJI_DINAMIS_ID", $this->getNextId("PLAN_RLA_FORM_UJI_DINAMIS_ID","plan_rla_form_uji_dinamis"));

    	$str = "
    	INSERT INTO plan_rla_form_uji_dinamis
    	(
    		PLAN_RLA_FORM_UJI_DINAMIS_ID, FORM_UJI_DETIL_DINAMIS_ID, PLAN_RLA_ID, FORM_UJI_ID, PENGUKURAN_ID
    		, TIPE_INPUT_ID, TABEL_TEMPLATE_ID, BARIS, NAMA, KELOMPOK_EQUIPMENT_ID, STATUS_TABLE, LINK_FILE
    		, PENGUKURAN_TIPE_INPUT_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID")."
	    	, ".$this->getField("FORM_UJI_DETIL_DINAMIS_ID")."
	    	, ".$this->getField("PLAN_RLA_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, ".$this->getField("PENGUKURAN_ID")."
	    	, ".$this->getField("TIPE_INPUT_ID")."
	    	, ".$this->getField("TABEL_TEMPLATE_ID")."
	    	, ".$this->getField("BARIS")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("KELOMPOK_EQUIPMENT_ID")."
	    	, '".$this->getField("STATUS_TABLE")."'
	    	, '".$this->getField("LINK_FILE")."'
	    	, ".$this->getField("PENGUKURAN_TIPE_INPUT_ID")."
	    )";

		$this->id= $this->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID");
		$this->query= $str;
		// echo $str;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE plan_rla_form_uji_dinamis
		SET
		FORM_UJI_DETIL_DINAMIS_ID= ".$this->getField("FORM_UJI_DETIL_DINAMIS_ID")."
		, PLAN_RLA_ID= ".$this->getField("PLAN_RLA_ID")."
		, FORM_UJI_ID= ".$this->getField("FORM_UJI_ID")."
		, PENGUKURAN_ID= ".$this->getField("PENGUKURAN_ID")."
		, TIPE_INPUT_ID= ".$this->getField("TIPE_INPUT_ID")."
		, TABEL_TEMPLATE_ID= ".$this->getField("TABEL_TEMPLATE_ID")."
		, BARIS= ".$this->getField("BARIS")."
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS_TABLE= '".$this->getField("STATUS_TABLE")."'
		, LINK_FILE= '".$this->getField("LINK_FILE")."'
		, PENGUKURAN_TIPE_INPUT_ID= ".$this->getField("PENGUKURAN_TIPE_INPUT_ID")."
		WHERE PLAN_RLA_FORM_UJI_DINAMIS_ID = '".$this->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatenama()
	{
		$str = "
		UPDATE plan_rla_form_uji_dinamis
		SET
		NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE PLAN_RLA_FORM_UJI_DINAMIS_ID = '".$this->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID")."' AND PLAN_RLA_ID = '".$this->getField("PLAN_RLA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);		

	}

	function insertfiledetil()
    {
    	$this->setField("PLAN_RLA_FORM_UJI_DINAMIS_ID", $this->getNextId("PLAN_RLA_FORM_UJI_DINAMIS_ID","plan_rla_form_uji_dinamis"));

    	$str = "
    	INSERT INTO plan_rla_form_uji_dinamis
    	(
    		PLAN_RLA_FORM_UJI_DINAMIS_ID, FORM_UJI_DETIL_DINAMIS_ID, PLAN_RLA_ID, FORM_UJI_ID, PENGUKURAN_ID, 
            TIPE_INPUT_ID, TABEL_TEMPLATE_ID,BARIS, NAMA,KELOMPOK_EQUIPMENT_ID,STATUS_TABLE,LINK_FILE, PENGUKURAN_TIPE_INPUT_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID")."
	    	, ".$this->getField("FORM_UJI_DETIL_DINAMIS_ID")."
	    	, ".$this->getField("PLAN_RLA_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, ".$this->getField("PENGUKURAN_ID")."
	    	, ".$this->getField("TIPE_INPUT_ID")."
	    	, ".$this->getField("TABEL_TEMPLATE_ID")."
	    	, ".$this->getField("BARIS")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("KELOMPOK_EQUIPMENT_ID")."
	    	, '".$this->getField("STATUS_TABLE")."'
	    	, '".$this->getField("LINK_FILE")."'
	    	, ".$this->getField("PENGUKURAN_TIPE_INPUT_ID")."
	    )";

		$this->id= $this->getField("PLAN_RLA_FORM_UJI_DETIL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatefiledetil()
	{
		$str = "
		UPDATE plan_rla_form_uji_dinamis
		SET
		LINK_FILE=	'".$this->getField("LINK_FILE")."'
		WHERE FORM_UJI_DETIL_DINAMIS_ID = '".$this->getField("FORM_UJI_DETIL_DINAMIS_ID")."'
		AND PLAN_RLA_FORM_UJI_DINAMIS_ID = '".$this->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID")."'
		"; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM plan_rla_form_uji_dinamis
		WHERE 
		TABEL_TEMPLATE_ID = ".$this->getField("TABEL_TEMPLATE_ID")."
		AND PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID")."
		AND PENGUKURAN_TIPE_INPUT_ID = ".$this->getField("PENGUKURAN_TIPE_INPUT_ID")."
		AND PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID")."
		AND FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND KELOMPOK_EQUIPMENT_ID = ".$this->getField("KELOMPOK_EQUIPMENT_ID")."
		AND PENGUKURAN_TIPE_INPUT_ID = ".$this->getField("PENGUKURAN_TIPE_INPUT_ID")."
		;"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function selectByParamsDetil($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY PLAN_RLA_FORM_UJI_DINAMIS_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM plan_rla_form_uji_dinamis A
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

    function selectByParamsMaxBaris($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="")
	{
		$str = "
		SELECT 
			MAX(BARIS)
		FROM plan_rla_form_uji_dinamis A
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

    function selectByParamsReport($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="")
	{
		$str = "
		SELECT  A.FORM_UJI_ID,A.NAMA,E.TABEL_TEMPLATE_ID,E.NAMA TABEL_NAMA,D.PENGUKURAN_ID,F.KELOMPOK_EQUIPMENT_ID,F.NAMA NAMA_KELOMPOK,G.NAMA PENGUKURAN_NAMA
		FROM FORM_UJI A
		INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
		INNER JOIN FORM_UJI_DETIL_DINAMIS C ON C.FORM_UJI_ID = A.FORM_UJI_ID AND C.STATUS_TABLE ='TABLE'
		INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS D ON D.FORM_UJI_ID = A.FORM_UJI_ID
		INNER JOIN TABEL_TEMPLATE E ON E.TABEL_TEMPLATE_ID = D.TABEL_TEMPLATE_ID
		INNER JOIN KELOMPOK_EQUIPMENT F ON F.KELOMPOK_EQUIPMENT_ID = D.KELOMPOK_EQUIPMENT_ID
		INNER JOIN PENGUKURAN G ON G.PENGUKURAN_ID = D.PENGUKURAN_ID 
		WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $unitment." GROUP BY A.FORM_UJI_ID,A.NAMA,E.TABEL_TEMPLATE_ID,D.PENGUKURAN_ID,F.KELOMPOK_EQUIPMENT_ID,F.NAMA,G.NAMA  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsValidasiPengukuran($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
			A.PENGUKURAN_ID 
		FROM plan_rla_form_uji_dinamis A
		INNER JOIN PENGUKURAN_TIPE_INPUT B ON B.PENGUKURAN_ID = A.PENGUKURAN_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $unitment." GROUP BY  A.PENGUKURAN_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsValidasiPengukuranTipeInput($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
			A.PENGUKURAN_ID, A.TABEL_TEMPLATE_ID
		FROM plan_rla_form_uji_dinamis A
		INNER JOIN PENGUKURAN_TIPE_INPUT B ON B.PENGUKURAN_ID = A.PENGUKURAN_ID AND B.MASTER_TABEL_ID = A.TABEL_TEMPLATE_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $unitment." GROUP BY  A.PENGUKURAN_ID, A.TABEL_TEMPLATE_ID  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


 //    function selectByParamsReportAllStatus($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder=" ORDER BY PENGUKURAN_ID ")
	// {
	// 	$str = "
	// 	SELECT  A.FORM_UJI_ID,A.NAMA,D.PENGUKURAN_ID,F.KELOMPOK_EQUIPMENT_ID,F.NAMA NAMA_KELOMPOK,G.NAMA PENGUKURAN_NAMA
	// 	FROM FORM_UJI A
	// 	INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
	// 	INNER JOIN FORM_UJI_DETIL_DINAMIS C ON C.FORM_UJI_ID = A.FORM_UJI_ID 
	// 	INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS D ON D.FORM_UJI_ID = A.FORM_UJI_ID
	// 	INNER JOIN KELOMPOK_EQUIPMENT F ON F.KELOMPOK_EQUIPMENT_ID = D.KELOMPOK_EQUIPMENT_ID
	// 	INNER JOIN PENGUKURAN G ON G.PENGUKURAN_ID = D.PENGUKURAN_ID 
	// 	WHERE 1=1

	// 	"; 
		
	// 	while(list($key,$val) = each($paramsArray))
	// 	{
	// 		$str .= " AND $key = '$val' ";
	// 	}
		
	// 	$str .= $unitment." GROUP BY A.FORM_UJI_ID,A.NAMA,D.PENGUKURAN_ID,F.KELOMPOK_EQUIPMENT_ID,F.NAMA,G.NAMA  ".$sOrder;
	// 	$this->query = $str;
				
	// 	return $this->selectLimit($str,$limit,$from); 
 //    }

    function selectByParamsReportAllStatus($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder=" ORDER BY PENGUKURAN_ID ")
	{
		$str = "
		SELECT A.FORM_UJI_ID,A.NAMA,G.PENGUKURAN_ID,F.KELOMPOK_EQUIPMENT_ID,F.NAMA NAMA_KELOMPOK,G.NAMA PENGUKURAN_NAMA 
		FROM FORM_UJI A 
		INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID 
		INNER JOIN FORM_UJI_DETIL_DINAMIS C ON C.FORM_UJI_ID = A.FORM_UJI_ID 
		INNER JOIN PLAN_RLA_KELOMPOK_EQUIPMENT D ON D.PLAN_RLA_ID = B.PLAN_RLA_ID 
		INNER JOIN KELOMPOK_EQUIPMENT F ON F.KELOMPOK_EQUIPMENT_ID = D.KELOMPOK_EQUIPMENT_ID 
		INNER JOIN FORM_UJI_PENGUKURAN H ON H.FORM_UJI_ID = A.FORM_UJI_ID 
		INNER JOIN PENGUKURAN G ON G.PENGUKURAN_ID = H.PENGUKURAN_ID 
		WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $unitment." GROUP BY A.FORM_UJI_ID,A.NAMA,G.PENGUKURAN_ID,F.KELOMPOK_EQUIPMENT_ID,F.NAMA,G.NAMA  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDetilNew($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY form_uji_detil_dinamis_id ASC")
	{
		$str = "
		SELECT A.*
		FROM form_uji_detil_dinamis A
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

    function selectseq($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="")
	{
		$str = "
		SELECT B.SEQ, A.LINK_FILE
		FROM plan_rla_form_uji_dinamis A
		INNER JOIN pengukuran_tipe_input B ON A.PENGUKURAN_TIPE_INPUT_ID = B.PENGUKURAN_TIPE_INPUT_ID
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

    function updatelink()
	{
		$str = "
		UPDATE plan_rla_form_uji_dinamis
		SET
		NAMA= '".$this->getField("NAMA")."'
		, LINK_FILE= ''
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE PLAN_RLA_FORM_UJI_DINAMIS_ID = '".$this->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deletedata()
	{
		$str = "
		DELETE FROM plan_rla_form_uji_dinamis
		WHERE 
		PLAN_RLA_FORM_UJI_DINAMIS_ID = '".$this->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID")."'
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

  } 
?>