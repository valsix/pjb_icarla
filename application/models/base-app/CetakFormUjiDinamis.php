<? 
  include_once(APPPATH.'/models/Entity.php');

  class CetakFormUjiDinamis extends Entity{ 

	var $query;

    function CetakFormUjiDinamis()
	{
      $this->Entity(); 
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
	

 //    function selectByParamsFormUjiReport($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY E.KELOMPOK_EQUIPMENT_ID")
	// {
	// 	$str = "
	// 	SELECT  A.FORM_UJI_ID,A.NAMA,E.KELOMPOK_EQUIPMENT_ID,E.NAMA NAMA_KELOMPOK,A.NAMEPLATE_ID
	// 	FROM FORM_UJI A
	// 	INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
	// 	INNER JOIN FORM_UJI_DETIL_DINAMIS C ON C.FORM_UJI_ID = A.FORM_UJI_ID AND C.STATUS_TABLE ='TABLE'
	// 	INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS D ON D.FORM_UJI_ID = A.FORM_UJI_ID
	// 	INNER JOIN KELOMPOK_EQUIPMENT E ON E.KELOMPOK_EQUIPMENT_ID = D.KELOMPOK_EQUIPMENT_ID
	// 	WHERE 1=1

	// 	"; 
		
	// 	while(list($key,$val) = each($paramsArray))
	// 	{
	// 		$str .= " AND $key = '$val' ";
	// 	}
		
	// 	$str .= $statement." GROUP BY A.FORM_UJI_ID,A.NAMA,E.KELOMPOK_EQUIPMENT_ID,E.NAMA,A.NAMEPLATE_ID  ".$sOrder;
	// 	// echo $sOrder;exit;
	// 	$this->query = $str;
				
	// 	return $this->selectLimit($str,$limit,$from); 
 //    }

	function selectByParamsFormUjiReport($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY E.KELOMPOK_EQUIPMENT_ID")
	{
		$str = "
		SELECT  A.FORM_UJI_ID,A.NAMA,E.KELOMPOK_EQUIPMENT_ID,E.NAMA NAMA_KELOMPOK,A.NAMEPLATE_ID,E.PARENT_ID,E.ID
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
		
		$str .= $statement." GROUP BY A.FORM_UJI_ID,A.NAMA,E.KELOMPOK_EQUIPMENT_ID,E.NAMA,A.NAMEPLATE_ID  ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }



    function selectByParamsReport($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="")
	{
		$str = "
		SELECT  A.FORM_UJI_ID,A.NAMA,E.TABEL_TEMPLATE_ID,E.NAMA TABEL_NAMA,D.PENGUKURAN_ID,F.KELOMPOK_EQUIPMENT_ID,F.NAMA NAMA_KELOMPOK
		FROM FORM_UJI A
		INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
		INNER JOIN FORM_UJI_DETIL_DINAMIS C ON C.FORM_UJI_ID = A.FORM_UJI_ID AND C.STATUS_TABLE ='TABLE'
		INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS D ON D.FORM_UJI_ID = A.FORM_UJI_ID
		INNER JOIN TABEL_TEMPLATE E ON E.TABEL_TEMPLATE_ID = D.TABEL_TEMPLATE_ID
		INNER JOIN KELOMPOK_EQUIPMENT F ON F.KELOMPOK_EQUIPMENT_ID = D.KELOMPOK_EQUIPMENT_ID
		WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $unitment." GROUP BY A.FORM_UJI_ID,A.NAMA,E.TABEL_TEMPLATE_ID,D.PENGUKURAN_ID,F.KELOMPOK_EQUIPMENT_ID,F.NAMA  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsTipeInput($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY seq ASC")
	{
		$str = "
		SELECT 
			a.*, b.STATUS_TABLE
			from pengukuran_tipe_input a
			left join TIPE_INPUT b on a.TIPE_INPUT_ID= b.TIPE_INPUT_ID
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


    function selectByParamsFormUjiDetilDinamis($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY FORM_UJI_DETIL_DINAMIS_ID ASC")
	{
		$str = "
		SELECT 
			a.*
			from FORM_UJI_DETIL_DINAMIS  A
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

    function selectplanrlaujidinamis($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PLAN_RLA_FORM_UJI_DINAMIS_ID ASC")
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
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPengukuranTipeInput($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PENGUKURAN_ID,A.SEQ")
	{
		$str = "
		SELECT A.*,B.TABEL_TEMPLATE_ID, B.NAMA TABEL_NAMA, COALESCE( NULLIF(C.STATUS_TABLE,'') , 'BINARY' ) STATUS_TABLE
		FROM PENGUKURAN_TIPE_INPUT A
		LEFT JOIN TABEL_TEMPLATE B ON B.TABEL_TEMPLATE_ID = A.MASTER_TABEL_ID
		LEFT JOIN TIPE_INPUT C ON C.TIPE_INPUT_ID= A.TIPE_INPUT_ID
		LEFT JOIN FORM_UJI_DETIL_DINAMIS D ON D.PENGUKURAN_TIPE_INPUT_ID= A.PENGUKURAN_TIPE_INPUT_ID
		LEFT JOIN form_uji_kelompok_equipment E ON E.FORM_UJI_ID= D.FORM_UJI_ID
		INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS F ON A.PENGUKURAN_ID = F.PENGUKURAN_ID 
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PENGUKURAN_TIPE_INPUT_ID,B.TABEL_TEMPLATE_ID, B.NAMA,C.STATUS_TABLE ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsFormUjiPengukuran($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PENGUKURAN_ID")
	{
		$str = "
		SELECT A.*,B.PENGUKURAN_ID, B.NAMA PENGUKURAN_NAMA
		FROM FORM_UJI_PENGUKURAN A
		LEFT JOIN PENGUKURAN B ON B.PENGUKURAN_ID = A.PENGUKURAN_ID
		INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS C ON C.PENGUKURAN_ID = B.PENGUKURAN_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.FORM_UJI_PENGUKURAN_ID ,B.PENGUKURAN_ID,B.NAMA  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

     function selectByParamsPlanRlaDinamis($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="")
	{
		$str = "
		SELECT  A.*, B.NAMA TABEL_NAMA,C.NAMA PENGUKURAN_NAMA
		FROM PLAN_RLA_FORM_UJI_DINAMIS A
		INNER JOIN TABEL_TEMPLATE B ON B.TABEL_TEMPLATE_ID = A.TABEL_TEMPLATE_ID
		INNER JOIN PENGUKURAN C ON C.PENGUKURAN_ID = A.PENGUKURAN_ID
		WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $unitment."  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsDetil($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY TABEL_DETIL_ID ASC")
	{
		$str = "
		SELECT A.*, B.NAMA NAMA_TEMPLATE,B.ROWSPAN,B.COLSPAN,B.TABEL_DETIL_ID,B.BARIS
		FROM TABEL_TEMPLATE A
		INNER JOIN TABEL_DETIL B ON B.TABEL_TEMPLATE_ID = A.TABEL_TEMPLATE_ID
		INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS C ON C.TABEL_TEMPLATE_ID = A.TABEL_TEMPLATE_ID 
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.TABEL_TEMPLATE_ID, B.NAMA,B.ROWSPAN,B.COLSPAN,B.TABEL_DETIL_ID,B.BARIS ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMaxBaris($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT MAX(A.BARIS)  
		FROM TABEL_DETIL A
		INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS B ON B.TABEL_TEMPLATE_ID = A.TABEL_TEMPLATE_ID 
		WHERE  1=1
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
		SELECT A.BARIS  
		FROM TABEL_DETIL A
		INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS B ON B.TABEL_TEMPLATE_ID = A.TABEL_TEMPLATE_ID   
		WHERE  1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY BARIS ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsPengukuranTipeInputBaru($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PENGUKURAN_ID,D.SEQ")
	{
		$str = "
		SELECT
			A.PENGUKURAN_TIPE_INPUT_ID, D.VALUE, A.PENGUKURAN_ID, B.TABEL_TEMPLATE_ID
			, B.NAMA TABEL_NAMA, D.SEQ, COALESCE( NULLIF(A.STATUS_TABLE,'') , 'BINARY' ) STATUS_TABLE
			, COALESCE(MAX(F.BARIS),0) JUMLAH_ROW
		FROM form_uji_detil_dinamis A
		LEFT JOIN tabel_template B ON B.TABEL_TEMPLATE_ID = A.TABEL_TEMPLATE_ID
		LEFT JOIN tipe_input C ON C.TIPE_INPUT_ID= A.TIPE_INPUT_ID
		LEFT JOIN pengukuran_tipe_input D ON D.PENGUKURAN_TIPE_INPUT_ID= A.PENGUKURAN_TIPE_INPUT_ID AND A.TIPE_INPUT_ID = D.TIPE_INPUT_ID
		LEFT JOIN form_uji_kelompok_equipment E ON E.FORM_UJI_ID= A.FORM_UJI_ID
		INNER JOIN plan_rla_form_uji_dinamis F ON A.FORM_UJI_ID = F.FORM_UJI_ID  AND A.PENGUKURAN_ID = F.PENGUKURAN_ID AND D.PENGUKURAN_TIPE_INPUT_ID = A.PENGUKURAN_TIPE_INPUT_ID
		AND COALESCE(B.TABEL_TEMPLATE_ID,-1) = COALESCE(F.TABEL_TEMPLATE_ID,-1)
		AND A.STATUS_TABLE = F.STATUS_TABLE 
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PENGUKURAN_TIPE_INPUT_ID,D.VALUE,B.TABEL_TEMPLATE_ID, B.NAMA,A.STATUS_TABLE,D.SEQ,A.PENGUKURAN_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


     function selectByParamsMaxBarisPlanRla($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT MAX(A.BARIS)  
		FROM PLAN_RLA_FORM_UJI_DINAMIS A
		WHERE  1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsPengukuranTipeInputBaruText($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PENGUKURAN_ID,D.SEQ")
	{
		$str = "
		SELECT A.PENGUKURAN_TIPE_INPUT_ID,A.NAMA,D.VALUE,A.PENGUKURAN_ID,B.TABEL_TEMPLATE_ID, B.NAMA TABEL_NAMA,D.SEQ, COALESCE( NULLIF(A.STATUS_TABLE,'') , 'BINARY' ) STATUS_TABLE
		FROM FORM_UJI_DETIL_DINAMIS A
		LEFT JOIN TABEL_TEMPLATE B ON B.TABEL_TEMPLATE_ID = A.TABEL_TEMPLATE_ID
		LEFT JOIN TIPE_INPUT C ON C.TIPE_INPUT_ID= A.TIPE_INPUT_ID
		LEFT JOIN PENGUKURAN_TIPE_INPUT D ON D.PENGUKURAN_TIPE_INPUT_ID= A.PENGUKURAN_TIPE_INPUT_ID
		LEFT JOIN form_uji_kelompok_equipment E ON E.FORM_UJI_ID= A.FORM_UJI_ID
		INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS F ON A.FORM_UJI_ID = F.FORM_UJI_ID  AND A.PENGUKURAN_ID = F.PENGUKURAN_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PENGUKURAN_TIPE_INPUT_ID,A.NAMA,D.VALUE,B.TABEL_TEMPLATE_ID, B.NAMA,A.STATUS_TABLE,D.SEQ,A.PENGUKURAN_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


     function countFormUjiDetilDinamis($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT 
			count(1) as ROWCOUNT
			from FORM_UJI_DETIL_DINAMIS  A
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

 //    function selectByParamsFormUjiReportNameplate($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY E.KELOMPOK_EQUIPMENT_ID")
	// {
	// 	$str = "
	// 	SELECT  A.FORM_UJI_ID,A.NAMA,E.KELOMPOK_EQUIPMENT_ID,E.NAMA NAMA_KELOMPOK,A.NAMEPLATE_ID,F.NAMA NAMA_NAMEPLATE
	// 	FROM FORM_UJI A
	// 	INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID
	// 	INNER JOIN FORM_UJI_DETIL_DINAMIS C ON C.FORM_UJI_ID = A.FORM_UJI_ID AND C.STATUS_TABLE ='TABLE'
	// 	INNER JOIN PLAN_RLA_FORM_UJI_DINAMIS D ON D.FORM_UJI_ID = A.FORM_UJI_ID
	// 	INNER JOIN KELOMPOK_EQUIPMENT E ON E.KELOMPOK_EQUIPMENT_ID = D.KELOMPOK_EQUIPMENT_ID
	// 	INNER JOIN NAMEPLATE F ON F.NAMEPLATE_ID = A.NAMEPLATE_ID
	// 	WHERE 1=1

	// 	"; 
		
	// 	while(list($key,$val) = each($paramsArray))
	// 	{
	// 		$str .= " AND $key = '$val' ";
	// 	}
		
	// 	$str .= $statement." GROUP BY A.FORM_UJI_ID,A.NAMA,E.KELOMPOK_EQUIPMENT_ID,E.NAMA,A.NAMEPLATE_ID,F.NAMA  ".$sOrder;
	// 	// echo $sOrder;exit;
	// 	$this->query = $str;
				
	// 	return $this->selectLimit($str,$limit,$from); 
 //    }

     function selectByParamsFormUjiReportNameplate($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY F.KELOMPOK_EQUIPMENT_ID")
	{
		$str = "
		SELECT A.FORM_UJI_ID,A.NAMA,G.PENGUKURAN_ID,F.KELOMPOK_EQUIPMENT_ID,F.NAMA NAMA_KELOMPOK,G.NAMA PENGUKURAN_NAMA,J.NAMEPLATE_ID,J.NAMA NAMA_NAMEPLATE 
		FROM FORM_UJI A 
		INNER JOIN PLAN_RLA_FORM_UJI B ON B.FORM_UJI_ID = A.FORM_UJI_ID 
		INNER JOIN FORM_UJI_DETIL_DINAMIS C ON C.FORM_UJI_ID = A.FORM_UJI_ID 
		INNER JOIN PLAN_RLA_KELOMPOK_EQUIPMENT D ON D.PLAN_RLA_ID = B.PLAN_RLA_ID 
		INNER JOIN KELOMPOK_EQUIPMENT F ON F.KELOMPOK_EQUIPMENT_ID = D.KELOMPOK_EQUIPMENT_ID
		INNER JOIN FORM_UJI_PENGUKURAN H ON H.FORM_UJI_ID = A.FORM_UJI_ID
		INNER JOIN PENGUKURAN G ON G.PENGUKURAN_ID = H.PENGUKURAN_ID 
		INNER JOIN PLAN_RLA_NAMEPLATE I ON I.PLAN_RLA_ID = D.PLAN_RLA_ID AND I.KELOMPOK_EQUIPMENT_ID = D.KELOMPOK_EQUIPMENT_ID
		INNER JOIN NAMEPLATE J ON J.NAMEPLATE_ID = I.NAMEPLATE_ID
		WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.FORM_UJI_ID,A.NAMA,G.PENGUKURAN_ID,F.KELOMPOK_EQUIPMENT_ID,F.NAMA,G.NAMA,J.NAMEPLATE_ID  ".$sOrder;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

     function selectByParamsFormUjiReportNameplateNew($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY F.KELOMPOK_EQUIPMENT_ID")
	{
		$str = "
		
		SELECT F.KELOMPOK_EQUIPMENT_ID,F.NAMA NAMA_KELOMPOK,J.NAMEPLATE_ID,J.NAMA NAMA_NAMEPLATE,F.PARENT_ID,F.ID
		FROM PLAN_RLA_NAMEPLATE A 
		INNER JOIN PLAN_RLA_KELOMPOK_EQUIPMENT D ON D.PLAN_RLA_ID = A.PLAN_RLA_ID AND D.KELOMPOK_EQUIPMENT_ID = A.KELOMPOK_EQUIPMENT_ID
		INNER JOIN KELOMPOK_EQUIPMENT F ON F.KELOMPOK_EQUIPMENT_ID = D.KELOMPOK_EQUIPMENT_ID
		INNER JOIN NAMEPLATE J ON J.NAMEPLATE_ID = A.NAMEPLATE_ID
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


    function selectByParamsPlanRlaCatatan($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PLAN_RLA_ID ASC")
	{
		$str = "
		SELECT A.*,B.NAMA NAMA_CATATAN,B.TANGGAL TANGGAL_CATATAN,B.CATATAN
		from PLAN_RLA A 
		INNER JOIN CATATAN_RLA B ON A.PLAN_RLA_ID = B.PLAN_RLA_ID
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


    function selectByParamsPlanRla($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PLAN_RLA_ID ASC")
	{
		$str = "
		SELECT A.*
		from PLAN_RLA A 
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


    function selectByParamsNameplate($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.NAMEPLATE_DETIL_ID ASC")
	{
		$str = "
		SELECT A.*,B.NAMA NAMA_NAMEPLATE
		from NAMEPLATE_DETIL A 
		INNER JOIN NAMEPLATE B ON B.NAMEPLATE_ID = A.NAMEPLATE_ID
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