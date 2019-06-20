<?php
class CRestricted {
	
	# protected $list_users;

	public static function listagem(){
		$list_users = array('2509','2686','2398','417','274','434','442','373');
		return $list_users;
	}

	public static function vef( $matricula ){
		$flag = 0;$ac='';
		$list_users = self::listagem();
		for( $i=0; $i < count($list_users); $i++ ){
			if( $list_users[$i] == $matricula ){
				$flag = 1;
			}
		}
		if( $flag == 1 ){
			$ac = 'yes';
		}else {
			$ac = 'not';
		}

		return $ac;
	}

}

?>