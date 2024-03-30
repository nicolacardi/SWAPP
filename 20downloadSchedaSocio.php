<?
require_once ('fpdf181/fpdf.php');              
require_once ('fpdf181/MC_TABLE.php');          //Estende fpdf
require_once ('fpdf181/MLT.php');               //Estende MC_TABLE
require_once ('fpdf181/Rotate.php');            //Estende MLT
require_once ('fpdf181/SetClassi.php');         //Estende Rotate: in SetClassi ci sono diverse classi Generiche ad esempio c'è WRITEHtml


include_once("database/databaseii.php");
include_once("assets/functions/functions.php");
include_once("assets/functions/ifloggedin.php");


//Dopo aver caricato le varie classi che si estendono in catena creiamo la classe PDF che useremo: 
// nelle iscrizioni in questa classe inseriamo il footer e header che sono classi SPECIFICHE di questo file.
// TUTTE le altre sono nella catena.
class PDF extends PDF_SetClassiGeneriche {}

include_once("iscrizioni/settings_fpdf_Base.php");


$imgsquare = './assets/img/square.png';
$imgsquaremini = './assets/img/squaremini.png';
$imgsquarecrossed = './assets/img/squarecrossed.png';
$imgsquarecrossedmini = './assets/img/squarecrossedmini.png';

$ID_soc = $_POST['ID_soc'];

//FRONTESPIZIO************************************************************************************************************************************
$pdf->AddPage();
//Logo
// $width =  30;
// $positionX= 210 - $width - 10;
// $positionY =  5;

// $pdf->Image('assets/img/logo/logo'.$_SESSION['codscuola'].'/logodefGrigioScuro.png',$positionX,$positionY, $width);
//Titoli
$pdf->SetTextColor(0,0,0);
$pdf->SetXY (0,10);
$pdf->SetFont($fontdefault,'',10);


//estraggo i dati da mostrare nella parte anagrafica
$sql2 = "SELECT ID_soc, ID_fam_soc, ID_mae_soc, padremadre_soc, tipo_soc, dataiscrizione_soc, datarichiestaiscrizione_soc, quotapagata_soc, datadisiscrizione_soc, datarestituzionequota_soc, ckrinunciaquota_soc,  motivocessazione_soc, mf_soc, nome_soc, cognome_soc, datanascita_soc, comunenascita_soc, provnascita_soc, paesenascita_soc, cittadinanza_soc, cf_soc, indirizzo_soc, comune_soc, prov_soc, paese_soc, CAP_soc, telefono_soc, altrotel_soc, email_soc, note_soc, img_soc, descrizione_tsc ".
"FROM tab_anagraficasoci JOIN tab_tipisoci ON tipo_soc = ID_tsc ".
"WHERE ID_soc = ?;";
$stmt2 = mysqli_prepare($mysqli, $sql2);
mysqli_stmt_bind_param($stmt2, "i", $ID_soc);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $ID_soc, $ID_fam_soc, $ID_mae_soc, $padremadre_soc, $tipo_soc, $dataiscrizione_soc, $datarichiestaiscrizione_soc, $quotapagata_soc,  $datadisiscrizione_soc, $datarestituzionequota_soc, $ckrinunciaquota_soc, $motivocessazione_soc, $mf_soc, $nome_soc, $cognome_soc, $datanascita_soc, $comunenascita_soc, $provnascita_soc, $paesenascita_soc, $cittadinanza_soc, $cf_soc, $indirizzo_soc, $comune_soc, $prov_soc, $paese_soc, $CAP_soc, $telefono_soc, $altrotel_soc, $email_soc, $note_soc, $img_soc, $descrizione_tsc);
$i=0;
while (mysqli_stmt_fetch($stmt2)) {
$i++;

}


$h1 = 6;

$pdf->SetX(10);
$pdf->SetY(15);

$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$pdf->Cell(190 ,$h1,"SCHEDA SOCIO",0,1,'C');

$pdf->Ln(2);

$pdf->SetFont('TitilliumWeb-SemiBold','',12);

$pdf->Cell(190 ,$h1,"Socio ".$descrizione_tsc,1,1,'C', True);
$pdf->Ln(5);

if ($mf_soc == "M") {
    $pdf->Cell(190,$h1,"DATI ANAGRAFICI DEL SOCIO",1,1,'L');
} else {
    $pdf->Cell(190,$h1,"DATI ANAGRAFICI DELLA SOCIA",1,1,'L');
}


$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Cognome",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(150,$h1,strtoupper($cognome_soc),1,1,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Nome",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(150,$h1,strtoupper($nome_soc),1,1,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Luogo di nascita",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(150,$h1,$comunenascita_soc,1,1,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Data di nascita",1,0,'L');
$pdf->SetFont($fontdefault,'',12);

if($datanascita_soc!='0000-00-00' && $datanascita_soc!='1900-01-01' && $datanascita_soc!= NULL) {
    $datanascita_soc = date('d/m/Y', strtotime(str_replace('-','/', $datanascita_soc)));
} 
else{
    $datanascita_soc = "";
}

$pdf->Cell(150,$h1,$datanascita_soc,1,1,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Paese di nascita",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(60,$h1,$paesenascita_soc,1,0,'L');
$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(30,$h1,"Cittadinanza",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(60,$h1,$cittadinanza_soc,1,1,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Codice Fiscale",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(150,$h1,$cf_soc,1,1,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Residenza",'LTR',0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(150,$h1,utf8_decode($indirizzo_soc),1,1,'L');

$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(40,$h1,"",'LBR',0,'L');
$pdf->Cell(30,$h1,$CAP_soc,1,0,'L');
$pdf->Cell(90,$h1,$comune_soc,1,0,'L');
$pdf->Cell(30,$h1,$prov_soc,1,1,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Recapiti telefonici",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(75,$h1,$telefono_soc,1,0,'L');
$pdf->Cell(75,$h1,$altrotel_soc,1,1,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Indirizzo e-mail",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(150,$h1,$email_soc,1,1,'L');


$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Ln(5);
$pdf->Cell(190,$h1,"DATI AFFILIAZIONE",1,1,'L');


$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Quota Pagata Euro",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
if($quotapagata_soc == 0) { $quotapagata_soc = "";}
$pdf->Cell(150,$h1,$quotapagata_soc,1,1,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Data Richiesta Iscrizione",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(55,$h1,timestamp_to_ggmmaaaa($datarichiestaiscrizione_soc),1,0,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Data Iscrizione",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(55,$h1,timestamp_to_ggmmaaaa($dataiscrizione_soc),1,1,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Data Disiscrizione",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(55,$h1,timestamp_to_ggmmaaaa($datadisiscrizione_soc),1,0,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Data Restituzione Quota",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(55,$h1,timestamp_to_ggmmaaaa($datarestituzionequota_soc),1,1,'L');


$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(40,$h1,"Motivo Cessazione",1,0,'L');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(150,$h1,timestamp_to_ggmmaaaa($motivocessazione_soc),1,1,'L');

$pdf->SetFont($fontdefault,'',10);
$pdf->Cell(95,$h1,"",1,0,'L');


if ($ckrinunciaquota_soc == 1) {
    $pdf->Cell(95,$h1,"Rinuncia alla restituzione della quota".$pdf->Image($imgsquarecrossed,$pdf->GetX()+58, $pdf->GetY()+0.6,5),1,0,'L');
} else  {
    $pdf->Cell(95,$h1,"Rinuncia alla restituzione della quota".$pdf->Image($imgsquare,$pdf->GetX()+58, $pdf->GetY()+0.6,5),1,0,'L');
}


$pdf->Output();