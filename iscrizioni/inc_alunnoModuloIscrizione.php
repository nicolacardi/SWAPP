<?
    
    $pdf->SetFont('TitilliumWeb-SemiBold','',16);
    $pdf->Cell(0,8,"CHIEDONO L'ADESIONE AI SERVIZI EDUCATIVI PER L'A.S. ".$annoscolastico, 0,1, 'C');
    $pdf->SetFont($fontdefault,'',14);

    if ($mf_alu == "M") { $frase = "del figlio"; $desinenza = "o"; $articolo="il";}
    if ($mf_alu == "F")  {$frase ="della figlia"; $desinenza = "a"; $articolo="la";}
    if ($mf_alu != "F" && $mf_alu != "M")  {$frase ="del/la figlio/a"; $desinenza = "o/a"; $articolo="il/la";}

    $pdf->Cell(0,6,$frase, 0,1, 'C');

    $w1 = 45;
    $w2 = 145;
    $w3 = 85;
    $w4 = 30;
    $h1 = 6;
    $h2 = 4;
// DATI ANAGRAFICI ***********************************************************************************
    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell($w1,$h1,"Cognome",1,0,'L');
    $pdf->SetFont($fontdefault,'',12);
    $pdf->Cell($w2,$h1,strtoupper($cognome_alu),1,1,'L');

    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell($w1,$h1,"Nome",1,0,'L');
    $pdf->SetFont($fontdefault,'',12);
    $pdf->Cell($w2,$h1,strtoupper($nome_alu),1,1,'L');

    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell($w1,$h1,"Luogo di nascita",1,0,'L');
    $pdf->SetFont($fontdefault,'',12);
    $pdf->Cell($w2,$h1,$comunenascita_alu,1,1,'L');

    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell($w1,$h1,"Data di nascita",1,0,'L');
    $pdf->SetFont($fontdefault,'',12);
    if($datanascita_alu!='0000-00-00' && $datanascita_alu!='1900-01-01' && $datanascita_alu != NULL) {$datanascita_alu = date('d/m/Y', strtotime(str_replace('-','/', $datanascita_alu)));} else {$datanascita_alu = "";}
    $pdf->Cell($w2,$h1,$datanascita_alu,1,1,'L');

    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell($w1,$h1,"Paese di nascita",1,0,'L');
    $pdf->SetFont($fontdefault,'',12);
    $pdf->Cell($w2-$w3,$h1,$paesenascita_alu,1,0,'L');
    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell($w4,$h1,"Cittadinanza",1,0,'L');
    $pdf->SetFont($fontdefault,'',12);
    $pdf->Cell($w3-$w4,$h1,$cittadinanza_alu,1,1,'L');

    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell($w1,$h1,"Codice Fiscale",1,0,'L');
    $pdf->SetFont($fontdefault,'',12);
    $pdf->Cell($w2,$h1,$cf_alu,1,1,'L');

    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell($w1,$h1,"Residenza",'LTR',0,'L');
    $pdf->SetFont($fontdefault,'',12);
    $pdf->Cell($w2,$h1,$indirizzo_alu,1,1,'L');

    $pdf->SetFont($fontdefault,'',12);
    $pdf->Cell($w1,$h1,"",'LBR',0,'L');
    $pdf->Cell(30,$h1,$CAP_alu,1,0,'L');
    $pdf->Cell(90,$h1,$citta_alu,1,0,'L');
    $pdf->Cell(25,$h1,$prov_alu,1,1,'L');

    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell($w1,$h1,"Scuola di Provenienza",1,0,'L');
    $pdf->SetFont($fontdefault,'',12);
    $pdf->Cell($w2,$h1,$scuolaprovenienza_alu,1,1,'L');

    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell($w1,$h1,"Indirizzo Scuola",1,0,'L');
    $pdf->SetFont($fontdefault,'',12);
    $pdf->Cell($w2,$h1,$indirizzoscproven_alu,1,1,'L');

    $pdf->SetFont($fontdefault,'',10);

    if ($disabilita_alu == 1) {
        $disabilita = $pdf->Image($imgsquarecrossed,$pdf->GetX()+2, $pdf->GetY()+1,4)."        alunn".$desinenza." con disabilita'";
    } else {
        $disabilita = $pdf->Image($imgsquare,$pdf->GetX()+2, $pdf->GetY()+1,4)."        alunn".$desinenza." con disabilita'";
    }
    $pdf->Cell(95,$h1,$disabilita,1,0,'L');

    if ($DSA_alu == 1) {
        $DSA = $pdf->Image($imgsquarecrossed,$pdf->GetX()+2, $pdf->GetY()+1,4)."        alunn".$desinenza." con DSA";
    } else {
        $DSA = $pdf->Image($imgsquare,$pdf->GetX()+2, $pdf->GetY()+1,4)."        alunn".$desinenza." con DSA";
    }
    $pdf->Cell(95,$h1,$DSA,1,1,'L');



