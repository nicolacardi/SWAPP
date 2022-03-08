<?
//REGOLAMENTO INTERNO ************************************************************************************************************************************
$pdf->AddPage();
$pdf->SetLink($link3);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,utf8_decode("ALLEGATO B"), 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$pdf->Cell(0,10,utf8_decode("REGOLAMENTO INTERNO"), 0,1, 'C');


$testo= "1.ISCRIZIONE. L'iscrizione è valida per il singolo anno scolastico di riferimento e potrà essere rinnovata anno per anno fatto salvo il caso di inadempimenti di cui ai successivi punti del presente regolamento. In caso di ritiro, la quota d'iscrizione verrà comunque trattenuta a copertura delle spese di segreteria.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "2.ACQUISIZIONE INFORMAZIONI DA ALTRI ISTITUTI DI PROVENIENZA. I genitori/affidatari autorizzano la Scuola Steiner-Waldorf di Verona ad acquisire eventuali informazioni in ambito pedagogico ed amministrativo dalla scuola di provenienza dell'alunno.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "3.ORARI: Gli alunni dovranno essere a scuola alle ore 7.55. Si raccomanda la puntualità. La scuola non si assume responsabilità per gli alunni non accompagnati che rimangono all'esterno del perimetro della scuola. Durante l'orario scolastico gli allievi non possono uscire dai confini dell'area scolastica per nessun motivo. Nell'ambito dell'orario scolastico, salvo casi particolari, l'alunno partecipa a tutte le attività programmate dalla scuola. Tutti i permessi per le attività didattiche previste fuori dal perimetro della scuola vanno autorizzate e firmate dai genitori/affidatari. In mancanza della firma, l'alunno resta a scuola.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "4.AMBIENTE SCOLASTICO L'edificio scolastico è uno spazio esclusivamente educativo, perciò ci si appella alla coscienza di tutti affinché venga rispettato; esso ha bisogno della massima cura e manutenzione da parte di tutti. Tutti i luoghi ed il materiale scolastico, dalle aule ai corridoi, dai bagni al salone, dai banchi agli oggetti vanno rispettati e trattati con cura e responsabilità. Una particolare attenzione deve essere riservata, da parte degli alunni, alla cura dei banchi e delle sedie: scritte ed incisioni sono severamente vietate. Nel caso di non rispetto degli stessi è fatta cura del genitore o dell'alunno di provvedere tempestivamente al ripristino dello stato originario dei medesimi. Qualora ciò non fosse possibile la scuola richiederà alla famiglia dell'alunno che ha utilizzato il banco o la sedia di provvedere all'acquisto dello stesso. Gli strumenti musicali e tutti gli attrezzi e materiali scolastici non possono essere utilizzati se non in presenza del maestro di riferimento.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "5.DIVIETO DI FUMO: In tutti i locali della scuola e nelle aree di pertinenza è severamente vietato fumare. Il divieto di fumo è esteso anche alle sigarette elettroniche. Per i trasgressori sono previste sanzioni pecuniarie fino ad euro 500 e sanzioni disciplinari. Il divieto riguarda tutte le persone presenti a scuola: studenti, personale docente, genitori ed esterni.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "6.SEGRETERIA La segreteria è aperta dal lunedì al venerdì dalle 8.00 alle 9.00 e dalle 14.30 alle 15.00.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "7.APPARECCHIATURE ELETTRONICHE: A scuola non sono permessi fotocamere, giochi elettronici, ipod, lettori mp3, smartphone, ecc... Queste apparecchiature possono essere introdotte a scuola solo previo accordo con l'insegnante di classe e, in questo caso, vanno depositate in segreteria all'arrivo la mattina prima dell'inizio delle lezioni e possono essere ritirati all'uscita. La prima volta che durante la permanenza nell'ambiente scolastico un alunno verrà trovato in possesso di uno degli oggetti sopra descritti, gli verrà sequestrato e sarà restituito ai genitori; la seconda volta verrà restituito alla fine dell'anno scolastico.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "8.ASSENZA PER MOTIVI DI SALUTE. Gli alunni che per motivi di salute non possano frequentare la scuola, saranno riaccolti in classe con la giustificazione. Le famiglie sono tenute a versare comunque l'intera retta scolastica annuale, anche nel caso di assenze prolungate.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "9.RICEVIMENTO DEI GENITORI: Gli insegnanti incontrano i genitori nelle riunioni di classe e, per i colloqui individuali con gli insegnanti di materia, durante l'orario di ricevimento disponibile in segreteria.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "10.CONTRIBUTO SCOLASTICO ANNUALE. Il contributo scolastico annuale, oltre alla frequenza scolastica, comprende la quota d'iscrizione alla Federazione Italiana delle Scuole Steiner Waldorf in Italia, all'Associazione Veneto Steiner Waldorf, l'assicurazione. Il versamento del contributo scolastico annuale di ogni famiglia rappresenta un impegno responsabile verso la necessità della scuola sulla base della ripartizione dei costi. A questo scopo il Consiglio di Amministrazione della Cooperativa si riserva la facoltà di adeguare le richieste sulla base di un quadro più preciso del numero effettivo di iscritti o in sede di approvazione del bilancio. La retta scolastica annuale, salvo che per l'Asilo, non include il servizio mensa e nemmeno il servizio doposcuola di cui ai successivi punti 12 e 13. Poiché l'intento della Cooperativa è di dare la possibilità di frequentare la scuola anche ai bambini le cui famiglie si trovano in particolari difficoltà economiche, chi ne avesse la necessità può chiedere, attraverso la Segreteria, un colloquio con il CdA che, in base alle disponibilità del ''Fondo Solidarietà'', verificherà la possibilità di un aiuto.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "11.MODALITÀ PAGAMENTO RETTA ANNUALE. Il pagamento della retta annuale può essere effettuato in un'unica soluzione a mezzo bonifico o essere ripartito in 12 (dodici) rate entro il giorno 5 di ogni mese, da settembre ad agosto compresi, tramite mandato per addebito diretto SEPA - SDD Core (Area Unica dei Pagamenti in Euro).";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "12.REGOLARITÀ PAGAMENTI. Salvo diversa intesa concordata con il Consiglio di Amministrazione, non verranno accettate richieste di iscrizione da parte di famiglie non in regola con i pagamenti dell'anno precedente. Il mancato pagamento anche di una sola rata entro 30 giorni dalla relativa scadenza lascia libero il Consiglio di Amministrazione di risolvere il rapporto, rimanendo l'obbligo in capo alla famiglia inadempiente di corrispondere l'importo dell'intero anno scolastico a titolo di risarcimento del danno.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "13.RITIRO ANTICIPATO IN CORSO D'ANNO. Chi desiderasse ritirare definitivamente il proprio/a figlio/a dalla scuola, nel corso dell'anno scolastico, deve comunicarlo per iscritto almeno 30 giorni prima; resta comunque espressamente inteso che sarà tenuto al pagamento dell'intero contributo scolastico annuale.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "14.PIANO OFFERTA FORMATIVA. I genitori/affidatari sono tenuti a conoscere i principi fondamentali del PTOF e del PEI condividendone i contenuti e scegliendoli come percorso scolastico per i propri figli, dando così implicita autorizzazione anche all'utilizzo delle attrezzature e degli strumenti necessari per lo svolgimento delle materie previste nel piano formativo (falegnameria, lavori manuali ecc...). Tali documenti sono esibiti dalla scuola all'atto dell'iscrizione e consultabili in ogni momento presso la Segreteria e sul sito web istituzionale. I genitori/affidatari sono, inoltre, tenuti ad informarsi sull'andamento scolastico e disciplinare dei propri figli, nonché a garantire la propria partecipazione alle riunioni di classe, ai periodici incontri individuali richiesti dagli insegnanti e alle riunioni organizzative fissate dalla scuola, le cui date saranno comunicate con congruo anticipo. Per l'arricchimento del percorso formativo e la realizzazione degli obiettivi della scuola è richiesto che ogni famiglia, compatibilmente con i propri impegni, possa partecipare attivamente alla vita della stessa, anche formulando proposte e pareri.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "15.SERVIZIO MENSA. Le famiglie possono richiedere il servizio mensa per i propri figli come da apposito modulo da sottoscrivere a inizio anno scolastico. il pagamento del servizio avverrà mediante l'acquisto in Segreteria di blocchetti da 10 buoni pasto.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "16.ALLERGIE: All'atto dell'iscrizione, o tempestivamente al momento dell'insorgenza, le famiglie sono tenute a documentare eventuali allergie dei figli mediante produzione di idoneo certificato medico.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "17.ABBIGLIAMENTO: Si invitano insegnanti ed alunni a vestire in maniera consona all'ambiente scolastico.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "18.SERVIZIO DOPOSCUOLA. Alle famiglie che ne fossero interessate, nei giorni di rientro, la scuola offre un servizio di doposcuola a pagamento, come da modulo da sottoscrivere ad inizio anno scolastico. Il servizio consiste in attività extra scolastiche, e non nello svolgimento dei compiti assegnati per casa, e sarà attivato al raggiungimento del numero minimo necessario per la copertura dei relativi costi. L'importo pattuito è annuale, indipendentemente dal numero di presenze del bambino, ferie scolastiche, gite, uscite didattiche, ecc..., può essere pagato in un'unica soluzione o ripartito in 9 rate da ottobre a giugno entro il giorno 5 di ogni mese.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "19.RECESSO UNILATERALE SERVIZIO DOPOSCUOLA. Il Consiglio di Amministrazione si riserva la facoltà di recedere unilateralmente dal servizio doposcuola di cui al punto precedente in qualsiasi momento, senza obbligo di avviso e di restituzione dell'eventuale corrispettivo già anticipato, in caso di inadempimento, agli impegni contenuti nel precedente punto 18 del presente Regolamento. Al verificarsi di tale situazione i genitori saranno esonerati dal versare le rate che abbiano scadenza successiva al momento dell'intervenuto recesso.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "20.ATTIVITÀ POMERIDIANE: Durante la settimana la Scuola propone alcune attività pomeridiane come il doposcuola musicale. Tali attività sono a cura degli insegnanti che direttamente le gestiscono. Solo gli alunni e i genitori coinvolti in queste attività possono sostare negli spazi della Scuola. Durante le attese i bambini e i ragazzi devono comunque essere sorvegliati dai propri genitori.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "21.MALESSERI O INFORTUNI: All'atto dell'iscrizione, oltre ai recapiti telematici, si richiedono necessariamente i recapiti telefonici di reperibilità a cui la scuola può ricorrere in caso di malessere o infortunio dell'alunno. Nel caso in cui non fosse possibile contattare il referente, la scuola si ritiene autorizzata ad adottare i provvedimenti ritenuti più opportuni al fine di tutelare la salute dei bambini, dando i genitori per rato e valido l'operato della scuola medesima.";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

$testo= "22.ACCETTAZIONE DEL REGOLAMENTO. I genitori/affidatari accettano integralmente il presente Regolamento che costituisce parte integrante e sostanziale della domanda di iscrizione alla scuola. L'impegno e la responsabilità individuale nell'osservare queste norme di igiene sociale concorrono al benessere e all'armonia dell'intera comunità scolastica";
$pdf->SetFont($fontdefault,'',10);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,5,$testo);

?>
