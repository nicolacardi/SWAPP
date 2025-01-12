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
$pdf->Cell(0,10,utf8_decode("1) ORARIO SCOLASTICO"), 0,1, 'J');
$testo= "L'orario di entrata è il seguente:

Scuola dell'infanzia: I bambini entrano, accompagnati dai genitori, da via Tergola e sono attesi dalle maestre entro le ore 8.45; i genitori ritirano i bambini entro le ore 14.45.

Primaria: gli alunni dalla  I° classe alla V° entrano da via Tergola. 
Gli alunni della classe I° possono essere accompagnati dai genitori fino all'atrio, dove li accoglie il maestro. 
Gli insegnanti attendono i bambini in atrio fino alle 8.10 e li accompagnano nelle rispettive classi. 
Le lezioni terminano alle ore 14.55.

Secondaria: i ragazzi entrano da via Retrone e si recano alle rispettive classi per l'inizio delle lezioni, alle 8.05. 
Le lezioni terminano alle ore 14.55.

Al fine di permettere un'entrata ed un'uscita ordinate invitiamo i genitori a non sostare nell'atrio d'ingresso tra le ore 8.00 e le ore 8.15 e tra le ore 14.45 e le 15.00.
Al termine delle lezioni gli insegnanti accompagnano bambini e ragazzi alle rispettive uscite.
Si raccomanda la massima puntualità sia per l'ingresso sia per l'uscita.
In caso di ritardo i genitori devono avvisare la segreteria ed organizzare il ritiro del proprio figlio tramite persone di fiducia opportunamente autorizzate tramite delega scritta.
I genitori sono pregati di non sostare oltre il necessario nel parcheggio e nella strada in modo da mantenere buone abitudini e cordiali rapporti di buon vicinato con gli abitanti del quartiere.
Nel caso in cui si acconsenta a permettere ai ragazzi più grandi di tornare a casa in modo autonomo, è necessario compilare l'apposito modulo di permesso che deve essere firmato da entrambi i genitori, valido solo per l'anno scolastico in corso.
La scuola declina ogni responsabilità fuori dall'orario scolastico.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);


$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("2)	PERMESSI ENTRATE/USCITE/ASSENZE"), 0,1, 'J');
$testo= "Per qualsiasi tipo di ritardo, entrata posticipata, uscita anticipata o assenza , il genitore deve compilare l'apposito modulo nel libretto personale.
<b>E' necessario che i genitori leggano attentamente e approvino il Regolamento Pediatrico (Allegato C).</b>";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->WriteHTML($testo);

