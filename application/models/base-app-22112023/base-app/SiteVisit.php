<? 
  include_once(APPPATH.'/models/Entity.php');

  class SiteVisit extends Entity{ 

	var $query;

    function SiteVisit()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("SITE_VISIT_ID", $this->getNextId("SITE_VISIT_ID","site_visit"));

    	$str = "
    	INSERT INTO site_visit
    	(
    		SITE_VISIT_ID, GENERAL_SEKTOR, DISTRIK_ID, GENERAL_REPORT, 
            GENERAL_TANGGAL_SITE, GENERAL_NAME, GENERAL_DRAWING, KRONOLOGI_GANGGUAN, 
            KRONOLOGI_DOKUMEN, KRONOLOGI_ATTACH_FILE, KRONOLOGI_WAITING_TIME, 
            SITE_INVESTIGATION, SITE_DOKUMEN_REVERENCE, SITE_ATTACH_FILE, 
            SITE_INVESTIGATION_TIME, ANALISA, ANALISA_TIME, TASK_DESCRIPTION, TASK_EXECUTION_TIME, 
            MAINTENANCE_POST, MAINTENANCE_DOKUMENTASI, MAINTENANCE_ATTACH_FILE, 
            MAINTENANCE_POST_TIME, MAINTENANCE_STANDART, KOMPARASI_WRENCH_TIME, 
            KOMPARASI_TOTAL_DOWN_TIME, KOMPARASI_START_DATE, KOMPARASI_FINISH_DATE, 
            KESIMPULAN_REKOMEN, KESIMPULAN_LESSON, PEMERIKSA_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("SITE_VISIT_ID")."
	    	, '".$this->getField("GENERAL_SEKTOR")."'
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("GENERAL_REPORT")."'
	    	, ".$this->getField("GENERAL_TANGGAL_SITE")."
	    	, '".$this->getField("GENERAL_NAME")."'
	    	, '".$this->getField("GENERAL_DRAWING")."'
	    	, '".$this->getField("KRONOLOGI_GANGGUAN")."'
	    	, '".$this->getField("KRONOLOGI_DOKUMEN")."'
	    	, '".$this->getField("KRONOLOGI_ATTACH_FILE")."'
	    	, ".$this->getField("KRONOLOGI_WAITING_TIME")."
	    	, '".$this->getField("SITE_INVESTIGATION")."'
	    	, '".$this->getField("SITE_DOKUMEN_REVERENCE")."'
	    	, '".$this->getField("SITE_ATTACH_FILE")."'
	    	, ".$this->getField("SITE_INVESTIGATION_TIME")."
	    	, '".$this->getField("ANALISA")."'
	    	, ".$this->getField("ANALISA_TIME")."
	    	, '".$this->getField("TASK_DESCRIPTION")."'
	    	, ".$this->getField("TASK_EXECUTION_TIME")."
	    	, '".$this->getField("MAINTENANCE_POST")."'
	    	, '".$this->getField("MAINTENANCE_DOKUMENTASI")."'
	    	, '".$this->getField("MAINTENANCE_ATTACH_FILE")."'
	    	, ".$this->getField("MAINTENANCE_POST_TIME")."
	    	, '".$this->getField("MAINTENANCE_STANDART")."'
	    	, ".$this->getField("KOMPARASI_WRENCH_TIME")."
	    	, ".$this->getField("KOMPARASI_TOTAL_DOWN_TIME")."
	    	, ".$this->getField("KOMPARASI_START_DATE")."
	    	, ".$this->getField("KOMPARASI_FINISH_DATE")."
	    	, '".$this->getField("KESIMPULAN_REKOMEN")."'
	    	, '".$this->getField("KESIMPULAN_LESSON")."'
	    	, ".$this->getField("PEMERIKSA_ID")."
	    )"; 

		$this->id= $this->getField("SITE_VISIT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function inserttask()
    {
    	$this->setField("SITE_VISIT_TASK_ID", $this->getNextId("SITE_VISIT_TASK_ID","site_visit_task"));

    	$str = "
    	INSERT INTO site_visit_task
    	(
    		SITE_VISIT_TASK_ID,SITE_VISIT_ID, DESKRIPSI, MATERIAL, TOOLS, 
            RESOURCE
    	)
    	VALUES 
    	(
	    	".$this->getField("SITE_VISIT_TASK_ID")."
	    	, ".$this->getField("SITE_VISIT_ID")."
	    	, '".$this->getField("DESKRIPSI")."'
	    	, '".$this->getField("MATERIAL")."'
	    	, '".$this->getField("TOOLS")."'
	    	, '".$this->getField("RESOURCE")."'
	    	
	    )"; 

		$this->id= $this->getField("SITE_VISIT_TASK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertmaintenance()
    {
    	$this->setField("SITE_VISIT_MAINTENANCE_ID", $this->getNextId("SITE_VISIT_MAINTENANCE_ID","site_visit_maintenance"));

    	$str = "
    	INSERT INTO site_visit_maintenance
    	(
    		SITE_VISIT_MAINTENANCE_ID,SITE_VISIT_ID, TOOLS
    	)
    	VALUES 
    	(
	    	".$this->getField("SITE_VISIT_MAINTENANCE_ID")."
	    	, ".$this->getField("SITE_VISIT_ID")."
	    	, '".$this->getField("TOOLS")."'
	    	
	    )"; 

		$this->id= $this->getField("SITE_VISIT_MAINTENANCE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertkomparasi()
    {
    	$this->setField("SITE_VISIT_KOMPARASI_ID", $this->getNextId("SITE_VISIT_KOMPARASI_ID","site_visit_komparasi"));

    	$str = "
    	INSERT INTO site_visit_komparasi
    	(
    		SITE_VISIT_KOMPARASI_ID,SITE_VISIT_ID, PARAMETER, SATUAN, SEBELUM, 
            SESUDAH
    	)
    	VALUES 
    	(
	    	".$this->getField("SITE_VISIT_KOMPARASI_ID")."
	    	, ".$this->getField("SITE_VISIT_ID")."
	    	, '".$this->getField("PARAMETER")."'
	    	, '".$this->getField("SATUAN")."'
	    	, '".$this->getField("SEBELUM")."'
	    	, '".$this->getField("SESUDAH")."'
	    	
	    )"; 

		$this->id= $this->getField("SITE_VISIT_KOMPARASI_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertpersonal()
    {
    	$this->setField("SITE_VISIT_PERSONAL_ID", $this->getNextId("SITE_VISIT_PERSONAL_ID","site_visit_personal"));

    	$str = "
    	INSERT INTO site_visit_personal
    	(
    		SITE_VISIT_PERSONAL_ID,SITE_VISIT_ID, NID, NAMA, UNIT
    	)
    	VALUES 
    	(
	    	".$this->getField("SITE_VISIT_PERSONAL_ID")."
	    	, ".$this->getField("SITE_VISIT_ID")."
	    	, '".$this->getField("NID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("UNIT")."'
	    	
	    )"; 

		$this->id= $this->getField("SITE_VISIT_KOMPARASI_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE site_visit
		SET
		 GENERAL_SEKTOR='".$this->getField("GENERAL_SEKTOR")."'
		, DISTRIK_ID=".$this->getField("DISTRIK_ID")."
		, GENERAL_REPORT='".$this->getField("GENERAL_REPORT")."'
		, GENERAL_TANGGAL_SITE=".$this->getField("GENERAL_TANGGAL_SITE")."
		, GENERAL_NAME='".$this->getField("GENERAL_NAME")."'
		, GENERAL_DRAWING='".$this->getField("GENERAL_DRAWING")."'
		, KRONOLOGI_GANGGUAN='".$this->getField("KRONOLOGI_GANGGUAN")."'
		, KRONOLOGI_DOKUMEN='".$this->getField("KRONOLOGI_DOKUMEN")."'
		, KRONOLOGI_ATTACH_FILE='".$this->getField("KRONOLOGI_ATTACH_FILE")."'
		, KRONOLOGI_WAITING_TIME=".$this->getField("KRONOLOGI_WAITING_TIME")."
		, SITE_INVESTIGATION='".$this->getField("SITE_INVESTIGATION")."'
		, SITE_DOKUMEN_REVERENCE='".$this->getField("SITE_DOKUMEN_REVERENCE")."'
		, SITE_ATTACH_FILE='".$this->getField("SITE_ATTACH_FILE")."'
		, SITE_INVESTIGATION_TIME=".$this->getField("SITE_INVESTIGATION_TIME")."
		, ANALISA='".$this->getField("ANALISA")."'
		, ANALISA_TIME=".$this->getField("ANALISA_TIME")."
		, TASK_DESCRIPTION='".$this->getField("TASK_DESCRIPTION")."'
		, TASK_EXECUTION_TIME=".$this->getField("TASK_EXECUTION_TIME")."
		, MAINTENANCE_POST='".$this->getField("MAINTENANCE_POST")."'
		, MAINTENANCE_DOKUMENTASI='".$this->getField("MAINTENANCE_DOKUMENTASI")."'
		, MAINTENANCE_ATTACH_FILE='".$this->getField("MAINTENANCE_ATTACH_FILE")."'
		, MAINTENANCE_POST_TIME=".$this->getField("MAINTENANCE_POST_TIME")."
		, MAINTENANCE_STANDART='".$this->getField("MAINTENANCE_STANDART")."'
		, KOMPARASI_WRENCH_TIME=".$this->getField("KOMPARASI_WRENCH_TIME")."
		, KOMPARASI_TOTAL_DOWN_TIME=".$this->getField("KOMPARASI_TOTAL_DOWN_TIME")."
		, KOMPARASI_START_DATE=".$this->getField("KOMPARASI_START_DATE")."
		, KOMPARASI_FINISH_DATE=".$this->getField("KOMPARASI_FINISH_DATE")."
		, KESIMPULAN_REKOMEN='".$this->getField("KESIMPULAN_REKOMEN")."'
		, KESIMPULAN_LESSON='".$this->getField("KESIMPULAN_LESSON")."'
		, PEMERIKSA_ID=".$this->getField("PEMERIKSA_ID")."
		WHERE SITE_VISIT_ID = '".$this->getField("SITE_VISIT_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateupload($field)
	{
		$str = "
		UPDATE site_visit
		SET
		".$field."='".$this->getField($field)."'
		WHERE SITE_VISIT_ID = '".$this->getField("SITE_VISIT_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str .= "
		DELETE FROM site_visit
		WHERE 
		SITE_VISIT_ID = ".$this->getField("SITE_VISIT_ID").";";

		$str .= "
		DELETE FROM site_visit_task
		WHERE 
		SITE_VISIT_ID = ".$this->getField("SITE_VISIT_ID").";";

		$str .= "
		DELETE FROM site_visit_maintenance
		WHERE 
		SITE_VISIT_ID = ".$this->getField("SITE_VISIT_ID").";";

		$str .= "
		DELETE FROM site_visit_komparasi
		WHERE 
		SITE_VISIT_ID = ".$this->getField("SITE_VISIT_ID").";";

		$str .= "
		DELETE FROM site_visit_personal
		WHERE 
		SITE_VISIT_ID = ".$this->getField("SITE_VISIT_ID").";"; 


		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deletetask()
	{
		$str = "
		DELETE FROM site_visit_task
		WHERE 
		SITE_VISIT_ID = ".$this->getField("SITE_VISIT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletetaskdetail()
	{
		$str = "
		DELETE FROM site_visit_task
		WHERE 
		SITE_VISIT_TASK_ID = ".$this->getField("SITE_VISIT_TASK_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletemaintenance()
	{
		$str = "
		DELETE FROM site_visit_maintenance
		WHERE 
		SITE_VISIT_ID = ".$this->getField("SITE_VISIT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletemaintenancedetail()
	{
		$str = "
		DELETE FROM site_visit_maintenance
		WHERE 
		SITE_VISIT_MAINTENANCE_ID = ".$this->getField("SITE_VISIT_MAINTENANCE_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletekomparasi()
	{
		$str = "
		DELETE FROM site_visit_komparasi
		WHERE 
		SITE_VISIT_ID = ".$this->getField("SITE_VISIT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletekomparasidetail()
	{
		$str = "
		DELETE FROM site_visit_komparasi
		WHERE 
		SITE_VISIT_KOMPARASI_ID = ".$this->getField("SITE_VISIT_KOMPARASI_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function deletepersonal()
	{
		$str = "
		DELETE FROM site_visit_personal
		WHERE 
		SITE_VISIT_ID = ".$this->getField("SITE_VISIT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletepersonaldetail()
	{
		$str = "
		DELETE FROM site_visit_personal
		WHERE 
		SITE_VISIT_PERSONAL_ID = ".$this->getField("SITE_VISIT_PERSONAL_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}



    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY SITE_VISIT_ID ASC")
	{
		$str = "
		SELECT A.*,B.NAMA NAMA_PEMERIKSA, C.KODE KODE_DISTRIK, C.NAMA NAMA_DISTRIK
		FROM site_visit A 
		LEFT JOIN 
		(
			SELECT A.PENGGUNA_INTERNAL_ID AS USER_ID, NID, NAMA_LENGKAP AS NAMA	
			FROM PENGGUNA_INTERNAL A 
			UNION ALL 
			SELECT A.PENGGUNA_EXTERNAL_ID AS USER_ID, NID, A.NAMA
			FROM PENGGUNA_EXTERNAL A
			WHERE 1=1
		) B ON B.NID = A.PEMERIKSA_ID
		LEFT JOIN DISTRIK C ON C.DISTRIK_ID = A.DISTRIK_ID
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


    function selectByParamsTask($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY SITE_VISIT_TASK_ID ASC")
	{
		$str = "
		SELECT A.*
		FROM site_visit_task A
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

    function selectByParamsMaintenance($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY SITE_VISIT_MAINTENANCE_ID ASC")
	{
		$str = "
		SELECT A.*
		FROM site_visit_maintenance A
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

    function selectByParamsKomparasi($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY SITE_VISIT_KOMPARASI_ID ASC")
	{
		$str = "
		SELECT A.*
		FROM site_visit_komparasi A
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

    function selectByParamsPersonal($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY SITE_VISIT_PERSONAL_ID ASC")
	{
		$str = "
		SELECT A.*
		FROM site_visit_personal A
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