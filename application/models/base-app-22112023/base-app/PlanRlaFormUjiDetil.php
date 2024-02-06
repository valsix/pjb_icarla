<? 
  include_once(APPPATH.'/models/Entity.php');

  class PlanRlaFormUjiDetil extends Entity{ 

	var $query;

    function PlanRlaFormUjiDetil()
	{
      $this->Entity(); 
    }
	function insert()
    {
    	$this->setField("PLAN_RLA_FORM_UJI_DETIL_ID", $this->getNextId("PLAN_RLA_FORM_UJI_DETIL_ID","plan_rla_form_uji_detil"));

    	$str = "
    	INSERT INTO plan_rla_form_uji_detil
    	(
    		PLAN_RLA_FORM_UJI_DETIL_ID,PLAN_RLA_ID,FORM_UJI_ID,FORM_UJI_TIPE_ID,WAKTU,HV_GND,LV_GND,HV_LV,BUSHING,SKIRT,TEGANGAN,IMA,WATTS,TAP,IMA_RT,WATTS_RT,LC_RT,IMA_SR,WATTS_SR,LC_SR,IMA_TS,WATTS_TS,LC_TS,FASA_RATIO,HV_KV,LV_KV, RASIO_TEGANGAN, HV_V, DERAJAT_HV_V, 
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
	    	".$this->getField("PLAN_RLA_FORM_UJI_DETIL_ID")."
	    	, ".$this->getField("PLAN_RLA_ID")."
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


		$this->id= $this->getField("PLAN_RLA_FORM_UJI_DETIL_ID");
		$this->query= $str;
		// echo $str;
		return $this->execQuery($str);
	}

	
	function deletedetil()
	{
		$str = "
		DELETE FROM plan_rla_form_uji_detil
		WHERE 
		PLAN_RLA_ID = ".$this->getField("PLAN_RLA_ID")."
		AND FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
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
		DELETE FROM plan_rla_form_uji_detil
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
		DELETE FROM plan_rla_form_uji_detil
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
		DELETE FROM plan_rla_form_uji_detil
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."
		AND PLAN_RLA_FORM_UJI_DETIL_ID = ".$this->getField("PLAN_RLA_FORM_UJI_DETIL_ID")."
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	
	function deletedetiltabeltan()
	{
		$str = "
		DELETE FROM plan_rla_form_uji_detil
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."
		AND PLAN_RLA_FORM_UJI_DETIL_ID = ".$this->getField("PLAN_RLA_FORM_UJI_DETIL_ID")."
		AND TIPE_TAN = '".$this->getField("TIPE_TAN")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedetiltabelsfra()
	{
		$str = "
		DELETE FROM plan_rla_form_uji_detil
		WHERE 
		FORM_UJI_ID = ".$this->getField("FORM_UJI_ID")."
		AND FORM_UJI_TIPE_ID = ".$this->getField("FORM_UJI_TIPE_ID")."
		AND PLAN_RLA_FORM_UJI_DETIL_ID = ".$this->getField("PLAN_RLA_FORM_UJI_DETIL_ID")."
		AND TIPE_SFRA = '".$this->getField("TIPE_SFRA")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParamsDetil($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY PLAN_RLA_FORM_UJI_DETIL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM plan_rla_form_uji_detil A
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