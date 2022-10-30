<?
		$pdf->AddPage();
    
        $pdf->SetFont('TitilliumWeb-SemiBold','',16);
        $pdf->Cell(0,8,"RICHIESTA SERVIZIO MENSA a.s. ".$annoscolastico, 0,1, 'C');
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


        $testo = "CHIEDONO PER ".$LUILEI[$mf_alu]." DI USUFRUIRE DEL SERVIZIO MENSA PER I SEGUENTI GIORNI";
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'C');
        
        $pdf->Ln(5);
        $pdf->SetFont($fontdefault,'',$fontsizedefault);

        $testo = $pdf->Image($imgsquare,$pdf->GetX()+40, $pdf->GetY()+2,5)."      LUNEDI";
        $pdf->Cell(40,$h1,"",0,0,'L');
        $pdf->Cell(50,$h1,$testo,0,0,'L');
        $testo = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+2,5)."      OCCASIONALMENTE";
        $pdf->Cell(50,$h1,$testo,0,1,'L');
        $testo = $pdf->Image($imgsquare,$pdf->GetX()+40, $pdf->GetY()+2,5)."      MARTEDI";
        $pdf->Cell(40,$h1,"",0,0,'L');
        $pdf->Cell(50,$h1,$testo,0,1,'L');
        $testo = $pdf->Image($imgsquare,$pdf->GetX()+40, $pdf->GetY()+2,5)."      MERCOLEDI";
        $pdf->Cell(40,$h1,"",0,0,'L');
        $pdf->Cell(50,$h1,$testo,0,1,'L');
        $testo = $pdf->Image($imgsquare,$pdf->GetX()+40, $pdf->GetY()+2,5)."      GIOVEDI";
        $pdf->Cell(40,$h1,"",0,0,'L');
        $pdf->Cell(50,$h1,$testo,0,1,'L');
        $testo = $pdf->Image($imgsquare,$pdf->GetX()+40, $pdf->GetY()+2,5)."      VENERDI";
        $pdf->Cell(40,$h1,"",0,0,'L');
        $pdf->Cell(50,$h1,$testo,0,1,'L');

        $pdf->Ln(2);

        $pdf->Ln(5);
        $testo = "REGOLAMENTO:";
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');
        $testo = "- l'iscrizione al servizio va effettuata compilando il presente modulo;";
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');
        $testo = "- eventuali iscrizioni in corso d'anno, modifiche o ritiri vanno comunicati in Segreteria;";
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');
        $testo = "- il pagamento del servizio avverrà, da parte del genitore, mediante l’acquisto in segreteria di blocchetti da:";
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');
        $testo = "10 buoni pasto (costo euro 60,00);";
		$pdf->Cell(190,$h1,utf8_decode($testo),0,1,'L');


        $pdf->Ln(45);
        include("firmepadremadreluogo.php");

?>