// ...ALLA CLASSE ************************************************************************************
    $pdf->SetFont('TitilliumWeb-SemiBold','',14);
    if (!$blank) {
        $pdf->Cell(0,7,"per ".$classi[$classe_cla],0,1,'C');
    }
    else {
        $pdf->Cell(0,7,"per la classe..................................................",0,1,'C');
    }

    if ($disabilita_alu == 1) {
        $pdf->SetFont($fontdefault,'',8);
        $testo="Dichiaro che mi".$desinenza." figli".$desinenza.", o ".$articolo." minore per cui esercito la  responsabilità genitoriale, e' in possesso di una certificazione ai sensi della legge n. 104 del 1992 (Legge quadro per l'assistenza, l'integrazione sociale e i diritti delle persone handicappate) che consegnero' in segreteria entro il ".$scadiscrizione.$_SESSION['anno1'].".";
        $testo = utf8_decode($testo);
        $pdf->MultiCell(0,3.5,$testo);
        $pdf->SetFont($fontdefault,'',12);
    }

    if ($DSA_alu == 1) {
        $pdf->SetFont($fontdefault,'',8);
        $testo="Dichiaro che mi".$desinenza." figli".$desinenza.", o  ".$articolo." minore per cui esercito la  responsabilità genitoriale, e' in possesso di una certificazione DSA (Disturbo Specifico dell'Apprendimento) che consegnero' in segreteria entro il ".$scadiscrizione.$_SESSION['anno1'].".";
        $testo = utf8_decode($testo);
        $pdf->MultiCell(0,3.5,$testo);
        $pdf->SetFont($fontdefault,'',12);
    }

    $pdf->Cell(0,2,"","T",1,'C');

