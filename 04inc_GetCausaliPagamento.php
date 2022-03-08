<? $sql0 = "SELECT descrizione_pca, ord_pca FROM tab_pagamenticausali ORDER BY ord_pca";
$stmt0 = mysqli_prepare($mysqli, $sql0);
mysqli_stmt_execute($stmt0);
mysqli_stmt_bind_result($stmt0, $descrizione_pca, $ord_pca);
$n = 0;
while (mysqli_stmt_fetch($stmt0)) {
		$causali_pagA [$ord_pca] = $descrizione_pca; //ci possono esser dei salti. Infatti è stato tolto un valore ed è rimasto un buco (4) nella tab_pagamenti causali 
		$ord_pcaA [$ord_pca] = $ord_pca;   //costruisce una matrice di valori NON CONSECUTIVI che servirà poi a pescare correttamente.
		$n++;
}?>