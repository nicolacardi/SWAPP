<?
$pdf->AddPage();
    
    $pdf->SetFont('TitilliumWeb-SemiBold','',10);
    $pdf->SetFillColor(255,255,0);
    $pdf->Cell(0,7,utf8_decode("DA STAMPARE E CONSEGNARE SOLO QUALORA L'ADESIONE NON SIA STATA EFFETTUATA IN PRECEDENZA"), 1,1, 'C', True);
    $pdf->SetFillColor(220,220,220);
    $pdf->SetFont('TitilliumWeb-SemiBold','',16);

    if ($volontario == 1) {
        $testo = "RICHIESTA DI ADESIONE A SOCIO VOLONTARIO";
    } else {
        $testo = "RICHIESTA DI ADESIONE A SOCIO ORDINARIO";
    }
    $pdf->Cell(0,10,utf8_decode($testo), 0,1, 'C');

    $pdf->SetFont($fontdefault,'',10);
    $pdf->Cell(110,7,"",0,0);
    $pdf->Cell(25,7,"Data e Luogo ",0,0,'L');
    $pdf->Cell(45,7,"","B",1);

    //INTESTAZIONE
    $pdf->Ln(7);
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
    $pdf->Ln(5);
    $pdf->Cell(35,7,"Il/la sottoscritto/a ",0,0,'L');
    $pdf->Cell(95,7,strtoupper($nome_socio)." ".strtoupper($cognome_socio),"B",1,'C');
    $pdf->Cell(35,7,"nato/a a ",0,0,'L');
    $pdf->Cell(95,7,strtoupper($comunenascita_socio." ".$provnascita_socio." ".$paesenascita_socio),"B",0,'C');
    $pdf->Cell(10,7," il ",0,0,'C');
    $pdf->Cell(40,7,strtoupper($datanascita_socio),"B",1,'C');
    $pdf->Cell(35,7,"residente a ",0,0,'L');
    $pdf->Cell(95,7,strtoupper($comune_socio." ".$prov_socio." ".$paese_socio),"B",0,'C');
    $pdf->Cell(10,7," CAP ",0,0,'C');
    $pdf->Cell(40,7,strtoupper($CAP_socio),"B",1,'C');
    $pdf->Cell(35,7,"in via ",0,0,'L');
    $pdf->Cell(145,7,$indirizzo_socio,"B",1,'C');
    $pdf->Cell(35,7,"COD FISCALE ",0,0,'L');
    $pdf->Cell(145,7,strtoupper($cf_socio),"B",1,'C');
    $pdf->Cell(35,7,"Tel ",0,0,'L');
    $pdf->Cell(40,7,strtoupper($telefono_socio),"B",0,'C');
    $pdf->Cell(20,7,"e-mail ",0,0,'C');
    $pdf->Cell(85,7,$email_socio,"B",1,'C');
    $pdf->SetFont('TitilliumWeb-SemiBold','',12);

    //CON LA PRESENTE....
    $pdf->Ln(5);
    $pdf->Cell(0,10,utf8_decode("Con la presente chiede di poter essere ammesso in qualità di:"), 0,1, 'C');
    $pdf->SetFont($fontdefault,'',11);
    //$pdf->Cell(10,7,"",0,0);
    $pdf->Cell(25,7,"",0,0,"L");

    if ($volontario == 1) {
        $pdf->Cell(47.5,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Ordinario",1,0,"L");
        $pdf->Cell(47.5,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Attivo",1,0,"L");
        $pdf->Cell(47.5,7,$pdf->Image($imgsquarecrossedmini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Volontario",1,0,"L");
    } else {
        $pdf->Cell(47.5,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Ordinario",1,0,"L");
        $pdf->Cell(47.5,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Attivo",1,0,"L");
        $pdf->Cell(47.5,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Volontario",1,0,"L");
    }
    $pdf->Cell(47.5,7,"",0,1,"L");
    $pdf->Ln(5);
    if ($volontario == 1) {
        $testo= "Inoltre chiede di essere iscritto al registro dei volontari";
        $pdf->MultiCell(0,5,utf8_decode($testo), 0, "C");
    }
    //DICHIARA
    $pdf->SetXY (10,165);
    $pdf->SetFont('TitilliumWeb-SemiBold','',12);
    $pdf->Cell(0,10,utf8_decode("DICHIARA:"), 0,1, 'C');
    $pdf->SetFont($fontdefault,'',10);

    $testo="di accettare i contenuti dello Statuto, di condividere gli scopi sociali e contribuire alla loro realizzazione.";
    $pdf->MultiCell(0,5,utf8_decode($testo), 0, "C");

    if ($volontario != 1) {
        $testo="Si impegna altresì a versare alla scadenza fissata la quota di rinnovo stabilita annualmente dal Consiglio Direttivo.";
        $pdf->MultiCell(0,5,utf8_decode($testo), 0, "C");
    }

    //FIRME
    $pdf->Ln(10);
    $pdf->Cell(90,5,"IL RICHIEDENTE",0,0,'L');
    $pdf->Cell(100,5,"","B",1);
    $pdf->Image('../assets/img/Icone/frecciafirmablack.png', 100, $pdf->GetY()-18, 20);

    $pdf->Ln(7);
    $pdf->Cell(100,5,"Allegati:",0,1,'L');
    $pdf->Cell(100,5,utf8_decode("1. Fotocopia del documento di identità valido"),0,1,'L');
    $pdf->Cell(100,5,utf8_decode("2. Fotocopia del codice fiscale"),0,0,'L');

    $pdf->Ln(15);
    $pdf->Cell(90,5,utf8_decode("Per la ".$ragionesocialescuola),0,1,'L');
    $pdf->Cell(90,5,"Firma rappresentante del CDA",0,0,'L');
    $pdf->Cell(100,5,"","B",1);

    //tabellina in calce
    $pdf->Ln(5);
    $pdf->Cell(0,5,utf8_decode("Riservato alla Segreteria"), 1,1, 'C', True);

    $pdf->Cell(45,5,"data di arrivo",1,0,"L");
    $pdf->Cell(25,5,"",1,0,"L");
    $pdf->Cell(25,5,"Prot. n.",1,0,"L");
    $pdf->Cell(25,5,"",1,0,"L");
    $pdf->Cell(25,5,"/A.3. a.",1,0,"L");
    $pdf->Cell(45,5,"firma","R",1,"L");

    $pdf->Cell(45,5,"","L",0,"L");
    $pdf->Cell(25,5,"cassa ric. n.",1,0,"L");
    $pdf->Cell(25,5,"",1,0,"L");
    $pdf->Cell(25,5,"data",1,0,"L");
    $pdf->Cell(25,5,"",1,0,"L");
    $pdf->Cell(45,5,"","R",1,"L");

    $pdf->Cell(45,5,"pagamento","L",0,"L");
    $pdf->Cell(25,5,"POS",1,0,"L");
    $pdf->Cell(25,5,"-",1,0,"L");
    $pdf->Cell(25,5,"data",1,0,"L");
    $pdf->Cell(25,5,"",1,0,"L");
    $pdf->Cell(45,5,"","R",1,"L");

    $pdf->Cell(45,5,"","LB",0,"L");
    $pdf->Cell(25,5,"bonifico",1,0,"L");
    $pdf->Cell(25,5,"-",1,0,"L");
    $pdf->Cell(25,5,"data",1,0,"L");
    $pdf->Cell(25,5,"",1,0,"L");
    $pdf->Cell(45,5,"","BR",1,"L");


?>