// TRASPORTO PUBBLICO ********************************************************************************
    if ($ISC_mostra_trasportopubblico ==1) {
        //lo mostro comunque
        $pdf->SetFont('TitilliumWeb-SemiBold','',12);
        $pdf->Cell(0,5,"RICHIESTA DI TRASPORTO SCOLASTICO PUBBLICO",0,1,'C', True);
        $pdf->SetFont($fontdefault,'',8.5);
        $pdf->Ln(1);
        if ($cktrasportopubblico_alu == 1) {
            //dichiarazione nel caso uno decida di richiedere
            $testo="Il/i sottoscritto/i dichiara/no che ".$articolo." propri".$desinenza." figli".$desinenza." utilizza già il trasporto urbano e/o extraurbano. in questo caso il rinnovo è automatico.";
            $testo = utf8_decode($testo);
            $pdf->Image($imgsquare,$pdf->GetX()+2, $pdf->GetY(),4);
            $pdf->Cell(10,5,"",0,0,'L');
            $pdf->MultiCell(0,3.6,$testo);
            
            $pdf->Ln(1);
            $testo="Il/i sottoscritto/i intende/intendono richiedere per ".$articolo." propri".$desinenza." figli".$desinenza." il servizio trasporto urbano e/o extraurbano. In questo caso la scuola provvederà ad inoltrare la richiesta al Servizio Trasporti Pubblici.";
            $testo = utf8_decode($testo);
            $pdf->Image($imgsquare,$pdf->GetX()+2, $pdf->GetY()+1,4);
            $pdf->Cell(10,5,"",0,0,'L');
            $pdf->MultiCell(0,3.6,$testo);
            
            $pdf->SetFont('TitilliumWeb-SemiBold','',9);
            $pdf->Cell(0,6,"COMPILARE QUALORA PER ESIGENZE FAMILIARI SI DEBBA FARE RIFERIMENTO AD UN INDIRIZZO DIVERSO DA QUELLO SUINDICATO",0,1,'C');

            $pdf->SetLineWidth(0.05);
            $pdf->SetFont($fontdefault,'',10);
            $pdf->Cell($w1,$h2,"Comune",1,0,'L');
            $pdf->Cell($w2,$h2,"",1,1,'L');
            $pdf->Cell($w1,$h2,"Frazione",1,0,'L');
            $pdf->Cell($w2,$h2,"",1,1,'L');
            $pdf->Cell($w1,$h2,"Via e N.",1,0,'L');
            $pdf->Cell($w2,$h2,"",1,1,'L');
            $pdf->SetLineWidth(0.2);
        } else {
            //dichiarazione nel caso uno decida di non richiederlo
            $testo="Il/i sottoscritto/i dichiara/no di non essere interessato/i al servizio trasporti per ".$articolo." propri".$desinenza." figli".$desinenza.".";
            $testo = utf8_decode($testo);
            //$pdf->Image($imgsquarecrossed, $pdf->GetX()+2, $pdf->GetY(),4);
            //$pdf->Cell(10,5,"",0,0,'L');
            $pdf->MultiCell(0,3.5,$testo);
            
        }
        
    }

// MENSA *********************************************************************************************
    if ($ISC_mostra_mensa ==1 ) {
        //lo mostro solo se uno decide di non avvalersi
        $pdf->Ln(2);
        $pdf->SetFont('TitilliumWeb-SemiBold','',12);
        $pdf->Cell(0,5,"MENSA SCOLASTICA",0,1,'C', True);
        $pdf->SetFont($fontdefault,'',8);
        $pdf->Ln(1);

        $testo="Consapevole/i che il diritto allo studio si realizza anche attraverso la fruizione del servizio di mensa ".$testoarticolomensa.", i sottoscritti dichiarano, per ".$articolo." propri".$desinenza." figli".$desinenza." l'intenzione di";
        $testo = utf8_decode($testo);
        $pdf->MultiCell(0,3.6,$testo);
        
        $pdf->SetFillColor(255,255,0);
        $pdf->SetFont('TitilliumWeb-SemiBold','',10);
        if ($blank){
            $pdf->Cell(0,4,
            $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY(),5)."       AVVALERSI DEL SERVIZIO MENSA".
            $pdf->Image($imgsquare,$pdf->GetX()+94, $pdf->GetY(),5)."                                                        NON AVVALERSI DEL SERVIZIO MENSA"
            ,0,1,'L');
        } else {
            if ($ckmensa_alu == -1) {
                $pdf->Cell(60,4,"",0,0);
                $pdf->Cell(10,4,"NON",0,0,'R', True);
                $pdf->Cell(120,4," AVVALERSI DEL SERVIZIO MENSA",0,1,'L');
            } else {
                $pdf->Cell(0,4," AVVALERSI DEL SERVIZIO MENSA",0,1,'C');
            }
        }
        $pdf->SetFont($fontdefault,'',8);
	    $pdf->SetFillColor(220,220,220);
        $pdf->Ln(1);
        $testo="Tale indirizzo, espresso all'atto dell'iscrizione ha effetto per l'intero anno scolastico cui si riferisce.";
        $testo = utf8_decode($testo);
        $pdf->MultiCell(0,3.6,$testo);
        
        
        $pdf->Ln(1);
    }

