<? 
$w1 = 10;
$wGap =  2;
$hGap =  2;
$R =           130;
$G =           130;
$B =           130;
$pdf->SetDrawColor($R,$G,$B);
$pdf->SetTextColor($R,$G,$B);

$x1 = 0;
$y1 = 258;
$hLeg = 18;
$wOb = 30;
$wDesc = 148;
$pdf->SetFont($fontdefault,'',8);
$pdf->Rect  (10+ $x1,$y1, $w1 ,$hLeg);
$pdf->SetXY (10+ $x1 + $w1, $y1);
$pdf->RotatedText(10+ $x1 + $w1 - 3,$y1 + $hLeg - 3,"* LEGENDA",90);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->SetFont($fontdefault,'',8);
$pdf->SetXY (10+$x1 + $w1 + $wGap,$y1);
$pdf->Cell($wOb,8,utf8_decode("In Via di Acquisizione"), "TLRB",0, 'C');
$pdf->Cell($wDesc,8,utf8_decode(""), "TLRB",0, 'C');
$pdf->SetXY ($pdf->GetX()-$wDesc,$y1);
$pdf->MultiCell($wDesc,3.5,utf8_decode("L'alunno porta a termine compiti solo in situazioni note e unicamente con il supporto del docente e di risorse fornite appositamente"), 0,'J');

$pdf->SetXY (10+$x1 + $w1 + $wGap,$y1+10);
$pdf->Cell($wOb,8,utf8_decode("Base"), "TLRB",0, 'C');
$pdf->Cell($wDesc,8,utf8_decode(""), "TLRB",0, 'C');
$pdf->SetXY ($pdf->GetX()-$wDesc,$y1+10);
$pdf->MultiCell($wDesc,3.5,utf8_decode("L'alunno porta a termine compiti solo in situazioni note e utilizzando le risorse fornite dal docente, sia in modo autonomo ma discontinuo, sia in modo non autonomo ma con continuità"), 0,'J');

$x1 = 210;
$pdf->SetXY (10+$x1,$y1);
$pdf->SetFont($fontdefault,'',8);
$pdf->Rect  (10+ $x1,$y1, $w1 ,$hLeg);
$pdf->SetXY (10+ $x1 + $w1, $y1);
$pdf->RotatedText(10+ $x1 + $w1 - 3,$y1 + $hLeg - 3,"* LEGENDA",90);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->SetFont($fontdefault,'',8);
$pdf->SetXY (10+$x1 + $w1 + $wGap,$y1);
$pdf->Cell($wOb,8,utf8_decode("Intermedio"), "TLRB",0, 'C');
$pdf->Cell($wDesc,8,utf8_decode(""), "TLRB",0, 'C');
$pdf->SetXY ($pdf->GetX()-$wDesc,$y1);
$pdf->MultiCell($wDesc,3.5,utf8_decode("L'alunno porta a termine compiti in situazioni note in modo autonomo e continuo; risolve compiti in situazioni non note utilizzando le risorse fornite dal docente o reperite altrove, anche se in modo discontinuo e non del tutto autonomo"), 0,'J');

$pdf->SetXY (10+$x1 + $w1 + $wGap,$y1+10);
$pdf->Cell($wOb,8,utf8_decode("Avanzato"), "TLRB",0, 'C');
$pdf->Cell($wDesc,8,utf8_decode(""), "TLRB",0, 'C');
$pdf->SetXY ($pdf->GetX()-$wDesc,$y1+10);
$pdf->MultiCell($wDesc,3.5,utf8_decode("L'alunno porta a termine compiti in situazioni note e non note mobilitando una varietà di risorse, sia fornite dal docente sia reperite altrove in modo autonomo e con continuità"), 0,'J');


$R =           0;
$G =           0;
$B =           0;
$pdf->SetDrawColor($R,$G,$B);
$pdf->SetTextColor($R,$G,$B);
?>