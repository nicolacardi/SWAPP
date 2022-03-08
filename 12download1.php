<?//Costruzione pagella ufficiale di tipo 1 (così codificata in database)
//la vecchia pagella originale
$tipodoc_mat = 1;

include ('12downloadEstrazioneDati.php');


//FRONTESPIZIO E QUARTA************************************************************************************************************************************

$pdf->AddPage("L", "A3");
$pdf->SetFont($fontdefault,'',5);
$pdf->Cell(-10,-10,$tipodoc_mat, 0,1, 'C');

$pdf->SetFillColor(200,200,200);
$titleSize =    16;
$yRectQuarta =  10;
$hRectQuarta = 275;
$colorsPag = explode (";", $_SESSION['colorsPag']); 
$R =           $colorsPag[0];
$G =           $colorsPag[1];
$B =           $colorsPag[2];
$mostraSez =     1;
$pdf->SetDrawColor($R,$G,$B);
$pdf->SetTextColor($R,$G,$B);
$coloreLogo = "Viola";
$titoloDoc = "Documento di Valutazione";
$sottoTitoloDoc = "";
// $pdf->SetDash(1,1); //5mm on, 5mm off
// $pdf->SetDash();

include("12stampasoloamministrativiA3.php");

include("12FrontespizioEQuarta.php");

//FINE FRONTESPIZIO E QUARTA************************************************************************************************************************************
//INIZIO SCRITTURA PAGELLA************************************************************************************************************************************
$pdf->AddPage("L", "A3");

include("12stampasoloamministrativiA3.php");
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);

include("12LogoAltoDxeSx.php");

$w1 =   190;        //Larghezza Titolo
$w2 =   110;        //Larghezza Materia
$wGap = 10;         //Larghezza Gap
$w3 =   30;         //Larghezza Voti

$y1 =   30;         //Start Y
$y2 =   55;         //Start Voti
$h1 =   8;          //H Titolo
$h2 =   10;         //H Titolo 2
$hInt = 5;          //H Prima riga intestazioni
$hGap = 2;          //H Seconda riga Intestazioni


if ($pagprimotrim_cls == 1) {
    $x1 = 10;
    $pdf->SetXY ($x1,$y1);
    $pdf->SetFont($fontdefault,'',$titleSize);
    $pdf->Cell($w1,$h1,utf8_decode("- PRIMO QUADRIMESTRE -"), 0,1, 'C');
    $pdf->SetFont($fontdefault,'',13);
    $pdf->SetXY ($x1,$y1 + $h1);
    $pdf->Cell($w1,$h2,utf8_decode("(".$nome_alu." ".$cognome_alu." - a.s. ".$annoscolastico_cla.")"), 0,1, 'C');
    $pdf->SetXY ($x1,$y1 + $h1 + $h2);
    $pdf->Cell($w2,$hInt,utf8_decode("Materia"), 0,0, 'C');
    $pdf->Cell($wGap,$hInt,utf8_decode(""), 0,0, 'C');
    $pdf->Cell($w3,$hInt,utf8_decode("Voto"), 0,0, 'C');
    $pdf->Cell($wGap,$hInt,utf8_decode(""), 0,0, 'C');
    $pdf->Cell($w3,$hInt,utf8_decode("Voto"), 0,0, 'C');
    $pdf->SetXY ($x1,$y2);
    $pdf->SetFont($fontdefault,'',11);
    $pdf->Cell($w2,$hGap,utf8_decode(""),0,0, 'C');
    $pdf->Cell($wGap,$hGap,utf8_decode(""), 0,0, 'C');
    $pdf->Cell($w3,$hGap,utf8_decode("in cifre /10"), 0,0, 'C');
    $pdf->Cell($wGap,$hGap,utf8_decode(""), 0,0, 'C');
    $pdf->Cell($w3,$hGap,utf8_decode("in lettere /decimi"), 0,0, 'C');
}