// USCITA AUTONOMA ***********************************************************************************

    if ($ISC_mostra_uscitaautonoma ==1 && $ckautuscitaautonoma_alu == 1) {
        //lo mostro solo se uno decide di autorizzare...in una pagina a sè stante
        $pdf->Ln(2);
        $pdf->SetFont('TitilliumWeb-SemiBold','',12);
        $pdf->Cell(0,6,"AUTORIZZAZIONE PER L'USCITA AUTONOMA",0,1,'C', True);
        $pdf->SetFont($fontdefault,'',8);
        $pdf->Ln(1);

        $testo="In considerazione dell'età del propri".$desinenza." figli".$desinenza.", del suo grado di autonomia, dello specifico contesto del percorso scuola-casa, all".$desinenza." stess".$desinenza." noto e del fatto che ".$articolo." propri".$desinenza." figli".$desinenza." è dotato dell'adeguata maturità psico-fisica per un rientro autonomo a casa da scuola in sicurezza il/i sottoscritto/i";
        $testo = utf8_decode($testo);
        $pdf->MultiCell(0,3.6,$testo);
        
        $pdf->SetFillColor(255,255,0);
        $pdf->SetFont('TitilliumWeb-SemiBold','',10);
        $pdf->Cell(80,5,"",0,0,'C');
        $pdf->Cell(30,5,"AUTORIZZANO",0,1,'C', True);
        $pdf->SetFont($fontdefault,'',8);
	    $pdf->SetFillColor(220,220,220);

        $testo="ai sensi dell'art.19bis	L.172 del04.12.2017, la scuola a consentire l'uscita autonoma del minore da scuola al termine dell'orario delle lezioni, anche in caso di variazioni di orario (ad es. scioperi, assemblee sindacali...) e di ogni altra attività curricolare o extracurricolare prevista dal ".$POF_PTOF_PSD." della scuola, così come anche al periodo di svolgimento degli Esami di Stato conclusivi del I ciclo d'istruzione. La presente autorizzazione esonera il personale scolastico da ogni responsabilità connessa all'adempimento dell'obbligo di vigilanza ed ha efficacia per l'anno scolastico oggetto dell'iscrizione.";
        $testo = utf8_decode($testo);
        $pdf->MultiCell(0,3.7,$testo);
        
        // $pdf->SetDash(1,1); //5mm on, 5mm off;
        // $pdf->Cell(0,1,"","B",1,'C');
        // $pdf->SetDash(); //Restore dash
    }

// DOPOSCUOLA ***********************************************************************************

    if ($ISC_mostra_doposcuola ==1) {
        //lo mostro solo se uno decide di autorizzare...in una pagina a sè stante
        $pdf->Ln(2);
        $pdf->SetFont('TitilliumWeb-SemiBold','',12);
        $pdf->Cell(0,6,"RICHIESTA DOPOSCUOLA",0,1,'C', True);
        $pdf->SetFont($fontdefault,'',8);
        $pdf->Ln(1);

        $testo="Il servizio consiste in attività extra scolastiche, e non nello svolgimento dei compiti assegnati per casa, e sarà attivato al raggiungimento del numero minimo necessario per la copertura dei relativi costi. L'importo pattuito è annuale, indipendentemente dal numero di presenze dell'alunno/a, ferie scolastiche, gite, uscite didattiche, ecc...,può essere pagato in un'unica soluzione o ripartito in 9 rate da ottobre a giugno entro il giorno 5 di ogni mese.";
        $testo = utf8_decode($testo);
        $pdf->MultiCell(0,3.7,$testo);

        $testo="I sottoscritti per ".$articolo." propri".$desinenza." figli".$desinenza." :";
        $testo = utf8_decode($testo);
        $pdf->MultiCell(0,3.7,$testo);

        
        $pdf->SetFillColor(255,255,0);
        if ($ckdoposcuola_alu != 1) {
            $pdf->SetFont($fontdefault,'',10);
            $pdf->Cell(65,4,"",0,0);
            $pdf->SetFont('TitilliumWeb-SemiBold','',10);
            $pdf->Cell(10,4,"NON",0,0,'R', True);
            $pdf->Cell(115,4," RICHIEDONO IL DOPOSCUOLA",0,1,'L');

        } else {
            $pdf->SetFont($fontdefault,'',10);

            $pdf->SetFont('TitilliumWeb-SemiBold','',10);
            $pdf->Cell(0,4," RICHIEDONO IL DOPOSCUOLA",0,1,'C');

        }

        
        // $pdf->SetDash(1,1); //5mm on, 5mm off;
        // $pdf->Cell(0,1,"","B",1,'C');
        // $pdf->SetDash(); //Restore dash
    }

