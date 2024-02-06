<? 
  include_once(APPPATH.'/models/Entity.php');

  class PengadaanKontrak extends Entity{ 

	var $query;

    function PengadaanKontrak()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PENGADAAN_KONTRAK_ID", $this->getNextId("PENGADAAN_KONTRAK_ID","pengadaan_kontrak"));

    	$str = "
    	INSERT INTO pengadaan_kontrak
    	(
    		PENGADAAN_KONTRAK_ID,NAMA_VENDOR, NOMOR_KONTRAK, JUDUL_KONTRAK, TANGGAL_KONTRAK, TANGGAL_BERLAKU, TANGGAL_LEVERING, NILAI, PLAN_RLA_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGADAAN_KONTRAK_ID")."
	    	, '".$this->getField("NAMA_VENDOR")."'
	    	, '".$this->getField("NOMOR_KONTRAK")."'
	    	, '".$this->getField("JUDUL_KONTRAK")."'
	    	, ".$this->getField("TANGGAL_KONTRAK")."
	    	, ".$this->getField("TANGGAL_BERLAKU")."
	    	, ".$this->getField("TANGGAL_LEVERING")."
	    	, '".$this->getField("NILAI")."'
	    	, ".$this->getField("PLAN_RLA_ID")."
	    )"; 

		$this->id= $this->getField("PENGADAAN_KONTRAK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE pengadaan_kontrak
		SET
		NAMA_VENDOR= '".$this->getField("NAMA_VENDOR")."'
		, NOMOR_KONTRAK= '".$this->getField("NOMOR_KONTRAK")."'
		, JUDUL_KONTRAK= '".$this->getField("JUDUL_KONTRAK")."'
		, TANGGAL_KONTRAK= ".$this->getField("TANGGAL_KONTRAK")."
		, TANGGAL_BERLAKU= ".$this->getField("TANGGAL_BERLAKU")."
		, TANGGAL_LEVERING= ".$this->getField("TANGGAL_LEVERING")."
		, NILAI= '".$this->getField("NILAI")."'
		, PLAN_RLA_ID= ".$this->getField("PLAN_RLA_ID")."
		WHERE PENGADAAN_KONTRAK_ID = '".$this->getField("PENGADAAN_KONTRAK_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM pengadaan_kontrak
		WHERE 
		PENGADAAN_KONTRAK_ID = ".$this->getField("PENGADAAN_KONTRAK_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $jabatanment='', $sOrder="")
	{
		$str = "
		SELECT 
			A.*,B.KODE_MASTER_PLAN
		FROM pengadaan_kontrak A
		LEFT JOIN PLAN_RLA B ON B.PLAN_RLA_ID = A.PLAN_RLA_ID
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

  } 
?>