$x1 = 220;
$pdf->SetXY ($x1,$y1);
$pdf->SetFont($fontdefault,'',$titleSize);
$pdf->Cell($w1,$h1,utf8_decode("- SECONDO QUADRIMESTRE -"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',13);
$pdf->SetXY ($x1,$y1 + $h1);
$pdf->Cell($w1,$h2,utf8_decode("(".$nome_alu." ".$cognome_alu." - a.s. ".$annoscolastico_cla.")"), 0,1, 'C');
$pdf->SetXY ($x1,$y1+ $h1 + $h2);
$pdf->Cell($w2,$hInt,utf8_decode("Materia"), 0,0, 'C');
$pdf->Cell($wGap,$hInt,utf8_decode(""), 0,0, 'C');
$pdf->Cell($w3,$hInt,utf8_decode("Voto"), 0,0, 'C');
$pdf->Cell($wGap,$hInt,utf8_decode(""), 0,0, 'C');
$pdf->Cell($w3,$hInt,utf8_decode("Voto"), 0,0, 'C');
$pdf->SetXY ($x1,$y2);
$pdf->SetFont($fontdefault,'',11);
$pdf->Cell($w2,$hGap,utf8_decode(""),0,0, 'C');
$pdf->Cell($wGap,$hGap,utf8_decode(""), 0,0, 'C');
$pdf->Cell($w3,$hGap,utf8_decode("in cifre /10"), 0,0, 'C');
$pdf->Cell($wGap,$hGap,utf8_decode(""), 0,0, 'C');
$pdf->Cell($w3,$hGap,utf8_decode("in lettere /decimi"), 0,0, 'C');

$pdf->SetFont($fontdefault,'',14);






$y1 = 60;
if ($aselme_cla == "EL") {

    if ($giuquad1_cla == '' && $giuquad2_cla == '') {
        $h1 = 15;
        $rowh = 20;
    } else {
        $h1 = 15;       //era 20: altezza del box in cui viene scritto il voto
        $rowh = 20;     //era 25: altezza della riga INCLUSA l'altezza h1
    }
    
} else {

    if ($giuquad1_cla == '' && $giuquad2_cla == '') {
        $h1 = 10;
        $rowh = 12;
    } else {
        $h1 = 7;
        $rowh = 8;
    }
}

while (mysqli_stmt_fetch($stmt)) {
    if ($pagprimotrim_cls == 1) {
        $x1 = 10;
        $pdf->SetXY ($x1, $y1);
        $pdf->Cell($w2,$h1,utf8_decode($descmateria_mat),1,0, 'C');
        $pdf->Cell($wGap,$h1,utf8_decode(""), 0,0, 'C');
        if ($vot1_cla == "0"){
            $pdf->Cell($w3,$h1,"-", 1,0, 'C');
        } else {
            $pdf->Cell($w3,$h1,utf8_decode($vot1_cla), 1,0, 'C');
        }

        $pdf->Cell($wGap,$h1,utf8_decode(""), 0,0, 'C');
        if ($descmateria_mat =="Comportamento") {
            $pdf->Cell($w3,$h1,utf8_decode(array_search($vot1_cla,$votidesccomp)), 1,0, 'C');
        } else {
            if ($vot1_cla == "0"){
                $pdf->Cell($w3,$h1,"-", 1,0, 'C');
            } else {
                $pdf->Cell($w3,$h1,utf8_decode(array_search($vot1_cla,$votidesc)), 1,0, 'C');
            }
        }
    }


    $x1 = 220;
    $pdf->SetXY ($x1, $y1);
    if ($quadrimestre == 2) {$pdf->Cell($w2,$h1,utf8_decode($descmateria_mat),1,0, 'C');} else {$pdf->Cell(110,$h1,"",1,0, 'C');}
    $pdf->Cell($wGap,$hGap,utf8_decode(""), 0,0, 'C');
    if ($quadrimestre == 2) {
        if ($vot2_cla == "0"){
            $pdf->Cell($w3,$h1,"-", 1,0, 'C');
        } else {
            $pdf->Cell($w3,$h1,utf8_decode($vot2_cla), 1,0, 'C');
        }
    } else {
        $pdf->Cell($w3,$h1,"", 1,0, 'C');
    }
    $pdf->Cell($wGap,$h1,utf8_decode(""), 0,0, 'C');
    //test
    
    if ($quadrimestre == 2)  {
        if ($descmateria_mat =="Comportamento") {
            $pdf->Cell($w3,$h1,utf8_decode(array_search($vot2_cla,$votidesccomp)), 1,0, 'C');
        } else {
            if ($vot2_cla == "0"){
                $pdf->Cell($w3,$h1,"-", 1,0, 'C');
            } else {
                $pdf->Cell($w3,$h1,utf8_decode(array_search($vot2_cla,$votidesc)), 1,0, 'C');
            }
        }
    } else {
        $pdf->Cell($w3,$h1,"", 1,0, 'C');
    }
    $y1 = $y1 + $rowh;            
}

$pdf->SetFont($fontdefault,'',14);
if ($giuquad1_cla == '' && $giuquad2_cla == '') {
} else {
    if ($pagprimotrim_cls == 1) {

            $x1 = 10;
            $y1 = 183;
            $pdf->SetXY ($x1, $y1);
            $pdf->Cell(190,6,utf8_decode("RILEVAZIONE DEI PROGRESSI NELL'APPRENDIMENTO"), 0,1, 'C');
            $pdf->Cell(190,6,utf8_decode("E NELLO SVILUPPO  PERSONALE E SOCIALE"), 0,1, 'C');
            $pdf->Cell(190,2,utf8_decode(""), 0,1, 'C');
            $pdf->Cell(190,8,utf8_decode("VALUTAZIONE INTERMEDIA"), 1,1, 'C');
            $pdf->Rect($x1,$y1+22,190,42);

            if (strlen($giuquad1_cla) > 300) { $pdf->SetFont($fontdefault,'',11); $mcrowH = 6;} else { $pdf->SetFont($fontdefault,'',12); $mcrowH = 8;}

            //$txt=$pdf->MultiCell(190,8,utf8_decode(str_replace("\\n", "\r", $giuquad1_cla)),0,'C',0,5);
            $txt=$pdf->MultiCell(190,$mcrowH,utf8_decode(str_replace( "@@", "\n", stripslashes(str_replace("\\n", "@@",$giuquad1_cla)))),0,'C',0,5);
            //QUESTA VARIAZIONE DI MULTICELL CONSENTE DI:1 INTERROMPERE QUANDO SI RAGGIUNGONO N LINEE (4 IN QUESTO CASO) E RESTITUIRE IL TESTO MANCANTE:
            //NB...NON CI SI ACCORGE CHE IL TESTO è TAGLIATO A MENO CHE NON SIA IMPOSTATO IL BORDO, ALLORA SI VEDE IL BORDO INFERIORE MANCANTE!
            //$pdf->MultiCell(190,8,utf8_decode($giuquad1_cla), 1, "C");
            //$pdf->Cell(190,40,utf8_decode(str_replace("\\n", "\r", $giuquad1_cla)), 0, 1, "C");

    }



    $pdf->SetFont($fontdefault,'',14);
    $x1 = 220;
    $y1 = 183;
    $pdf->SetXY ($x1, $y1);
    $pdf->Cell(190,6,utf8_decode("RILEVAZIONE DEI PROGRESSI NELL'APPRENDIMENTO"), 0,1, 'C');
    $pdf->SetX ($x1);
    $pdf->Cell(190,6,utf8_decode("E NELLO SVILUPPO  PERSONALE E SOCIALE"), 0,1, 'C');
    $pdf->SetX ($x1);
    $pdf->Cell(190,2,utf8_decode(""), 0,1, 'C');
    $pdf->SetX ($x1);
    $pdf->Cell(190,8,utf8_decode("VALUTAZIONE FINALE"), 1,1, 'C');
    $pdf->SetX ($x1);
    $pdf->Rect($x1,$y1+22,190,42);
    if ($quadrimestre == 2) {

        if (strlen($giuquad2_cla) > 300) { $pdf->SetFont($fontdefault,'',11); $mcrowH = 6;} else { $pdf->SetFont($fontdefault,'',12); $mcrowH = 8;}

        $txt=$pdf->MultiCell(190,$mcrowH,utf8_decode(str_replace("\\n", "\r", $giuquad2_cla)),0,'C',0,5); //VEDI SOPRA: VARIAZIONE DI MULTICELL	
        //$pdf->MultiCell(190,40,utf8_decode(str_replace("\\n", "\r", $giuquad2_cla)), 1, "C");
    } else {
        $pdf->Cell(190,0,"", 1,0, 'C');
    }
}

//Timbro Firme e tratteggi per firme Sinistra
if ($pagprimotrim_cls == 1) {
    $indicetimbro = rand(1,9);
    $pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', (135), 250, 20);
    $pdf->SetFont($fontdefault,'',12);
    $pdf->SetXY (15,250);
    $pdf->Cell(60,10,"Firma del genitore", 0 ,1, 'C');
    $pdf->SetXY (15,255);
    $pdf->SetFont($fontdefault,'',9);
    $pdf->Cell(60,10,"(o di chi ne fa le veci)", 0 ,0, 'C');
    $pdf->SetFont($fontdefault,'',12);
    $pdf->SetXY (135,250);
    $pdf->Cell(60,10,"Il Coordinatore Didattico", 0 ,1, 'C');
    $indicefirma = rand(1,15);
    $pdf->Image('assets/img/firmecoordinatori/firme'.$codscuola.'/CoordDidattico'.$aselme_cla.$indicefirma.'.png', (135), 255, 60);

    $pdf->SetDash(1,1); //5mm on, 5mm off
    $pdf->SetXY ((15),260);
    $pdf->Cell(60,10,"", "B" ,0, 'C');
    $pdf->SetXY ((135),260);
    $pdf->Cell(60,10,"", "B" ,0, 'C');
    $pdf->SetDash(); //Restore dash
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);
}

//Timbro Firme e tratteggi per firme Destra
$indicetimbro = rand(1,9);
if ($quadrimestre == 2) {
    $pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', (135+210), 250, 20);
}
$pdf->SetFont($fontdefault,'',12);
$pdf->SetXY ((15+210),250);
$pdf->Cell(60,10,"Firma del genitore", 0 ,0, 'C');
$pdf->SetXY ((15+210),255);
$pdf->SetFont($fontdefault,'',9);
$pdf->Cell(60,10,"(o di chi ne fa le veci)", 0 ,0, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->SetXY ((135+210),250);
$pdf->Cell(60,10,"Il Coordinatore Didattico", 0 ,1, 'C');
$indicefirma = rand(1,15);
if ($quadrimestre == 2) {
    $pdf->Image('assets/img/firmecoordinatori/firme'.$codscuola.'/CoordDidattico'.$aselme_cla.$indicefirma.'.png', (135+210), 255, 60);
}

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->SetXY ((15+210),260);
$pdf->Cell(60,10,"", "B" ,0, 'C');
$pdf->SetXY ((135+210),260);
$pdf->Cell(60,10,"", "B" ,0, 'C');
$pdf->SetDash(); //Restore dash
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);
?>