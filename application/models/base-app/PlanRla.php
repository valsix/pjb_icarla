<? 
  include_once(APPPATH.'/models/Entity.php');

  class PlanRla extends Entity{ 

	var $query;

    function PlanRla()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PLAN_RLA_ID", $this->getNextId("PLAN_RLA_ID","plan_rla"));

    	$str = "
    	INSERT INTO plan_rla
    	(
    		PLAN_RLA_ID, KODE_MASTER_PLAN, DISTRIK_ID, ENTITAS, UNIT_ID
    		, EQUIPMENT_ID,  JUDUL_KEGIATAN, RLA_LEVEL
    		, RLA_INDEX, ANGGARAN_RENCANA, ANGGARAN_REALISASI, WORK_ORDER
    		, WORK_REQUEST, KODE_PRK
    		, RENCANA_TANGGAL_AWAL,RENCANA_TANGGAL_AKHIR,RENCANA_DURASI,REALISASI_TANGGAL_AWAL
    		, REALISASI_TANGGAL_AKHIR
    		, REALISASI_DURASI, TIMELINE_RLA_ID, PIC_ID, STATUS, PEMERIKSA_ID
    		, V_STATUS
    		, LAMPIRAN
    		, WORK_ORDER_ID
    		, WORK_REQUEST_ID
    		, PROGRESS
    		, PENGGUNA_ID
    		, ROLE_ID
    		, TAHUN
    		,LAST_CREATE_USER
    		,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("PLAN_RLA_ID")."
	    	, '".$this->getField("KODE_MASTER_PLAN")."'
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("ENTITAS")."'
	    	, ".$this->getField("UNIT_ID")."
	    	, ".$this->getField("EQUIPMENT_ID")."
	    	, '".$this->getField("JUDUL_KEGIATAN")."'
	    	, '".$this->getField("RLA_LEVEL")."'
	    	, '".$this->getField("RLA_INDEX")."'
	    	, '".$this->getField("ANGGARAN_RENCANA")."'
	    	, '".$this->getField("ANGGARAN_REALISASI")."'
	    	, '".$this->getField("WORK_ORDER")."'
	    	, '".$this->getField("WORK_REQUEST")."'
	    	, '".$this->getField("KODE_PRK")."'
	    	, ".$this->getField("RENCANA_TANGGAL_AWAL")."
	    	, ".$this->getField("RENCANA_TANGGAL_AKHIR")."
	    	, '".$this->getField("RENCANA_DURASI")."'
	    	, ".$this->getField("REALISASI_TANGGAL_AWAL")."
	    	, ".$this->getField("REALISASI_TANGGAL_AKHIR")."
	    	, '".$this->getField("REALISASI_DURASI")."'
	    	, ".$this->getField("TIMELINE_RLA_ID")."
	    	, '".$this->getField("PIC_ID")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("PEMERIKSA_ID")."'
	    	, ".$this->getField("V_STATUS")."
	    	, '".$this->getField("LAMPIRAN")."'
	    	, ".$this->getField("WORK_ORDER_ID")."
	    	, ".$this->getField("WORK_REQUEST_ID")."
	    	, '".$this->getField("PROGRESS")."'
	    	, ".$this->getField("PENGGUNA_ID")."
	    	, ".$this->getField("ROLE_ID")."
	    	, ".$this->getField("TAHUN")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("PLAN_RLA_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertform()
    {
    	$this->setField("PLAN_RLA_FORM_UJI_ID", $this->getNextId("PLAN_RLA_FORM_UJI_ID","plan_rla_form_uji"));

    	$str = "
    	INSERT INTO plan_rla_form_uji
    	(
    		PLAN_RLA_FORM_UJI_ID,PLAN_RLA_ID,FORM_UJI_ID,KELOMPOK_EQUIPMENT_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PLAN_RLA_FORM_UJI_ID")."
	    	, ".$this->getField("PLAN_RLA_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, ".$this->getField("KELOMPOK_EQUIPMENT_ID")."
	    	
	    )"; 

		$this->id= $this->getField("PLAN_RLA_FORM_UJI_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertpengadaan()
    {
    	$this->setField("PLAN_RLA_PENGADAAN_ID", $this->getNextId("PLAN_RLA_PENGADAAN_ID","plan_rla_pengadaan"));

    	$str = "
    	INSERT INTO plan_rla_pengadaan
    	(
    		PLAN_RLA_PENGADAAN_ID,PLAN_RLA_ID,PENGADAAN_KONTRAK_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PLAN_RLA_PENGADAAN_ID")."
	    	, ".$this->getField("PLAN_RLA_ID")."
	    	, ".$this->getField("PENGADAAN_KONTRAK_ID")."
	    	
	    )"; 

		$this->id= $this->getField("PLAN_RLA_PENGADAAN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertequipment()
    {
    	$this->setField("PLAN_RLA_KELOMPOK_EQUIPMENT_ID", $this->getNextId("PLAN_RLA_KELOMPOK_EQUIPMENT_ID","plan_rla_kelompok_equipment"));

    	$str = "
    	INSERT INTO plan_rla_kelompok_equipment
    	(
            PLAN_RLA_KELOMPOK_EQUIPMENT_ID, PLAN_RLA_ID, KELOMPOK_EQUIPMENT_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PLAN_RLA_KELOMPOK_EQUIPMENT_ID")."
	    	, ".$this->getField("PLAN_RLA_ID")."
	    	, ".$this->getField("KELOMPOK_EQUIPMENT_ID")."
	 
	    )"; 

		$this->id= $this->getField("PLAN_RLA_KELOMPOK_EQUIPMENT_ID");
		$this->query= $str;
		// echo $str;
		return $this->execQuery($str);
	}



	function insertnameplate()
    {
    	$this->setField("PLAN_RLA_NAMEPLATE_ID", $this->getNextId("PLAN_RLA_NAMEPLATE_ID","plan_rla_nameplate"));

    	$str = "
    	INSERT INTO plan_rla_nameplate
    	(
            PLAN_RLA_NAMEPLATE_ID, PLAN_RLA_ID, KELOMPOK_EQUIPMENT_ID, NAMEPLATE_ID, SUMMARY,REKOMENDASI,PLAN_RLA_SUMMARY_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PLAN_RLA_NAMEPLATE_ID")."
	    	, ".$this->getField("PLAN_RLA_ID")."
	    	, ".$this->getField("KELOMPOK_EQUIPMENT_ID")."
	    	, ".$this->getField("NAMEPLATE_ID")."
	    	, '".$this->getField("SUMMARY")."'
	    	, '".$this->getField("REKOMENDASI")."'
	    	, ".$this->getField("PLAN_RLA_SUMMARY_ID")."
	 
	    )"; 


		$this->id= $this->getField("PLAN_RLA_NAMEPLATE_ID");
		$this->query= $str;
		// echo $str;
		return $this->execQuery($str);
	}


	function updatenameplate()
	{
		$str = "
		UPDATE plan_rla_nameplate
		SET
		 NAMEPLATE_ID = ".$this->getField("NAMEPLATE_ID")."
		, SUMMARY = '".$this->getField("SUMMARY")."'
		, REKOMENDASI = '".$this->getField("REKOMENDASI")."'
		, PLAN_RLA_SUMMARY_ID = ".$this->getField("PLAN_RLA_SUMMARY_ID")."
		WHERE PLAN_RLA_NAMEPLATE_ID = '".$this->getField("PLAN_RLA_NAMEPLATE_ID")."'
		AND PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID")."
		"; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
	}


	function deleteequipment()
	{
		$str = "
		DELETE FROM plan_rla_kelompok_equipment
		WHERE 
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID")."
		
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function insertsummary()
    {
    	$this->setField("PLAN_RLA_SUMMARY_ID", $this->getNextId("PLAN_RLA_SUMMARY_ID","plan_rla_summary"));

    	$str = "
    	INSERT INTO plan_rla_summary
    	(
            PLAN_RLA_SUMMARY_ID, PLAN_RLA_ID, V_STATUS,TESTED_ID,COORDINATOR_ID,QUALITY_ID,WITNESS_ID,TESTED_STATUS,COORDINATOR_STATUS,QUALITY_STATUS,WITNESS_STATUS
    	)
    	VALUES 
    	(
	    	".$this->getField("PLAN_RLA_SUMMARY_ID")."
	    	, ".$this->getField("PLAN_RLA_ID")."
	    	, ".$this->getField("V_STATUS")."
	    	, ".$this->getField("TESTED_ID")."
	    	, ".$this->getField("COORDINATOR_ID")."
	    	, ".$this->getField("QUALITY_ID")."
	    	, ".$this->getField("WITNESS_ID")."
	    	, ".$this->getField("TESTED_STATUS")."
	    	, ".$this->getField("COORDINATOR_STATUS")."
	    	, ".$this->getField("QUALITY_STATUS")."
	    	, ".$this->getField("WITNESS_STATUS")."
	    )"; 


		$this->id= $this->getField("PLAN_RLA_SUMMARY_ID");
		$this->query= $str;
		// echo $str;
		return $this->execQuery($str);
	}


	function updatesummary()
	{
		$str = "
		UPDATE plan_rla_summary
		SET
		 V_STATUS = ".$this->getField("V_STATUS")."
		 , TESTED_ID = ".$this->getField("TESTED_ID")."
		 , COORDINATOR_ID = ".$this->getField("COORDINATOR_ID")."
		 , QUALITY_ID = ".$this->getField("QUALITY_ID")."
		 , WITNESS_ID = ".$this->getField("WITNESS_ID")."
		 , TESTED_STATUS = ".$this->getField("TESTED_STATUS")."
		 , COORDINATOR_STATUS = ".$this->getField("COORDINATOR_STATUS")."
		 , QUALITY_STATUS = ".$this->getField("QUALITY_STATUS")."
		 , WITNESS_STATUS = ".$this->getField("WITNESS_STATUS")."
		WHERE PLAN_RLA_SUMMARY_ID = '".$this->getField("PLAN_RLA_SUMMARY_ID")."'
		"; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
	}


	function update()
	{
		$str = "
		UPDATE plan_rla
		SET
		KODE_MASTER_PLAN= '".$this->getField("KODE_MASTER_PLAN")."'
		, DISTRIK_ID=".$this->getField("DISTRIK_ID")."
		, ENTITAS='".$this->getField("ENTITAS")."'
		, UNIT_ID=".$this->getField("UNIT_ID")."
		, EQUIPMENT_ID=".$this->getField("EQUIPMENT_ID")."
		, JUDUL_KEGIATAN='".$this->getField("JUDUL_KEGIATAN")."'
		, RLA_LEVEL='".$this->getField("RLA_LEVEL")."'
		, RLA_INDEX='".$this->getField("RLA_INDEX")."'
		, ANGGARAN_RENCANA='".$this->getField("ANGGARAN_RENCANA")."'
		, ANGGARAN_REALISASI='".$this->getField("ANGGARAN_REALISASI")."'
		, WORK_ORDER='".$this->getField("WORK_ORDER")."'
		, WORK_REQUEST='".$this->getField("WORK_REQUEST")."'
		, KODE_PRK='".$this->getField("KODE_PRK")."'
		, RENCANA_TANGGAL_AWAL=".$this->getField("RENCANA_TANGGAL_AWAL")."
		, RENCANA_TANGGAL_AKHIR=".$this->getField("RENCANA_TANGGAL_AKHIR")."
		, RENCANA_DURASI='".$this->getField("RENCANA_DURASI")."'
		, REALISASI_TANGGAL_AWAL=".$this->getField("REALISASI_TANGGAL_AWAL")."
		, REALISASI_TANGGAL_AKHIR=".$this->getField("REALISASI_TANGGAL_AKHIR")."
		, REALISASI_DURASI='".$this->getField("REALISASI_DURASI")."'
		, TIMELINE_RLA_ID=".$this->getField("TIMELINE_RLA_ID")."
		, PIC_ID='".$this->getField("PIC_ID")."'
		, STATUS='".$this->getField("STATUS")."'
		, PEMERIKSA_ID='".$this->getField("PEMERIKSA_ID")."'
		, V_STATUS=".$this->getField("V_STATUS")."
		, LAMPIRAN='".$this->getField("LAMPIRAN")."'
		, WORK_ORDER_ID=".$this->getField("WORK_ORDER_ID")."
		, WORK_REQUEST_ID=".$this->getField("WORK_REQUEST_ID")."
		, PROGRESS='".$this->getField("PROGRESS")."'
		, PENGGUNA_ID=".$this->getField("PENGGUNA_ID")."
		, ROLE_ID=".$this->getField("ROLE_ID")."
		, TAHUN=".$this->getField("TAHUN")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."

		WHERE PLAN_RLA_ID = '".$this->getField("PLAN_RLA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateupload()
	{
		$str = "
		UPDATE plan_rla
		SET
		LAMPIRAN = '".$this->getField("LAMPIRAN")."'
		WHERE PLAN_RLA_ID = '".$this->getField("PLAN_RLA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updatecatatan()
	{
		$str = "
		UPDATE plan_rla
		SET
		STATUS_CATATAN = '".$this->getField("STATUS_CATATAN")."'
		WHERE PLAN_RLA_ID = '".$this->getField("PLAN_RLA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateapprovalrealisasi()
	{
		$str = "
		UPDATE plan_rla
		SET
		
		 RLA_INDEX='".$this->getField("RLA_INDEX")."'
		, ANGGARAN_REALISASI='".$this->getField("ANGGARAN_REALISASI")."'
		, REALISASI_TANGGAL_AWAL=".$this->getField("REALISASI_TANGGAL_AWAL")."
		, REALISASI_TANGGAL_AKHIR=".$this->getField("REALISASI_TANGGAL_AKHIR")."
		, REALISASI_DURASI='".$this->getField("REALISASI_DURASI")."'
		, PROGRESS='".$this->getField("PROGRESS")."'
		, STATUS_FINISH='".$this->getField("STATUS_FINISH")."'
		WHERE PLAN_RLA_ID = '".$this->getField("PLAN_RLA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM plan_rla
		WHERE 
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deleteform()
	{
		$str = "
		DELETE FROM plan_rla_form_uji
		WHERE 
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletepengadaan()
	{
		$str = "
		DELETE FROM plan_rla_pengadaan WHERE
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletepengadaankontrak()
	{
		$str = "
		DELETE FROM PENGADAAN_KONTRAK WHERE
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletepengukuran()
	{
		$str = "
		DELETE FROM T_PENGUKURAN WHERE
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID")."
		"; 
		$str .= "
		DELETE FROM T_PENGUKURAN_DETAIL WHERE
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deleteall()
	{
		$str = "
		DELETE FROM plan_rla
		WHERE 
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").";"; 

		$str .= "
		DELETE FROM plan_rla_form_uji
		WHERE 
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").";"; 

		$this->query = $str;

		$str .= "
		DELETE FROM plan_rla_form_uji_dinamis
		WHERE 
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").";"; 

		$this->query = $str;

		$str .= "
		DELETE FROM PENGADAAN_KONTRAK WHERE
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").";"; 

		$str .= "
		DELETE FROM plan_rla_pengadaan WHERE
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").";"; 

		$str .= "
		DELETE FROM T_PENGUKURAN WHERE
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").";
		"; 
		$str .= "
		DELETE FROM T_PENGUKURAN_DETAIL WHERE
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").";";

		$str .= "
			DELETE FROM CATATAN_RLA
			WHERE 
			PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID").";
		";  

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.PLAN_RLA_ID")
	{
		$str = "
		
		SELECT
			B.KODE KODE_DISTRIK
			, B.NAMA NAMA_DISTRIK, C.KODE KODE_UNIT, C.NAMA NAMA_UNIT
			, D.NAMA NAMA_PIC
			, E.NAMA NAMA_PEMERIKSA
			, F.FORM_UJI_ID_INFO
			, F.NAMA_FORM, G.NAMA NAMA_EAM
			, H.PENGADAAN_KONTRAK_ID_INFO, H.NOMOR_KONTRAK
			, SA.NAMA STATUS_APPROVE_NAMA
			, A.*
			, I.WORK_ORDER_ID
			, I.DESCRIPTION WO_DESC
			, I.WO WO_NO
			, I.PROJECT_NO WO_PROJECT
			, J.WORK_REQUEST_ID
			, J.DESCRIPTION WR_DESC
			, SA.STATUS_APPROVE_ID
			, K.PLAN_RLA_KELOMPOK_EQUIPMENT_ID_INFO
			, L.NAMA EAM_NAMA
		FROM plan_rla A
		LEFT JOIN status_approve SA ON A.V_STATUS = SA.STATUS_APPROVE_ID
		LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		LEFT JOIN UNIT C ON C.UNIT_ID = A.UNIT_ID
		LEFT JOIN 
		(
			SELECT A.PENGGUNA_INTERNAL_ID AS USER_ID, NID, NAMA_LENGKAP AS NAMA	
			FROM PENGGUNA_INTERNAL A 
			UNION ALL 
			SELECT A.PENGGUNA_EXTERNAL_ID AS USER_ID, NID, A.NAMA
			FROM PENGGUNA_EXTERNAL A
			WHERE 1=1
		) D ON D.NID = A.PIC_ID
		LEFT JOIN 
		(
			SELECT A.PENGGUNA_INTERNAL_ID AS USER_ID, NID, NAMA_LENGKAP AS NAMA	
			FROM PENGGUNA_INTERNAL A 
			UNION ALL 
			SELECT A.PENGGUNA_EXTERNAL_ID AS USER_ID, NID, A.NAMA
			FROM PENGGUNA_EXTERNAL A
			WHERE 1=1
		) E ON E.NID = A.PEMERIKSA_ID
		LEFT JOIN 
		(
			SELECT  B.PLAN_RLA_ID
			,STRING_AGG(A.FORM_UJI_ID::text, ', ') AS FORM_UJI_ID_INFO
			,STRING_AGG(A.NAMA, ', ') AS NAMA_FORM
			FROM FORM_UJI A
			INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
			GROUP BY B.PLAN_RLA_ID
		) F ON F.PLAN_RLA_ID = A.PLAN_RLA_ID
		LEFT JOIN EAM G ON G.EAM_ID = A.EQUIPMENT_ID
		LEFT JOIN 
		(
			SELECT B.PLAN_RLA_ID
			,STRING_AGG(A.PENGADAAN_KONTRAK_ID::text, ', ') AS PENGADAAN_KONTRAK_ID_INFO
			,STRING_AGG(A.NOMOR_KONTRAK, ', ') AS NOMOR_KONTRAK
			FROM PENGADAAN_KONTRAK A
			INNER JOIN PLAN_RLA_PENGADAAN B ON B.PENGADAAN_KONTRAK_ID = A.PENGADAAN_KONTRAK_ID 
			GROUP BY B.PLAN_RLA_ID
		) H ON H.PLAN_RLA_ID = A.PLAN_RLA_ID

		LEFT JOIN WORK_ORDER I ON I.WORK_ORDER_ID = A.WORK_ORDER_ID
		LEFT JOIN WORK_REQUEST J ON J.WORK_REQUEST_ID = A.WORK_REQUEST_ID
		LEFT JOIN 
		(
			SELECT A.PLAN_RLA_ID
			,STRING_AGG(A.KELOMPOK_EQUIPMENT_ID::text, ', ') AS PLAN_RLA_KELOMPOK_EQUIPMENT_ID_INFO
			FROM PLAN_RLA_KELOMPOK_EQUIPMENT A
			GROUP BY A.PLAN_RLA_ID
		) K ON K.PLAN_RLA_ID = A.PLAN_RLA_ID
		LEFT JOIN EAM L ON L.EAM_ID = A.EQUIPMENT_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckRole($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.ROLE_ID")
	{
		$str = "
		SELECT
			* FROM ROLE_APPROVAL A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPlanRlaFormUji($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.PLAN_RLA_FORM_UJI_ID")
	{
		$str = "
		SELECT
			* FROM PLAN_RLA_FORM_UJI A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPlanRlaFormUjiTemplate($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.FORM_UJI_ID")
	{
		$str = "
		SELECT  B.PLAN_RLA_ID,A.FORM_UJI_ID,A.NAMA
		FROM FORM_UJI A
		INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
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

     function selectByParamsPlanRlaFormUjiTemplateTipe($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.FORM_UJI_ID")
	{
		$str = "
		SELECT A.FORM_UJI_ID, A.FORM_UJI_TIPE_ID,B.NAMA
		FROM FORM_UJI_ISI A
		LEFT JOIN FORM_UJI_TIPE B ON B.FORM_UJI_TIPE_ID = A.FORM_UJI_TIPE_ID 
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

    function selectByParamsPlanRlaFormUjiJumlah($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ")
	{
		$str = "
		SELECT COUNT (1) AS ROWCOUNT FROM form_uji_detil A
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

    function selectByParamsPlanRlaFormUjiDetilNama($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ")
	{
		$str = "
		SELECT * FROM form_uji_detil A
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

    function selectByParamsPlanRlaFormUjiNama($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ")
	{
		$str = "
		SELECT * FROM form_uji A
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

    function selectByParamsPlanRlaFormUjiTemplateDinamis($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY D.KELOMPOK_EQUIPMENT_ID")
	{
		$str = "
		SELECT  A.FORM_UJI_ID,A.NAMA,D.KELOMPOK_EQUIPMENT_ID,D.NAMA NAMA_KELOMPOK
		FROM FORM_UJI A
		INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
		INNER JOIN FORM_UJI_DETIL_DINAMIS C ON C.FORM_UJI_ID = A.FORM_UJI_ID AND C.STATUS_TABLE ='TABLE'
		INNER JOIN KELOMPOK_EQUIPMENT D ON D.KELOMPOK_EQUIPMENT_ID = B.KELOMPOK_EQUIPMENT_ID
		WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.FORM_UJI_ID,A.NAMA,D.KELOMPOK_EQUIPMENT_ID   ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPlanRlaFormUjiTemplatePengukuran($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.PENGUKURAN_ID,D.SEQ
 ")
	{
		$str = "
		SELECT A.FORM_UJI_ID , A.PENGUKURAN_ID,B.NAMA,A.TABEL_TEMPLATE_ID, C.NAMA NAMA_TABEL,A.TIPE_INPUT_ID,A.PENGUKURAN_TIPE_INPUT_ID,D.SEQ
		FROM FORM_UJI_DETIL_DINAMIS A 
		INNER JOIN PENGUKURAN B ON B.PENGUKURAN_ID = A.PENGUKURAN_ID 
		INNER JOIN TABEL_TEMPLATE C ON C.TABEL_TEMPLATE_ID = A.TABEL_TEMPLATE_ID
		INNER JOIN PENGUKURAN_TIPE_INPUT D ON D.PENGUKURAN_TIPE_INPUT_ID = A.PENGUKURAN_TIPE_INPUT_ID
		WHERE 1=1
		AND A.STATUS_TABLE = 'TABLE'
		

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.FORM_UJI_ID,A.PENGUKURAN_ID,B.NAMA,A.TABEL_TEMPLATE_ID, C.NAMA , A.TIPE_INPUT_ID,A.PENGUKURAN_TIPE_INPUT_ID,D.SEQ ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

     function selectByParamsFormUjiReport($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY E.KELOMPOK_EQUIPMENT_ID")
	{
		$str = "
		SELECT  A.FORM_UJI_ID,A.NAMA,E.KELOMPOK_EQUIPMENT_ID,E.NAMA NAMA_KELOMPOK
		FROM FORM_UJI A
		INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
		INNER JOIN FORM_UJI_DETIL_DINAMIS C ON C.FORM_UJI_ID = A.FORM_UJI_ID AND C.STATUS_TABLE ='TABLE'
		INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS D ON D.FORM_UJI_ID = A.FORM_UJI_ID
		INNER JOIN KELOMPOK_EQUIPMENT E ON E.KELOMPOK_EQUIPMENT_ID = D.KELOMPOK_EQUIPMENT_ID
		WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.FORM_UJI_ID,A.NAMA,E.KELOMPOK_EQUIPMENT_ID,E.NAMA  ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


     function selectByParamsListFormUji($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="  ORDER BY B.PLAN_RLA_FORM_UJI_ID ASC")
	{
		$str = "
		SELECT  B.PLAN_RLA_ID
		,A.FORM_UJI_ID
		,C.KELOMPOK_EQUIPMENT_ID
		,A.NAMA FORM_UJI_NAMA
		,C.NAMA KELOMPOK_EQUIPMENT_NAMA
		FROM FORM_UJI A
		INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
		INNER JOIN KELOMPOK_EQUIPMENT C ON C.KELOMPOK_EQUIPMENT_ID = B.KELOMPOK_EQUIPMENT_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }



     function selectByParamsFormUjiReportNew($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY E.ID")
	{
		$str = "
		SELECT  A.FORM_UJI_ID,A.NAMA,E.KELOMPOK_EQUIPMENT_ID,E.NAMA NAMA_KELOMPOK,E.ID,E.KELOMPOK_EQUIPMENT_PARENT_ID,E.PARENT_ID
		FROM FORM_UJI A
		INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
		INNER JOIN FORM_UJI_DETIL_DINAMIS C ON C.FORM_UJI_ID = A.FORM_UJI_ID 
		INNER JOIN PLAN_RLA_KELOMPOK_EQUIPMENT D ON D.PLAN_RLA_ID = B.PLAN_RLA_ID
		INNER JOIN KELOMPOK_EQUIPMENT E ON E.KELOMPOK_EQUIPMENT_ID = D.KELOMPOK_EQUIPMENT_ID
		INNER JOIN FORM_UJI_KELOMPOK_EQUIPMENT F ON F.KELOMPOK_EQUIPMENT_ID = E.KELOMPOK_EQUIPMENT_ID AND  F.FORM_UJI_ID = A.FORM_UJI_ID
		WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.FORM_UJI_ID,A.NAMA,E.KELOMPOK_EQUIPMENT_ID,E.NAMA  ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }



    function selectByParamsKelompokEquipment($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.ID")
    {
    	$str = "
    	SELECT A.KELOMPOK_EQUIPMENT_ID,A.NAMA,A.ID,A.KELOMPOK_EQUIPMENT_PARENT_ID,A.PARENT_ID
    	FROM KELOMPOK_EQUIPMENT A
    	INNER JOIN PLAN_RLA_KELOMPOK_EQUIPMENT B ON B.KELOMPOK_EQUIPMENT_ID = A.KELOMPOK_EQUIPMENT_ID
    	WHERE 1=1

    	"; 

    	while(list($key,$val) = each($paramsArray))
    	{
    		$str .= " AND $key = '$val' ";
    	}

    	$str .= $statement." GROUP BY A.KELOMPOK_EQUIPMENT_ID  ".$sOrder;
		// echo $sOrder;exit;
    	$this->query = $str;

    	return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsNameplate($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.PLAN_RLA_NAMEPLATE_ID")
    {
    	$str = "
    	SELECT *
    	FROM PLAN_RLA_NAMEPLATE A
    	WHERE 1=1

    	"; 

    	while(list($key,$val) = each($paramsArray))
    	{
    		$str .= " AND $key = '$val' ";
    	}

    	$str .= $statement." ".$sOrder;
		// echo $sOrder;exit;
    	$this->query = $str;

    	return $this->selectLimit($str,$limit,$from); 
    }


     function selectByParamsPlanRlaPengukuran($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.FORM_UJI_ID")
	{
		$str = "
		SELECT B.PLAN_RLA_ID,A.FORM_UJI_ID,A.NAMA, B.KELOMPOK_EQUIPMENT_ID,C.NAMA KELOMPOK_NAMA
		FROM FORM_UJI A 
		INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
		INNER JOIN KELOMPOK_EQUIPMENT C ON C.KELOMPOK_EQUIPMENT_ID = B.KELOMPOK_EQUIPMENT_ID 
		WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY  B.PLAN_RLA_ID,A.FORM_UJI_ID,A.NAMA, B.KELOMPOK_EQUIPMENT_ID,C.NAMA  ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }



    function selectByParamsKelompokEquipmentPengukuran($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.ID")
    {
    	$str = "
    	SELECT A.KELOMPOK_EQUIPMENT_ID,A.NAMA,A.PARENT_ID,A.ID
    	FROM KELOMPOK_EQUIPMENT A
    	INNER JOIN PLAN_RLA_KELOMPOK_EQUIPMENT B ON B.KELOMPOK_EQUIPMENT_ID = A.KELOMPOK_EQUIPMENT_ID
    	INNER JOIN PLAN_RLA_FORM_UJI C ON C.KELOMPOK_EQUIPMENT_ID = B.KELOMPOK_EQUIPMENT_ID

    	WHERE 1=1

    	"; 

    	while(list($key,$val) = each($paramsArray))
    	{
    		$str .= " AND $key = '$val' ";
    	}

    	$str .= $statement." GROUP BY A.KELOMPOK_EQUIPMENT_ID  ".$sOrder;
		// echo $sOrder;exit;
    	$this->query = $str;

    	return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsSummary($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY A.PLAN_RLA_SUMMARY_ID")
    {
    	$str = "
    	
    	SELECT A.*
		, B.NAMA_LENGKAP TESTED_NAMA
		, C.NAMA_LENGKAP COORDINATOR_NAMA
		, D.NAMA_LENGKAP QUALITY_NAMA
		, E.NAMA_LENGKAP WITNESS_NAMA
    	FROM PLAN_RLA_SUMMARY A
    	LEFT JOIN 
    	(
			SELECT A.PENGGUNA_INTERNAL_ID AS USER_ID, NID, NAMA_LENGKAP, '1' STATUS
			FROM PENGGUNA_INTERNAL A 
			WHERE 1=1
			UNION ALL
			SELECT A.PENGGUNA_EXTERNAL_ID AS USER_ID, NID, NAMA, '2' STATUS
			FROM PENGGUNA_EXTERNAL A 
			WHERE 1=1 
    	) B ON B.USER_ID = A.TESTED_ID AND A.TESTED_STATUS = B.STATUS
    	LEFT JOIN 
    	(
			SELECT A.PENGGUNA_INTERNAL_ID AS USER_ID, NID, NAMA_LENGKAP, '1' STATUS
			FROM PENGGUNA_INTERNAL A 
			WHERE 1=1
			UNION ALL
			SELECT A.PENGGUNA_EXTERNAL_ID AS USER_ID, NID, NAMA, '2' STATUS
			FROM PENGGUNA_EXTERNAL A 
			WHERE 1=1
    	) C ON C.USER_ID = A.COORDINATOR_ID AND A.COORDINATOR_STATUS = C.STATUS
    	LEFT JOIN 
    	(
			SELECT A.PENGGUNA_INTERNAL_ID AS USER_ID, NID, NAMA_LENGKAP, '1' STATUS
			FROM PENGGUNA_INTERNAL A 
			WHERE 1=1
			UNION ALL
			SELECT A.PENGGUNA_EXTERNAL_ID AS USER_ID, NID, NAMA, '2' STATUS
			FROM PENGGUNA_EXTERNAL A 
			WHERE 1=1 
    	) D ON D.USER_ID = A.QUALITY_ID AND A.QUALITY_STATUS = D.STATUS
    	LEFT JOIN 
    	(
			SELECT A.PENGGUNA_INTERNAL_ID AS USER_ID, NID, NAMA_LENGKAP, '1' STATUS
			FROM PENGGUNA_INTERNAL A 
			WHERE 1=1
			UNION ALL
			SELECT A.PENGGUNA_EXTERNAL_ID AS USER_ID, NID, NAMA, '2' STATUS
			FROM PENGGUNA_EXTERNAL A 
			WHERE 1=1 
    	) E ON E.USER_ID = A.WITNESS_ID AND A.WITNESS_STATUS = E.STATUS
    	WHERE 1=1


    	"; 

    	while(list($key,$val) = each($paramsArray))
    	{
    		$str .= " AND $key = '$val' ";
    	}

    	$str .= $statement." ".$sOrder;
		// echo $sOrder;exit;
    	$this->query = $str;

    	return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsFilterTahun($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT TAHUN
		FROM
		(
			SELECT DATE_PART('year',RENCANA_TANGGAL_AWAL)  TAHUN
			FROM PLAN_RLA
			GROUP BY DATE_PART('year',RENCANA_TANGGAL_AWAL) 
			UNION ALL
			SELECT DATE_PART('year',RENCANA_TANGGAL_AKHIR) 
			TAHUN FROM PLAN_RLA
			GROUP BY DATE_PART('year',RENCANA_TANGGAL_AKHIR)
			UNION ALL
			SELECT DATE_PART('year',REALISASI_TANGGAL_AWAL)
			TAHUN FROM PLAN_RLA
			GROUP BY DATE_PART('year',REALISASI_TANGGAL_AWAL)
			UNION ALL
			SELECT DATE_PART('year',REALISASI_TANGGAL_AKHIR)
			TAHUN FROM PLAN_RLA
			GROUP BY DATE_PART('year',REALISASI_TANGGAL_AKHIR)
		) A
		WHERE TAHUN IS NOT NULL
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY TAHUN  ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectcheckapproval($reftabel, $refid, $statement, $sOrder="ORDER BY B.FLOWD_INDEX ASC")
	{
		$str = "
		SELECT
			B.ROLE_ID, B.FLOWD_INDEX, C.ROLE_NAMA, D.APPR_ID
		FROM flow_approval A
		INNER JOIN flow_appdetail B ON A.FLOW_ID = B.FLOW_ID
		INNER JOIN role_approval C ON B.ROLE_ID = C.ROLE_ID
		INNER JOIN
		(
			SELECT B.KODE_MODUL, A.*
			FROM approval A
			INNER JOIN (SELECT KODE_MODUL, LINK_MODUL FROM pengguna_modul) B ON LINK_MODUL = REF_TABEL
		) D ON D.KODE_MODUL = A.REF_TABEL AND REF_ID = '".$refid."'
		WHERE 1=1 AND D.REF_TABEL = '".$reftabel."'
		";
		
		$str .= $statement."  ".$sOrder;
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,-1,-1); 
    }



   

  } 
?>