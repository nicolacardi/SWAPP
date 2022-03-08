<?include_once("../database/databaseBii.php");
$annoscolastico = $_SESSION['anno_iscrizioni'];

include_once("diciture.php");
include_once("dicitureInformativaPrivacy.php");
include_once("settings_fpdf_Classi.php");
include_once("settings_fpdf_Base.php");


$anno1 = substr($_SESSION['annopreiscrizione_fam'], 0, 4);
$anno2 = "20".substr($_SESSION['annopreiscrizione_fam'], 5, 2);

//questo file rappresenta l'HUB attraveso il quale passa il download di tutti gli allegati
//viene passato un parametro di tipo GET

$allegato = $_GET['nomeallegato'];
include_once("Allegato".$allegato.".php");

$pdf->Output();
?>
