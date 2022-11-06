<?  
    $pdf->SetFont($fontdefault,'',8);
    $pdf->Cell(60,5,"Per ".$ragionesocialescuola,0,1,'C');
    $pdf->Cell(60,5,"(Il rappresentante legale)",0,1,'C');
    $pdf->Ln(4);
    $pdf->Cell(60,5,"","B",1);

    $indicefirma = rand(1,10);
    $firmapresidenteimg = '../assets/img/firmepresidente/firmepresidente'.$codscuola."/firmapresidente".$indicefirma.'.png';
    if (file_exists($firmapresidenteimg)) {
        $pdf->Image($firmapresidenteimg, $pdf->GetX(), $pdf->GetY()-20, 60);
    }

?>