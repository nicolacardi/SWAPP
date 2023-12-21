<? $pdf->SetDrawColor(0,0,0);
$pdf->SetTextColor(0,0,0);

//Timbro Firme e tratteggi per firme Quarta di Copertina
$indicetimbro = rand(1,9);
$filetimbro = 'assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png';
$piusu = 100;
if (file_exists($filetimbro)) {$pdf->Image($filetimbro, 135, 250-$piusu, 20);}

$pdf->SetFont($fontdefault,'',12);
$pdf->SetXY (15,250-$piusu);
$pdf->Cell(60,10,"Firma del genitore", 0 ,0, 'C');
$pdf->SetXY (15,255-$piusu);
$pdf->SetFont($fontdefault,'',9);
$pdf->Cell(60,10,"(o di chi ne fa le veci)", 0 ,0, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->SetXY (135,250-$piusu);
$pdf->Cell(60,10,"Il Coordinatore Didattico", 0 ,1, 'C');
$indicefirma = rand(1,15);
$filefirma = 'assets/img/firmecoordinatori/firme'.$codscuola.'/CoordDidattico'.$aselme_cla.$indicefirma.'.png';
if (file_exists($filefirma)) {$pdf->Image($filefirma, 135, 255-$piusu, 60);}

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->SetXY (15,260-$piusu);
$pdf->Cell(60,10,"", "B" ,0, 'C');
$pdf->SetXY (135,260-$piusu);
$pdf->Cell(60,10,"", "B" ,0, 'C');
$pdf->SetDash(); //Restore dash
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0); ?>