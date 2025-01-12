<?
		$pdf->AddPage();
    
        $pdf->SetFont('TitilliumWeb-SemiBold','',16);
        $pdf->Cell(0,8,"AUTORIZZAZIONE USCITA DALLA SCUOLA a.s. ".$annoscolastico, 0,1, 'C');
        $pdf->SetFont($fontdefault,'',14);


        $fontsizedefault = 11;
        $pdf->SetFont($fontdefault,'',$fontsizedefault);


        // Stylesheet
        // $pdf->SetStyle("TAG","FONTTYPE","N/B/I/U o combinazioni","fontsize 10/12/28", "color 0,0,255", "indent", "bullet");
        $pdf->SetStyleWriteTag("h1",    "TitilliumWeb-SemiBold",    "N",    $fontsizedefault,   0, 0);
        $pdf->SetStyleWriteTag("n",     $fontdefault,               "N",    $fontsizedefault,   0, 0);
        $pdf->SetStyleWriteTag("bu",     "TitilliumWeb-SemiBold",   "U",    $fontsizedefault,   0);
        $pdf->SetStyleWriteTag("b",     "TitilliumWeb-SemiBold",    "N",    $fontsizedefault,   0);
        $pdf->SetStyleWriteTag("a",     $fontdefault,               "BU",   $fontsizedefault,   "0,0,255");
        $pdf->SetStyleWriteTag("bul",   $fontdefault,               "N",    $fontsizedefault,   0, 3, chr(149));

        $pdf->Ln(3);


		$pdf->Ln(8);
		$testo="I sottoscritti ".strtoupper($nomepadre_fam). " ".strtoupper($cognomepadre_fam)." e ".strtoupper($nomemadre_fam). " ".strtoupper($cognomemadre_fam). " genitori/esercenti la responsabilita' genitoriale di:";

		if ($blank) {
			$testo="I sottoscritti __________________________ e  __________________________, genitori/esercenti la responsabilita' genitoriale di:";  //utilizzo di $nomi
		}

		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
        $h = 6;

        // $testo="Il/La sottoscritto/a";
        // $pdf->Cell(35,$h,$testo,0,0,'L');
        // $pdf->Cell(150,$h,"","B",1,'L');

        $h1 = 8;

        $pdf->Ln(3);


        // $testo = "in qualità di                     padre     ".$pdf->Image($imgsquare,$pdf->GetX()+50, $pdf->GetY()+2,5)."                   madre".$pdf->Image($imgsquare,$pdf->GetX()+81, $pdf->GetY()+2,5)."                         tutore".$pdf->Image($imgsquare,$pdf->GetX()+112, $pdf->GetY()+2,5)."                 affidatario                   di".$pdf->Image($imgsquare,$pdf->GetX()+143, $pdf->GetY()+2,5);
		// $pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');

        $pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
        if (!$blank) {
            $testo = strtoupper($nome_alu)." ".strtoupper($cognome_alu)." iscritto al".$classi[$classe_cla];
        }
        else {
            $testo = ".......................................... iscritto alla classe ...........";
        }
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');
        $pdf->SetFont($fontdefault,'',14);

        $testo = "DICHIARANO";
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'C');
        
        $pdf->SetFont($fontdefault,'',$fontsizedefault);

        if ($mf_alu == "M"){$figliofiglia = " il proprio figlio "; $desinenza= "o";} else {$figliofiglia = " la propria figlia ";$desinenza="a";}

        $testo = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+2,5)."      che". $figliofiglia."sarà ritirat".$desinenza. " al termine delle lezioni da uno dei due genitori" ;
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');

        $testo = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+2,5)."      di delegare i genitori della Scuola a ritirare". $figliofiglia."al termine delle lezioni" ;
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');

        $testo = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+2,5)."      di delegare le seguenti persone maggiorenni a ritirare".$figliofiglia."al termine delle lezioni" ;
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');

        $testo = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+2,5)."      che".$figliofiglia."uscirà autonomamente dai locali della Scuola esonerando il personale scolastico dalla" ;
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');

        $testo = "      responsabilità connessa all'adempimento dell'obbligo di vigilanza" ;
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');

        $testo = "      (L. 172/2017 e Nota Miur n° 2379 del 12/12/2017)." ;
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');

        $pdf->Ln(2);

        $testo="1.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(115,$h,"","B",0,'L');
        $testo="Tel.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(55,$h,"","B",1,'L');

        $pdf->Ln(2);
        $testo="2.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(115,$h,"","B",0,'L');
        $testo="Tel.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(55,$h,"","B",1,'L');

        $pdf->Ln(2);
        $testo="3.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(115,$h,"","B",0,'L');
        $testo="Tel.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(55,$h,"","B",1,'L');

        $pdf->Ln(2);
        $testo="4.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(115,$h,"","B",0,'L');
        $testo="Tel.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(55,$h,"","B",1,'L');

        $pdf->Ln(2);
        $testo="5.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(115,$h,"","B",0,'L');
        $testo="Tel.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(55,$h,"","B",1,'L');

        $pdf->Ln(2);
        $testo="6.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(115,$h,"","B",0,'L');
        $testo="Tel.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(55,$h,"","B",1,'L');

        $pdf->Ln(2);
        $testo="7.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(115,$h,"","B",0,'L');
        $testo="Tel.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(55,$h,"","B",1,'L');

        $pdf->Ln(2);
        $testo="8.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(115,$h,"","B",0,'L');
        $testo="Tel.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(55,$h,"","B",1,'L');

        $pdf->Ln(2);
        $testo="9.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(115,$h,"","B",0,'L');
        $testo="Tel.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(55,$h,"","B",1,'L');

        $pdf->Ln(2);
        $testo="10.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(115,$h,"","B",0,'L');
        $testo="Tel.";
        $pdf->Cell(10,$h,$testo,0,0,'L');
        $pdf->Cell(55,$h,"","B",1,'L');

        // $pdf->Ln(2);
        // $testo="11.";
        // $pdf->Cell(10,$h,$testo,0,0,'L');
        // $pdf->Cell(115,$h,"","B",0,'L');
        // $testo="Tel.";
        // $pdf->Cell(10,$h,$testo,0,0,'L');
        // $pdf->Cell(55,$h,"","B",1,'L');

        // $pdf->Ln(2);
        // $testo="12.";
        // $pdf->Cell(10,$h,$testo,0,0,'L');
        // $pdf->Cell(115,$h,"","B",0,'L');
        // $testo="Tel.";
        // $pdf->Cell(10,$h,$testo,0,0,'L');
        // $pdf->Cell(55,$h,"","B",1,'L');

        // $pdf->Ln(2);
        // $testo="13.";
        // $pdf->Cell(10,$h,$testo,0,0,'L');
        // $pdf->Cell(115,$h,"","B",0,'L');
        // $testo="Tel.";
        // $pdf->Cell(10,$h,$testo,0,0,'L');
        // $pdf->Cell(55,$h,"","B",1,'L');

        // $pdf->Ln(2);
        // $testo="14.";
        // $pdf->Cell(10,$h,$testo,0,0,'L');
        // $pdf->Cell(115,$h,"","B",0,'L');
        // $testo="Tel.";
        // $pdf->Cell(10,$h,$testo,0,0,'L');
        // $pdf->Cell(55,$h,"","B",1,'L');

        // $pdf->Ln(2);
        // $testo="15.";
        // $pdf->Cell(10,$h,$testo,0,0,'L');
        // $pdf->Cell(115,$h,"","B",0,'L');
        // $testo="Tel.";
        // $pdf->Cell(10,$h,$testo,0,0,'L');
        // $pdf->Cell(55,$h,"","B",1,'L');

        $pdf->Ln(5);
        $testo = "Si impegnano altresì a comunicare tempestivamente eventuali modifiche alle autorizzazioni sopra indicate.";
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');

        $pdf->Ln(25);
        include("firmepadremadreluogo.php");

?>