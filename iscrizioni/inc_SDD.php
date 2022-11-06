<?
    $pdf->AddPage();
    $nPagina = intval($pdf->PageNo());
    if($nPagina % 2 == 0){
        $pdf->Ln(20); 
        $pdf->Cell(0,5,"PAGINA VUOTA", 0,1, 'C');
        $pdf->AddPage();
    }

    switch ($intestazionefatt_fam) {
        case "altro":
            $nome = "";
            $cognome = "";
            $indirizzo = "";
            $comune = "";
            $prov = "";
            $CAP = "";
            $CF = "                ";
            $iban = "                           ";
        break;
        case "padre":
            $nome = $nomepadre_fam;
            $cognome = $cognomepadre_fam;
            $indirizzo = $indirizzopadre_fam;
            $comune = $comunepadre_fam;
            $prov = $provpadre_fam;
            $CAP = $CAPpadre_fam;
            $CF = $cfpadre_fam;
            $iban = $ibanpadre_fam;

        break;
        case "madre":
            $nome = $nomemadre_fam;
            $cognome = $cognomemadre_fam;
            $indirizzo = $indirizzomadre_fam;
            $comune = $comunemadre_fam;
            $prov = $provmadre_fam;
            $CAP = $CAPmadre_fam;
            $CF = $cfmadre_fam;
            $iban = $ibanmadre_fam;

        break;
        case null:
            $nome = "";
            $cognome = "";
            $indirizzo = "";
            $comune = "";
            $prov = "";
            $CAP = "";
            $CF = "                ";
            $iban = "                           ";
            
        }

    $ibanA = str_split($iban);



    $pdf->SetFont('TitilliumWeb-SemiBold','',11);
    $pdf->MultiCell(0,5,utf8_decode("Mandato per addebito diretto SEPA - SDD Core (Area Unica dei Pagamenti in Euro) n° |__|__|__ /20__"), 0, "C");
    $pdf->Ln(2);
    $testo="Con la sottoscrizione del presente mandato, si autorizza la ".$ragionesocialescuola." a richiedere alla banca del debitore l'addebito sul suo conto e l'autorizzazione alla banca del debitore di procedere a tale addebito conformemente alle disposizioni impartite dalla ".$ragionesocialescuola." relativamente alle
    rette scolastiche della ".$nomescuola." per i seguenti alunni: ";


    $pdf->SetFont($fontdefault,'',9);
    $pdf->MultiCell(0,5,utf8_decode($testo), 1, "J");

    $pdf->Ln(2);
    $pdf->SetFont('TitilliumWeb-SemiBold','',11);

    $pdf->Cell(0,5,$nomi, 0,1, 'C');


    $pdf->Ln(2);

    $pdf->Cell(0,5,"FATTURA INTESTATA ". $testointestazione, 1,1, 'L');
    $pdf->SetFont($fontdefault,'',9);

    $hriga = 6;
    $w1 = 30;
    $w2 = 65;
    $w3 = 25;
    $w4 = 90;
    $w5 = 10;
    $w6 = 20;
    $w7 = 4.7;
    $w8 = 155;
    $w9 = 15;
    $w10 = 20;
    $wgap = 1;

    //DEBITORE
    $pdf->SetXY(10,75);
    $pdf->Cell(0,50,"", 1,1, 'L');
    $pdf->SetXY(10,75);
    $pdf->Cell(0,5,"DATI RELATIVI AL DEBITORE (intestatario del Conto Corrente di addebito)", 0,1, 'L');
    $pdf->SetXY(10,80);
    $pdf->Cell($w1,$hriga,"Cognome ",0,0,'R');
    $pdf->Cell($w2,$hriga,$cognome,1,0,'L');
    $pdf->Cell($w3,$hriga,"Nome ",0,0,'R');
    $pdf->Cell($w2,$hriga,$nome,1,1,'L');

    $pdf->Ln(2);
    $pdf->Cell($w1,$hriga,"Indirizzo e N.",0,0,'R');
    $pdf->Cell($w4,$hriga,$indirizzo,1,1,'L');


    $pdf->Ln(2);
    $pdf->Cell($w1,$hriga,"Comune ",0,0,'R');
    $pdf->Cell($w4,$hriga,$comune,1,0,'L');
    $pdf->Cell($w10,$hriga,"Prov ",0,0,'R');
    $pdf->Cell($w5,$hriga,$prov,1,0,'L');
    $pdf->Cell($w9,$hriga,"CAP ",0,0,'R');
    $pdf->Cell($w6,$hriga,$CAP,1,1,'L');

    $pdf->Ln(2);
    $pdf->Cell($w1,$hriga,"Cod. Fiscale ",0,0,'R');
    $pdf->SetFont($fontdefault,'',12);
    for ($x = 1; $x <= 16; $x++) {
        $pdf->Cell($w7,$hriga,substr($CF, $x-1, 1),1,0,'L');
        $pdf->Cell($wgap,$hriga,"",0,0,'L');
    }
    $pdf->SetFont($fontdefault,'',9);


    $pdf->Ln(12);
    $pdf->Cell($w1,$hriga,"Cod. IBAN ",0,0,'R');
    for ($x = 1; $x <= 27; $x++) {

        $pdf->Cell($w7,$hriga,$ibanA[$x-1],1,0,'C');
        $pdf->Cell($wgap,$hriga,"",0,0,'L');
    }

    // CREDITORE
    $pdf->SetXY(10,125);
    $pdf->Cell(0,30,"", 1,1, 'L');
    $pdf->SetXY(10,125);
    $pdf->Cell(0,5,"DATI RELATIVI AL CREDITORE", 0,1, 'L');
    $pdf->SetXY(10,130);

    $pdf->Cell($w1,$hriga,"Rag. Sociale ",0,0,'R');
    $pdf->Cell($w8,$hriga,utf8_decode($ragionesocialescuola),1,1,'L');

    $pdf->Ln(2);
    $pdf->Cell($w1,$hriga,"Cod. Identificativo ",0,0,'R');	
    $pdf->Cell($w8,$hriga,$codIdentificativo,1,1,'L');

    $pdf->Ln(2);
    $pdf->Cell($w1,$hriga,"Sede Legale ",0,0,'R');	
    $pdf->Cell($w8,$hriga,utf8_decode($indirizzoscuola),1,0,'L');

    //SOTTOSCRITTORE
    $pdf->SetXY(10,155);
    $pdf->Cell(0,38,"", 1,1, 'L');
    $pdf->SetXY(10,155);
    $pdf->Cell(0,5,"DATI RELATIVI AL SOTTOSCRITTORE (nel caso in cui Sottoscrittore e Debitore NON coincidano)", 0,1, 'L');
    $pdf->SetXY(10,160);
    $pdf->Cell($w1,$hriga,"Cognome ",0,0,'R');
    $pdf->Cell($w2,$hriga,"",1,0,'L');
    $pdf->Cell($w3,$hriga,"Nome ",0,0,'R');
    $pdf->Cell($w2,$hriga,"",1,1,'L');

    $pdf->Ln(2);
    $pdf->Cell($w1,$hriga,"Indirizzo e N. ",0,0,'R');
    $pdf->Cell($w4,$hriga,"",1,1,'L');

    $pdf->Ln(2);
    $pdf->Cell($w1,$hriga,"Comune ",0,0,'R');
    $pdf->Cell($w4,$hriga,"",1,0,'L');
    $pdf->Cell($w10,$hriga,"Prov ",0,0,'R');
    $pdf->Cell($w5,$hriga,"",1,0,'L');
    $pdf->Cell($w9,$hriga,"CAP ",0,0,'R');
    $pdf->Cell($w6,$hriga,"",1,1,'L');

    $pdf->Ln(2);
    $pdf->Cell($w1,$hriga,"Cod. Fiscale ",0,0,'R');
    for ($x = 1; $x <= 16; $x++) {
        $pdf->Cell($w7,$hriga,"",1,0,'L');
        $pdf->Cell($wgap,$hriga,"",0,0,'L');
    }

    //TIPO DI PAGAMENTO
    $pdf->SetXY(10,193);
    $pdf->Cell(0,13,"", 1,1, 'L');

    $pdf->SetXY(10,195);
    $pdf->Cell($w1,$hriga,"Tipo di Pagamento ",0,0,'R');
    $pdf->Cell(65,7,"ricorrente".$pdf->Image($imgsquarecrossed,$pdf->GetX()+45, $pdf->GetY()+1,5),1,0,"C");
    // $pdf->Cell(25,7,"",0,0,"C");
    // $pdf->Cell(65,7,"singolo addebito".$pdf->Image($imgsquare,$pdf->GetX()+45, $pdf->GetY()+1,5),1,0,"C");

    //INVIARE MODULO

    // $pdf->SetFont('TitilliumWeb-SemiBold','',11);
    // $pdf->SetXY(10,210);
    // $testo= "Inviare il modulo compilato e firmato a : ".$emailamministrazionescuola."consegnando poi l'originale alla segreteria della scuola ";
    // $pdf->MultiCell(0,5,utf8_decode($testo),0,'L');

        
    //FIRMA
    $pdf->Ln(40);
    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell(60,5,"Firma",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(60,5,"",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(60,5,"Data e luogo",0,1,'C');

    $pdf->Ln(4);
    $pdf->SetFont($fontdefault,'',8);
    $pdf->Cell(60,5,"","B",0,'C');
    $pdf->Cell(5,5,"","",0,'C');
    $pdf->Cell(60,5,"",0,0,'C');
    $pdf->Cell(5,5,"","",0,'C');
    $pdf->Cell(60,5,"","B",0,'C');
    $pdf->Image('../assets/img/Icone/frecciafirmablack.png', 10, $pdf->GetY()-18, 20);
?>