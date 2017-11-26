<?php

class Security_model extends CI_Model
{
	function checkInt($parametr)
	{
		if($parametr == 0 || !is_numeric($parametr)) {
			show_404();
		}
	}
	
	function checkStr($data, $block = TRUE)
	{
		$newData = htmlspecialchars($data);
		$stripTagsData = strip_tags($data);
		if(strlen($stripTagsData) != strlen($data))
		{
			if($block)
				die("все очень плохо!");
		}
		return $newData;	
	}
	
}

?>