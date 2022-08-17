<?
//REGOLAMENTO INTERNO ************************************************************************************************************************************
$pdf->AddPage();
$pdf->SetLink($link3);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,utf8_decode("ALLEGATO B"), 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$pdf->Cell(0,10,utf8_decode("REGOLAMENTO INTERNO"), 0,1, 'C');

$testo= "I genitori sono invitati a prendere visione del regolamento interno e a motivare i bambini e i ragazzi ad osservarlo.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("1) ORARIO DI LEZIONE"), 0,1, 'J');
$testo= "L'orario di entrata è il seguente:
I ragazzi entrano alle ore 8.15.
Le lezioni del mattino terminano tutti i giorni alle ore 13.00. Nei giorni di martedì e giovedì riprendono alle ore 14 e terminano alle ore 16.

Si raccomanda la massima puntualità sia per l'ingresso sia per l'uscita.
E' necessario un permesso firmato da entrambi i genitori valevole per tutto l'anno scolastico per consentire l'uscita autonoma dei ragazzi.
ARCA declina ogni responsabilità fuori dall'orario scolastico.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);


$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("2)	PERMESSI ENTRATE/USCITE/ASSENZE"), 0,1, 'J');
$testo= "Per qualsiasi tipo di ritardo, entrata posticipata, uscita anticipata o assenza, il genitore deve compilare l'apposito modulo nel libretto personale.
Per assenze superiori ai sei giorni (si conteggiano anche il sabato e la domenica) è necessario presentare, oltre alla giustificazione, anche il certificato medico a cura del proprio medico curante. 
E' necessario che i genitori leggano attentamente e approvino il Regolamento Pediatrico (Allegato C).";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("3)	RICEVIMENTO DEI GENITORI:"), 0,1, 'J');
$testo= "Gli insegnanti incontrano i genitori nelle riunioni di classe e, per colloqui individuali, durante l'orario di ricevimento, comunicato dalla segreteria.
Per questioni rilevanti i genitori possono chiedere un incontro con i rappresentanti del Collegio.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("4)	FARMACI"), 0,1, 'J');
$testo= "Allergie ed intolleranze vanno tempestivamente segnalate alla segreteria mediante compilazione dell'apposito modulo. E' necessario allegare alla segnalazione anche un certificato del medico allergologo attestante l'allergia e/o intolleranza.
Si ricorda che al personale non è consentita la somministrazione di farmaci.
E' a cura del genitore far presente agli insegnanti e al medico scolastico eventuali patologie del proprio figlio.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("5)	CELLULARI E APPARECCHI ELETTRONICI"), 0,1, 'J');
$testo= "All'interno degli spazi di formazione è vietato per tutti, adulti e ragazzi, l'uso di cellulari e di altri apparecchi elettronici durante le lezioni. 
Il personale è tenuto a far rispettare tale regola richiamando verbalmente eventuali trasgressori.
Tale regola vale anche per le uscite didattiche.
Da tale divieto sono escluse la segreteria e, solo in casi eccezionali, gli insegnanti.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("6)	ABBIGLIAMENTO"), 0,1, 'J');
$testo= "Si invitano insegnanti ed alunni a vestire in maniera consona e decorosa. ";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("7)	ATTIVITA' POMERIDIANE"), 0,1, 'J');
$testo= "Durante la settimana vengono proposte alcune attività pomeridiane (corsi di musica, falegnameria, dopo scuola ecc.).Tali attività sono a cura degli insegnanti che direttamente le gestiscono. Solo gli alunni e i genitori coinvolti in queste attività possono partecipare.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("8)	AMBIENTE SCOLASTICO"), 0,1, 'J');
$testo= "Gli spazi adibiti alla formazione sono concessi in locazione da terzi: ci si appella alla coscienza di tutti affinché vengano rispettati; essi hanno bisogno della massima cura e manutenzione da parte di tutti.
Tutti i luoghi ed il materiale utilizzato, le aule, i corridoi, i bagni, il salone, i banchi e gli oggetti vanno rispettati e trattati con cura e responsabilità.
Una particolare attenzione deve essere riservata, da parte degli alunni, alla cura dei banchi e delle sedie: scritte ed incisioni sono severamente vietate. Nel caso di non rispetto degli stessi è fatta cura del genitore o dell'alunno di provvedere tempestivamente al ripristino dello stato originario dei medesimi. 
Qualora ciò non fosse possibile la famiglia dell'alunno che ha utilizzato il banco o la sedia provvederà al ri-acquisto di quanto è stato compromesso. 
Gli strumenti musicali e tutti gli attrezzi e materiali scolastici non possono essere utilizzati se non in presenza del maestro di riferimento.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("9) DIVIETO DI FUMO"), 0,1, 'J');
$testo= "In tutti i locali interne e nelle aree comune interne è severamente vietato fumare. Il divieto di fumo è esteso anche alle sigarette elettroniche. Per i trasgressori sono previste sanzioni pecuniarie (fino a euro 500) e sanzioni disciplinari. 
Il divieto riguarda tutte le persone presenti a scuola: studenti, personale docente, genitori ed esterni.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("10) SEGRETERIA"), 0,1, 'J');
$testo= "La segreteria è aperta dal lunedì al venerdì dalle 8.15 alle 9.30 e dalle 14.00 alle 14.45.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("11) PAGAMENTI"), 0,1, 'J');
$testo= "Le quote scolastiche sono necessarie per permettere alla Soc. Cooperativa Sociale Arca di assolvere con puntualità agli obblighi economici quali:
- il pagamento degli stipendi agli insegnanti e di coloro che vi lavorano;
- l'acquisto del materiale scolastico e di tutto ciò che contribuisce al buon funzionamento dell'iniziativa.
Pertanto si chiede ai genitori la massima coscienza nel versare con puntualità, entro il 5 di ogni mese, la retta concordata al fine di non mettere in difficoltà il buon andamento economico.

L'impegno e la responsabilità individuale nell'osservare queste norme di igiene sociale concorrono al benessere e all'armonia dell'intera comunità.


Il Collegio Insegnanti
Il Consiglio di Amministrazione";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

?>
