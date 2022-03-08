<?
$pdf->AddPage();
    
$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->SetFillColor(255,255,0);
$pdf->Cell(0,7,utf8_decode("DA STAMPARE E CONSEGNARE SOLO QUALORA L'ADESIONE NON SIA STATA EFFETTUATA IN PRECEDENZA"), 1,1, 'C', True);
$pdf->SetFillColor(220,220,220);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,utf8_decode("RICHIESTA DI ADESIONE A SOCIO"), 0,1, 'C');

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
$pdf->Cell(95,7,strtoupper($comunenascita_socio." (".$provnascita_socio.") - ".$paesenascita_socio),"B",0,'C');
$pdf->Cell(10,7," il ",0,0,'C');
$pdf->Cell(40,7,strtoupper($datanascita_socio),"B",1,'C');
$pdf->Cell(35,7,"residente a ",0,0,'L');
$pdf->Cell(95,7,strtoupper($comune_socio." (".$prov_socio.") - ".$paese_socio),"B",0,'C');
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

$pdf->Cell(35,7,"Professione/attivita' ",0,0,'L');
$pdf->Cell(145,7,$professione,"B",1,'C');
$pdf->Cell(35,7,"ruolo ",0,0,'L');
$pdf->Cell(145,7,"","B",1,'C');
$pdf->Cell(35,7,"settore",0,0,'L');
$pdf->Cell(145,7,"","B",1,'C');
$pdf->Cell(35,7,"altre competenze",0,0,'L');
$pdf->Cell(145,7,"","B",1,'C');


//CON LA PRESENTE....
$pdf->Ln(5);
$pdf->Cell(0,5,utf8_decode("Con la presente chiede di poter essere ammesso in qualità di"),0,1,'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',11);
$pdf->Cell(0,5,"socio dell'Associazione Pedagogica Steineriana Aurora",0,1,'C');
$pdf->SetFont($fontdefault,'',11);
$pdf->Cell(0,5,"e dichiara di accettare quanto previsto dallo Statuto e dal Regolamento della Associazione",0,1,'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',11);
$pdf->Cell(0,5,utf8_decode("versa altresì la quota di iscrizione di euro 10,00 (dieci/00)"),0,1,'C');
$pdf->Ln(6);

$testo = "N.B. La risposta alla richiesta del tipo di lavoro svolto e dell'hobby e all'eventuale disponibilità di un furgone è sentitamente caldeggiata. Tale informazione serve all'Associazione Genitori perché è all'interno del nostro gruppo che troviamo, da sempre, chi aiuta nelle varie attività che la gestione della nostra Scuola richiede. Siamo noi Genitori che facciamo i lavori di manutenzione dei locali nei quali i nostri figli passano così tante ore e dei mobili che utilizzano quotidianamente, siamo noi Genitori che ci occupiamo di fare in modo che la nostra Scuola sia in ordine ed accogliente e siamo sempre noi Genitori che uniamo le forze per realizzare le gioiose feste che scandiscono l'anno e che aiutano a contenere i costi individuali. In quest'ottica ci servirebbe sapere quali attività ognuno è capace di svolgere anche fuori della propria professione così da sapere ogni volta chi poter interpellare compatibilmente con la disponibilità di ognuno.";
$pdf->SetFont($fontdefault,'',9);
$pdf->MultiCell(190,4.5,utf8_decode($testo),1,'J',0,5);

$pdf->Ln(10);

//FIRME
$pdf->SetFont($fontdefault,'',10);
$pdf->Ln(10);
$pdf->Cell(90,5,"IL RICHIEDENTE",0,0,'L');
$pdf->Cell(100,5,"","B",1);
$pdf->Image('../assets/img/Icone/frecciafirmablack.png', 100, $pdf->GetY()-18, 20);


$pdf->SetFont($fontdefault,'',10);
$pdf->Ln(10);
$pdf->Cell(60,5,"Delibera del Cda di Ammissione del",0,0,'L');
$pdf->Cell(30,5,"","B",0);
$pdf->Cell(50,5,"",0,0);
$pdf->Cell(20,5,"n. libro soci",0,0,'L');
$pdf->Cell(30,5,"","B",1);


?>