$pdf->Ln(5);
$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("3)	RICEVIMENTO DEI GENITORI:"), 0,1, 'J');
$testo= "Gli insegnanti incontrano i genitori nelle riunioni di classe e, per colloqui individuali, durante l'orario di ricevimento, esposto in bacheca vicino alla segreteria.
Per questioni rilevanti i genitori possono chiedere un incontro con i rappresentanti del Collegio.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("4)	ALIMENTAZIONE E FARMACI"), 0,1, 'J');
$testo= "Gli alunni a scuola ricevono la merenda e il pranzo; i genitori  pertanto  non devono fornire altri alimenti. 
L'accesso alla cucina è riservato solo al personale autorizzato.
Allergie ed intolleranze vanno tempestivamente segnalate alla segreteria mediante compilazione dell'apposito modulo. E' necessario allegare alla segnalazione anche un certificato del medico allergologo attestante l'allergia e/o intolleranza con indicazione della dieta da seguire.
Si ricorda che al personale della Scuola non è consentita la somministrazione di farmaci, se non espressamente autorizzata dai genitori tramite il modulo ''Delega alla somministrazione di farmaci'' reperibile in segreteria,  corredato da certificato medico.
E' a cura del genitore far presente agli insegnanti e al medico scolastico la patologia del proprio figlio.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("5)	CELLULARI E APPARECCHI ELETTRONICI"), 0,1, 'J');
$testo= "All'interno degli spazi scolastici (edificio e spazi esterni) è vietato per tutti, adulti e ragazzi, l'uso di cellulari e di altri apparecchi elettronici in orario scolastico. 
Il personale della scuola è tenuto a far rispettare tale regola richiamando verbalmente eventuali trasgressori.
Tale regola vale anche per le uscite didattiche.
Da tale divieto sono escluse la segreteria e l'aula insegnanti.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("6)	ABBIGLIAMENTO"), 0,1, 'J');
$testo= "Si invitano insegnanti ed alunni a vestire in maniera consona all'ambiente scolastico. ";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("7)	GIOCHI E RICREAZIONI"), 0,1, 'J');
$testo= "Bambini e ragazzi trovano a scuola palloni e giochi da tavolo da utilizzare durante le ricreazioni. 
Non è possibile pertanto portare a scuola giochi personali senza il permesso del proprio insegnante.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("8)	ATTIVITA' POMERIDIANE"), 0,1, 'J');
$testo= "Durante la settimana la Scuola propone alcune attività pomeridiane (corsi di musica, falegnameria, dopo scuola ecc.).Tali attività sono a cura degli insegnanti che direttamente le gestiscono. 
Solo gli alunni e i genitori coinvolti in queste attività possono sostare negli spazi della Scuola.
Durante le attese i bambini e i ragazzi devono comunque essere sorvegliati dai propri genitori e dagli insegnanti presenti.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("9)	AMBIENTE SCOLASTICO"), 0,1, 'J');
$testo= "L'edificio scolastico è uno spazio esclusivamente educativo, perciò ci si appella alla coscienza di tutti affinché venga rispettato; esso ha bisogno della massima cura e manutenzione da parte di tutti.
Tutti i luoghi ed il materiale scolastico, dalle aule ai corridoi, dai bagni al salone, dai banchi agli oggetti vanno rispettati e trattati con cura e responsabilità.
Una particolare attenzione deve essere riservata, da parte degli alunni, alla cura dei banchi e delle sedie: scritte ed incisioni sono severamente vietate. Nel caso di non rispetto degli stessi è fatta cura del genitore o dell'alunno di provvedere tempestivamente al ripristino dello stato originario dei medesimi. 
Qualora ciò non fosse possibile la scuola richiederà alla famiglia dell'alunno che ha utilizzato il banco o la sedia di provvedere all'acquisto dello stesso. 
Gli strumenti musicali e tutti gli attrezzi e materiali scolastici non possono essere utilizzati se non in presenza del maestro di riferimento.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("10) DIVIETO DI FUMO"), 0,1, 'J');
$testo= "In tutti i locali della scuola e nelle aree di pertinenza è severamente vietato fumare. Il divieto di fumo è esteso anche alle sigarette elettroniche. Per i trasgressori sono previste sanzioni pecuniarie (fino a euro 500) e sanzioni disciplinari. 
Il divieto riguarda tutte le persone presenti a scuola: studenti, personale docente, genitori ed esterni.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("11) SEGRETERIA"), 0,1, 'J');
$testo= "La segreteria è aperta dal lunedì al venerdì dalle 8.15 alle 9.30 e dalle 14.00 alle 14.45.
Al fine di permettere un sereno ed ordinato inizio della giornata scolastica si prega di attendere l'inizio delle lezioni fuori dai cancelli e di accedere alla segreteria dalle ore 8.15 in poi.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$pdf->SetFont('TitilliumWeb-SemiBold','',10);
$pdf->Cell(0,10,utf8_decode("12) PAGAMENTI"), 0,1, 'J');
$testo= "Le quote scolastiche sono necessarie per permettere alla Scuola di assolvere con puntualità agli obblighi economici quali:
- il pagamento degli stipendi agli insegnanti e di coloro che vi lavorano;
- l'acquisto del materiale scolastico e degli alimenti per la mensa;
- il riscaldamento, le manutenzioni e tutto ciò che contribuisce al buon funzionamento della scuola.
Pertanto si chiede ai genitori la massima coscienza nel versare con puntualità, entro il 5 di ogni mese, la retta scolastica al fine di non mettere in difficoltà il buon andamento economico.

L'impegno e la responsabilità individuale nell'osservare queste norme di igiene sociale concorrono al benessere e all'armonia dell'intera comunità scolastica.


Il Collegio Insegnanti
Il Consiglio di Amministrazione";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

?>
