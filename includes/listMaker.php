<?php 

class listData 
{ 
	public static function makeList ($action, $data){

		$show= '';

		if ($data[0]['id'] !=NULL) {

			if ($data !='' && $action=='flo' || $action=='slo') {
				foreach ($data as $line) {
					$show .= "<li><a id='".$line['id']."' name='".$line['value']."_".$line['id']."'><span class='badge'>".$line['id']."</span> <span id='message'>".$line['message']."</span></a></li>\n";
				}
			}
			elseif ($data !='' && $action=='neighborhoods') {
				foreach ($data as $line) {
					$show .= "<li><a id='".$line['id']."' name='".$line['id']."'>".$line['id']."</a></li>\n";
				}
			}
			elseif ($data !='') {
				foreach ($data as $line) {
					$show .= "<li><a id='".$line['id']."' name='".$line['name']."'><span class='badge'>".$line['id']."</span> ".$line['name']."</a></li>\n";
				}		
			}
		}else{
			$show = null;
		}

		return $show;		
	}

}
