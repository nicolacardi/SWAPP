<?$sql = "SELECT DISTINCT nome_alu, cognome_alu, comunenascita_alu, provnascita_alu, datanascita_alu, citta_alu, prov_alu, cf_alu, mf_alu  FROM tab_anagraficaalunni WHERE ID_alu = ? ;";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "i", $ID_alu_cla);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nome_alu, $cognome_alu, $comunenascita_alu, $provnascita_alu, $datanascita_alu, $citta_alu, $prov_alu, $cf_alu, $mf_alu);
while (mysqli_stmt_fetch($stmt)) {
}
if ($mf_alu == "M") {$finmin = "o"; $finMAI = "O";} else {$finmin = "a"; $finMAI = "A";}
if ($aselme_cla == 'AS') { header('Location: 02IMieiAlunni.php'); }

$sql = "SELECT classe_cla, sezione_cla, ggassenza1_cla, ggassenza2_cla, datapagella1_cla, datapagella2_cla, hafreq_cla, votofinale_cla, ammesso_cla, giuquad1_cla, giuquad2_cla, desc_cls, desc2_cls, pagprimotrim_cls FROM tab_classialunni LEFT JOIN tab_classi ON classe_cla = classe_cls WHERE ID_alu_cla = ? AND annoscolastico_cla = ?;";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "is", $ID_alu_cla, $annoscolastico_cla);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $classe_cla, $sezione_cla, $ggassenza1_cla, $ggassenza2_cla, $datapagella1_cla, $datapagella2_cla, $hafreq_cla, $votofinale_cla, $ammesso_cla, $giuquad1_cla, $giuquad2_cla, $desc_cls, $desc2_cls, $pagprimotrim_cls);
while (mysqli_stmt_fetch($stmt)) {
}

//se datapagella = 00/00/0000 o simile bisogna mettere la data odierna
if ($datapagella1_cla == '1900-00-00' || $datapagella1_cla == '0000-00-00' ||$datapagella1_cla =='') {$datapagella1_cla = date("Y-m-d");}
if ($datapagella2_cla == '1900-00-00' || $datapagella2_cla == '0000-00-00' ||$datapagella2_cla =='') {$datapagella2_cla = date("Y-m-d");}
//estraggo i campi di tab_classialunnivoti.

$votidoppiSecondoQuadrimestre= getPar('votidoppiSecondoQuadrimestre');

            $CODtipovoto = array("idle", "0", "AC", "BA", "IN", "AV");
            $DESCtipovoto = array("", "-", "In Via di Acquisizione", "Base", "Intermedio", "Avanzato");
            //estraggo le materie dell'alunno nell'anno scolastico
            //ci metto a fianco i voti dati agli obiettivi - dove ce ne siano
            //poi ci metto a fianco le descrizioni di quegli obiettivi
            $sql = "SELECT ID_mat, vot1_clo, vot2_clo, desc_obd, ord_mat, ord_obd
            FROM (((tab_materievoti LEFT JOIN  tab_classialunnivoti ON codmat_cla = codmat_mat AND aselme_cla = aselme_mat AND ID_alu_cla = ? AND annoscolastico_cla = ?) 
            LEFT JOIN tab_materievotiobiettivi ON ID_mat = ID_mat_obi )
            JOIN tab_materievotiobiettividesc ON ID_obi = ID_obi_obd AND classe_obd = ? )
            LEFT JOIN tab_classialunnivotiobiettivi ON ID_obi_clo = ID_obi AND ID_cla_clo = ID_cla
            WHERE aselme_mat = ? AND tipodoc_mat = ? ORDER BY ord_mat, ord_obd;";
                $vot1ObA = array();
                $vot2ObA = array();
                $descObA = array();
            //in questa select devo estrarre gli obiettivi, le loro descrizioni e i voti dati a ID_alu_cla da tab_classialunniobiettivi
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, "issss", $ID_alu_cla, $annoscolastico_cla, $classe_cla, $aselme_cla, $tipodoc_mat);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $ID_mat, $vot1_clo, $vot2_clo, $desc_obd, $ord_mat, $ord_obd);


            $ID_mateprec = 0;
            while (mysqli_stmt_fetch($stmt)) {
                if ($ID_mat != $ID_matprec) {$n = 0;}
                $n++;
                array_search($vot1_clo, $CODtipovoto);

                $vot1ObA [$ID_mat][$n] = $DESCtipovoto[array_search($vot1_clo, $CODtipovoto)];
                $vot2ObA [$ID_mat][$n] = $DESCtipovoto[array_search($vot2_clo, $CODtipovoto)];
                $descObA [$ID_mat][$n] = $desc_obd;
                $ID_matprec = $ID_mat;
            }

