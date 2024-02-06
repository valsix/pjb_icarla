<? 
  include_once(APPPATH.'/models/Entity.php');

  class Import extends Entity{ 

	var $query;

    function Import()
	{
      $this->Entity(); 
    }

    function insertdistrik()
    {
    	$this->setField("DISTRIK_ID", $this->getNextId("DISTRIK_ID","distrik"));

    	$str = "
    	INSERT INTO distrik
    	(
    		DISTRIK_ID, NAMA, KODE , PERUSAHAAN_EKSTERNAL_ID, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	'".$this->getField("DISTRIK_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("DISTRIK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updatedistrik()
	{
		$str = "
		UPDATE distrik
		SET
		NAMA= '".$this->getField("NAMA")."'
		, PERUSAHAAN_EKSTERNAL_ID= ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE DISTRIK_ID = '".$this->getField("DISTRIK_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertblok()
    {
    	$this->setField("BLOK_ID", $this->getNextId("BLOK_ID","blok"));

    	$str = "
    	INSERT INTO blok
    	(
    		BLOK_ID,DISTRIK_ID, KODE,NAMA,JENIS_ENTERPRISE,URL
    	)
    	VALUES 
    	(
	    	".$this->getField("BLOK_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("JENIS_ENTERPRISE")."
	    	, '".$this->getField("URL")."'
	    )"; 

		$this->id= $this->getField("BLOK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateblok()
	{
		$str = "
		UPDATE blok
		SET
		DISTRIK_ID= ".$this->getField("DISTRIK_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, JENIS_ENTERPRISE= ".$this->getField("JENIS_ENTERPRISE")."
		, URL= '".$this->getField("URL")."'
		WHERE BLOK_ID = '".$this->getField("BLOK_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertperusahaaneksternal()
    {
    	$this->setField("PERUSAHAAN_EKSTERNAL_ID", $this->getNextId("PERUSAHAAN_EKSTERNAL_ID","perusahaan_eksternal"));

    	$str = "
    	INSERT INTO perusahaan_eksternal
    	(
    		PERUSAHAAN_EKSTERNAL_ID, NAMA, KODE
    	)
    	VALUES 
    	(
	    	'".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    )"; 

		$this->id= $this->getField("PERUSAHAAN_EKSTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateperusahaaneksternal()
	{
		$str = "
		UPDATE perusahaan_eksternal
		SET
		NAMA= '".$this->getField("NAMA")."'
		WHERE PERUSAHAAN_EKSTERNAL_ID = '".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertunit()
    {
    	$this->setField("UNIT_ID", $this->getNextId("UNIT_ID","unit"));

    	$str = "
    	INSERT INTO unit
    	(
    		UNIT_ID,DISTRIK_ID,BLOK_ID, KODE,NAMA, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("UNIT_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("BLOK_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("UNIT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updateunit()
	{
		$str = "
		UPDATE unit
		SET
		UNIT_ID= ".$this->getField("UNIT_ID")."
		, DISTRIK_ID= ".$this->getField("DISTRIK_ID")."
		, BLOK_ID= ".$this->getField("BLOK_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE UNIT_ID = '".$this->getField("UNIT_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertenjiniringunit()
    {
    	$this->setField("ENJINIRINGUNIT_ID", $this->getNextId("ENJINIRINGUNIT_ID","enjiniringunit"));

    	$str = "
    	INSERT INTO enjiniringunit
    	(
    		ENJINIRINGUNIT_ID, NAMA, STATUS, KODE, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	'".$this->getField("ENJINIRINGUNIT_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("ENJINIRINGUNIT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateenjiniringunit()
	{
		$str = "
		UPDATE enjiniringunit
		SET
		NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		
		WHERE ENJINIRINGUNIT_ID = '".$this->getField("ENJINIRINGUNIT_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertformuji()
    {
    	$this->setField("FORM_UJI_ID", $this->getNextId("FORM_UJI_ID","form_uji"));

    	$str = "
    	INSERT INTO form_uji
    	(
    		FORM_UJI_ID,KODE,NAMA,STATUS, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("FORM_UJI_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("FORM_UJI_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateformuji()
	{
		$str = "
		UPDATE form_uji
		SET
		FORM_UJI_ID= ".$this->getField("FORM_UJI_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		
		WHERE FORM_UJI_ID = '".$this->getField("FORM_UJI_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertmanufaktur()
    {
    	$this->setField("MANUFAKTUR_ID", $this->getNextId("MANUFAKTUR_ID","manufaktur"));

    	$str = "
    	INSERT INTO manufaktur
    	(
    		MANUFAKTUR_ID,KODE,NAMA,STATUS, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("MANUFAKTUR_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("MANUFAKTUR_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatemanufaktur()
	{
		$str = "
		UPDATE manufaktur
		SET
		MANUFAKTUR_ID= ".$this->getField("MANUFAKTUR_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE MANUFAKTUR_ID = '".$this->getField("MANUFAKTUR_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertuom()
    {
    	$this->setField("UOM_ID", $this->getNextId("UOM_ID","uom"));

    	$str = "
    	INSERT INTO uom
    	(
    		UOM_ID,NAMA, STATUS, FUNCTION_INPUT, KETERANGAN , LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("UOM_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("FUNCTION_INPUT")."'
	    	, '".$this->getField("KETERANGAN")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("UOM_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateuom()
	{
		$str = "
		UPDATE uom
		SET
		UOM_ID= ".$this->getField("UOM_ID")."
		, STATUS= '".$this->getField("STATUS")."'
		, FUNCTION_INPUT= '".$this->getField("FUNCTION_INPUT")."'
		, KETERANGAN= '".$this->getField("KETERANGAN")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE UOM_ID = '".$this->getField("UOM_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function insertmeasuringtools()
    {
    	$this->setField("MEASURING_TOOLS_ID", $this->getNextId("MEASURING_TOOLS_ID","measuring_tools"));

    	$str = "
    	INSERT INTO measuring_tools
    	(
    		MEASURING_TOOLS_ID,KODE,NAMA,STATUS, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("MEASURING_TOOLS_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("MEASURING_TOOLS_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatemeasuringtools()
	{
		$str = "
		UPDATE measuring_tools
		SET
		MEASURING_TOOLS_ID= ".$this->getField("MEASURING_TOOLS_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE MEASURING_TOOLS_ID = '".$this->getField("MEASURING_TOOLS_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertjenispengukuran()
    {
    	$this->setField("JENIS_PENGUKURAN_ID", $this->getNextId("JENIS_PENGUKURAN_ID","jenis_pengukuran"));

    	$str = "
    	INSERT INTO jenis_pengukuran
    	(
    		JENIS_PENGUKURAN_ID,FORM_UJI_ID, KODE, NAMA, REFERENSI, CATATAN, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("JENIS_PENGUKURAN_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("REFERENSI")."'
	    	, '".$this->getField("CATATAN")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("JENIS_PENGUKURAN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatejenispengukuran()
	{
		$str = "
		UPDATE jenis_pengukuran
		SET
		JENIS_PENGUKURAN_ID= ".$this->getField("JENIS_PENGUKURAN_ID")."
		, FORM_UJI_ID= ".$this->getField("FORM_UJI_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, REFERENSI= '".$this->getField("REFERENSI")."'
		, CATATAN= '".$this->getField("CATATAN")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE JENIS_PENGUKURAN_ID = '".$this->getField("JENIS_PENGUKURAN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function inserteam()
    {
    	$this->setField("EAM_ID", $this->getNextId("EAM_ID","EAM"));

    	$str = "
    	INSERT INTO EAM
    	(
    		EAM_ID, NAMA,KETERANGAN, URL, STATUS, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	'".$this->getField("EAM_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KETERANGAN")."'
	    	, '".$this->getField("URL")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("EAM_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateeam()
	{
		$str = "
		UPDATE EAM
		SET
		NAMA= '".$this->getField("NAMA")."'
		, URL= '".$this->getField("URL")."'
		, KETERANGAN= '".$this->getField("KETERANGAN")."'
		, STATUS= '".$this->getField("STATUS")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."

		WHERE EAM_ID = '".$this->getField("EAM_ID")."'
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertkomentar()
    {
    	$this->setField("KOMENTAR_ID", $this->getNextId("KOMENTAR_ID","komentar"));

    	$str = "
    	INSERT INTO komentar
    	(
    		KOMENTAR_ID,NAMA,STATUS,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("KOMENTAR_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("KOMENTAR_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updatekomentar()
	{
		$str = "
		UPDATE komentar
		SET
		 STATUS= '".$this->getField("STATUS")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE KOMENTAR_ID = ".$this->getField("KOMENTAR_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertstate()
    {
    	$this->setField("STATE_ID", $this->getNextId("STATE_ID","state"));

    	$str = "
    	INSERT INTO state
    	(
    		STATE_ID, NAMA, STATUS,TIPE_INPUT_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("STATE_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("TIPE_INPUT_ID")."
	    )"; 

	    $this->id= $this->getField("STATE_ID");
	    $this->query= $str;
					// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updatestate()
	{
		$str = "
		UPDATE state
		SET
		NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, TIPE_INPUT_ID= ".$this->getField("TIPE_INPUT_ID")."
		WHERE STATE_ID = '".$this->getField("STATE_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function inserttipeinput()
    {
    	$this->setField("TIPE_INPUT_ID", $this->getNextId("TIPE_INPUT_ID","tipe_input"));

    	$str = "
    	INSERT INTO tipe_input
    	(
    		TIPE_INPUT_ID,NAMA, STATUS, FUNCTION_INPUT, KETERANGAN
    	)
    	VALUES 
    	(
	    	".$this->getField("TIPE_INPUT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("FUNCTION_INPUT")."'
	    	, '".$this->getField("KETERANGAN")."'
	    )"; 

		$this->id= $this->getField("TIPE_INPUT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function inserttipeinputdetail()
    {
    	$this->setField("TIPE_INPUT_DETAIL_ID", $this->getNextId("TIPE_INPUT_DETAIL_ID","tipe_input_detail"));

    	$str = "
    	INSERT INTO tipe_input_detail
    	(
    		TIPE_INPUT_DETAIL_ID,TIPE_INPUT_ID,TIPE_PENGUKURAN_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("TIPE_INPUT_DETAIL_ID")."
	    	, ".$this->getField("TIPE_INPUT_ID")."
	    	, ".$this->getField("TIPE_PENGUKURAN_ID")."
	    	
	    )"; 

		$this->id= $this->getField("TIPE_INPUT_DETAIL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatetipeinput()
	{
		$str = "
		UPDATE tipe_input
		SET
		TIPE_INPUT_ID= ".$this->getField("TIPE_INPUT_ID")."
		, STATUS= '".$this->getField("STATUS")."'
		, NAMA= '".$this->getField("NAMA")."'
		, FUNCTION_INPUT= '".$this->getField("FUNCTION_INPUT")."'
		, KETERANGAN= '".$this->getField("KETERANGAN")."'
		WHERE TIPE_INPUT_ID = '".$this->getField("TIPE_INPUT_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deletetipeinputdetail()
	{
		$str = "
		DELETE FROM tipe_input_detail
		WHERE 
		TIPE_INPUT_ID = ".$this->getField("TIPE_INPUT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function insertgroupstate()
    {
    	$this->setField("GROUP_STATE_ID", $this->getNextId("GROUP_STATE_ID","GROUP_STATE"));

    	$str = "
    	INSERT INTO GROUP_STATE
    	(
    		GROUP_STATE_ID, NAMA, STATUS
    	)
    	VALUES 
    	(
	    	'".$this->getField("GROUP_STATE_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    )"; 

		$this->id= $this->getField("GROUP_STATE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updategroupstate()
	{
		$str = "
		UPDATE GROUP_STATE
		SET
		NAMA= '".$this->getField("NAMA")."'

		WHERE GROUP_STATE_ID = '".$this->getField("GROUP_STATE_ID")."'
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertGroupStateDetail()
    {
    	$this->setField("GROUP_STATE_DETAIL_ID", $this->getNextId("GROUP_STATE_DETAIL_ID","GROUP_STATE_DETAIL"));

    	$str = "
    	INSERT INTO GROUP_STATE_DETAIL
    	(
    		GROUP_STATE_DETAIL_ID, GROUP_STATE_ID, STATE_ID, TIPE, URUT
    	)
    	VALUES 
    	(
	    	'".$this->getField("GROUP_STATE_DETAIL_ID")."'
	    	, ".$this->getField("GROUP_STATE_ID")."
	    	, ".$this->getField("STATE_ID")."
	    	, ".$this->getField("TIPE")."
	    	, ".$this->getField("URUT")."
	    )"; 

		$this->id= $this->getField("GROUP_STATE_DETAIL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateGroupStateDetail()
	{
		$str = "
		UPDATE GROUP_STATE_DETAIL
		SET
		GROUP_STATE_ID= ".$this->getField("GROUP_STATE_ID")."
		, STATE_ID= ".$this->getField("STATE_ID")."
		, TIPE= ".$this->getField("TIPE")."
		, URUT= ".$this->getField("URUT")."

		WHERE GROUP_STATE_DETAIL_ID = ".$this->getField("GROUP_STATE_DETAIL_ID")."
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deleteGroupStateDetail()
	{
		$str = "
		DELETE FROM GROUP_STATE_DETAIL
		WHERE 
		GROUP_STATE_ID = ".$this->getField("GROUP_STATE_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function insertpenggunaeksternal()
    {
    	$this->setField("PENGGUNA_EXTERNAL_ID", $this->getNextId("PENGGUNA_EXTERNAL_ID","pengguna_external"));

    	$str = "
    	INSERT INTO pengguna_external
    	(
    		PENGGUNA_EXTERNAL_ID,DISTRIK_ID,POSITION_ID,ROLE_ID,PERUSAHAAN_EKSTERNAL_ID, NID, NAMA, STATUS, NO_TELP, EMAIL, FOTO, PASSWORD,EXPIRED_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGGUNA_EXTERNAL_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("POSITION_ID")."'
	    	, ".$this->getField("ROLE_ID")."
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    	, '".$this->getField("NID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("NO_TELP")."
	    	, '".$this->getField("EMAIL")."'
	    	, '".$this->getField("FOTO")."'
	    	, '".$this->getField("PASSWORD")."'
	    	, ".$this->getField("EXPIRED_DATE")."
	    )"; 

		$this->id= $this->getField("PENGGUNA_EXTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatepenggunaeksternal()
	{
		$str = "
		UPDATE pengguna_external
		SET
		DISTRIK_ID = ".$this->getField("DISTRIK_ID")."
		, POSITION_ID = '".$this->getField("POSITION_ID")."'
		, ROLE_ID = ".$this->getField("ROLE_ID")."
		, PERUSAHAAN_EKSTERNAL_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
		, NID = '".$this->getField("NID")."'
		, NAMA = '".$this->getField("NAMA")."'
		, STATUS = '".$this->getField("STATUS")."'
		, NO_TELP = ".$this->getField("NO_TELP")."
		, EMAIL = '".$this->getField("EMAIL")."'
		, EXPIRED_DATE = ".$this->getField("EXPIRED_DATE")."
		WHERE PENGGUNA_EXTERNAL_ID = '".$this->getField("PENGGUNA_EXTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertpenggunainternal()
    {
    	$this->setField("PENGGUNA_INTERNAL_ID", $this->getNextId("PENGGUNA_INTERNAL_ID","pengguna_internal"));

    	$str = "
    	INSERT INTO pengguna_internal
    	(
    		PENGGUNA_INTERNAL_ID,DISTRIK_ID,POSITION_ID,ROLE_ID,PERUSAHAAN_EKSTERNAL_ID, NID, NAMA, STATUS, NO_TELP, EMAIL, FOTO, PASSWORD,EXPIRED_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGGUNA_INTERNAL_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("POSITION_ID")."'
	    	, ".$this->getField("ROLE_ID")."
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    	, '".$this->getField("NID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("NO_TELP")."
	    	, '".$this->getField("EMAIL")."'
	    	, '".$this->getField("FOTO")."'
	    	, '".$this->getField("PASSWORD")."'
	    	, ".$this->getField("EXPIRED_DATE")."
	    )"; 

		$this->id= $this->getField("PENGGUNA_INTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatepenggunainternal()
	{
		$str = "
		UPDATE pengguna_internal
		SET
		DISTRIK_ID = ".$this->getField("DISTRIK_ID")."
		, POSITION_ID = '".$this->getField("POSITION_ID")."'
		, ROLE_ID = ".$this->getField("ROLE_ID")."
		, PERUSAHAAN_EKSTERNAL_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
		, NID = '".$this->getField("NID")."'
		, NAMA = '".$this->getField("NAMA")."'
		, STATUS = '".$this->getField("STATUS")."'
		, NO_TELP = ".$this->getField("NO_TELP")."
		, EMAIL = '".$this->getField("EMAIL")."'
		, EXPIRED_DATE = ".$this->getField("EXPIRED_DATE")."
		WHERE PENGGUNA_INTERNAL_ID = '".$this->getField("PENGGUNA_INTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertpengguna()
    {
    	$this->setField("PENGGUNA_ID", $this->getNextId("PENGGUNA_ID","PENGGUNA"));

    	$str = "
    	INSERT INTO PENGGUNA
    	(
    		PENGGUNA_ID, USERNAME, NAMA, STATUS, PERUSAHAAN_ID, ROLE_ID, PENGGUNA_EXTERNAL_ID, TIPE
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_ID")."'
	    	, '".$this->getField("USERNAME")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("PERUSAHAAN_ID")."
	    	, '".$this->getField("ROLE_ID")."'
	    	, ".$this->getField("PENGGUNA_EXTERNAL_ID")."
	    	, 2
	    )"; 

		$this->id= $this->getField("PENGGUNA_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatepengguna()
	{
		$str = "
		UPDATE PENGGUNA
		SET
		USERNAME= '".$this->getField("USERNAME")."'
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, PERUSAHAAN_ID= ".$this->getField("PERUSAHAAN_ID")."
		, ROLE_ID= '".$this->getField("ROLE_ID")."'
		, PENGGUNA_EXTERNAL_ID= ".$this->getField("PENGGUNA_EXTERNAL_ID")."

		WHERE PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertjabatan()
  	{
	    $str = "
	    INSERT INTO MASTER_JABATAN
	    (
	        POSITION_ID, NAMA_POSISI, SUPERIOR_ID, KODE_KATEGORI, KATEGORI, KODE_KELOMPOK_JABATAN, KELOMPOK_JABATAN
	        , KODE_JENJANG_JABATAN, JENJANG_JABATAN, KODE_KLASIFIKASI_UNIT, KLASIFIKASI_UNIT, KODE_UNIT, UNIT, KODE_DITBID, DITBID, KODE_BAGIAN, BAGIAN,OCCUP_STATUS,NAMA_LENGKAP,EMAIL,NID,POSISI,CHANGE_REASON,KODE_DISTRIK
	    )
	    VALUES 
	    (
	     	'".$this->getField("POSITION_ID")."'
	      , '".$this->getField("NAMA_POSISI")."'
	      , '".$this->getField("SUPERIOR_ID")."'
	      , '".$this->getField("KODE_KATEGORI")."'
	      , '".$this->getField("KATEGORI")."'
	      , '".$this->getField("KODE_KELOMPOK_JABATAN")."'
	      , '".$this->getField("KELOMPOK_JABATAN")."'
	      , '".$this->getField("KODE_JENJANG_JABATAN")."'
	      , '".$this->getField("JENJANG_JABATAN")."'
	      , '".$this->getField("KODE_KLASIFIKASI_UNIT")."'
	      , '".$this->getField("KLASIFIKASI_UNIT")."'
	      , '".$this->getField("KODE_UNIT")."'
	      , '".$this->getField("UNIT")."'
	      , '".$this->getField("KODE_DITBID")."'
	      , '".$this->getField("DITBID")."'
	      , '".$this->getField("KODE_BAGIAN")."'
	      , '".$this->getField("BAGIAN")."'
	      , '".$this->getField("OCCUP_STATUS")."'
	      , '".$this->getField("NAMA_LENGKAP")."'
	      , '".$this->getField("EMAIL")."'
	      , '".$this->getField("NID")."'
	      , '".$this->getField("POSISI")."'
	      , '".$this->getField("CHANGE_REASON")."'
	      , '".$this->getField("KODE_DISTRIK")."'
	    )"; 
	    $this->query= $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
  	}

	function updatejabatan()
	{
	    $str = "
	    UPDATE MASTER_JABATAN 
	    SET
	      NAMA_POSISI= '".$this->getField("NAMA_POSISI")."'
	      , SUPERIOR_ID= '".$this->getField("SUPERIOR_ID")."'
	      , KODE_KATEGORI= '".$this->getField("KODE_KATEGORI")."'
	      , KATEGORI= '".$this->getField("KATEGORI")."'
	      , KODE_KELOMPOK_JABATAN= '".$this->getField("KODE_KELOMPOK_JABATAN")."'
	      , KELOMPOK_JABATAN= '".$this->getField("KELOMPOK_JABATAN")."'
	      , KODE_JENJANG_JABATAN= '".$this->getField("KODE_JENJANG_JABATAN")."'
	      , JENJANG_JABATAN= '".$this->getField("JENJANG_JABATAN")."'
	      , KODE_KLASIFIKASI_UNIT= '".$this->getField("KODE_KLASIFIKASI_UNIT")."'
	      , KLASIFIKASI_UNIT= '".$this->getField("KLASIFIKASI_UNIT")."'
	      , KODE_UNIT= '".$this->getField("KODE_UNIT")."'
	      , UNIT= '".$this->getField("UNIT")."'
	      , KODE_DITBID= '".$this->getField("KODE_DITBID")."'
	      , DITBID= '".$this->getField("DITBID")."'
	      , KODE_BAGIAN= '".$this->getField("KODE_BAGIAN")."'
	      , BAGIAN= '".$this->getField("BAGIAN")."'
	      , OCCUP_STATUS= '".$this->getField("OCCUP_STATUS")."'
	      , NAMA_LENGKAP= '".$this->getField("NAMA_LENGKAP")."'
	      , EMAIL= '".$this->getField("EMAIL")."'
	      , NID= '".$this->getField("NID")."'
	      , POSISI= '".$this->getField("POSISI")."'
	      , CHANGE_REASON= '".$this->getField("CHANGE_REASON")."'
	      , KODE_DISTRIK= '".$this->getField("KODE_DISTRIK")."'
	    WHERE POSITION_ID = '".$this->getField("POSITION_ID")."'
	    "; 
	    $this->query = $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertpengukuran()
    {
    	// echo $this->getField("GROUP_STATE_ID");exit;
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

	function insertjenispengukurandetil()
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

	function updatepengukuran()
	{
		$str = "
		UPDATE pengukuran
		SET
		 ENJINIRINGUNIT_ID = ".$this->getField("ENJINIRINGUNIT_ID")."
		, GROUP_STATE_ID = ".$this->getField("GROUP_STATE_ID")."
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

	function insertnameplate()
    {
    	$this->setField("NAMEPLATE_ID", $this->getNextId("NAMEPLATE_ID","NAMEPLATE"));

    	$str = "
    	INSERT INTO NAMEPLATE
    	(
    		NAMEPLATE_ID, NAMA, STATUS
    	)
    	VALUES 
    	(
	    	'".$this->getField("NAMEPLATE_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    )"; 

		$this->id= $this->getField("NAMEPLATE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatenameplate()
	{
		$str = "
		UPDATE NAMEPLATE
		SET
		NAMA= '".$this->getField("NAMA")."'

		WHERE NAMEPLATE_ID = '".$this->getField("NAMEPLATE_ID")."'
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertNameplateDetail()
    {
    	$this->setField("NAMEPLATE_DETIL_ID", $this->getNextId("NAMEPLATE_DETIL_ID","NAMEPLATE_DETIL"));

    	$str = "
    	INSERT INTO NAMEPLATE_DETIL
    	(
    		NAMEPLATE_DETIL_ID, NAMEPLATE_ID, NAMA, NAMA_TABEL, STATUS
    	)
    	VALUES 
    	(
	    	'".$this->getField("NAMEPLATE_DETIL_ID")."'
	    	, ".$this->getField("NAMEPLATE_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("NAMA_TABEL")."'
	    	, '".$this->getField("STATUS")."'
	    )"; 

		$this->id= $this->getField("NAMEPLATE_DETIL_ID");
		$this->query= $str;
		// echo $str;exit;
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

	function updatedetilnameplate()
	{
		$str = "
		UPDATE form_uji
		SET
		NAMEPLATE_ID=".$this->getField("NAMEPLATE_ID")."

		WHERE FORM_UJI_ID = '".$this->getField("FORM_UJI_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatedetilnameplatenew()
	{
		$str = "
		UPDATE form_uji_nameplate
		SET
		FORM_UJI_ID=".$this->getField("FORM_UJI_ID")."
		, NAMEPLATE_ID=".$this->getField("NAMEPLATE_ID")."
		, NAMA_NAMEPLATE='".$this->getField("NAMA_NAMEPLATE")."'
		, NAMA_TABEL='".$this->getField("NAMA_TABEL")."'
		, NAMEPLATE_DETIL_ID='".$this->getField("NAMEPLATE_DETIL_ID")."'

		WHERE FORM_UJI_NAMEPLATE_ID = '".$this->getField("FORM_UJI_NAMEPLATE_ID")."'
		"; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
	}
	function deletedetilnameplatenew()
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

	function insertpenggunahak()
    {
    	$this->setField("PENGGUNA_HAK_ID", $this->getNextId("PENGGUNA_HAK_ID","pengguna_hak"));

    	$str = "
    	INSERT INTO pengguna_hak
    	(
    		PENGGUNA_HAK_ID, NAMA_HAK, KODE_HAK , DESKRIPSI
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_HAK_ID")."'
	    	, '".$this->getField("NAMA_HAK")."'
	    	, '".$this->getField("KODE_HAK")."'
	    	, '".$this->getField("DESKRIPSI")."'
	    )"; 

		$this->id= $this->getField("PENGGUNA_HAK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatepenggunahak()
	{
		$str = "
		UPDATE pengguna_hak
		SET
		PENGGUNA_HAK_ID=".$this->getField("PENGGUNA_HAK_ID")."
		, KODE_HAK='".$this->getField("KODE_HAK")."'
		, NAMA_HAK='".$this->getField("NAMA_HAK")."'
		, DESKRIPSI='".$this->getField("DESKRIPSI")."'

		WHERE PENGGUNA_HAK_ID = ".$this->getField("PENGGUNA_HAK_ID")."
		"; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
	}

	function selectByParamsCheckDetilNameplate($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY FORM_UJI_NAMEPLATE_ID ASC")
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
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


	function selectByParamsCheckDistrik($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DISTRIK_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM DISTRIK A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

	
    function selectByParamsCheckPerusahaanExternal($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY PERUSAHAAN_EKSTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM PERUSAHAAN_EKSTERNAL A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckBlok($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY BLOK_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM BLOK A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckUnit($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY UNIT_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM UNIT A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckEnjiniringUnit($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY ENJINIRINGUNIT_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM ENJINIRINGUNIT A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsCheckFormUji($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY FORM_UJI_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM FORM_UJI A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckManufaktur($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY MANUFAKTUR_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM MANUFAKTUR A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsUom($paramsArray=array(),$limit=-1,$from=-1, $jabatanment='', $sOrder="ORDER BY UOM_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM uom A
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

    function selectByParamsMeasuringTools($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY MEASURING_TOOLS_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM measuring_tools A
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

    function selectByParamsJenisPengukuran($paramsArray=array(),$limit=-1,$from=-1, $jenis_pengukuranment='', $sOrder="ORDER BY JENIS_PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM jenis_pengukuran A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $jenis_pengukuranment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

   	function selectByParamsEam($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY EAM_ID ASC")
	{
		$str = "
			SELECT 
				A.*
			FROM EAM A 
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

	function selectByParamsKomentar($paramsArray=array(),$limit=-1,$from=-1, $jabatanment='', $sOrder="ORDER BY KOMENTAR_ID DESC")
	{
		$str = "
		SELECT 
			A.*			
		FROM komentar A
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

    function selectByParamsCheckTipe($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY TIPE_INPUT_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM tipe_input A 
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


    function selectByParamsCheckTipePengukuran($paramsArray=array(),$limit=-1,$from=-1, $tipe_pengukuranment='', $sOrder="ORDER BY TIPE_PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM tipe_pengukuran A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $tipe_pengukuranment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckState($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY STATE_ID ASC")
	{
		$str = "
			SELECT 
				A.*
				, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
			FROM STATE A 
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


    function selectByParamsCheckGroupState($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY GROUP_STATE_ID ASC")
	{
		$str = "
			SELECT 
				A.*
				, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
			FROM GROUP_STATE A 
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

	function selectByParamsCheckGroupStateDetail($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY GROUP_STATE_DETAIL_ID ASC")
	{
		$str = "
			SELECT 
				A.*
			FROM GROUP_STATE_DETAIL A 
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

	function selectByParamsCheckPenggunaEksternal($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY PENGGUNA_EXTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM pengguna_external A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

   	function selectByParamsCheckMasterJabatan($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY POSITION_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM master_jabatan A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckRole($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY ROLE_ID ASC")
	{
		$str = "
			SELECT 
				A.*
			FROM ROLE_APPROVAL A 
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


	function selectByParamsCheckPenggunaInternal($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY PENGGUNA_INTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM pengguna_internal A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckJabatan($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY POSITION_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM MASTER_JABATAN A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckPengukuran($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY PENGUKURAN_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM PENGUKURAN A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckNameplate($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY NAMEPLATE_ID ASC")
	{
		$str = "
			SELECT 
				A.*
				, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
			FROM NAMEPLATE A 
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



	function insertKelompokEquipment()
	{
    	$this->setField("KELOMPOK_EQUIPMENT_ID", $this->getNextId("KELOMPOK_EQUIPMENT_ID","KELOMPOK_EQUIPMENT"));

    	$str = "
    	INSERT INTO KELOMPOK_EQUIPMENT
    	(
    			KELOMPOK_EQUIPMENT_ID, KODE, NAMA, STATUS, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    		'".$this->getField("KELOMPOK_EQUIPMENT_ID")."'
	    		, '".$this->getField("KODE")."'
	    		, '".$this->getField("NAMA")."'
	    		, '".$this->getField("STATUS")."'
	    		, '".$this->getField("LAST_CREATE_USER")."'
	    		, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

			$this->id= $this->getField("KELOMPOK_EQUIPMENT_ID");
			$this->query= $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function updateKelompokEquipment()
	{
			$str = "
			UPDATE KELOMPOK_EQUIPMENT
			SET
			KODE= '".$this->getField("KODE")."'
			, NAMA= '".$this->getField("NAMA")."'
			, STATUS= '".$this->getField("STATUS")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
			
			WHERE KELOMPOK_EQUIPMENT_ID = '".$this->getField("KELOMPOK_EQUIPMENT_ID")."'
			";

			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function selectByParamsCheckKelompokEquipment($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KELOMPOK_EQUIPMENT_ID ASC")
	{
			$str = "
			SELECT 
					A.*
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



	function selectByParamsCheckHakAkses($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGGUNA_HAK_ID ASC")
	{
			$str = "
			SELECT 
					A.*
			FROM PENGGUNA_HAK A
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

	function insertPenggunaHakAkses()
	{
    	$this->setField("PENGGUNA_HAK_AKSES_ID", $this->getNextId("PENGGUNA_HAK_AKSES_ID","PENGGUNA_HAK_AKSES"));

    	$str = "
    	INSERT INTO PENGGUNA_HAK_AKSES
    	(
    			PENGGUNA_HAK_AKSES_ID, PENGGUNA_ID, PENGGUNA_HAK_ID
    	)
    	VALUES 
    	(
		    	'".$this->getField("PENGGUNA_HAK_AKSES_ID")."'
		    	, '".$this->getField("PENGGUNA_ID")."'
		    	, '".$this->getField("PENGGUNA_HAK_ID")."'
	    )"; 

			$this->id= $this->getField("PENGGUNA_HAK_AKSES_ID");
			$this->query= $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function deletePenggunaHakAkses()
	{
			$str = "
			DELETE FROM PENGGUNA_HAK_AKSES
			WHERE 
			PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'"; 

			// echo $str;exit();
			$this->query = $str;
			return $this->execQuery($str);
	}

	function insertPenggunaDistrik()
	{
    	$this->setField("PENGGUNA_DISTRIK_ID", $this->getNextId("PENGGUNA_DISTRIK_ID","PENGGUNA_DISTRIK"));

    	$str = "
    	INSERT INTO PENGGUNA_DISTRIK
    	(
    			PENGGUNA_DISTRIK_ID, PENGGUNA_ID, DISTRIK_ID
    	)
    	VALUES 
    	(
		    	'".$this->getField("PENGGUNA_DISTRIK_ID")."'
		    	, '".$this->getField("PENGGUNA_ID")."'
		    	, '".$this->getField("DISTRIK_ID")."'
	    )"; 

	    $this->id= $this->getField("PENGGUNA_DISTRIK_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function deletePenggunaDistrik()
	{
			$str = "
			DELETE FROM PENGGUNA_DISTRIK
			WHERE 
			PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'"; 

			// echo $str;exit();
			$this->query = $str;
			return $this->execQuery($str);
	}


    function selectByParamsCheckTabel($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="",$sTabel='')
	{
		$str = "
		SELECT 
			A.*
		FROM ".$sTabel." A
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

    function selectByParamsCheckHak($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY PENGGUNA_HAK_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM PENGGUNA_HAK A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }



  } 
?>