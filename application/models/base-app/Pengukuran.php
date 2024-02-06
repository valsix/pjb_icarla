<? 
  include_once(APPPATH.'/models/Entity.php');

  class Pengukuran extends Entity{ 

	var $query;

    function Pengukuran()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PENGUKURAN_ID", $this->getNextId("PENGUKURAN_ID","pengukuran"));

    	$str = "
    	INSERT INTO pengukuran
    	(
    		PENGUKURAN_ID,ENJINIRINGUNIT_ID,GROUP_STATE_ID,KODE,NAMA,NAMA_PENGUKURAN,TIPE_INPUT_ID,FORMULA, STATUS_PENGUKURAN,CATATAN,SEQUENCE,IS_INTERVAL,STATUS,ANALOG,TEXT_TIPE,UOM_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGUKURAN_ID")."
	    	, ".$this->getField("ENJINIRINGUNIT_ID")."
	    	, ".$this->getField("GROUP_STATE_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("NAMA_PENGUKURAN")."'
	    	, ".$this->getField("TIPE_INPUT_ID")."
	    	, '".$this->getField("FORMULA")."'
	    	, '".$this->getField("STATUS_PENGUKURAN")."'
	    	, '".$this->getField("CATATAN")."'
	    	, '".$this->getField("SEQUENCE")."'
	    	, '".$this->getField("IS_INTERVAL")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("ANALOG")."
	    	, '".$this->getField("TEXT_TIPE")."'
	    	, ".$this->getField("UOM_ID")."
	    )"; 

		$this->id= $this->getField("PENGUKURAN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertTipe()
    {
    	$this->setField("PENGUKURAN_TIPE_INPUT_ID", $this->getNextId("PENGUKURAN_TIPE_INPUT_ID","pengukuran_tipe_input"));

    	$str = "
    	INSERT INTO pengukuran_tipe_input
    	(
    		PENGUKURAN_TIPE_INPUT_ID, PENGUKURAN_ID, TIPE_INPUT_ID, SEQ, MASTER_TABEL_ID, VALUE
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGUKURAN_TIPE_INPUT_ID")."
	    	, ".$this->getField("PENGUKURAN_ID")."
	    	, ".$this->getField("TIPE_INPUT_ID")."
	    	, ".$this->getField("SEQ")."
	    	, ".$this->getField("MASTER_TABEL_ID")."
	    	, '".$this->getField("VALUE")."'
	    )"; 

		$this->id= $this->getField("pengukuran_tipe_input_id");
		$this->query= $str;
		// echo "xxx***".$str;exit;
		return $this->execQuery($str);
	}

	function updateTipe()
	{
		$str = "
		UPDATE pengukuran_tipe_input
		SET
		TIPE_INPUT_ID = ".$this->getField("TIPE_INPUT_ID")."
		, SEQ = ".$this->getField("SEQ")."
		, MASTER_TABEL_ID = ".$this->getField("MASTER_TABEL_ID")."
		, VALUE = '".$this->getField("VALUE")."'
		WHERE PENGUKURAN_TIPE_INPUT_ID = ".$this->getField("PENGUKURAN_TIPE_INPUT_ID")."
		"; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
	}

	function insertjenis()
    {
    	$this->setField("PENGUKURAN_JENIS_ID", $this->getNextId("PENGUKURAN_JENIS_ID","pengukuran_jenis"));

    	$str = "
    	INSERT INTO pengukuran_jenis
    	(
    		PENGUKURAN_JENIS_ID,PENGUKURAN_ID,JENIS_PENGUKURAN_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGUKURAN_JENIS_ID")."
	    	, ".$this->getField("PENGUKURAN_ID")."
	    	, ".$this->getField("JENIS_PENGUKURAN_ID")."
	    	
	    )"; 

		$this->id= $this->getField("PENGUKURAN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE pengukuran
		SET
		 ENJINIRINGUNIT_ID = ".$this->getField("ENJINIRINGUNIT_ID")."
		, GROUP_STATE_ID = ".$this->getField("GROUP_STATE_ID")."
		, KODE = '".$this->getField("KODE")."'
		, NAMA = '".$this->getField("NAMA")."'
		, NAMA_PENGUKURAN = '".$this->getField("NAMA_PENGUKURAN")."'
		, TIPE_INPUT_ID = ".$this->getField("TIPE_INPUT_ID")."
		, FORMULA = '".$this->getField("FORMULA")."'
		, STATUS_PENGUKURAN = '".$this->getField("STATUS_PENGUKURAN")."'
		, CATATAN = '".$this->getField("CATATAN")."'
		, SEQUENCE = '".$this->getField("SEQUENCE")."'
		, IS_INTERVAL = '".$this->getField("IS_INTERVAL")."'
		, STATUS = '".$this->getField("STATUS")."'
		, ANALOG = ".$this->getField("ANALOG")."
		, TEXT_TIPE = '".$this->getField("TEXT_TIPE")."'
		, UOM_ID = ".$this->getField("UOM_ID")."
		
		WHERE PENGUKURAN_ID = '".$this->getField("PENGUKURAN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateupload($field)
	{
		$str = "
		UPDATE pengukuran
		SET
		LINK_FILE = '".$this->getField("LINK_FILE")."'
		WHERE PENGUKURAN_ID = '".$this->getField("PENGUKURAN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM pengukuran
		WHERE 
		PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID")."
		;"; 

		$str .= "
		DELETE FROM pengukuran_jenis
		WHERE 
		PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID").";
		";

		$str .= "
		DELETE FROM pengukuran_tipe_input
		WHERE 
		PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID")."
		";

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function delete_gambar()
	{
		$str = "
		UPDATE pengukuran
		SET
		LINK_FILE = ''
		WHERE PENGUKURAN_ID = '".$this->getField("PENGUKURAN_ID")."'
		"; 
		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletejenis()
	{
		$str = "
		DELETE FROM pengukuran_jenis
		WHERE 
		PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGUKURAN_ID ASC")
	{
		$str = "

		SELECT 
		A.*
		, C.NAMA ENJINIRING_NAMA
		, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
		, B.NAMA_JENIS
		, B.JENIS_PENGUKURAN_INFO
		, D.TIPE_INPUT_ID
		, D.NAMA TIPE_INPUT
		, A.UOM_ID
		, A.NAMA NAMA_UOM
		, CASE
			WHEN EXISTS (select b.pengukuran_id
			from form_uji_detil_dinamis x
			where x.pengukuran_id = A.pengukuran_id)
			THEN '1'
			ELSE '0' 
			END PENGUKURAN_CHECK
		FROM pengukuran A
		LEFT JOIN 
		(
			
			SELECT B.PENGUKURAN_ID
			,STRING_AGG(A.JENIS_PENGUKURAN_ID::text, ', ') AS JENIS_PENGUKURAN_INFO
			,STRING_AGG(A.NAMA, ', ') AS NAMA_JENIS 
			FROM JENIS_PENGUKURAN A
			INNER JOIN PENGUKURAN_JENIS B ON B.JENIS_PENGUKURAN_ID = A.JENIS_PENGUKURAN_ID 
			GROUP BY B.PENGUKURAN_ID
		) B ON B.PENGUKURAN_ID = A.PENGUKURAN_ID
		LEFT JOIN ENJINIRINGUNIT C ON C.ENJINIRINGUNIT_ID = A.ENJINIRINGUNIT_ID
		LEFT JOIN 
		(
				SELECT 
				 '0' TIPE_INPUT_ID
				 , 'Binary' NAMA
				UNION ALL
				SELECT TIPE_INPUT_ID,NAMA
				FROM
				TIPE_INPUT 
		)D  ON D.TIPE_INPUT_ID = A.TIPE_INPUT_ID
		LEFT JOIN UOM E ON E.UOM_ID = A.UOM_ID 
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

    function selectByParamsJenis($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY B.JENIS_PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
			B.JENIS_PENGUKURAN_ID
		FROM pengukuran A
		LEFT JOIN 
		(
			SELECT A.*,B.PENGUKURAN_ID 
			FROM JENIS_PENGUKURAN A
			INNER JOIN PENGUKURAN_JENIS B ON B.JENIS_PENGUKURAN_ID = A.JENIS_PENGUKURAN_ID 
		) B ON B.PENGUKURAN_ID = A.PENGUKURAN_ID
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

    function selectByParamsTipeInput($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY seq ASC")
	{
		$str = "
		SELECT
				A.*, B.STATUS_TABLE, TT.NAMA TABEL_TEMPLATE_NAMA
		FROM pengukuran_tipe_input A
		LEFT JOIN tipe_input B ON A.TIPE_INPUT_ID = B.TIPE_INPUT_ID
		LEFT JOIN tabel_template TT ON A.MASTER_TABEl_ID = TT.TABEL_TEMPLATE_ID
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

    function delete_tipeinput()
    {
    	$str = "
    	DELETE FROM pengukuran_tipe_input
    	WHERE 
    	pengukuran_tipe_input_id = ".$this->getField("pengukuran_tipe_input_id")."
    	AND PENGUKURAN_ID = ".$this->getField("PENGUKURAN_ID")."
    	;"; 

    	$this->query = $str;

    	// echo $str;exit;
    	return $this->execQuery($str);
    }

    function selectByParamsComboPengukuran($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY  A.PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT A.PENGUKURAN_ID, A.NAMA FROM pengukuran A
		INNER JOIN pengukuran_TIPE_INPUT B ON B.PENGUKURAN_ID = A.PENGUKURAN_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY  A.PENGUKURAN_ID, A.NAMA ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }
  } 
?>