<?  $pdf->SetFont($fontdefault,'',9);
    $pdf->Cell(60,5,"Firma del padre/tutore* (leggibile)",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(60,5,"Firma della madre/tutrice* (leggibile)",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(60,5,"Data e luogo",0,1,'C');

    $pdf->SetFont($fontdefault,'',8);
    $pdf->Cell(60,5,"(* ove presente)",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(60,5,"(* ove presente)",0,1,'C');

    $pdf->Ln(2);
    $pdf->SetFont($fontdefault,'',8);
    $pdf->Cell(60,5,"","B",0,'C');
    $pdf->Cell(5,5,"","",0,'C');
    $pdf->Cell(60,5,"","B",0,'C');
    $pdf->Cell(5,5,"","",0,'C');
    $pdf->SetFont($fontdefault,'',10);

    $pdf->Cell(60,5,$li.",","B",0,'L');
    
    $indicetimbro = rand(1,9);
    $pdf->Image('../assets/img/Icone/frecciafirmablack.png', $pdf->GetX()-200, $pdf->GetY()-18, 20);
    $pdf->Image('../assets/img/Icone/frecciafirmablack.png', $pdf->GetX()-135, $pdf->GetY()-18, 20);

    ?>