// RELIGIONE *****************************************************************************************

    if ($ISC_mostra_sceltareligione ==1) {

        $altReligioneA = array("1"=>"ATTIVITA' DIDATTICHE E FORMATIVE", "2"=>"ATTIVITA' DI STUDIO E/O RICERCA INDIVIDUALI CON ASSISTENZA DI PERSONALE DOCENTE", "3"=>"NON FREQUENA DELLA SCUOLA NELLE ORE DI INSEGNAMENTO DELLA RELIGIONE CATTOLICA");

        //lo mostro solo se uno decide di autorizzare...in una pagina a sè stante
        $pdf->Ln(2);
        $pdf->SetFont('TitilliumWeb-SemiBold','',12);
        $pdf->Cell(0,6,"ESERCIZIO DEL DIRITTO DI SCELTA SE AVVALERSI DELL'INSEGNAMENTO DELLA RELIGIONE CATTOLICA",0,1,'C', True);
        $pdf->SetFont($fontdefault,'',8);
        $pdf->Ln(1);

        $testo="Premesso che lo Stato assicura l'insegnamento della religione cattolica nelle scuole di ogni ordine e grado in conformità all'accordo che apporta modifiche al Concordato Lateranense (art. 9.2), il presente modulo costituisce richiesta dell'autorità scolastica in ordine all'esercizio del diritto di scegliere se avvalersi o non avvalersi dell'insegnamento della religione cattolica. Il/i sottoscritto/i dichiara/no di";
        $testo = utf8_decode($testo);
        $pdf->MultiCell(0,3.6,$testo);
        
        $pdf->SetFillColor(255,255,0);
        $pdf->SetFont('TitilliumWeb-SemiBold','',10);
        if ($ckreligione_alu != 1) {
            $pdf->Cell(40,4,"",0,0);
            $pdf->Cell(10,4,"NON",0,0,'R', True);
            $pdf->Cell(140,4," AVVALERSI DELL'INSEGNAMENTO DELLA RELIGIONE CATTOLICA",0,1,'L');
            $pdf->SetFont($fontdefault,'',8);
            $testo="al suo posto viene scelto: ".$altReligioneA[$altreligione_alu];
            $testo = utf8_decode($testo);
            $pdf->MultiCell(0,3.7,$testo);
        } else {
            $pdf->Cell(0,5,"AVVALERSI DELL'INSEGNAMENTO DELLA RELIGIONE CATTOLICA",0,1,'C', True);
        }
        $pdf->SetFillColor(220,220,220);

        // $pdf->SetDash(1,1); //5mm on, 5mm off;
        // $pdf->Cell(0,1,"","B",1,'C');
        // $pdf->SetDash(); //Restore dash
    }






// $pdf->Cell(0,10,"RELIGIONE","T",1,'C');
// $pdf->Cell(0,10,"MENSA","T",1,'C');
// $pdf->Cell(0,10,"TRASPORTO PUBBLICO","T",1,'C');
// $pdf->Cell(0,10,"USCITA AUTONOMA","T",1,'C');


?>