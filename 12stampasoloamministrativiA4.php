<?
$stampa_solo_amministrativi = $_SESSION['stampa_solo_amministrativi'];
//stampa solo amministrativi pagina dx e sx su A3
if ($stampa_solo_amministrativi == 1) {
    if ($_SESSION ["role_usr"] == 2){
        //in questo caso devo far comparire un bel BOZZA in grande in mezzo alla pagina
        $pdf->SetXY (0,140);
        $pdf->SetTextColor(230,230,230);
        $pdf->SetFont('TitilliumWeb-SemiBold','',170);
        $pdf->Cell(210,8,utf8_decode("BOZZA"), 0,1, 'C');

        $pdf->SetXY (0,190);
        $pdf->SetFont('TitilliumWeb-SemiBold','',40);
        $pdf->Cell(210,8,utf8_decode("per la stampa"), 0,1, 'C');
        $pdf->SetXY (0,210);
        $pdf->Cell(210,8,utf8_decode("rivolgersi alla segreteria"), 0,1, 'C');
       
    }
}

?>