<? 
  include_once(APPPATH.'/models/Entity.php');

  class FormUjiTipe extends Entity{ 

	var $query;

    function FormUjiTipe()
	{
      $this->Entity(); 
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
    	$str = "
 		SELECT
 		*
    	FROM FORM_UJI_TIPE A
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