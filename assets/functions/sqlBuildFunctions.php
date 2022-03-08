<?

function filterbysqlexplode ($fil, $campo, $filsq) {
    //in questa funzione ricevo l'intera stringa
    //per prima cosa individuo se c'è l'uguale come primo carattere perchè le chiamate
    //a filterbysql avverranno come = o come LIKE a seconda
    if ($fil == '') {
        return $filsq;
    }

    if (substr($fil,0,1) == '=') {
        $parametro = "=";
        $fil = substr($fil, 1); //tolgo da $fil l'uguale in questo caso, tanto quello l'ho già registrato come parametro
    } else {
        $parametro = "LIKE";
    }
    //a questo punto divido la stringa in base alle virgole eventualmente presenti
    //e passo ciascuna substring a filterbysql con il parametro predeterminato

    $fil_arr = explode (",", $fil); 
    foreach($fil_arr as $elemento_tra_virgole) {
        $filsqV = filterbysql( $elemento_tra_virgole, $campo, $filsqV, $parametro);
    }
    $filsq =  $filsq." AND ( ". substr($filsqV, 4). ") ";
    return $filsq;
}


function filterbysql ($elemento_tra_virgole, $campo, $filsq, $parametro) {
    //parametro può essere = o LIKE
    //elemento_tra_virgole è ormai eventualmente depurato dell'uguale iniziale (se presente)
    if ($parametro == "=") {
        $filsq = $filsq . " OR ". $campo. " = '". $elemento_tra_virgole ."' ";
    } else {
        $filsq = $filsq . " OR ". $campo. " LIKE '%". $elemento_tra_virgole ."%' ";
    }
    return $filsq;
}

function orderbysql ($ord, $campo, $ordsq) {		
    switch ($ord) {
        case '--' :
            break;
        case 'az' :
            $ordsq = $ordsq . ' , '. $campo. ' '. 'ASC ' ;
            break;
        case 'za':
            $ordsq = $ordsq . ' , '. $campo. ' '. 'DESC ' ;
            break;
    }
    return $ordsq;
}


	
?>
