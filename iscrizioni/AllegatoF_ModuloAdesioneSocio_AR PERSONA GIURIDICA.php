<?
$pdf->AddPage();

    $pdf->SetFont('TitilliumWeb-SemiBold','',10);
    $pdf->SetFillColor(255,255,0);
    // $pdf->Cell(0,7,utf8_decode("DA STAMPARE E CONSEGNARE SOLO QUALORA L'ADESIONE NON SIA STATA EFFETTUATA IN PRECEDENZA"), 1,1, 'C', True);
    // $pdf->SetFillColor(220,220,220);
    $pdf->SetFont('TitilliumWeb-SemiBold','',16);
    $pdf->Cell(0,10,utf8_decode("RICHIESTA DI ADESIONE A SOCIO"), 0,1, 'C');

    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell(110,7,"",0,0);
    $pdf->Cell(25,7,"Data e Luogo ",0,0,'L');
    $pdf->Cell(45,7,"","B",1);

    //INTESTAZIONE
    $pdf->Ln(2);
    $pdf->Cell(110,5,"",0,0);
    $pdf->Cell(70,5,utf8_decode("Al Cda della"),0,1,'L');
    $pdf->Cell(110,5,"",0,0);
    $pdf->Cell(70,5,utf8_decode($intestazione1),0,1,'L');
    $pdf->Cell(110,5,"",0,0);
    $pdf->Cell(70,5,utf8_decode($intestazione2),0,1,'L');
    $pdf->Cell(110,5,"",0,0);
    $pdf->Cell(70,5,utf8_decode($indirizzoscuola),0,1,'L');

    //DATI SOCIO
    $pdf->SetFont($fontdefault,'',11);
    $pdf->Ln(2);
    $pdf->Cell(35,7,"Rag. Sociale ",0,0,'L');
    $pdf->Cell(145,7,"","B",1,'C');
    $pdf->Cell(35,7,"Sede Legale in",0,0,'L');
    $pdf->Cell(95,7,"","B",0,'C');
    $pdf->Cell(10,7," CAP ",0,0,'C');
    $pdf->Cell(40,7,"","B",1,'C');
    $pdf->Cell(35,7,"via ",0,0,'L');
    $pdf->Cell(145,7,"","B",1,'C');
    $pdf->Cell(35,7,"CF /. P IVA ",0,0,'L');
    $pdf->Cell(145,7,"","B",1,'C');
    $pdf->Cell(35,7,"Tel ",0,0,'L');
    $pdf->Cell(40,7,"","B",0,'C');
    $pdf->Cell(20,7,"e-mail ",0,0,'C');
    $pdf->Cell(85,7,"","B",1,'C');


    $pdf->Cell(35,7,"Rappr. Legale ",0,0,'L');
    $pdf->Cell(145,7,"","B",1,'C');
    $pdf->Cell(35,7,"nato/a a ",0,0,'L');
    $pdf->Cell(95,7,"","B",0,'C');
    $pdf->Cell(10,7," il ",0,0,'C');
    $pdf->Cell(40,7,"","B",1,'C');
    $pdf->Cell(35,7,"COD FISCALE ",0,0,'L');
    $pdf->Cell(145,7,strtoupper($cf_socio),"B",1,'C');


    $pdf->SetFont('TitilliumWeb-SemiBold','',12);

    //CON LA PRESENTE....
    $pdf->Ln(2);
    $pdf->Cell(0,10,utf8_decode("Con la presente chiede di poter essere ammesso in qualità di:"), 0,1, 'C');
    $pdf->SetFont($fontdefault,'',11);
    //$pdf->Cell(10,7,"",0,0);
    if ($blank) {
        $pdf->Cell(47.5,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Fruitore",1,0,"L");
    } else {
        $pdf->Cell(47.5,7,$pdf->Image($imgsquarecrossedmini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Fruitore",1,0,"L");
    }
    $pdf->Cell(47.5,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Lavoratore",1,0,"L");
    $pdf->Cell(47.5,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Volontario",1,0,"L");
    $pdf->Cell(47.5,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Sovventore",1,1,"L");
    $pdf->Ln(2);

    $testo= "alla ".$ragionesocialescuola.", sottoscrivendo n. __ quote di capitale sociale
    per un importo di euro _________ da versare così come espressamente previsto dallo Statuto Sociale.";
    $pdf->MultiCell(0,5,utf8_decode($testo), 0, "C");


    //DICHIARA
    $pdf->SetXY (10,165);
    $pdf->SetFont('TitilliumWeb-SemiBold','',12);
    $pdf->Cell(0,10,utf8_decode("DICHIARA:"), 0,1, 'C');
    $pdf->SetFont($fontdefault,'',10);

    $testo=
    "    - di non svolgere alcuna attività in contrasto con gli scopi sociali della Cooperativa
    - di essere a conoscenza ed approvare lo Statuto della Cooperativa, consultabile presso la segreteria
    - di accettare le deliberazioni legalmente adottate dagli organismi sociali
    - di accettare le clausole arbitrali come previsto dallo Statuto
    - di aver preso visione delle informazioni di seguito riportate, relative all' 'INFORMATIVA AI SENSI E PER GLI EFFETTI DI CUI
    ALL'ARTICOLO 13, D. LGS. 30 GIUGNO 2003 N. 196' ed esprime altresì il proprio consenso al trattamento e alla
    comunicazione dei propri dati personali.";
    $pdf->MultiCell(0,5,utf8_decode($testo), 0, "L");

    //FIRME
    $pdf->Ln(10);
    $pdf->Cell(90,5,"IL RICHIEDENTE",0,0,'L');
    $pdf->Cell(100,5,"","B",1);
    $pdf->Image('../assets/img/Icone/frecciafirmablack.png', 100, $pdf->GetY()-18, 20);

    $pdf->Ln(3);
    $pdf->Cell(100,5,"Allegati:",0,1,'L');
    $pdf->Cell(100,5,utf8_decode("1. Fotocopia del documento di identità valido del Rappr. Legale"),0,1,'L');
    $pdf->Cell(100,5,utf8_decode("2. Fotocopia del codice fiscale del Rappr. legale"),0,0,'L');

    $pdf->Ln(10);
    $pdf->Cell(90,5,utf8_decode("Per la ".$ragionesocialescuola),0,1,'L');
    $pdf->Cell(90,5,"Firma rappresentante del CDA",0,0,'L');
    $pdf->Cell(100,5,"","B",1);


    $pdf->SetFillColor(220,220,220);

    $pdf->Ln(3);
    $pdf->SetFont($fontdefault,'',8);
    $pdf->Cell(70,7,"Spazio riservato alla segreteria","LT",0,"L");
    $pdf->Cell(60,7,"Data Pagamento","T",0,"C");
    $pdf->Cell(60,7,"Per la Segreteria","TR",1,"C");

    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell(70,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Quota pagata","LB",0,"L");
    $pdf->Cell(60,7,"________________________","B",0,"C");
    $pdf->Cell(60,7,"________________________","BR",1,"C");

    ?>