//Estraggo i voti della sola materia COMPORTAMENTO
$sql = "SELECT vot1_cla, giu1_cla, vot2_cla, giu2_cla, descmateria_mat 
FROM (tab_materievoti LEFT JOIN  tab_classialunnivoti ON codmat_cla = codmat_mat AND aselme_cla = aselme_mat AND ID_alu_cla = ? AND annoscolastico_cla = ?) 
WHERE aselme_mat = ? AND codmat_mat = 'COM' AND tipodoc_mat = ".$tipodoc_mat." ORDER BY ord_mat;";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "iss", $ID_alu_cla, $annoscolastico_cla, $aselme_cla);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $vot1_comportamento, $giu1_comportamento, $vot2_comportamento, $giu2_comportamento, $descmateria_comportamento);
mysqli_stmt_store_result($stmt);
while (mysqli_stmt_fetch($stmt)) {
}


//Estraggo le materie, ci metto a fianco i voti dell'alunno eventuali ed il conteggio degli obiettivi se ce ne sono
$sql = "SELECT ID_mat, codmat_cla, vot1_cla, giu1_cla, vot2_cla, giu2_cla, codmat_mat, descmateria_mat, contaobiettivi.n 
FROM (tab_materievoti LEFT JOIN  tab_classialunnivoti ON codmat_cla = codmat_mat AND aselme_cla = aselme_mat AND ID_alu_cla = ? AND annoscolastico_cla = ?) 
LEFT JOIN (SELECT ID_mat_obi, COUNT(*) AS n FROM tab_materievotiobiettivi GROUP BY ID_mat_obi) contaobiettivi ON tab_materievoti.ID_mat = contaobiettivi.ID_mat_obi
WHERE aselme_mat = ? AND tipodoc_mat = ".$tipodoc_mat." ORDER BY ord_mat;";


// $sql = "SELECT codmat_cla, vot1_cla, giu1_cla, vot2_cla, giu2_cla, codmat_mat, descmateria_mat 
// FROM (tab_materievoti LEFT JOIN  tab_classialunnivoti ON codmat_cla = codmat_mat AND aselme_cla = aselme_mat AND ID_alu_cla = ? AND annoscolastico_cla = ?) 
// LEFT JOIN (SELECT ID_mat_obi, COUNT(*) AS n FROM tab_materievotiobiettivi GROUP BY ID_mat_obi) contaobiettivi ON tab_materievoti.ID_mat = contaobiettivi.ID_mat_obi
// WHERE aselme_mat = ? AND tipodoc_mat = ".$tipodoc_mat." ORDER BY ord_mat;";

$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "iss", $ID_alu_cla, $annoscolastico_cla, $aselme_cla);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_mat, $codmat_cla, $vot1_cla, $giu1_cla, $vot2_cla, $giu2_cla, $codmat_mat, $descmateria_mat, $n_obiettivi);
mysqli_stmt_store_result($stmt);

//in questo file, comune a tutti i download delle pagelle, viene preparata la SELECT, mentre la fetch avviene poi nel file nel quale viene incluso questo
?>