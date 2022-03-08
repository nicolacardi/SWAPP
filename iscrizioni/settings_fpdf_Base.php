<?$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddFont('TitilliumWeb-ExtraLight','','TitilliumWeb-ExtraLight.php');
$pdf->AddFont('TitilliumWeb-Regular','','TitilliumWeb-Regular.php');
$pdf->AddFont('TitilliumWeb-SemiBold','','TitilliumWeb-SemiBold.php');
$pdf->AddFont('TitilliumWeb-Italic','','TitilliumWeb-Italic.php');
$pdf->AddFont('TitilliumWeb-Regular','B','TitilliumWeb-SemiBold.php');  //Bold
$pdf->AddFont('TitilliumWeb-Regular','I','TitilliumWeb-Italic.php');    //Italic
$pdf->SetFillColor(220,220,220);
$fontdefault = 'TitilliumWeb-Regular';?>