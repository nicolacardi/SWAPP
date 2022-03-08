<?
//estraggo aselme
$aselme_cls = getASELME($classe_ver);
//con aselme e anno scolastico estraggo il tipo di pagella
$tipopagella = getTipoPagella1($annoscolastico_ver, $aselme_cls);

//sono due report completamente diversi a seconda che siano votazioni per obiettivi (tipo 6) o meno
if ($tipopagella == 6) {

    for($quadrimestre=1;$quadrimestre<=2;$quadrimestre++) {
//ESTRAZIONE E PUBBLICAZIONE VOTI : CASO VOTI CON OBIETTIVI ********************************************************

        $startY =   45;
        $startX =   10;
        $Hriga =    7.5;
        $riga =     0;
        $Lriga =    9.5;
        $colonna =  0;
        $LNome =    30;
        $LCognome = 30;

        $pdf->AddPage("L", "A3");
        $pdf->Cell(0, $Hriga,"Quadro sinottico delle votazioni approvate per la classe ".$classe_ver." - Quadrimestre ".$quadrimestre, 0,0, 'C');


        $sql = "SELECT ID_alu, nome_alu, cognome_alu, codmat_cla, vot".$quadrimestre."_cla, vot".$quadrimestre."_clo, codob_obi, descmateria_mat 
        FROM ((tab_anagraficaalunni JOIN tab_classialunni ON ID_alu =  tab_classialunni.ID_alu_cla) 
        LEFT JOIN tab_classialunnivoti ON ID_alu = tab_classialunnivoti.ID_alu_cla AND tab_classialunnivoti.annoscolastico_cla = '".$annoscolastico_ver."')
        LEFT JOIN tab_classialunnivotiobiettivi ON tab_classialunnivoti.ID_cla = ID_cla_clo 
        LEFT JOIN tab_materievotiobiettivi ON ID_obi_clo =  ID_obi 
        LEFT JOIN tab_materievoti ON codmat_mat = codmat_cla AND aselme_mat = '".$aselme_cls."' AND tipodoc_mat = ".$tipopagella."
        WHERE tab_classialunni.classe_cla = '".$classe_ver."' AND tab_classialunni.annoscolastico_cla = '".$annoscolastico_ver."' 
        AND ritirato_cla = 0 AND listaattesa_cla = 0 
        ORDER BY cognome_alu, nome_alu, ord_mat, codmat_cla, ID_obi_clo ;";
        //$pdf->SetXY (0,0);
        //$txt=$pdf->MultiCell(200,6,utf8_decode("SQL:  ".$sql),"LBR",'C',0,5);

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $codmat_cla, $vot_cla, $vot_clo, $codob_obi, $descmateria_mat );
        
        $codob_obiA = array("COM");
        mysqli_stmt_execute($stmt);

        $pdf->SetFont('TitilliumWeb-SemiBold','',10);
        $pdf->SetXY ($startX + $LNome + $LCognome, $startY);
        $pdf->Cell($Lriga, $Hriga, "COM", 1,0, 'C');
        $pdf->SetFont($fontdefault,'',9);

        while (mysqli_stmt_fetch($stmt)) {

            if($ID_alu != $ID_aluprev) {
                $riga++;
                //scrivo il nome e cognome
                $pdf->SetXY ($startX, $startY + $riga * $Hriga);
                $pdf->Cell($LNome, $Hriga, utf8_decode($nome_alu), 1,0, 'L');
                $pdf->Cell($LCognome, $Hriga, utf8_decode($cognome_alu), 1,0, 'L');
            }

            //inserisco gli obiettivi in un array solo se già non ci sono e quando li inserisco li vado anche a scrivere in prima riga
            if ($codmat_cla !="COM") {

                if (in_array( $codob_obi, $codob_obiA)){} else {
                    array_push ($codob_obiA, $codob_obi);
                    if ($codob_obi != null) {
                        $pdf->SetFont('TitilliumWeb-SemiBold','',10);
                        $pdf->SetXY ($startX + $LNome + $LCognome + array_search($codob_obi, $codob_obiA) * $Lriga, $startY);
                        $pdf->Cell($Lriga, $Hriga, utf8_decode($codob_obi), 1,0, 'C');
                        $pdf->SetXY ($startX + $LNome + $LCognome + array_search($codob_obi, $codob_obiA) * $Lriga, $startY-10);
                        $pdf->RotatedText($startX + $LNome + $LCognome + array_search($codob_obi, $codob_obiA) * $Lriga+$Lriga - 3, $startY-2 , $descmateria_mat,90);
                        $pdf->SetFont($fontdefault,'',9);
                    }
                } 

                //scrivo il voto nella posizione indicata dalla posizione nell'array: così non sbaglia, ma lo scrive nella colonna corretta
                $pdf->SetXY ($startX + $LNome + $LCognome + array_search($codob_obi, $codob_obiA) * $Lriga, $startY + $riga * $Hriga);
                if($vot_clo != "0" && $vot_clo != null) {
                    $pdf->Cell($Lriga, $Hriga, utf8_decode($vot_clo), 1,0, 'C');
                }
                
            } else {
                //mi occupo infine del voto del comportamento, che non è ovviamente per obiettivi
                if($vot_cla != "0" && $vot_cla != null) {
                    $pdf->SetXY ($startX + $LNome + $LCognome, $startY + $riga * $Hriga);
                    $pdf->Cell($Lriga, $Hriga, utf8_decode($vot_cla), 1,0, 'C');
                }
            }
            $ID_aluprev = $ID_alu;
        }


        // $pdf->Ln(1);
        // $pdf->MultiCell(180,5,utf8_decode($sql),0,'L');


//FINE ESTRAZIONE E PUBBLICAZIONE VOTI : CASO VOTI CON OBIETTIVI ***************************************************

//LEGENDA Voti pagella tipo 6 **************************************************************************************
                            $x1 = 0;

                                                    
                            $pdf->SetFont('TitilliumWeb-SemiBold','',12);
                            $pdf->SetXY (10+$x1,237);
                            $pdf->Cell(400,8,utf8_decode("LEGENDA"), "B",0, 'C');
                            $pdf->SetFont($fontdefault,'',8);

                            $pdf->SetXY (10+$x1,247);
                            $pdf->Cell(57,8,utf8_decode("GI=Gravemente Insufficiente"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("I= Insufficiente"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("S= Sufficiente"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("D= Discreto"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("B= Buono"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("DT= Distinto"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("O= Ottimo"), "TLRB",0, 'C');


                            $pdf->SetXY (10+$x1,257);
                            $pdf->Cell(40,8,utf8_decode("AC = In Via di Acquisizione"), "TLRB",0, 'C');
                            $pdf->Cell(150,8,utf8_decode(""), "TLRB",0, 'C');
                            $pdf->SetXY ($pdf->GetX()-150,257);
                            $pdf->MultiCell(150,3.5,utf8_decode("L'alunno porta a termine compiti solo in situazioni note e unicamente con il supporto del docente e di risorse fornite appositamente"), 0,'J');

                            $pdf->SetXY (10+$x1,265);
                            $pdf->Cell(40,8,utf8_decode("BA = Base"), "TLRB",0, 'C');
                            $pdf->Cell(150,8,utf8_decode(""), "TLRB",0, 'C');
                            $pdf->SetXY ($pdf->GetX()-150,265);
                            $pdf->MultiCell(150,3.5,utf8_decode("L'alunno porta a termine compiti solo in situazioni note e utilizzando le risorse fornite dal docente, sia in modo autonomo ma discontinuo, sia in modo non autonomo ma con continuità"), 0,'J');

                            $x1 = 210;
                            $pdf->SetXY (10+$x1,247);

                            $pdf->SetFont($fontdefault,'',8);
                            $pdf->SetXY (10+$x1,257);
                            $pdf->Cell(40,8,utf8_decode("IN = Intermedio"), "TLRB",0, 'C');
                            $pdf->Cell(150,8,utf8_decode(""), "TLRB",0, 'C');
                            $pdf->SetXY ($pdf->GetX()-150,257);
                            $pdf->MultiCell(150,3.5,utf8_decode("L'alunno porta a termine compiti in situazioni note in modo autonomo e continuo; risolve compiti in situazioni non note utilizzando le risorse fornite dal docente o reperite altrove, anche se in modo discontinuo e non del tutto autonomo"), 0,'J');

                            $pdf->SetXY (10+$x1,265);
                            $pdf->Cell(40,8,utf8_decode("AV = Avanzato"), "TLRB",0, 'C');
                            $pdf->Cell(150,8,utf8_decode(""), "TLRB",0, 'C');
                            $pdf->SetXY ($pdf->GetX()-150,265);
                            $pdf->MultiCell(150,3.5,utf8_decode("L'alunno porta a termine compiti in situazioni note e non note mobilitando una varietà di risorse, sia fornite dal docente sia reperite altrove in modo autonomo e con continuità"), 0,'J');
//FINE LEGENDA Voti pagella tipo 6 *********************************************************************************

    }

} else {

     //************************in questo caso estraggo i voti direttamente e non i voti degli obiettivi********************
    for($quadrimestre=1;$quadrimestre<=2;$quadrimestre++) {
//ESTRAZIONE E PUBBLICAZIONE VOTI : CASO VOTI SENZA OBIETTIVI ******************************************************
        $startY =      50;
        $startX =      10;
        $Hriga =       7.5;
        $riga =        0;
        $Lriga =       22;
        $colonna =     0;
        $LNome =       30;
        $LCognome =    35;

        $pdf->AddPage("L", "A3");
        $pdf->Cell(0, $Hriga,"Quadro sinottico delle votazioni approvate per la classe ".$classe_ver, 0,0, 'C');

        //estraggo i nomi degli alunni e i voti e li scrivo tutti nella prima colonna a sinistra
        $sql = "SELECT ID_alu, nome_alu, cognome_alu, codmat_cla, vot".$quadrimestre."_cla, descmateria_mat
        FROM (tab_anagraficaalunni JOIN tab_classialunni ON ID_alu =  tab_classialunni.ID_alu_cla) 
        LEFT JOIN tab_classialunnivoti ON ID_alu = tab_classialunnivoti.ID_alu_cla AND tab_classialunnivoti.annoscolastico_cla = '".$annoscolastico_ver."'
        LEFT JOIN tab_materievoti ON codmat_mat = codmat_cla AND aselme_mat = '".$aselme_cls."' AND tipodoc_mat = ".$tipopagella."
        WHERE tab_classialunni.classe_cla = '".$classe_ver."' AND tab_classialunni.annoscolastico_cla = '".$annoscolastico_ver."' 
        AND ritirato_cla = 0 AND listaattesa_cla = 0 
        ORDER BY cognome_alu, nome_alu, ord_mat, codmat_cla ;";

        //$pdf->SetXY (0,0);
        //$txt=$pdf->MultiCell(200,6,utf8_decode($sql),"LBR",'C',0,5);
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $codmat_cla, $vot_cla, $descmateria_mat);
        $codmat_claA = array("COM");
        mysqli_stmt_execute($stmt);



        while (mysqli_stmt_fetch($stmt)) {

            if($ID_alu != $ID_aluprev) {
                $riga++;
                //scrivo nome e cognome
                $pdf->SetXY ($startX, $startY + $riga * $Hriga);
                $pdf->Cell($LNome, $Hriga, utf8_decode($nome_alu), 1,0, 'L');
                $pdf->Cell($LCognome, $Hriga, utf8_decode($cognome_alu), 1,0, 'L');
            }

            if ($codmat_cla !="COM") {
                if (in_array( $codmat_cla, $codmat_claA)){} else {
                    array_push ($codmat_claA, $codmat_cla);

                        $pdf->SetFont('TitilliumWeb-SemiBold','',10);

                        $pdf->SetXY ($startX + $LNome + $LCognome + array_search($codmat_cla, $codmat_claA) * $Lriga, $startY-10);
                        $pdf->RotatedText($startX + $LNome + $LCognome + array_search($codmat_cla, $codmat_claA) * $Lriga + ($Lriga/2), $startY+5 , $descmateria_mat,90);
                        $pdf->SetFont($fontdefault,'',9);

                } 

                $pdf->SetXY ($startX + $LNome + $LCognome + array_search($codmat_cla, $codmat_claA) * $Lriga, $startY + $riga * $Hriga);
                if($vot_cla != "0" && $vot_cla != null) {
                    $pdf->Cell($Lriga, $Hriga, utf8_decode($vot_cla), 1,0, 'C');
                }
            } else {

                $pdf->SetFont('TitilliumWeb-SemiBold','',10);
                $pdf->RotatedText($startX + $LNome + $LCognome + $Lriga/2, $startY +5 , utf8_decode("Comportamento"),90);
                $pdf->SetFont($fontdefault,'',9);
                
                //mi occupo infine del voto del comportamento, che va messo nella prima colonna
                if($vot_cla != "0" && $vot_cla != null) {
                    $pdf->SetXY ($startX + $LNome + $LCognome, $startY + $riga * $Hriga);
                    $pdf->Cell($Lriga, $Hriga, utf8_decode($vot_cla), 1,0, 'C');
                }
            }
            $ID_aluprev = $ID_alu;
        }




//FINE ESTRAZIONE E PUBBLICAZIONE VOTI : CASO VOTI SENZA OBIETTIVI *************************************************

//LEGENDA Voti pagella tipo <> 6 ***********************************************************************************
                            $x1 = 0;
                            $pdf->SetFont('TitilliumWeb-SemiBold','',12);
                            $pdf->SetXY (10+$x1,247);
                            $pdf->Cell(400,8,utf8_decode("LEGENDA"), "B",0, 'C');
                            $pdf->SetFont($fontdefault,'',8);
                            $pdf->SetXY (10+$x1,257);
                            $pdf->Cell(57,8,utf8_decode("GI=Gravemente Insufficiente"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("I= Insufficiente"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("S= Sufficiente"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("D= Discreto"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("B= Buono"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("DT= Distinto"), "TLRB",0, 'C');
                            $pdf->Cell(57,8,utf8_decode("O= Ottimo"), "TLRB",0, 'C');
//FINE LEGENDA Voti pagella tipo <> 6 ******************************************************************************
     
    }                 

}



?>