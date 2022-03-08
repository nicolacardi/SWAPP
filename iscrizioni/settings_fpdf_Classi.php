<?
//per generare un nuovo font scaricare il font nella cartella fontttf, attivare queste righe opportunamente
//define('FPDF_FONTPATH','/fpdf181/font');
//require('../fpdf181/makefont/makefont.php');
//MakeFont('../fpdf181/fontttf/TitilliumWeb-Regular.ttf','cp1252');
//si trova a quel punto un file .z e un file php che vanno spostati nella cartella font di fpdf


require_once ('../fpdf181/fpdf.php');
require_once ('../fpdf181/MC_TABLE.php');		//Estende fpdf
require_once ('../fpdf181/MLT.php');			//Estende MC_TABLE
require_once ('../fpdf181/Rotate.php');			//Estende MLT
require_once ('../fpdf181/SetClassi.php');		//Estende Rotate: in SetClassi ci sono diverse classi Generiche ad esempio c'è WRITEHtml
require_once ('../fpdf181/pdf_write_tag.php');	//Estende SetClassi


//class PDF extends PDF_SetClassiGeneriche 
class PDF extends PDF_WriteTag //NON FUNZIONAVA SE c'è WriteHMTL nel documento

{
	
	// Page header
	function Header()
	{
		$this->AddFont('TitilliumWeb-ExtraLight','','TitilliumWeb-ExtraLight.php');
		$this->AddFont('TitilliumWeb-Regular','','TitilliumWeb-Regular.php');
		$this->AddFont('TitilliumWeb-SemiBold','','TitilliumWeb-SemiBold.php');
		// Logo
		$this->Image('../assets/img/logo/logo'.$_SESSION['codscuola'].'/logodefViola.png',10,6,30);
		// Arial bold 15
		
		$this->SetFont('Arial','B',15);
		// Move to the right
		$this->Cell(80);
		// Title
		//$this->Cell(30,10,'Title',1,0,'C');
		// Line break
		$this->Ln(20);
	}
	
	// Page footer
	function Footer()
	{
		include ('diciture.php');
		// Position at 1.5 cm from bottom
		$this->SetY(-20);
		// Arial italic 8
		//$this->SetFont('Arial','I',8);
		$this->SetFont('TitilliumWeb-ExtraLight','',10);
		
		//Piè di pagina
		$this->SetTextColor(100,100,100);
		$this->Cell(0,4,utf8_decode($nomescuola),0,1,'L');
		$this->SetFont('TitilliumWeb-ExtraLight','',8);
		$this->Cell(0,4,utf8_decode($ragionesocialescuola),0,1,'L');
		$this->Cell(0,4,utf8_decode($indirizzocompletoscuola),0,1,'L');
		$this->Cell(0,4,utf8_decode($datiscuola),0,0,'L');
		// Page number		
		$this->Cell(0,10,'Pagina '.$this->PageNo().' di {nb}',0,0,'C');
		
		
		
	}

	
}?>