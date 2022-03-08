<?  
    include_once("database/databaseii.php");
    include_once("assets/functions/functions.php");
    $tipoQuoteExport = $_GET['tipoQuoteExport'];

    $CodiciAvereConcordatoA = array('AS'=>410031, 'EL'=>410032, 'ME' =>410033, 'SU' =>000000);
    $CodiciAvereConcordatoAIscTess = array('2'=>410009, '5'=>410008);
    if ($tipoQuoteExport == "pagate"){$file_name = "txt/".date('Ymd_h.i.s').'_PAGAMENTI.txt';}
    if ($tipoQuoteExport == "concordate"){$file_name = "txt/".date('Ymd_h.i.s').'_CONCORDATE.txt';}
    $handle = fopen($file_name, "w");
    fwrite($handle, trim("#File di testo creato per ELMAS\n"));
    $ID_pag = $_GET['ID_pag'];
    $ID_alu = $_GET['ID_alu'];
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
    $annoscolastico = $_GET['annoscolastico'];

    fwrite($handle, "\n#Tipo di quote:  ".$tipoQuoteExport);

    if ($ID_pag == 0) {$ID_pag = "no";} //nel caso di download di più record non ha senso indicare ID_pag = 0
    fwrite($handle, "\n#Singolo ID_pag: ".$ID_pag);
    fwrite($handle, "\n#ID Alunno:      ".$ID_alu);
    fwrite($handle, "\n#Dal:            ".$dateFrom);
    fwrite($handle, "\n#Al:             ".$dateTo."\n\n");

    if ($tipoQuoteExport == "pagate") {

        // ******************************** CASO QUOTE PAGATE ******************************
        if ($ID_pag != 0) {
            $whereID_pag = " AND ID_pag = ".$ID_pag." ";
        } else {
            $whereDate = " AND data_pag >= '".$dateFrom."' AND data_pag <= '".$dateTo."'";
            if ($ID_alu != 'Tutti') {$whereID_alu = " AND ID_alu_pag = ".$ID_alu." ";}
        }

        $sql = "SELECT ID_ret, ID_pag, importo_pag, data_pag, causale_pag, tipo_pag, soggetto_pag, nricevuta_pag, LPAD(mese_ret, 2, '0'), anno_ret, nome_alu, cognome_alu, nomepadre_fam, cognomepadre_fam, nomemadre_fam, cognomemadre_fam, indirizzo_alu, CAP_alu, citta_alu, prov_alu, cf_alu, aselme_cla 
        FROM tab_pagamenti
        LEFT JOIN tab_mensilirette ON ID_ret = ID_ret_pag
        LEFT JOIN tab_anagraficaalunni ON ID_alu =  ID_alu_pag
        LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam 
        LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_cla = '".$annoscolastico."'".
        //LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_cla = annoscolastico_ret".
        " WHERE 1 = 1 ". $whereID_pag. $whereDate. $whereID_alu;

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ID_ret, $ID_pag, $importo_pag, $data_pag, $causale_pag, $tipo_pag, $soggetto_pag, $nricevuta_pag, $mese_ret_pad, $anno_ret, $nome_alu, $cognome_alu, $nomepadre_fam, $cognomepadre_fam, $nomemadre_fam, $cognomemadre_fam, $indirizzo_alu, $cap_alu, $citta_alu, $prov_alu, $cf_alu, $aselme_cla );

        $CausaliIncassiA = array(1=>1018, 2=>1017, 3=>1017, 4=>1017); //2018: BONIFICO, 2017: CONTANTI, ALTRI: CONTANTI
        $CodiciDareIncassiA = array(1=>126061, 2=>125001, 4=>125002);
        $erroriEsportazione = "";
        
        
        $n = 0;
        while (mysqli_stmt_fetch($stmt)) { 
            $n++;
            //SE causale_pag = 2 (ISCRIZIONE) o causale_pag = 5 (QUOTA ASSOCIATIVA)
            // allora devo ANCHE creare una quota CONCORDATA che avrà NUMREG=2
            //e NUMDOC = 999999+id_pag SIA su concordata che su pagata
            if ($causale_pag == 2 || $causale_pag == 5) {
                // ******************************** INSERISCO UNA QUOTA CONCORDATA SE ISC o TESS ******************************
                $numreg = 2;
                //creo un ID che vado a inserire in NUMDOC e che è uguale nelle due testate (CONCORDATA e PAGATA).
                //poichè ID_ret non si uò usare in quanto in questo caso è null
                //utilizzo l'univoco ID_pag. Questo per coincidenza potrebbe essere uguale a qualche ID_ret
                //quindi vado a sommare 1000000 a ID_pag e quello lo metto in ID_ret, così poi verrà usato anche
                //nella scrittura del pagamento
                $ID_ret = $ID_pag + 1000000;


                //metto lo STESSO numero della testata del pagamento
                $towrite= "\n#******** QUOTA CONCORDATA GENERATA A FRONTE DI TESSERAMENTO O ISCRIZIONE ********";
                $towrite= $towrite."\n#******** CORRISPONDE A PAGAMENTO DI CUI IN TESTATA N. ".$n." ************************";
                $towrite= $towrite."\n#******** ID_pag = ".$ID_pag." ************************";

                $towrite= $towrite."\n[TESTA]";
                $towrite= $towrite."\n"."CF_RAGSOC1=".strtoupper($cognome_alu);
                $towrite= $towrite."\n"."CF_RAGSOC2=".strtoupper($nome_alu);
                $towrite= $towrite."\n"."CF_INDIRIZZO=".strtoupper($indirizzo_alu);
                $towrite= $towrite."\n"."CF_CAP=".$cap_alu;
                $towrite= $towrite."\n"."CF_COMUNE=".$citta_alu;
                $towrite= $towrite."\n"."CF_PROVINCIA=".$prov_alu;
                $towrite= $towrite."\n"."CF_CODFISC=".$cf_alu;
                $towrite= $towrite."\n"."CF_PIVA=";
                $towrite= $towrite."\n"."CF_CODPAG=BO001";
                $towrite= $towrite."\n"."CF_CODGEVE=";
                $towrite= $towrite."\n"."CF_NATGIU=";
                $towrite= $towrite."\n"."CF_INTEST=";
                $towrite= $towrite."\n"."BANCA_ABI=";
                $towrite= $towrite."\n"."BANCA_CAB=";
                $towrite= $towrite."\n"."DITTA=0001";
                $towrite= $towrite."\n"."ATTIVITA=1";
                $towrite= $towrite."\n"."TIPOREG=1";
                $towrite= $towrite."\n"."NUMREG=".$numreg;
                $towrite= $towrite."\n"."CAUSALE=1016"; //sempre e solo le rette a preventivo
                $towrite= $towrite."\n"."NUMDOC=".$ID_ret;

                $towrite= $towrite."\n"."DATADOC=".timestamp_to_ggmmaaaa($data_pag);
                
                $towrite= $towrite."\n"."DIVISA=EURO";
                $towrite= $towrite."\n"."CAMBIO=";
                $towrite= $towrite."\n"."TOTDOC=".number_format($importo_pag,2,",","");
                $towrite= $towrite."\n"."ACCONTO=";
                $towrite= $towrite."\n"."ABBUONO=";
                $towrite= $towrite."\n"."AGENTE=";
                $towrite= $towrite."\n";
                $towrite= $towrite."\n"."[IVA]";
                $towrite= $towrite."\n"."CODIVA=FCI";
                $towrite= $towrite."\n"."IMPONIBILE=".number_format($importo_pag,2,",","");
                $towrite= $towrite."\n"."IVA=0,00";
                $towrite= $towrite."\n";
                $towrite= $towrite."\n"."[COGE]";
                $towrite= $towrite."\n"."CONTO=0";
                $towrite= $towrite."\n"."IMPORTO=".number_format($importo_pag,2,",","");
                $towrite= $towrite."\n"."TIPORIGA=1";
                $towrite= $towrite."\n"."SEGNO=D";
                $towrite= $towrite."\n";
                $towrite= $towrite."\n"."[COGE]";
                $towrite= $towrite."\n"."CONTO=".$CodiciAvereConcordatoAIscTess[$causale_pag];  //nel caso di iscrizione o tesseramento non dipende da aselme ma da causale
                $towrite= $towrite."\n"."IMPORTO=".number_format($importo_pag,2,",","");
                $towrite= $towrite."\n"."TIPORIGA=4";
                $towrite= $towrite."\n"."SEGNO=A";
                $towrite= $towrite."\n";
                $towrite= $towrite."\n"."[COGE]";
                $towrite= $towrite."\n"."CONTO=247001";;
                $towrite= $towrite."\n"."IMPORTO=0,00";
                $towrite= $towrite."\n"."TIPORIGA=5";
                $towrite= $towrite."\n"."SEGNO=A";
                $towrite= $towrite."\n";
                $towrite= $towrite."\n"."[SCAD]";
                $towrite= $towrite."\n"."TIPORATA=BON";;
                if ($anno_ret != "") {
                    $towrite= $towrite."\n"."DATASCAD="."02/".$mese_ret_pad."/".$anno_ret;
                } else {
                    $towrite= $towrite."\n"."DATASCAD=";
                }
                $towrite= $towrite."\n"."IMPORTO=".number_format($importo_pag,2,",","");
                $towrite= $towrite."\n";

                fwrite($handle, $towrite);

            } else {
                $numreg = 1;
            }

            $importo_pag = number_format($importo_pag,2,",","");
            
            
            $towrite= "\n#******** TESTATA N. ".$n." ID_pag: ".$ID_pag."************************";
            $towrite= $towrite."\n[MOV_TESTA]";
            $towrite= $towrite."\n"."CAUSALE=".$CausaliIncassiA[$tipo_pag];
            $towrite= $towrite."\n"."DATAREG=".timestamp_to_ggmmaaaa($data_pag);

            if ($causale_pag == 2 || $causale_pag == 5) {
                $towrite= $towrite."\n"."DATADOC=".timestamp_to_ggmmaaaa($data_pag); //se tesseramento o iscrizione metto la data di pagamento anche come DATADOC
            } else {
                if ($anno_ret != "") {
                    $towrite= $towrite."\n"."DATADOC="."02/".$mese_ret_pad."/".$anno_ret;
                } else {
                    $towrite= $towrite."\n"."DATADOC=";
                }
            }

            if ($causale_pag == 3) {
                $towrite= $towrite."\n"."TIPOREG=";
            } else {
                $towrite= $towrite."\n"."TIPOREG=1";
            }

            if ($causale_pag == 3) {
                $towrite= $towrite."\n"."NUMRATA=";
            } else {
                $towrite= $towrite."\n"."NUMRATA=1";
            }

            if ($causale_pag == 3) {
                $towrite= $towrite."\n"."NUMREG=";
            } else {
                $towrite= $towrite."\n"."NUMREG=".$numreg;
            }


            $towrite= $towrite."\n"."NUMDOC=".$ID_ret; //ID_ret = null nel caso di donazione o altro diverso da una retta

            $towrite= $towrite."\n";
            $towrite= $towrite."\n"."[MOV_RIGA]";

            if ($causale_pag == 3) {
                $towrite= $towrite."\n"."TIPOCONTO=G";
            } else {
                $towrite= $towrite."\n"."TIPOCONTO=C";
            }

            if ($causale_pag == 3) {
                $towrite= $towrite."\n"."CONTO=410025";
            } else {
                $towrite= $towrite."\n"."CONTO=0";
            }

            if ($causale_pag == 3) {
                $towrite= $towrite."\n"."CODFISC=";
            } else {
                $towrite= $towrite."\n"."CODFISC= ".$cf_alu;
            }
            
            $towrite= $towrite."\n"."PIVA=";
            $towrite= $towrite."\n"."IMPORTO=".number_format($importo_pag,2,",","");
            $towrite= $towrite."\n"."SEGNO=A";
            if ($causale_pag == 3) {
                $towrite= $towrite."\n"."DESAGG=".strtoupper($cognome_alu)." ".strtoupper($nome_alu);
            }

            $towrite= $towrite."\n";
            $towrite= $towrite."\n"."[MOV_RIGA]";
            $towrite= $towrite."\n"."TIPOCONTO=G";
            $towrite= $towrite."\n"."CONTO=".$CodiciDareIncassiA[$tipo_pag];
            $towrite= $towrite."\n"."IMPORTO=".number_format($importo_pag,2,",","");
            $towrite= $towrite."\n"."SEGNO=D\n";

            if ($tipo_pag == 0) {
                $erroriEsportazione = $erroriEsportazione . "# ERR su pagamento del: " . $data_pag . " di ".$nome_alu." ".$cognome_alu." - " . "tipo pagamento non indicato\n";
            }
            if ($data_pag == "") {
                $erroriEsportazione = $erroriEsportazione . "# ERR su pagamento del: " . $data_pag . " di ".$nome_alu." ".$cognome_alu." - " . "data pagamento mancante\n";
            }

            if ($cf_alu == "") {
                $erroriEsportazione = $erroriEsportazione ."# ERR su pagamento del: " . $data_pag . " di ".$nome_alu." ".$cognome_alu." - " . "CF mancante\n";
            }

            if ($importo_pag == "") {
                $erroriEsportazione = $erroriEsportazione . "# ERR su pagamento del: " . $data_pag . " di ".$nome_alu." ".$cognome_alu." - " . "importo mancante\n";
            }

            
            fwrite($handle, $towrite);

        }
    } else {


        if ($ID_alu != 'Tutti') {$whereID_alu = " AND ID_alu = ".$ID_alu." ";}


        // ******************************** CASO QUOTE CONCORDATE ******************************
        
        $whereDate = " AND (CONCAT(anno_ret, '-', LPAD(mese_ret, 2, '0'), '-01') >='".$dateFrom."') AND (CONCAT (anno_ret, '-', LPAD(mese_ret, 2, '0'), '-01') <= '".$dateTo."')";

        $sql = "SELECT ID_ret, nome_alu, cognome_alu, concordato_ret, LPAD(mese_ret, 2, '0'), anno_ret, indirizzo_alu, cap_alu, citta_alu, prov_alu, cf_alu, aselme_cla
        FROM tab_mensilirette
        LEFT JOIN tab_anagraficaalunni ON ID_alu =  ID_alu_ret
        LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_cla = annoscolastico_ret
        WHERE concordato_ret <> 0 ". $whereDate. $whereID_alu;

        //ATTENZIONE!!! la quota concordata potrebbe essere 

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ID_ret, $nome_alu, $cognome_alu, $concordato_ret, $mese_ret_pad, $anno_ret, $indirizzo_alu, $cap_alu, $citta_alu, $prov_alu, $cf_alu, $aselme_cla );
        

        //Per DEBUG fwrite($handle, "sql: ".$sql);
        $n = 0;
        while (mysqli_stmt_fetch($stmt)) { 

            $concordato_ret = number_format($concordato_ret,2,",","");
            $n++;
            $towrite= "\n#******** TESTATA N. ".$n." ID_ret: ".$ID_ret."************************";
            
            $towrite= $towrite."\n[TESTA]";
            $towrite= $towrite."\n"."CF_RAGSOC1=".strtoupper($cognome_alu);
            $towrite= $towrite."\n"."CF_RAGSOC2=".strtoupper($nome_alu);
            $towrite= $towrite."\n"."CF_INDIRIZZO=".strtoupper($indirizzo_alu);
            $towrite= $towrite."\n"."CF_CAP=".$cap_alu;
            $towrite= $towrite."\n"."CF_COMUNE=".$citta_alu;
            $towrite= $towrite."\n"."CF_PROVINCIA=".$prov_alu;
            $towrite= $towrite."\n"."CF_CODFISC=".$cf_alu;
            $towrite= $towrite."\n"."CF_PIVA=";
            $towrite= $towrite."\n"."CF_CODPAG=BO001";
            $towrite= $towrite."\n"."CF_CODGEVE=";
            $towrite= $towrite."\n"."CF_NATGIU=";
            $towrite= $towrite."\n"."CF_INTEST=";
            $towrite= $towrite."\n"."BANCA_ABI=";
            $towrite= $towrite."\n"."BANCA_CAB=";
            $towrite= $towrite."\n"."DITTA=0001";
            $towrite= $towrite."\n"."ATTIVITA=1";
            $towrite= $towrite."\n"."TIPOREG=1";
            $towrite= $towrite."\n"."NUMREG=1";
            $towrite= $towrite."\n"."CAUSALE=1016"; //sempre e solo le rette a preventivo
            $towrite= $towrite."\n"."NUMDOC=".$ID_ret;
            $towrite= $towrite."\n"."DATADOC="."02/".$mese_ret_pad."/".$anno_ret;
            $towrite= $towrite."\n"."DIVISA=EURO";
            $towrite= $towrite."\n"."CAMBIO=";
            $towrite= $towrite."\n"."TOTDOC=".$concordato_ret;
            $towrite= $towrite."\n"."ACCONTO=";
            $towrite= $towrite."\n"."ABBUONO=";
            $towrite= $towrite."\n"."AGENTE=";
            $towrite= $towrite."\n";
            $towrite= $towrite."\n"."[IVA]";
            $towrite= $towrite."\n"."CODIVA=FCI";
            $towrite= $towrite."\n"."IMPONIBILE=".$concordato_ret;
            $towrite= $towrite."\n"."IVA=0,00";
            $towrite= $towrite."\n";
            $towrite= $towrite."\n"."[COGE]";
            $towrite= $towrite."\n"."CONTO=0";
            $towrite= $towrite."\n"."IMPORTO=".$concordato_ret;
            $towrite= $towrite."\n"."TIPORIGA=1";
            $towrite= $towrite."\n"."SEGNO=D";
            $towrite= $towrite."\n";
            $towrite= $towrite."\n"."[COGE]";
            $towrite= $towrite."\n"."CONTO=".$CodiciAvereConcordatoA[$aselme_cla];
            $towrite= $towrite."\n"."IMPORTO=".$concordato_ret;
            $towrite= $towrite."\n"."TIPORIGA=4";
            $towrite= $towrite."\n"."SEGNO=A";
            $towrite= $towrite."\n";
            $towrite= $towrite."\n"."[COGE]";
            $towrite= $towrite."\n"."CONTO=247001";;
            $towrite= $towrite."\n"."IMPORTO=0,00";
            $towrite= $towrite."\n"."TIPORIGA=5";
            $towrite= $towrite."\n"."SEGNO=A";
            $towrite= $towrite."\n";
            $towrite= $towrite."\n"."[SCAD]";
            $towrite= $towrite."\n"."TIPORATA=BON";;
            $towrite= $towrite."\n"."DATASCAD="."02/".$mese_ret_pad."/".$anno_ret;
            $towrite= $towrite."\n"."IMPORTO=".$concordato_ret;
            $towrite= $towrite."\n";

            fwrite($handle, $towrite);
            $n++;
        }
    }



    fclose($handle);

    //header('Content-Type: text/plain');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$file_name.'"');
    // header('Expires: Mon, 24 May 2021 11:00:00 GMT');                    //Una data passata qualunque
    // header('Cache-Control: must-revalidate');                            //The cache must verify the status of the stale resources before using it and expired ones should not be used.
    // header('Pragma: public');                                            //It is used for backwards compatibility with HTTP/1.0 caches where the Cache-Control HTTP/1.1 header is not yet present.
    // header('Content-Length: ' . filesize($file_name));                   //Content-Length is needed to detect premature message truncation when servers crash and to properly segment messages that share a persistent connection.
    //ob_clean();                                                           //Clean (erase) the output buffer
    //flush();                                                              //Flush system output buffer
    //header("Connection: close");                                          //When the client uses the Connection: close header in the request message, this means that it wants the server to close the connection after sending the response message.            
            
    
    //Nel caso siano stati rilevati degli errori si possono scrivere a inizio file così, in modo che anche l'import di ELMAS si blocchi        
            $arr = file($file_name);
            $arr[0] = $erroriEsportazione;
            if ($erroriEsportazione != "") {file_put_contents($file_name, implode($arr));}
    
    readfile($file_name);

?>
