<?
//REGOLAMENTO PEDIATRICO ************************************************************************************************************************************
$pdf->AddPage();
$pdf->SetLink($link4);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,utf8_decode("ALLEGATO C"), 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$pdf->Cell(0,10,utf8_decode("INDICAZIONI PER IL CONTROLLO E PREVENZIONE DELLE MALATTIE INFETTIVE"), 0,1, 'C');

$testo= "Di seguito vengono fornite alcune indicazioni generali riguardanti il controllo e la prevenzione delle malattie infettive per la tutela del bambino e della collettività. Questo obiettivo può essere perseguito solo attraverso la reciproca collaborazione e la partecipazione del personale della scuola, del medico scolastico, del pediatra e dei genitori.
A tal fine dovranno essere scrupolosamente osservati, per tutti i frequentanti, gli adempimenti di seguito riportati.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("1) AMMISSIONE"), 0,1, 'J');
$testo= "Per i bambini ammessi alla frequenza, le famiglie si impegnano a:
- fornire i nominativi ed i recapiti delle persone che potranno essere contattate in caso di necessità ed urgenza;
- presentare il certificato medico del pediatra relativo ad eventuali allergie, intolleranze e/o necessità di cure e/o diete particolari;
- segnalare con tempestività alla segreteria eventuali malattie del bambino potenzialmente trasmissibili;
- rilasciare il consenso al trattamento dei dati personali ai sensi del D.Lgs 196/2003.
Con il verificarsi di particolari situazioni epidemiologiche la Scuola, in osservanza a specifiche indicazioni normative in ambito sanitario, quale misura di prevenzione, potrà richiedere il temporaneo allontanamento degli alunni al fine di prevenire l'insorgere di epidemie.
";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);


$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("2) DIETA"), 0,1, 'J');
$testo= "Se il bambino presenta allergie ed intolleranze alimentari, che necessitano di una dieta particolare, dovrà essere tempestivamente presentata la certificazione dell'allergologo con le specifiche indicazioni.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("3) FARMACI"), 0,1, 'J');
$testo= "Il personale della Scuola non può somministrare farmaci agli alunni durante le ore di frequenza scolastica. Nel caso di alunni con patologie croniche, possono essere somministrati solamente farmaci indispensabili, su prescrizione del pediatra curante, con l'indicazione della posologia, della modalità di somministrazione e della corretta conservazione del farmaco e con delega del genitore.
";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("4) COMPORTAMENTO IN CASO DI SINTOMI"), 0,1, 'J');
$testo= "I genitori non devono portare il bambino a scuola quando presenta sintomi di malattia acuta in atto: febbre, vomito, diarrea, manifestazioni cutanee contagiose, congiuntiviti, bambino stranamente stanco o con irritabilità non giustificata, pianto persistente, tosse continua, dolore addominale persistente.
Qualora insorga una malattia acuta o si verifichi un trauma durante l'attività educativo/scolastica il responsabile avvisa il genitore o l'adulto di riferimento delegato, affinché provveda obbligatoriamente al rientro in famiglia o al trasporto presso strutture sanitarie. Nell’attesa sarà tenuto separato, in luogo confortevole e non a diretto contatto con i compagni.
In situazioni gravi la Scuola provvederà ad attivare il Servizio di Emergenza 118.
I genitori sono tenuti a consultare il pediatra curante per verificare se la patologia da cui è affetto il bambino è compatibile con la frequenza del servizio.
";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("5)	ASSENZA PER MALATTIA E RIAMMISSIONE ALLA FREQUENZA "), 0,1, 'J');
$testo= "I genitori sono tenuti a comunicare tempestivamente il motivo dell'assenza del proprio figlio/a, quando possa trattarsi di malattia infettiva diffusa, al fine di consentire l'attuazione di opportune misure profilattiche.
L'assenza per malattia, anche di durata superiore a cinque giorni consecutivi non necessita di certificato medico che ne attesti l'idoneità alla frequenza scolastica, tuttavia si raccomanda ai genitori di dichiarare, nella giustificazione di rientro, di essersi attenuti a quanto prescritto dal medico di famiglia e alle prescrizioni vigenti emanate in materia di prevenzione contagio covid.
Quando l'assenza non sia dovuta a malattia, ma ad altri motivi, i genitori devono preventivamente avvertire il personale della Scuola e al rientro giustificare l'assenza nel libretto personale.
Le riammissioni avverranno quando saranno decadute le condizioni che ne hanno provocato l'allontanamento, cioè quando il bambino sarà definitivamente guarito (almeno un giorno senza manifestare i sintomi della malattia sopraggiunta).
In particolare, si invita al rispetto delle seguenti misure di profilassi:";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->Ln(5);

$pdf->SetFont($fontdefault,'',11);
$pdf->SetWidths(array(120,70));
$pdf->Row(array("ALLONTANAMENTI CAUTELATIVI DEL BAMBINO DALLA FREQUENZA", "PERIODO MINIMO DI ALLONTANAMENTO"));
$pdf->Row(array("Febbre","Fino a definitiva scomparsa, con riammissione dopo almeno 24 ore di sfebbramento" ));
$pdf->Row(array("Diarrea","Fino 24 ore dall'ultima scarica e riammissione a guarigione clinica" ));
$pdf->Row(array("Vomito","Fino 24 ore dall'ultimo episodio di vomito"));
$pdf->Row(array("Congiuntivite, in caso di secrezione purulenta","Sino a 24 ore dall'inizio della terapia"));
$pdf->Row(array("Influenza","Fino a guarigione clinica"));
$pdf->Row(array("Malattie infettive","Fino a guarigione clinica"));
$pdf->Row(array("Pediculosi","in presenza di pidocchi o lendini Fino al giorno successivo al trattamento: Il bambino verra' riammesso solo se privo di lendini"));


$testo= "Il bambino che si ripresenti al servizio con gli stessi sintomi o non rispettando il periodo minimo di profilassi indicato non potrà essere accettato, salvo certificato medico che ne attesti la mancanza di pericolo di contagio.
Per ulteriori e diverse infezioni si fa riferimento a quanto indicato nel Manuale per la prevenzione delle malattie infettive nelle comunità infantili e scolastiche della Regione Veneto.
Per la pediculosi a quanto indicato nel Manuale La pediculosi del capo della Regione Veneto.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->Ln(5);
$testo= "E' richiesto ai genitori di attenersi scrupolosamente alle presenti indicazioni come dovere e rispetto per il proprio figlio e per l'intera comunità educativa.";
$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

?>
