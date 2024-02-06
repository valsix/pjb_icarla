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
    		FORM_UJI_ID,KODE,NAMA,STATUS,NAMEPLATE_ID,MEASURING_TOOLS_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("FORM_UJI_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("NAMEPLATE_ID")."
	    	, ".$this->getField("MEASURING_TOOLS_ID")."

	    )"; 

		$this->id= $this->getField("FORM_UJI_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertisi()
    {
    	$this->setField("FORM_UJI_ISI_ID", $this->getNextId("FORM_UJI_ISI_ID","form_uji_isi"));

    	$str = "
    	INSERT INTO form_uji_isi
    	(
    		FORM_UJI_ISI_ID, FORM_UJI_ID, FORM_UJI_TIPE_ID, REFERENCE, RESULT, 
            NOTE, AIR_TEMP, HUMIDITY, APPARATUS_TEMP, TAP_CHANGER, WEATHER, 
            MAX_DEV, CALCULATED_MOISTURE, MOISTURE_SATURATION, OIL_TEMPERATURE, 
            OIL_CONDUCTIVITY, CAPACITANCE, BARRIERS, POLARIZATION_INDEX, 
            MOISTURE_CATEGORY, BUBBLING_INCEPTION, OIL_CATEGORY, TAN, SPACERS, 
            DRY, MODERATELY_WET, WET, EXTREMELY_WET, LINK_GAMBAR, OIL_TEMP
    	)
    	VALUES 
    	(
	    	".$this->getField("FORM_UJI_ISI_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, ".$this->getField("FORM_UJI_TIPE_ID")."
	    	, '".$this->getField("REFERENCE")."'
	    	, '".$this->getField("RESULT")."'
	    	, '".$this->getField("NOTE")."'
	    	, '".$this->getField("AIR_TEMP")."'
	    	, '".$this->getField("HUMIDITY")."'
	    	, '".$this->getField("APPARATUS_TEMP")."'
	    	, '".$this->getField("TAP_CHANGER")."'
	    	, '".$this->getField("WEATHER")."'
	    	, '".$this->getField("MAX_DEV")."'
	    	, '".$this->getField("CALCULATED_MOISTURE")."'
	    	, '".$this->getField("MOISTURE_SATURATION")."'
	    	, '".$this->getField("OIL_TEMPERATURE")."'
	    	, '".$this->getField("OIL_CONDUCTIVITY")."'
	    	, '".$this->getField("CAPACITANCE")."'
	    	, '".$this->getField("BARRIERS")."'
	    	, '".$this->getField("POLARIZATION_INDEX")."'
	    	, '".$this->getField("MOISTURE_CATEGORY")."'
	    	, '".$this->getField("BUBBLING_INCEPTION")."'
	    	, '".$this->getField("OIL_CATEGORY")."'
	    	, '".$this->getField("TAN")."'
	    	, '".$this->getField("SPACERS")."'
	    	, '".$this->getField("DRY")."'
	    	, '".$this->getField("MODERATELY_WET")."'
	    	, '".$this->getField("WET")."'
	    	, '".$this->getField("EXTREMELY_WET")."'
	    	, '".$this->getField("LINK_GAMBAR")."'
	    	, '".$this->getField("OIL_TEMP")."'

	    )"; 

		$this->id= $this->getField("FORM_UJI_ISI_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertdetil()
    {
    	$this->setField("FORM_UJI_DETIL_ID", $this->getNextId("FORM_UJI_DETIL_ID","form_uji_detil"));

    	$str = "
    	INSERT INTO form_uji_detil
    	(
    		FORM_UJI_DETIL_ID,FORM_UJI_ID,FORM_UJI_TIPE_ID,WAKTU,HV_GND,LV_GND,HV_LV,BUSHING,SKIRT,TEGANGAN,IMA,WATTS,TAP,IMA_RT,WATTS_RT,LC_RT,IMA_SR,WATTS_SR,LC_SR,IMA_TS,WATTS_TS,LC_TS,FASA_RATIO,HV_KV,LV_KV, RASIO_TEGANGAN, HV_V, DERAJAT_HV_V, 
            LV_V, DERAJAT_LV_V, RASIO_HASIL, DEVIASI,TAP_RATIO, SISI_RDC, 
            TAP_RDC, FASA_RDC_R, ARUS_RDC_R, TEGANGAN_RDC_R, TAHANAN_RDC_R, 
            TAHANAN_TEMP_RDC_R, DEV_RDC_R, FASA_RDC_S, ARUS_RDC_S, TEGANGAN_RDC_S, 
            TAHANAN_RDC_S, TAHANAN_TEMP_RDC_S, DEV_RDC_S, FASA_RDC_T, ARUS_RDC_T, 
            TEGANGAN_RDC_T, TAHANAN_RDC_T, TAHANAN_TEMP_RDC_T, DEV_RDC_T
            , WINDING_TAN
            , MEASURE_TAN_CH_CHL,TEST_TAN_CH_CHL,ARUS_TAN_CH_CHL,DAYA_TAN_CH_CHL,PF_CORR_TAN_CH_CHL, CORR_FACT_TAN_CH_CHL,CAP_TAN_CH_CHL
            , MEASURE_TAN_CH,TEST_TAN_CH,ARUS_TAN_CH,DAYA_TAN_CH,PF_CORR_TAN_CH, CORR_FACT_TAN_CH,CAP_TAN_CH
            , MEASURE_TAN_CHL_UST,TEST_TAN_CHL_UST,ARUS_TAN_CHL_UST,DAYA_TAN_CHL_UST,PF_CORR_TAN_CHL_UST, CORR_FACT_TAN_CHL_UST,CAP_TAN_CHL_UST
            , MEASURE_TAN_CHL,TEST_TAN_CHL,ARUS_TAN_CHL,DAYA_TAN_CHL,PF_CORR_TAN_CHL, CORR_FACT_TAN_CHL,CAP_TAN_CHL
            , TIPE_TAN
            , WINDING_WITHOUT_TAN_1, WINDING_WITHOUT_TAN_2, WINDING_WITHOUT_TAN_3, WINDING_WITHOUT_TAN_4, WINDING_WITHOUT_TAN_5, WINDING_WITHOUT_TAN_6, WINDING_WITHOUT_TAN_7, WINDING_WITHOUT_TAN_8
            , CONDITION_TAN,GOOD_TAN,MAYBE_TAN,INVESTIGATED_TAN
            , HV_SFRA, HV_DL_SFRA, 
            HV_NCEPRI_SFRA, LV_SFRA, LV_DL_SFRA, LV_NCEPRI_SFRA, HVLV_SFRA, 
            HVLV_DL_SFRA, HVLV_NCEPRI_SFRA, HV_SHORT_SFRA, HV_SHORT_DL_SFRA, 
            HV_SHORT_NCEPRI_SFRA, HVLV_GROUND_SFRA, HVLV_GROUND_DL_SFRA, 
            HVLV_GROUND_NCEPRI_SFRA
            , TIPE_SFRA
            , TEGANGAN_EC
    	)
    	VALUES 
    	(
	    	".$this->getField("FORM_UJI_DETIL_ID")."
	    	, ".$this->getField("FORM_UJI_ID")."
	    	, ".$this->getField("FORM_UJI_TIPE_ID")."
	    	, '".$this->getField("WAKTU")."'
	    	, '".$this->getField("HV_GND")."'
	    	, '".$this->getField("LV_GND")."'
	    	, '".$this->getField("HV_LV")."'
	    	, '".$this->getField("BUSHING")."'
	    	, '".$this->getField("SKIRT")."'
	    	, '".$this->getField("TEGANGAN")."'
	    	, '".$this->getField("IMA")."'
	    	, '".$this->getField("WATTS")."'
	    	, '".$this->getField("TAP")."'
	    	, '".$this->getField("IMA_RT")."'
	    	, '".$this->getField("WATTS_RT")."'
	    	, '".$this->getField("LC_RT")."'
	    	, '".$this->getField("IMA_SR")."'
	    	, '".$this->getField("WATTS_SR")."'
	    	, '".$this->getField("LC_SR")."'
	    	, '".$this->getField("IMA_TS")."'
	    	, '".$this->getField("WATTS_TS")."'
	    	, '".$this->getField("LC_TS")."'
	    	, '".$this->getField("FASA_RATIO")."'
	    	, '".$this->getField("HV_KV")."'
	    	, '".$this->getField("LV_KV")."'
	    	, '".$this->getField("RASIO_TEGANGAN")."'
	    	, '".$this->getField("HV_V")."'
	    	, '".$this->getField("DERAJAT_HV_V")."'
	    	, '".$this->getField("LV_V")."'
	    	, '".$this->getField("DERAJAT_LV_V")."'
	    	, '".$this->getField("RASIO_HASIL")."'
	    	, '".$this->getField("DEVIASI")."'
	    	, '".$this->getField("TAP_RATIO")."'
	    	, '".$this->getField("SISI_RDC")."'
	    	, '".$this->getField("TAP_RDC")."'
	    	, '".$this->getField("FASA_RDC_R")."'
	    	, '".$this->getField("ARUS_RDC_R")."'
	    	, '".$this->getField("TEGANGAN_RDC_R")."'
	    	, '".$this->getField("TAHANAN_RDC_R")."'
	    	, '".$this->getField("TAHANAN_TEMP_RDC_R")."'
	    	, '".$this->getField("DEV_RDC_R")."'
	    	, '".$this->getField("FASA_RDC_S")."'
	    	, '".$this->getField("ARUS_RDC_S")."'
	    	, '".$this->getField("TEGANGAN_RDC_S")."'
	    	, '".$this->getField("TAHANAN_RDC_S")."'
	    	, '".$this->getField("TAHANAN_TEMP_RDC_S")."'
	    	, '".$this->getField("DEV_RDC_S")."'
	    	, '".$this->getField("FASA_RDC_T")."'
	    	, '".$this->getField("ARUS_RDC_T")."'
	    	, '".$this->getField("TEGANGAN_RDC_T")."'
	    	, '".$this->getField("TAHANAN_RDC_T")."'
	    	, '".$this->getField("TAHANAN_TEMP_RDC_T")."'
	    	, '".$this->getField("DEV_RDC_T")."'
	    	, '".$this->getField("WINDING_TAN")."'
	    	, '".$this->getField("MEASURE_TAN_CH_CHL")."'
	    	, '".$this->getField("TEST_TAN_CH_CHL")."'
	    	, '".$this->getField("ARUS_TAN_CH_CHL")."'
	    	, '".$this->getField("DAYA_TAN_CH_CHL")."'
	    	, '".$this->getField("PF_CORR_TAN_CH_CHL")."'
	    	, '".$this->getField("CORR_FACT_TAN_CH_CHL")."'
	    	, '".$this->getField("CAP_TAN_CH_CHL")."'
	    	, '".$this->getField("MEASURE_TAN_CH")."'
	    	, '".$this->getField("TEST_TAN_CH")."'
	    	, '".$this->getField("ARUS_TAN_CH")."'
	    	, '".$this->getField("DAYA_TAN_CH")."'
	    	, '".$this->getField("PF_CORR_TAN_CH")."'
	    	, '".$this->getField("CORR_FACT_TAN_CH")."'
	    	, '".$this->getField("CAP_TAN_CH")."'
	    	, '".$this->getField("MEASURE_TAN_CHL_UST")."'
	    	, '".$this->getField("TEST_TAN_CHL_UST")."'
	    	, '".$this->getField("ARUS_TAN_CHL_UST")."'
	    	, '".$this->getField("DAYA_TAN_CHL_UST")."'
	    	, '".$this->getField("PF_CORR_TAN_CHL_UST")."'
	    	, '".$this->getField("CORR_FACT_TAN_CHL_UST")."'
	    	, '".$this->getField("CAP_TAN_CHL_UST")."'
	    	, '".$this->getField("MEASURE_TAN_CHL")."'
	    	, '".$this->getField("TEST_TAN_CHL")."'
	    	, '".$this->getField("ARUS_TAN_CHL")."'
	    	, '".$this->getField("DAYA_TAN_CHL")."'
	    	, '".$this->getField("PF_CORR_TAN_CHL")."'
	    	, '".$this->getField("CORR_FACT_TAN_CHL")."'
	    	, '".$this->getField("CAP_TAN_CHL")."'
	    	, '".$this->getField("TIPE_TAN")."'
	    	, '".$this->getField("WINDING_WITHOUT_TAN_1")."'
	    	, '".$this->getField("WINDING_WITHOUT_TAN_2")."'
	    	, '".$this->getField("WINDING_WITHOUT_TAN_3")."'
	    	, '".$this->getField("WINDING_WITHOUT_TAN_4")."'
	    	, '".$this->getField("WINDING_WITHOUT_TAN_5")."'
	    	, '".$this->getField("WINDING_WITHOUT_TAN_6")."'
	    	, '".$this->getField("WINDING_WITHOUT_TAN_7")."'
	    	, '".$this->getField("WINDING_WITHOUT_TAN_8")."'
	    	, '".$this->getField("CONDITION_TAN")."'
	    	, '".$this->getField("GOOD_TAN")."'
	    	, '".$this->getField("MAYBE_TAN")."'
	    	, '".$this->getField("INVESTIGATED_TAN")."'
	    	, '".$this->getField("HV_SFRA")."'
	    	, '".$this->getField("HV_DL_SFRA")."'
	    	, '".$this->getField("HV_NCEPRI_SFRA")."'
	    	, '".$this->getField("LV_SFRA")."'
	    	, '".$this->getField("LV_DL_SFRA")."'
	    	, '".$this->getField("LV_NCEPRI_SFRA")."'
	    	, '".$this->getField("HVLV_SFRA")."'
	    	, '".$this->getField("HVLV_DL_SFRA")."'
	    	, '".$this->getField("HVLV_NCEPRI_SFRA")."'
	    	, '".$this->getField("HV_SHORT_SFRA")."'
	    	, '".$this->getField("HV_SHORT_DL_SFRA")."'
	    	, '".$this->getField("HV_SHORT_NCEPRI_SFRA")."'
	    	, '".$this->getField("HVLV_GROUND_SFRA")."'
	    	, '".$this->getField("HVLV_GROUND_DL_SFRA")."'
	    	, '".$this->getField("HVLV_GROUND_NCEPRI_SFRA")."'
	    	, '".$this->getField("TIPE_SFRA")."'
	    	, '".$this->getField("TEGANGAN_EC")."'

	    )"; 


		$this->id= $this->getField("FORM_UJI_DETIL_ID");
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

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deleteisi()
	{
		$str = "
		DELETE FROM form_uji_isi
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedetil()
	{
		$str = "
		DELETE FROM form_uji_detil
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."
		
		"; 

		// AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deletedetiltan()
	{
		$str = "
		DELETE FROM form_uji_detil
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."
		AND TIPE_TAN = '".$this->getField("TIPE_TAN")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedetilsfra()
	{
		$str = "
		DELETE FROM form_uji_detil
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."
		AND TIPE_SFRA = '".$this->getField("TIPE_SFRA")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedetiltabel()
	{
		$str = "
		DELETE FROM form_uji_detil
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."
		AND FORM_UJI_DETIL_ID = ".$this->getField("FORM_UJI_DETIL_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	
	function deletedetiltabeltan()
	{
		$str = "
		DELETE FROM form_uji_detil
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."
		AND FORM_UJI_DETIL_ID = ".$this->getField("FORM_UJI_DETIL_ID")."
		AND TIPE_TAN = '".$this->getField("TIPE_TAN")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedetiltabelsfra()
	{
		$str = "
		DELETE FROM form_uji_detil
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."
		AND FORM_UJI_DETIL_ID = ".$this->getField("FORM_UJI_DETIL_ID")."
		AND TIPE_SFRA = '".$this->getField("TIPE_SFRA")."'
		"; 

		$this->query = $str;
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

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY A.FORM_UJI_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
			, B.FORM_UJI_TIPE_ID_INFO
		FROM form_uji A
		LEFT JOIN 
		(
			SELECT A.FORM_UJI_ID
			,STRING_AGG(A.FORM_UJI_TIPE_ID::text, ', ') AS FORM_UJI_TIPE_ID_INFO
			FROM FORM_UJI_ISI A
			GROUP BY A.FORM_UJI_ID
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

 //    function selectByParamsNameplate($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY FORM_UJI_NAMEPLATE_ID ASC")
	// {
	// 	$str = "
	
	// 	SELECT  A.*,B.*
	// 	FROM NAMEPLATE_DETIL A
	// 	LEFT JOIN FORM_UJI_NAMEPLATE B ON B.NAMEPLATE_DETIL_ID = A.NAMEPLATE_DETIL_ID
	// 	WHERE 1=1
	// 	"; 
		
	// 	while(list($key,$val) = each($paramsArray))
	// 	{
	// 		$str .= " AND $key = '$val' ";
	// 	}
		
	// 	$str .= $unitment." ".$sOrder;
	// 	$this->query = $str;
				
	// 	return $this->selectLimit($str,$limit,$from); 
 //    }

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

  } 
?>