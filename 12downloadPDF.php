<?
require_once ('fpdf181/fpdf.php');              
require_once ('fpdf181/MC_TABLE.php');          //Estende fpdf
require_once ('fpdf181/MLT.php');               //Estende MC_TABLE
require_once ('fpdf181/Rotate.php');            //Estende MLT
require_once ('fpdf181/SetClassi.php');         //Estende Rotate: in SetClassi ci sono diverse classi Generiche ad esempio c'è WRITEHtml


include_once("database/databaseii.php");
include_once("assets/functions/functions.php");
include_once("assets/functions/ifloggedin.php");
include_once("iscrizioni/diciture.php");

//Dopo aver caricato le varie classi che si estendono in catena creiamo la classe PDF che useremo: 
// nelle iscrizioni in questa classe inseriamo il footer e header che sono classi SPECIFICHE di questo file.
// TUTTE le altre sono nella catena.
class PDF extends PDF_SetClassiGeneriche {}

include_once("iscrizioni/settings_fpdf_Base.php");

$ID_alu_cla = $_POST['ID_alu_cla']; 
$annoscolastico_cla = $_POST['annoscolastico_cla']; //tipo yyyy-yy
$quadrimestre = $_POST['quadrimestre'];             //vale 1 o 2
$classe_cla = $_POST['classe_cla'];                 //vale I II III IV V VI VII VIII IX X XI XII XIII ASILO
$sezione_cla = $_POST['sezione_cla'];               //vale A B C
$aselme_cla = $_POST['aselme_cla'];                 //vale AS EL ME NI SU
$codscuola = $_SESSION['codscuola'];                //vale PD CI VR
$Doc = $_POST['Doc'];                               //vale CerCom, ConOri oppure un numero



$votidesc=array("-"=>"0","UNO"=>"1","DUE"=>"2","TRE"=>"3","QUATTRO"=>"4","CINQUE"=>"5","SEI"=>"6","SETTE"=>"7","OTTO"=>"8","NOVE"=>"9","DIECI"=>"10","INSUFFICIENTE"=>"I","SUFFICIENTE"=>"S","BUONO"=>"B","DISCRETO"=>"D", "DISTINTO"=>"DT", "OTTIMO"=>"O", "-"=>"-", "--"=>"--", "Avanzato"=>"AV","Intermedio"=>"IN","Base"=>"BA","In via di acquisizione"=>"AC");
$votidesccomp=array("GRAV.INSUFF."=>"G","INSUFFICIENTE"=>"I", "SUFFICIENTE"=>"S", "BUONO"=>"B","DISCRETO"=>"D","OTTIMO"=>"O", "DISTINTO"=>"DT");

//Ora se è Batch ciclo sugli alunni della classe altrimenti ne lancio uno solo
//QUESTO FILE E' LO "SNODO" per
//  - Pagelle singole di tipo 1 1 quadrimestre
//  - Pagelle singole di tipo 2 1 quadrimestre
//  - Pagelle singole di tipo 1 2 quadrimestre
//  - Pagelle singole di tipo 2 2 quadrimestre
//  - Pagelle batch ti tipo 1 1 quadrimestre
//  - Pagelle batch di tipo 2 1 quadrimestre
//  - Pagelle batch di tipo 1 2 quadrimestre
//  - Pagelle batch di tipo 2 2 quadrimestre
//  - Doc Interni 1 quadrimestre
//  - Doc Interni 2 quadrimestre
//  - Doc Interni batch 1 quadrimestre
//  - Doc Interni batch 2 quadrimestre
// Viene SEMPRE lanciato questo file da 12EmissioneDocumenti ma anche da 02IMieiAlunni.
// a seconda dei parametri che gli vengono passati lui direziona le cose
// in futuro potrebbe facilmente spuntare un nuovo tipo di pagelle, passeranno sempre per di qua


