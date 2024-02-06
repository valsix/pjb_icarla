<? 
  include_once(APPPATH.'/models/Entity.php');

  class TimelineRla extends Entity{ 

	var $query;

    function TimelineRla()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("TIMELINE_RLA_ID", $this->getNextId("TIMELINE_RLA_ID","timeline_rla"));

    	$str = "
    	INSERT INTO timeline_rla
    	(
    		TIMELINE_RLA_ID, NAMA, RENCANA_TANGGAL_AWAL, RENCANA_TANGGAL_AKHIR
    		, RENCANA_DURASI
    		, REALISASI_TANGGAL_AWAL
    		, REALISASI_TANGGAL_AKHIR
    		, REALISASI_DURASI
    	)
    	VALUES 
    	(
	    	".$this->getField("TIMELINE_RLA_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("RENCANA_TANGGAL_AWAL")."
	    	, ".$this->getField("RENCANA_TANGGAL_AKHIR")."
	    	, '".$this->getField("RENCANA_DURASI")."'
	    	, ".$this->getField("REALISASI_TANGGAL_AWAL")."
	    	, ".$this->getField("REALISASI_TANGGAL_AKHIR")."
	    	, '".$this->getField("REALISASI_DURASI")."'
	    )"; 

		$this->id= $this->getField("TIMELINE_RLA_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE timeline_rla
		SET
		NAMA= '".$this->getField("NAMA")."'
		, RENCANA_TANGGAL_AWAL= ".$this->getField("RENCANA_TANGGAL_AWAL")."
		, RENCANA_TANGGAL_AKHIR= ".$this->getField("RENCANA_TANGGAL_AKHIR")."
		, RENCANA_DURASI= '".$this->getField("RENCANA_DURASI")."'
		, REALISASI_TANGGAL_AWAL= ".$this->getField("REALISASI_TANGGAL_AWAL")."
		, REALISASI_TANGGAL_AKHIR= ".$this->getField("REALISASI_TANGGAL_AKHIR")."
		, REALISASI_DURASI= '".$this->getField("REALISASI_DURASI")."'
		WHERE TIMELINE_RLA_ID = '".$this->getField("TIMELINE_RLA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM timeline_rla
		WHERE 
		TIMELINE_RLA_ID = ".$this->getField("TIMELINE_RLA_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY TIMELINE_RLA_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM timeline_rla A 
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

    function selectByParamsPlanRla($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="order by a.rencana_tanggal_awal,a.rencana_tanggal_akhir,a.realisasi_tanggal_awal, a.realisasi_tanggal_akhir desc")
		{
				$str = "
				select
						a.*,SA.NAMA  STATUS_APPROVE_NAMA
				from plan_rla a 
				LEFT JOIN status_approve SA ON A.V_STATUS = SA.STATUS_APPROVE_ID
				where 1=1 
				"; 
				
				while(list($key,$val) = each($paramsArray))
				{
					$str .= " AND $key = '$val' ";
				}
				
				$str .= $statement." ".$sOrder;
				$this->query = $str;
						
				return $this->selectLimit($str,$limit,$from); 
	  }

	  function selectByParamsPlanRlaWbs($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="order by tanggal_awal,tanggal_akhir desc")
		{
				$str = "
				select 
				*
				from
				(
					select
							a.plan_rla_id, 'Rencana' status
							, to_char(a.rencana_tanggal_awal, 'DD-MM-YYYY') tanggal_awal
							, to_char(a.rencana_tanggal_akhir, 'DD-MM-YYYY') tanggal_akhir
							, a.rencana_tanggal_akhir - a.rencana_tanggal_awal selisih
							, b.nama nama_progress
							, a.V_STATUS
					from plan_rla a
					left join timeline_rla b on b.timeline_rla_id = a.timeline_rla_id
					where a.rencana_tanggal_awal is not null and a.rencana_tanggal_akhir is not null

					UNION ALL

					select
							a.plan_rla_id, 'Realisasi' status
							, to_char(a.realisasi_tanggal_awal, 'DD-MM-YYYY') tanggal_awal
							, to_char(a.realisasi_tanggal_akhir, 'DD-MM-YYYY') tanggal_akhir
							, a.realisasi_tanggal_akhir - a.realisasi_tanggal_awal selisih
							, b.nama nama_progress
							, a.V_STATUS
					from plan_rla a
					left join timeline_rla b on b.timeline_rla_id = a.timeline_rla_id
					where a.realisasi_tanggal_awal is not null and a.realisasi_tanggal_akhir is not null
				) a
				where 1=1
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