<?//I PRINCIPI PEDAGOGICI DELLA SCUOLA STEINER WALDORF ************************************************************************************************************************************

include_once('../database/databaseii.php');

$pdf->AddPage();
$pdf->SetLink($link2);


$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,8,utf8_decode("ALLEGATO A"), 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Cell(0,6,utf8_decode("I PRINCIPI PEDAGOGICI DELLA SCUOLA STEINER WALDORF"), 0,1, 'C');
$fontsizedefault = 9;
$pdf->SetFont($fontdefault,'',$fontsizedefault);


// Stylesheet
// $pdf->SetStyle("TAG","FONTTYPE","N/B/I/U o combinazioni","fontsize 10/12/28", "color 0,0,255", "indent", "bullet");
$pdf->SetStyleWriteTag("h1",    "TitilliumWeb-SemiBold",   "N",    90,   0);
$pdf->SetStyleWriteTag("p",     $fontdefault,              "N",    45,   0);
$pdf->SetStyleWriteTag("em",    $fontdefault,              "I",    14,   0);
$pdf->SetStyleWriteTag("strong","TitilliumWeb-SemiBold",   "N",    10,   0);
$pdf->SetStyleWriteTag("a",     $fontdefault,              "BU",   10,   "0,0,255");
$pdf->SetStyleWriteTag("li",    $fontdefault,              "N",    10,   0, 3, chr(149));

$sql = "SELECT ID_doc, contenuto_doc FROM tab_documenti WHERE titolo_doc = 'Allegato_A';";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_doc, $contenuto_doc );
while (mysqli_stmt_fetch($stmt)) {
}


$pdf->WriteTag(0,4,utf8_decode(html_entity_decode($contenuto_doc)),"","J",0,0);

$pdf->Ln(8);

$pdf->MultiCell(200,10,$contenuto_doc,"T",'L');

    
    
        
    






?>