if (isset($ID_alu_cla)) {
		//Rettangolo grande dx
		// $pdf->AddPage("L", "A3");
		// $pdf->SetFont('TitilliumWeb-SemiBold','',16);
		// $pdf->Cell(210,10,"ID_alu_cla: ".$ID_alu_cla, 1,1, 'C');
		// $pdf->Cell(210,10,"classe_cla: ".$classe_cla, 1,1, 'C');
		// $pdf->Cell(210,10,"sezione_cla: ".$sezione_cla, 1,1, 'C');
		// $pdf->Cell(210,10,"annoscolastico_cla: ".$annoscolastico_cla, 1,1, 'C');
    include("12download".$Doc.".php");
} else {
    $sql2 = 'SELECT ID_alu_cla FROM ((tab_classialunni LEFT JOIN tab_anagraficaalunni ON ID_alu_cla = ID_alu) LEFT JOIN tab_classi ON classe_cla = classe_cls) WHERE classe_cla =  ? AND sezione_cla = ? AND annoscolastico_cla = ? AND listaattesa_cla = 0 ORDER BY cognome_alu' ;
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "sss", $classe_cla, $sezione_cla, $annoscolastico_cla);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_alu_cla);
	$nalunno = 0;
	mysqli_stmt_store_result($stmt2);
	while (mysqli_stmt_fetch($stmt2)){

		//$pdf->AddPage("L", "A3");

		//Rettangolo grande dx
		// $pdf->SetFont('TitilliumWeb-SemiBold','',16);
		// $pdf->Cell(210,10,"ID_alu_cla: ".$ID_alu_cla, 1,1, 'C');
		// $pdf->Cell(210,10,"classe_cla: ".$classe_cla, 1,1, 'C');
		// $pdf->Cell(210,10,"sezione_cla: ".$sezione_cla, 1,1, 'C');
		// $pdf->Cell(210,10,"annoscolastico_cla: ".$annoscolastico_cla, 1,1, 'C');
		// $pdf->Cell(210,10,"quadrimestre: ".$quadrimestre, 1,1, 'C');
		// $pdf->Cell(210,10,"aselme_cla: ".$aselme_cla, 1,1, 'C');
		// $pdf->Cell(210,10,"codscuola: ".$codscuola, 1,1, 'C');
		// $pdf->Cell(210,10,"Doc: ".$Doc, 1,1, 'C');		


		include("12download".$Doc.".php");
	}
}

$pdf->Output();




//ecco come salvare soltanto il file, utile per pubblicare
//$pdf->Output("F", "TEST/Esempio.pdf");
//header('Location: ' . $_SERVER['HTTP_REFERER']); //torna indietro

// email stuff (change data below)
// $to = "nicola.cardi@gmail.com"; 
// $from = "nicola.cardi@yahoo.it"; 
// $subject = "send email with pdf attachment"; 
// $message = "<p>Please see the attachment.</p>";

// // a random hash will be necessary to send mixed content
// $separator = md5(time());

// // carriage return type (we use a PHP end of line constant)
// $eol = PHP_EOL;

// // attachment name
// $filename = "example.pdf";

// // encode data (puts attachment in proper format)
// $pdfdoc = $pdf->Output("", "S");
// $attachment = chunk_split(base64_encode($pdfdoc));


// // main header (multipart mandatory)
// $headers  = "From: ".$from.$eol;
// $headers .= "MIME-Version: 1.0".$eol; 
// $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol; 
// $headers .= "Content-Transfer-Encoding: 7bit".$eol;
// $headers .= "This is a MIME encoded message.".$eol.$eol;

// // message
// $headers .= "--".$separator.$eol;
// $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
// $headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
// $headers .= $message.$eol.$eol;

// // attachment
// $headers .= "--".$separator.$eol;
// $headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
// $headers .= "Content-Transfer-Encoding: base64".$eol;
// $headers .= "Content-Disposition: attachment".$eol.$eol;
// $headers .= $attachment.$eol.$eol;
// $headers .= "--".$separator."--";

// // send message
// mail($to, $subject, "", $headers);

?>
