<?
    $return['yr'] = date('Y', strtotime("now"));    //yyyy
	$return['mnt'] = date('m', strtotime("now"));   //01-12
    $return['dt'] = date('d', strtotime("now"));    //01-31

    $return['hrs'] = date('H', strtotime("now"));   //01-24
    $return['mns'] = date('i', strtotime("now"));   //01-59
    $return['scd'] = date('s', strtotime("now"));   //01-59

	echo json_encode($return);
?>