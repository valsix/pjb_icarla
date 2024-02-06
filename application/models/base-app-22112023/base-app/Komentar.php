<? 
  include_once(APPPATH.'/models/Entity.php');

  class Komentar extends Entity{ 

	var $query;

    function Komentar()
	{
      $this->Entity(); 
    }

    function insert()
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


	function update()
	{
		$str = "
		UPDATE komentar
		SET
		 STATUS= '".$this->getField("STATUS")."'
		, NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE KOMENTAR_ID = ".$this->getField("KOMENTAR_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM komentar
		WHERE 
		KOMENTAR_ID = ".$this->getField("KOMENTAR_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $jabatanment='', $sOrder="ORDER BY KOMENTAR_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			, CASE WHEN A.STATUS = '1' THEN 'Inactive' ELSE 'Aktif' END INFO_STATUS
			
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

  } 
?>