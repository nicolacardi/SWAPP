<?
$ISC_mostra_regolinterno=			$_SESSION['ISC_mostra_regolinterno'];
$ISC_mostra_regolpediatrico=		$_SESSION['ISC_mostra_regolpediatrico'];
$ISC_mostra_allegatoA=		        $_SESSION['ISC_mostra_allegatoA'];
$ISC_mostra_dietespeciali=		    $_SESSION['ISC_mostra_dietespeciali'];


include_once("iscrizioni/diciture.php");
$pdf->AddPage();
$pdf->Image('../assets/img/Icone/recycle-sign.png',165,120,10);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,utf8_decode("INFORMATIVA ed ALLEGATI"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(0,10,utf8_decode("Questo documento contiene:"), 0,1, 'L');
$link1 = $pdf->AddLink();
$link2 = $pdf->AddLink();
$link3 = $pdf->AddLink();
$link4 = $pdf->AddLink();
$link5 = $pdf->AddLink();
$link6 = $pdf->AddLink();
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('','U');
$pdf->Write(10,'> Informativa relativa alla raccolta ed il trattamento dei dati',$link1);

if ($ISC_mostra_allegatoA ==1) {
    $pdf->Ln(10);
    $pdf->Write(10,'> ALLEGATO A : I PRINCIPI PEDAGOGICI DELLA SCUOLA STEINER WALDORF',$link2);
}
if ($ISC_mostra_regolinterno ==1) {
    $pdf->Ln(10);
    $pdf->Write(10,'> ALLEGATO B: REGOLAMENTO INTERNO',$link3);
}
if ($ISC_mostra_regolpediatrico ==1) {
    $pdf->Ln(10);
    $pdf->Write(10,'> ALLEGATO C: '.$fraseAllegatoCALL,$link4);
}



$pdf->Ln(10);
$pdf->Write(10,'> ALLEGATO D: CONTRIBUTI SCOLASTICI E REGOLAMENTO ECONOMICO',$link5);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont($fontdefault,'',10);


if ($ISC_mostra_dietespeciali ==1) {
    $pdf->Ln(10);
    $pdf->Write(10,'> ALLEGATO E: MODULO RICHIESTA DIETE SPECIALI',$link6);
}

$pdf->Ln(30);

$pdf->SetTextColor(0,115,0);
$pdf->Cell(30,10,utf8_decode("[Per rispetto nei confronti dell'ambiente stampate questo documento solo se davvero necessario]"), 0,1, 'L');
$pdf->SetTextColor(0,0,0);
//INFORMATIVA Trattamento dei dati ************************************************************************************************************************************
$pdf->AddPage();
$pdf->SetLink($link1);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,utf8_decode("RACCOLTA E TRATTAMENTO DEI DATI"), 0,1, 'C');
$pdf->Cell(0,10,utf8_decode("Informativa ai sensi dell'art.13 del Regolamento UE 2016/679"), 0,1, 'C');

$pdf->Ln(3);
$pdf->SetFont($fontdefault,'',9.5);
$informativaprivacy = utf8_decode($informativaprivacy);
$pdf->MultiCell(0,4.1,$informativaprivacy); //era 4.6
$pdf->Ln(3);

if ($ISC_mostra_allegatoA ==1) {
    include_once("AllegatoA_".$codscuola.".php");
}
if ($ISC_mostra_regolinterno ==1) {
    include_once("AllegatoB_".$codscuola.".php");
}
if ($ISC_mostra_regolpediatrico ==1) {
    include_once("AllegatoC_".$codscuola.".php");
}
include_once("AllegatoD_".$codscuola.".php");

if ($ISC_mostra_dietespeciali ==1) {
    include_once("AllegatoE.php");
}

?>