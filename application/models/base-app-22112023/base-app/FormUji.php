<? 
  include_once(APPPATH.'/models/Entity.php');

  class FormUji extends Entity{ 

	var $query;

    function FormUji()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("FORM_UJI_ID", $this->getNextId("FORM_UJI_ID","form_uji"));

    	$str = "
    	INSERT INTO form_uji
    	(
    		FORM_UJI_ID,KODE,NAMA,STATUS,NAMEPLATE_ID,MEASURING_TOOLS_ID,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("FORM_UJI_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("NAMEPLATE_ID")."
	    	, ".$this->getField("MEASURING_TOOLS_ID")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."

	    )"; 

		$this->id= $this->getField("FORM_UJI_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}
	function insertdetil()
    {
    	$this->setField("FORM_UJI_DETIL_DINAMIS_ID", $this->getNextId("FORM_UJI_DETIL_DINAMIS_ID","form_uji_detil_dinamis"));

    	$str = "
    	INSERT INTO FORM_UJI_DETIL_DINAMIS
    	(
            FORM_UJI_DETIL_DINAMIS_ID, FORM_UJI_ID, PENGUKURAN_ID, TIPE_INPUT_ID, 
            TABEL_TEMPLATE_ID, PENGUKURAN_TIPE_INPUT_ID, NAMA, STATUS_TABLE,LINK_FILE
    	)
    	VALUES 
    	(
	    	".$this->getField("FORM_UJI_DETIL_DINAMIS_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, ".$this->getField("PENGUKURAN_ID")."
	    	, ".$this->getField("TIPE_INPUT_ID")."
	    	, ".$this->getField("TABEL_TEMPLATE_ID")."
	    	, ".$this->getField("PENGUKURAN_TIPE_INPUT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS_TABLE")."'
	    	, '".$this->getField("LINK_FILE")."'
	    	
	    )"; 


		$this->id= $this->getField("FORM_UJI_DETIL_DINAMIS_ID");
		$this->query= $str;
		// echo $str;
		return $this->execQuery($str);
	}

	function insertpengukuran()
    {
    	$this->setField("FORM_UJI_PENGUKURAN_ID", $this->getNextId("FORM_UJI_PENGUKURAN_ID","form_uji_pengukuran"));

    	$str = "
    	INSERT INTO form_uji_pengukuran
    	(
            FORM_UJI_PENGUKURAN_ID, FORM_UJI_ID, PENGUKURAN_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("FORM_UJI_PENGUKURAN_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, ".$this->getField("PENGUKURAN_ID")."
	 
	    )"; 


		$this->id= $this->getField("FORM_UJI_PENGUKURAN_ID");
		$this->query= $str;
		// echo $str;
		return $this->execQuery($str);
	}

	function insertgambarmulti()
    {
    	$this->setField("FORM_UJI_GAMBAR_ID", $this->getNextId("FORM_UJI_GAMBAR_ID","form_uji_gambar"));

    	$str = "
    	INSERT INTO form_uji_gambar
    	(
    		FORM_UJI_GAMBAR_ID,FORM_UJI_ID,FORM_UJI_TIPE_ID,LINK_GAMBAR,NAMA
    	)
    	VALUES 
    	(
    		".$this->getField("FORM_UJI_GAMBAR_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	,".$this->getField("FORM_UJI_TIPE_ID")."
	    	, '".$this->getField("LINK_GAMBAR")."'
	    	, '".$this->getField("NAMA")."'
	    )"; 

		$this->id= $this->getField("FORM_UJI_GAMBAR_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertdetilnameplate()
    {
    	$this->setField("FORM_UJI_NAMEPLATE_ID", $this->getNextId("FORM_UJI_NAMEPLATE_ID","form_uji_nameplate"));

    	$str = "
    	INSERT INTO form_uji_nameplate
    	(
	    	FORM_UJI_NAMEPLATE_ID, FORM_UJI_ID, NAMEPLATE_DETIL_ID, MASTER_ID, 
	    	NAMEPLATE_ID, NAMA, NAMA_NAMEPLATE, NAMA_TABEL, STATUS
    	)
    	VALUES 
    	(
	    	".$this->getField("FORM_UJI_NAMEPLATE_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, ".$this->getField("NAMEPLATE_DETIL_ID")."
	    	, ".$this->getField("MASTER_ID")."
	    	, ".$this->getField("NAMEPLATE_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("NAMA_NAMEPLATE")."'
	    	, '".$this->getField("NAMA_TABEL")."'
	    	, '".$this->getField("STATUS")."'
	    	

	    )"; 

		$this->id= $this->getField("FORM_UJI_NAMEPLATE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertequipment()
    {
    	$this->setField("FORM_UJI_KELOMPOK_EQUIPMENT_ID", $this->getNextId("FORM_UJI_KELOMPOK_EQUIPMENT_ID","form_uji_kelompok_equipment"));

    	$str = "
    	INSERT INTO form_uji_kelompok_equipment
    	(
            FORM_UJI_KELOMPOK_EQUIPMENT_ID, FORM_UJI_ID, KELOMPOK_EQUIPMENT_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("FORM_UJI_KELOMPOK_EQUIPMENT_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, ".$this->getField("KELOMPOK_EQUIPMENT_ID")."
	 
	    )"; 


		$this->id= $this->getField("FORM_UJI_KELOMPOK_EQUIPMENT_ID");
		$this->query= $str;
		// echo $str;
		return $this->execQuery($str);
	}


	function copy()
    {
    	$this->setField("FORM_UJI_ID", $this->getNextId("FORM_UJI_ID","form_uji"));

    	$str = "

    	INSERT INTO form_uji
    	(
    		FORM_UJI_ID, KODE, NAMA, MEASURING_TOOLS_ID,STATUS
    	)
    	(
    		SELECT 
    		".$this->getField("FORM_UJI_ID")." 
    		, KODE
    		, NAMA
    		, MEASURING_TOOLS_ID
    		, '2'   
    		FROM form_uji 
    		WHERE FORM_UJI_ID = ".$this->getField("FORM_UJI_ID_PILIH")."
    	)
	    ;";

	    $str .= "

	    INSERT INTO form_uji_pengukuran
    	(
    		FORM_UJI_PENGUKURAN_ID, FORM_UJI_ID, PENGUKURAN_ID
    	)
    	(
    		SELECT 
    		 (
    		 SELECT COALESCE(MAX(FORM_UJI_PENGUKURAN_ID),0) FROM form_uji_pengukuran ) + row_number() over (order by FORM_UJI_PENGUKURAN_ID)
    		, ".$this->getField("FORM_UJI_ID")." 
    		, PENGUKURAN_ID 
    		FROM form_uji_pengukuran 
    		WHERE FORM_UJI_ID = ".$this->getField("FORM_UJI_ID_PILIH")."
    	)

   
	    ;";

		$str .= "

	    INSERT INTO form_uji_kelompok_equipment
    	(
    		FORM_UJI_KELOMPOK_EQUIPMENT_ID, FORM_UJI_ID, KELOMPOK_EQUIPMENT_ID
    	)
    	(
    		SELECT 
    		 (
    		 SELECT COALESCE(MAX(FORM_UJI_KELOMPOK_EQUIPMENT_ID),0) FROM form_uji_kelompok_equipment ) + row_number() over (order by FORM_UJI_KELOMPOK_EQUIPMENT_ID)
    		, ".$this->getField("FORM_UJI_ID")." 
    		, KELOMPOK_EQUIPMENT_ID 
    		FROM form_uji_kelompok_equipment 
    		WHERE FORM_UJI_ID = ".$this->getField("FORM_UJI_ID_PILIH")."
    	)

   
	    ;";

	    $str .= "

	    INSERT INTO FORM_UJI_DETIL_DINAMIS
    	(
    		FORM_UJI_DETIL_DINAMIS_ID, FORM_UJI_ID, PENGUKURAN_ID, TIPE_INPUT_ID, 
            TABEL_TEMPLATE_ID, PENGUKURAN_TIPE_INPUT_ID, NAMA, STATUS_TABLE,LINK_FILE
    	)
    	(
    		SELECT 
    		 (
    		 SELECT COALESCE(MAX(FORM_UJI_DETIL_DINAMIS_ID),0) FROM FORM_UJI_DETIL_DINAMIS ) + row_number() over (order by FORM_UJI_DETIL_DINAMIS_ID)
    		, ".$this->getField("FORM_UJI_ID")." 
    		, PENGUKURAN_ID 
    		, TIPE_INPUT_ID 
    		, TABEL_TEMPLATE_ID 
    		, PENGUKURAN_TIPE_INPUT_ID 
    		, NAMA 
    		, STATUS_TABLE 
    		, LINK_FILE
    		FROM FORM_UJI_DETIL_DINAMIS 
    		WHERE FORM_UJI_ID = ".$this->getField("FORM_UJI_ID_PILIH")."
    	)

   
	    ;"; 

  

		$this->id= $this->getField("FORM_UJI_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE form_uji
		SET
		 KODE= '".$this->getField("KODE")."'
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, NAMEPLATE_ID=".$this->getField("NAMEPLATE_ID")."
		, MEASURING_TOOLS_ID=".$this->getField("MEASURING_TOOLS_ID")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."

		WHERE FORM_UJI_ID = '".$this->getField("FORM_UJI_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updategambar()
	{
		$str = "
		UPDATE form_uji
		SET
		 LINK_GAMBAR= '".$this->getField("LINK_GAMBAR")."'
		
		WHERE FORM_UJI_ID = '".$this->getField("FORM_UJI_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updategambarNameplate()
	{
		$str = "
		UPDATE form_uji
		SET
		 LINK_GAMBAR= '".$this->getField("LINK_GAMBAR")."'
		
		WHERE FORM_UJI_ID = '".$this->getField("FORM_UJI_ID")."'
		AND NAMEPLATE_ID = '".$this->getField("NAMEPLATE_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatedetil()
	{
		$str = "
		UPDATE FORM_UJI_DETIL_DINAMIS
		SET
		 FORM_UJI_ID=".$this->getField("FORM_UJI_ID")."
		, PENGUKURAN_ID=".$this->getField("PENGUKURAN_ID")."
		, TIPE_INPUT_ID=".$this->getField("TIPE_INPUT_ID")."
		, TABEL_TEMPLATE_ID=".$this->getField("TABEL_TEMPLATE_ID")."
		, PENGUKURAN_TIPE_INPUT_ID=	".$this->getField("PENGUKURAN_TIPE_INPUT_ID")."
		, NAMA=	'".$this->getField("NAMA")."'
		, STATUS_TABLE=	'".$this->getField("STATUS_TABLE")."'

		WHERE FORM_UJI_DETIL_DINAMIS_ID = '".$this->getField("FORM_UJI_DETIL_DINAMIS_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatefiledetil()
	{
		$str = "
		UPDATE FORM_UJI_DETIL_DINAMIS
		SET
		LINK_FILE=	'".$this->getField("LINK_FILE")."'

		WHERE FORM_UJI_DETIL_DINAMIS_ID = '".$this->getField("FORM_UJI_DETIL_DINAMIS_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatepengukuran()
	{
		$str = "
		UPDATE FORM_UJI_PENGUKURAN
		SET
		 FORM_UJI_ID=".$this->getField("FORM_UJI_ID")."
		, PENGUKURAN_ID=".$this->getField("PENGUKURAN_ID")."
		WHERE PENGUKURAN_ID = '".$this->getField("PENGUKURAN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updateequipment()
	{
		$str = "
		UPDATE FORM_UJI_KELOMPOK_EQUIPMENT
		SET
		 FORM_UJI_ID=".$this->getField("FORM_UJI_ID")."
		, KELOMPOK_EQUIPMENT_ID=".$this->getField("KELOMPOK_EQUIPMENT_ID")."
		WHERE FORM_UJI_KELOMPOK_EQUIPMENT_ID = '".$this->getField("FORM_UJI_KELOMPOK_EQUIPMENT_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM form_uji
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID").";
		";

		$str .= "
		DELETE FROM form_uji_isi
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID").";
		";

		$str .= "
		DELETE FROM form_uji_detil
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID").";
		"; 

		$str .= "
		DELETE FROM form_uji_nameplate
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID").";
		";

		$str .= "
		DELETE FROM form_uji_gambar
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID").";
		"; 

		$str .= "
		DELETE FROM form_uji_detil_dinamis
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID").";
		";

		$str .= "
		DELETE FROM form_uji_pengukuran
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID").";
		";


		$str .= "
		DELETE FROM form_uji_kelompok_equipment
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID").";
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedetil()
	{
		$str = "
		DELETE FROM FORM_UJI_DETIL_DINAMIS
		WHERE 
		FORM_UJI_DETIL_DINAMIS_ID = ".$this->getField("FORM_UJI_DETIL_DINAMIS_ID")."
		AND FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID")."
		AND STATUS_TABLE = '".$this->getField("STATUS_TABLE")."'
		
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deletepengukuran()
	{
		$str = "
		DELETE FROM FORM_UJI_DETIL_DINAMIS
		WHERE 
		PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID")."
		AND FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		
		;"; 

		$str .= "
		DELETE FROM FORM_UJI_PENGUKURAN
		WHERE FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID")."
		
		;"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function deletepengukurantipe()
	{
		$str = "
		DELETE FROM FORM_UJI_PENGUKURAN
		WHERE FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	
	function deletegambar()
	{
		$str = "
		DELETE FROM form_uji_gambar
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."
		AND FORM_UJI_GAMBAR_ID = ".$this->getField("FORM_UJI_GAMBAR_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletegambarAll()
	{
		$str = "
		DELETE FROM form_uji_gambar
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function deletedetilnameplate()
	{
		$str = "
		DELETE FROM form_uji_nameplate
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND NAMEPLATE_ID = ".$this->getField("NAMEPLATE_ID")."
		
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deleteequipment()
	{
		$str = "
		DELETE FROM form_uji_kelompok_equipment
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedetilnameplateall()
	{
		$str = "
		DELETE FROM form_uji_nameplate
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function deletetabel()
	{
		$str = "
		DELETE FROM FORM_UJI_DETIL_DINAMIS
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID")."
		AND TABEL_TEMPLATE_ID = ".$this->getField("TABEL_TEMPLATE_ID")."
		AND STATUS_TABLE = 'TABLE'
		
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY A.FORM_UJI_ID ASC")
	{
		$str = "
		
		SELECT 
			A.*
			, CASE WHEN A.STATUS = '1' THEN 'Inactive' WHEN A.STATUS = '2' THEN 'Draft' ELSE 'Aktif' END INFO_STATUS
			, B.FORM_UJI_PENGUKURAN_ID_INFO
			, CASE
				WHEN EXISTS (select b.form_uji_id
				from plan_rla_form_uji_dinamis x
				where x.form_uji_id = A.form_uji_id)
				THEN '1'
				ELSE '0' 
			END DELETE_CHECK
			, C.FORM_UJI_KELOMPOK_EQUIPMENT_ID_INFO
		FROM form_uji A
		LEFT JOIN 
		(
			SELECT A.FORM_UJI_ID
			,STRING_AGG(A.PENGUKURAN_ID::text, ', ') AS FORM_UJI_PENGUKURAN_ID_INFO
			FROM FORM_UJI_PENGUKURAN A
			GROUP BY A.FORM_UJI_ID
		) B ON B.FORM_UJI_ID = A.FORM_UJI_ID
		LEFT JOIN 
		(
			SELECT A.FORM_UJI_ID
			,STRING_AGG(A.KELOMPOK_EQUIPMENT_ID::text, ', ') AS FORM_UJI_KELOMPOK_EQUIPMENT_ID_INFO
			FROM FORM_UJI_KELOMPOK_EQUIPMENT A
			GROUP BY A.FORM_UJI_ID
		) C ON C.FORM_UJI_ID = A.FORM_UJI_ID
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

    function selectByParamsDetil($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY FORM_UJI_DETIL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM form_uji_detil A
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

    function selectByParamsGambar($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY FORM_UJI_GAMBAR_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM form_uji_gambar A
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

    function selectByParamsNameplate($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY FORM_UJI_NAMEPLATE_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM form_uji_nameplate A
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

    function selectByParamsIsi($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY FORM_UJI_ISI_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM form_uji_isi A
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

    function selectByParamsPengukuranTabel($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY A.SEQ,C.BARIS ,C.TABEL_DETIL_ID")
	{
		$str = "
		SELECT 
		A.*, C.BARIS, C.NAMA_KOLOM , C.ROWSPAN, C.COLSPAN ,C.TABEL_DETIL_ID,B.STATUS_TABLE,C.BARIS
		FROM PENGUKURAN_TIPE_INPUT A
		INNER JOIN TIPE_INPUT B ON B.TIPE_INPUT_ID = A.TIPE_INPUT_ID
		LEFT JOIN 
		(
			SELECT A.TABEL_TEMPLATE_ID, B.BARIS, B.NAMA NAMA_KOLOM , B.ROWSPAN, B.COLSPAN,B.TABEL_DETIL_ID
			FROM TABEL_TEMPLATE A
			INNER JOIN TABEL_DETIL B ON B.TABEL_TEMPLATE_ID = A.TABEL_TEMPLATE_ID
		) C ON C.TABEL_TEMPLATE_ID = A.MASTER_TABEL_ID 
		WHERE 1=1
		AND STATUS_TABLE = 'TABLE'
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $unitment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsPengukuran($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder=" ORDER BY A.PENGUKURAN_ID,A.SEQ")
	{
		$str = "
		SELECT A.*,B.TABEL_TEMPLATE_ID, B.NAMA TABEL_NAMA, COALESCE( NULLIF(C.STATUS_TABLE,'') , 'BINARY' ) STATUS_TABLE
		FROM PENGUKURAN_TIPE_INPUT A
		LEFT JOIN TABEL_TEMPLATE B ON B.TABEL_TEMPLATE_ID = A.MASTER_TABEL_ID
		LEFT JOIN TIPE_INPUT C ON C.TIPE_INPUT_ID= A.TIPE_INPUT_ID
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

    function selectByParamsDetilDinamis($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY FORM_UJI_DETIL_DINAMIS_ID ASC")
	{
		$str = "
		SELECT 
			A.*
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

    function getCountFormUjiJumlahDinamis($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ")
	{
		$str = "
		SELECT COUNT (1) AS ROWCOUNT FROM form_uji_detil_dinamis A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."  ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsKelompokEquipment($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY A.FORM_UJI_ID ASC")
	{
		$str = "
		SELECT A.FORM_UJI_ID,A.NAMA NAMA_FORM, B.KELOMPOK_EQUIPMENT_ID,B.NAMA_KELOMPOK
		FROM FORM_UJI A
		INNER JOIN
		(
			 SELECT A.KELOMPOK_EQUIPMENT_ID,B.FORM_UJI_ID,A.NAMA NAMA_KELOMPOK
			 FROM KELOMPOK_EQUIPMENT A
			 INNER JOIN FORM_UJI_KELOMPOK_EQUIPMENT B ON B.KELOMPOK_EQUIPMENT_ID = A.KELOMPOK_EQUIPMENT_ID
		) B ON B.FORM_UJI_ID = A.FORM_UJI_ID
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


    function getCountFormUjiKelompokEquipment($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ")
	{
		$str = "
		SELECT COUNT (1) AS ROWCOUNT 
		FROM FORM_UJI A
		INNER JOIN
		(
			 SELECT A.KELOMPOK_EQUIPMENT_ID,B.FORM_UJI_ID,A.NAMA NAMA_KELOMPOK
			 FROM KELOMPOK_EQUIPMENT A
			 INNER JOIN FORM_UJI_KELOMPOK_EQUIPMENT B ON B.KELOMPOK_EQUIPMENT_ID = A.KELOMPOK_EQUIPMENT_ID
		) B ON B.FORM_UJI_ID = A.FORM_UJI_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."  ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsPengukuranMaster($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY A.PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT A.*
		FROM PENGUKURAN A
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

    function selectformujipengukuran($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY A.FORM_UJI_DETIL_DINAMIS_ID ASC")
	{
		$str = "
		SELECT 
		A.*
		FROM form_uji_detil_dinamis A
		INNER JOIN pengukuran_tipe_input B ON A.PENGUKURAN_ID = B.PENGUKURAN_ID
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


    function selectByParamsCheckPengukuran($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY FORM_UJI_PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM form_uji_pengukuran A
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

  } 
?>