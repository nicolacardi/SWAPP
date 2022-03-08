<? //Logo in alto a sinistra e a destra
$wLogo =       30;
$posXLogo =      5;
$posYLogo =    10;
if ($pagprimotrim_cls == 1) {
    $pdf->Image('assets/img/logo/logo'.$codscuola.'/logodefViola.png',$posXLogo,$posYLogo, $wLogo);
}
$posXLogo= 420 - $wLogo - $posXLogo;
$pdf->Image('assets/img/logo/logo'.$codscuola.'/logodefViola.png',$posXLogo,$posYLogo, $wLogo); ?>