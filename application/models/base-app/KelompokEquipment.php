<? 
include_once(APPPATH.'/models/Entity.php');

class KelompokEquipment extends Entity { 

	var $query;

    function KelompokEquipment()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("KELOMPOK_EQUIPMENT_ID", $this->getNextId("KELOMPOK_EQUIPMENT_ID","KELOMPOK_EQUIPMENT"));

    	$str = "
    	INSERT INTO KELOMPOK_EQUIPMENT
    	(
    		KELOMPOK_EQUIPMENT_ID, KELOMPOK_EQUIPMENT_PARENT_ID, KODE, NAMA, STATUS
    	)
    	VALUES 
    	(
	    	'".$this->getField("KELOMPOK_EQUIPMENT_ID")."'
	    	, '".$this->getField("KELOMPOK_EQUIPMENT_PARENT_ID")."'
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    )"; 

		$this->id= $this->getField("KELOMPOK_EQUIPMENT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
			$str = "
			UPDATE KELOMPOK_EQUIPMENT
			SET
			KODE= '".$this->getField("KODE")."'
			, NAMA= '".$this->getField("NAMA")."'
			, STATUS= '".$this->getField("STATUS")."'
			WHERE KELOMPOK_EQUIPMENT_ID = '".$this->getField("KELOMPOK_EQUIPMENT_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function updateStatus()
	{
		$str = "		
				UPDATE KELOMPOK_EQUIPMENT
				SET
					STATUS= ".$this->getField("STATUS")."
				WHERE ID LIKE '".$this->getField("ID")."%'
				"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

	function delete()
	{
		$str = "
		DELETE FROM KELOMPOK_EQUIPMENT
		WHERE 
		KELOMPOK_EQUIPMENT_ID = ".$this->getField("KELOMPOK_EQUIPMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectambildetil($vid)
	{
		$str = "SELECT ambil_nama_detil(".$vid.") NAMA_DETIL";
		$this->query = $str;
				
		return $this->selectLimit($str,-1,-1); 
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KELOMPOK_EQUIPMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*
				, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
				,
				CASE WHEN A.STATUS = '1' THEN 
				CONCAT('<a class=\"btntambah\" onClick=\"adddata(''',A.KELOMPOK_EQUIPMENT_ID,''',''insert'')\" style=\"cursor:pointer\" title=\"Tambah\"><i class=\"fa fa-plus-circle fa-lg\" aria-hidden=\"true\"></i></a> <a onClick=\"adddata(''',A.KELOMPOK_EQUIPMENT_ID,''',''update'')\", ''Aplikasi Data'', ''500'', ''200'')\" style=\"cursor:pointer\" title=\"Ubah\"><i class=\"fa fa-pencil fa-lg\" aria-hidden=\"true\"></i></a> <a class=\"btnhapus\" onClick=\"hapusdata(''',A.ID,''',''1'')\" style=\"cursor:pointer\" title=\"Klik untuk mengkatifkan data\"><i class=\"fa fa-check-circle-o fa-lg\" aria-hidden=\"true\"></i></a>')
				ELSE
				CONCAT('<a class=\"btntambah\" onClick=\"adddata(''',A.KELOMPOK_EQUIPMENT_ID,''',''insert'')\" style=\"cursor:pointer\" title=\"Tambah\"><i class=\"fa fa-plus-circle fa-lg\" aria-hidden=\"true\"></i></a> <a onClick=\"adddata(''',A.KELOMPOK_EQUIPMENT_ID,''',''update'')\", ''Aplikasi Data'', ''500'', ''200'')\" style=\"cursor:pointer\" title=\"Ubah\"><i class=\"fa fa-pencil fa-lg\" aria-hidden=\"true\"></i></a> <a class=\"btnhapus\" onClick=\"hapusdata(''',A.ID,''','''')\" style=\"cursor:pointer\" title=\"Klik untuk menonatifkan data\"><i class=\"fa fa-times-circle-o fa-lg\" aria-hidden=\"true\"></i></a>') 
				END LINK_URL_INFO

			FROM KELOMPOK_EQUIPMENT A 
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

	function getCountByParams($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT (1) AS ROWCOUNT 
		FROM KELOMPOK_EQUIPMENT A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		// echo $sOrder;exit;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

} 
?>