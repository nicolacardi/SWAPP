<?//I PRINCIPI PEDAGOGICI DELLA SCUOLA STEINER WALDORF ************************************************************************************************************************************



$pdf->AddPage();
$pdf->SetLink($link1);


$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,8,utf8_decode("ALLEGATO H"), 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Cell(0,10,utf8_decode("RACCOLTA E TRATTAMENTO DEI DATI"), 0,1, 'C');
$pdf->Cell(0,10,utf8_decode("Informativa ai sensi dell'art.13 del Regolamento UE 2016/679"), 0,1, 'C');

$fontsizedefault = 9;
$pdf->SetFont($fontdefault,'',$fontsizedefault);


// Stylesheet
// $pdf->SetStyle("TAG","FONTTYPE","N/B/I/U o combinazioni","fontsize 10/12/28", "color 0,0,255", "indent", "bullet");
$pdf->SetStyleWriteTag("h1",    "TitilliumWeb-SemiBold",    "N",    $fontsizedefault,   0, 0);
$pdf->SetStyleWriteTag("n",     $fontdefault,               "N",    $fontsizedefault,   0, 0);
$pdf->SetStyleWriteTag("bu",     "TitilliumWeb-SemiBold",   "U",    $fontsizedefault,   0);
$pdf->SetStyleWriteTag("b",     "TitilliumWeb-SemiBold",    "N",    $fontsizedefault,   0);
$pdf->SetStyleWriteTag("a",     $fontdefault,               "BU",   $fontsizedefault,   "0,0,255");
$pdf->SetStyleWriteTag("bul",   $fontdefault,               "N",    $fontsizedefault,   0, 3, chr(149));


$informativaprivacy= "Nel ringraziarLa per averci fornito i Suoi dati personali, portiamo a Sua conoscenza le finalità e le modalità del trattamento cui essi sono destinati.
Secondo quanto previsto dagli artt. 13 e 14 del REG. UE 2016/679  recante disposizioni sulla tutela della persona e di altri soggetti, rispetto al trattamento di dati personali questa Istituzione Scolastica, rappresentata dal presidente pro-tempore, in qualità di Titolare del trattamento dei dati personali, per espletare le sue funzioni istituzionali e, in particolare, per gestire le attività di istruzione, educative e formative stabilite dal ".$POF_PTOF_PSDext.", nonchè per accogliere l'eventuale domanda di adesione a socio, deve acquisire i dati personali che Vi riguardano, inclusi quei dati che il REG. UE 2016/679 definisce ''particolari'' (art. 9). 

Vi informiamo pertanto che, per le esigenze di gestione sopra indicate, possono essere oggetto di trattamento le seguenti categorie di dati: 
- dati relativi agli alunni, idonei a rilevare lo stato di salute, raccolti in riferimento a certificazioni di malattia, infortunio, esposizione a fattori di rischio, appartenenza a categorie protette, idoneità allo svolgimento di determinate attività, sorveglianza sanitaria; 
- dati relativi agli alunni idonei a rilevare opinioni politiche o adesioni sindacali ed associative, derivanti da richieste di organizzazione o partecipazione ad attività opzionali, facoltative o stabilite autonomamente dagli organismi rappresentativi studenteschi; 
- dati relativi agli alunni idonei a rilevare le convinzioni religiose o filosofiche ovvero l'adesione a organizzazioni di carattere religioso o filosofico, o quali la fruizione di permessi e festività aventi tali carattere; 

Vi informiamo inoltre che il trattamento dei vostri dati personali avrà le seguenti finalità: 
- partecipazione degli alunni alle attività organizzate in attuazione del del ".$POF_PTOF_PSDext."; 
- adempimento di obblighi derivanti da leggi, contratti, regolamenti in materia di igiene e sicurezza, in materia fiscale, in materia assicurativa; 
- tutela dei diritti in sede giudiziaria. 

Vi forniamo a tal fine le seguenti ulteriori informazioni: 
- Il trattamento dei dati personali sarà improntato a principi di correttezza, liceità e trasparenza e di tutela della Sua riservatezza e dei Suoi diritti anche in applicazione dell'art. 5 del REG. UE 2016/679; 
- I dati personali verranno trattati anche con l'ausilio di strumenti elettronici o comunque automatizzati con le modalità e le cautele previste dal già menzionato REG. UE 2016/679 e conservati per il tempo necessario all'espletamento delle attività istituzionali e amministrative riferibili alle predette finalità; 
- Sono adottate dalla scuola le misure minime per la sicurezza dei dati personali previste dal REG. UE 2016/679; 
- Il titolare del trattamento è ".$titolaretrattamentoTitolo."; 
- Gli incaricati al trattamento dati sono i docenti, gli assistenti amministrativi della Scuola, i collaboratori e i gestori espressamente autorizzati all'assolvimento di tali compiti, identificati ai sensi di legge, ed edotti dei vincoli imposti dal REG. UE 2016/679; 
- I dati oggetto di trattamento potranno essere comunicati ai seguenti soggetti esterni all'istituzione scolastica per fini funzionali: Ufficio Scolastico Provinciale e Regionale, Comuni, ASL competente per territorio, Autorità di polizia del territorio. 

Vi ricordiamo infine: 
- che il conferimento dei dati richiesti potrebbe essere indispensabile a questa istituzione scolastica per l'assolvimento dei suoi obblighi istituzionali; 
- che, ai sensi dell'art. 2-ter del D. lgs. 196/2003, in alcuni casi il trattamento può essere effettuato anche senza il consenso dell'interessato; 
- Le ricordiamo che gode dei diritti di cui agli artt. 15 e segg. del Regolamento UE 2016/679, fra cui il diritto di chiedere l'accesso ai dati personali e la rettifica o la cancellazione degli stessi o la limitazione del trattamento che lo riguardano o di opporsi al loro trattamento; ha inoltre il diritto di proporre reclamo all'autorità di controllo competente in materia, Garante per la protezione dei dati personali.
    
Il Titolare del trattamento dati
".$titolaretrattamento;



$pdf->Ln(3);
$pdf->SetFont($fontdefault,'',9.5);
$informativaprivacy = utf8_decode($informativaprivacy);
$pdf->MultiCell(0,4.1,$informativaprivacy);
$pdf->Ln(3);


    
    
        
    






?>
