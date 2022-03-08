<?
//***********************************INSEGNANTI E GENITORI - INSIEME PER IL DONO DELL'EDUCAZIONE *********************************/

include_once("iscrizioni/diciture.php");

//$_SESSION['annopreiscrizione_fam'] = $annopreiscrizione_fam;

$pdf->AddPage();
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,utf8_decode("Anno scolastico ".$_SESSION['annopreiscrizione_fam']), 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$pdf->Cell(0,10,utf8_decode("INSEGNANTI E GENITORI - INSIEME PER IL DONO DELL'EDUCAZIONE"), 0,1, 'C');

$fontsizedefault = 9;
$interlinea = 4.6;


$testo="

Nata nel 1991 dalla libera iniziativa di un gruppo di persone che ha deciso di far vivere l'esperienza pedagogica che fonda le sue basi nella concezione dell'essere umano proposta da Rudolf Steiner, l'esistenza della nostra scuola e' resa possibile non solo dalle qualita' pedagogiche e didattiche dei docenti, ma anche grazie all'entusiasmo, alla responsabilita', alla laboriosita' e al volontariato dei genitori e sostenitori che scelgono questa scuola per i propri figli.

La scuola e' gestita da un ente senza fini di lucro, la Cooperativa Sociale Aurora; tutti i costi di gestione devono trovare copertura attraverso quote scolastiche, donazioni o sponsorizzazioni e altri contributi. Non si tratta semplicemente di pagare un servizio, ma piuttosto di rendere possibile e sana, anche per quanto riguarda il denaro, un'esperienza che trova invece nella ''donazione'' la sua qualita' piu' peculiare: i genitori donano alla scuola affinche' gli insegnanti possano donare la propria opera e in futuro i bambini potranno donare al mondo tutti i propri talenti liberamente sviluppati.

L'Associazione Pedagogica Aurora (associazione di Promozione Sociale) e' formata da tutti i genitori degli alunni che frequentano la scuola (e' richiesto almeno un genitore per famiglia), nonche' da sostenitori e amici; la stessa offre un aiuto fondamentale per la gestione e il contenimento delle spese che si concretizza nella vita della scuola attraverso varie forme di volontariato come ad esempio la collaborazione nella gestione della mensa, delle pulizie, delle piccole manutenzioni, delle attivita' artigianali per i mercatini promossi per la raccolta fondi a sostegno delle attivita' della scuola.

In questo spirito, nella nostra scuola, cosi' come e' nell'ideale delle Scuole Steiner Waldorf, viene promossa all'interno della comunita' scolastica la ''solidarieta' economica'', per permettere anche ai figli di famiglie poco abbienti di poterla frequentare. Saranno la generosita' di chi ha mezzi maggiori e la capacita' di concepire altre fonti di entrata per la scuola a rendere possibile tutto cio'.
Gli aspetti economici sono solo un elemento, per quanto importante, della vita sociale di una scuola.

Le ''occasioni di incontro'' sono numerose (laboratori di lavoro, conferenze, assemblee, gruppi di studio e feste) e chi lo vuole puo' trovare in esse un'opportunita' in cui il bene superiore dell'educazione dei piccoli aiuta anche i grandi a dare il meglio di se'.

Le opportunita' di scambio e collaborazione tra insegnanti e genitori sono numerose e intense. Si cerca di costruire insieme una 'comunita'' in cui i bambini possano trovare le migliori condizioni di crescita.
";

$pdf->SetFont($fontdefault,'',$fontsizedefault);
$pdf->MultiCell(0,$interlinea,$testo);
//$pdf->WriteTag(0,10,$testo,1,"J");   //larghezza, interlinea, testo, bordo, J/L/R/C allineamento, fill, padding




//***********************************PRINCIPI - OBIETTIVI - ORGANIZZAZIONE *********************************/

$pdf->AddPage();
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,utf8_decode("Anno scolastico ".$_SESSION['annopreiscrizione_fam']), 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$pdf->Cell(0,10,utf8_decode("PRINCIPI - OBIETTIVI - ORGANIZZAZIONE"), 0,1, 'C');

$fontsizedefault = 9;
$interlinea = 4.2;

$testo= "Questo documento ha lo scopo di presentare la scuola Steiner Waldorf ''Aurora'' nei suoi principi pedagogici formativi e l'organizzazione su cui si basa per il suo funzionamento.

";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "Una pedagogia che promuove l'essere umano:";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "L'obiettivo dell'arte educativa nelle scuole Rudolf Steiner e' accompagnare l'essere umano durante l'infanzia e la gioventu' in modo che possa sviluppare al meglio i suoi talenti.
Piano di studi e insegnamento sono basati su dati di fatto dello sviluppo dell'uomo inteso come essere corporeo, animico e spirituale. Base dell'attivita' pedagogica e' quindi lo studio dell'essere umano il cui approccio metodico risale a Rudolf Steiner.
La scuola comprende l'asilo e il ciclo ad indirizzo generale, dalla prima alla ottava classe. La promozione delle qualita' animiche, della fantasia e della forza di volonta' si associa parimenti all'insegnamento concettuale e di osservazione. Vengono sviluppate tanto le capacita' individuali quanto la socialita' nella classe e nella comunita' scolastica. Si cerca di evitare una specializzazione precoce per non esaurire gia' nell'infanzia le immense possibilita' dell'essere umano. Quindi si rinuncia alla selezione e si applica in tutte le fasce d'eta' un insieme di insegnamento intellettuale, artistico e manuale-pratico.

";
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo="Le Scuole Rudolf Steiner:";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "La pedagogia secondo Rudolf Steiner e' la fonte di un movimento scolastico che viene realizzato in tutto il mondo in oltre 1500 scuole Rudolf Steiner o Waldorf. Questo metodo puo' essere applicato anche in scuole statali; in alcune (scuole europee), cio' avviene da tempo. In Italia esistono circa trenta scuole Steiner/Waldorf con strutture scolastiche individualmente differenziate. Le scuole nascono dall'impulso di genitori e vivono del sostegno economico di tutti coloro che vi partecipano (genitori e sostenitori).
Ogni scuola e' autonoma e costituisce una libera comunita' scolastica, integrata individualmente nel suo ambito culturale, giuridico ed economico. L'obbiettivo comune e' la vera formazione dell'essere umano. Le singole scuole collaborano tra di loro a livello regionale, nazionale e internazionale.
Molte scuole Steiner in tutto il mondo hanno realizzato, in piu' di cent'anni i numerosi impulsi pedagogici e sociali di Rudolf Steiner (1861 -1925). Le molteplici indicazioni legate ad una concezione di formazione scolastica per i giovani, sono state da allora, ulteriormente sviluppate.
Nelle nostre scuole materne e nelle classi elementari e medie (1a e 8a classe) si nutre l'anima del bambino e del fanciullo con quanto riceve dagli insegnanti.
Primo settennio: Un mondo buono da imitare. Nel primo settennio il bambino impara a camminare, a parlare, a pensare e a dire ''io'' a se stesso. Senza l'esempio di altri uomini da imitare il bambino non imparerebbe a crescere nel modo giusto.
Secondo settennio: Un mondo bello da sperimentare. Nel secondo settennio il bambino ricerca il rapporto con il mondo e con chi lo abita; acquista quindi importanza l'educazione dei sentimenti attraverso l'esperienza del bello. Il maestro come autorita' amata diventa la porta che si affaccia sul mondo, in una relazione che mutera' di pari passo ai mutamenti del bambino.
Terzo settennio: Un mondo vero da conoscere. Alle soglie della puberta' il ragazzo manifesta nuovi bisogni di conoscenza e di relazione. I suoi pensieri e le sue esperienze lo orientano verso cio' che gli appare come un ideale da raggiungere: il sapere dell'insegnante, la chiarezza del pensatore e l'opera, la capacita' creativa dell'artista.

";
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "Finanziamento:";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "La ''Scuola Steiner Waldorf Aurora'' non persegue scopi di lucro ed e' riconosciuta di pubblica utilita'. Il finanziamento della scuola avviene tramite:
- contributi economici richiesti ai genitori (pagamento retta);
- donazioni e contributi liberi da sostenitori (genitori di ex-allievi, enti e realta' economiche);
- ricavo dei mercatini e feste dell'Associazione (Bazar Natale e Festa di Primavera);
- ricavo delle possibili iniziative svolte da genitori, docenti e sostenitori della Scuola;
- contributi statali e regionali per la scuola materna paritaria (cifra da confermare ogni anno).
Il C.d.A. della scuola definisce annualmente un contributo economico che varia a seconda della classe frequentata. Coloro che non sono in grado di sostenere il pagamento del contributo economico richiesto, dovranno rivolgersi al ''Fondo Solidarieta' Famiglie''. Ogni anno verra' valutata la possibilita' di incontrare le richieste in base alla disponibilita' del fondo.
Eventuali contributi economici necessari a coprire interventi mirati di Supporto Didattico o di Pedagogia Curativa svolti in aggiunta o in sostituzione della normale attivita' curricolare prevista dal vigente Piano di Studi, dovranno essere corrisposti in aggiunta al contribuito base richiesto per la regolare frequenza scolastica.
Tipologia, durata e aspetti economici relativi a detti interventi saranno concordati con i responsabili Pedagogici ed amministrativi. Nessun intervento potra' attuarsi se non con accordo preventivo con le famiglie.
";
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);



//REGOLAMENTO INTERNO ************************************************************************************************************************************
$pdf->AddPage();
$pdf->SetLink($link3);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,10,utf8_decode("ALLEGATO B"), 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',14);
$pdf->Cell(0,10,utf8_decode("REGOLAMENTO INTERNO SCUOLA AURORA"), 0,1, 'C');
$fontsizedefault = 9;
$interlinea = 4.6;
$testo= "Quando gli alunni vengono a scuola hanno la possibilita' di sperimentare anche molti aspetti della vita sociale e, quindi, per favorire il dialogo, la collaborazione, il confronto, l'apertura agli altri, il rispetto reciproco e degli ambienti, e' opportuno che tutti si adeguino a norme di comportamento comune.";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "Il presente regolamento si applica sul calendario e sugli orari in vigore e comunicati all'inizio dell'anno scolastico.

";
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "ORARI:";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "- L'apertura e' alle ore 07,45 per accogliere in cortile tutti gli alunni. Si entra dal portoncino laterale affacciato sul parcheggio. 
Classi 6,7,8 entrata ore 7,50 - inizio lezioni ore 8,00
Classi 1,2,3,4,5 entrata ore 8,05 - inizio lezioni 8,15 
Scuola dell'infanzia entrata ore 8,20 - per chi arriva con i fratelli o arriva prima per necessità lavorative dei genitori, l'insegnante sarà presente dalle 7,50.
- Il portoncino viene chiuso alle ore 09,00. 
- La puntualita' e' segno di maturita' sociale e di rispetto, quindi e' opportuno essere presenti 'insieme' fin dall'inizio della giornata.";
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo="(Per chi arriva in ritardo e' obbligatorio il permesso di entrata in ritardo).";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "- E' richiesta la puntualita' anche al termine delle lezioni; i bambini della scuola dell'infanzia escono dalle 14.30 alle 14.40; 
Classi 1, 2, 3 e 4 alle 14.40 - i bambini saranno accompagnati dagli insegnanti nelle aree assegnate; 
Classi 5, 6, 7 e 8 alle 14.50
Classi 6,7 e 8 martedì e venerdì 15.40. La scuola viene chiusa alle ore 15.15.
Il martedì e venerdì rimane aperto dalle 15.40 fino alle 16.10 esclusivamente per i ragazzi che hanno il rientro. La scuola declina ogni responsabilita' nei riguardi degli alunni/e che dovessero essere ancora presenti all'interno dei locali scolastici o in giardino oltre tali orari. 
Nel caso in cui una famiglia richieda un orario di entrata e/o di uscita permanente diverso da quello in corso deve presentare al Collegio e, per conoscenza, anche al C.d.A, una richiesta scritta citando le motivazioni. Il Collegio valutera' la compatibilita' con il percorso pedagogico.

";
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "COME:";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "- Per le prime classi e' necessario il grembiule, per le altre si rimanda alla discrezione dell'insegnante.
- E' comunque consigliabile un abbigliamento sobrio e sano.
- Per le classi e' necessario disporre di un paio di scarpe preferibilmente traspiranti pulite da utilizzare all'interno della scuola.

";
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "COMPORTAMENTO:";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "- Le assenze devono sempre essere comunicate alla segreteria. Al rientro è necessario presentare la giustificazione attraverso il libretto personale; per le materne, le assenze per malattia vanno giustificate con autocertificazione.
Per le classi, le assenze per malattia superiori ai 5 giorni vanno giustificate con certificato medico o autocertificazione.
Per casi di pediculosi è necessario certificato medico oppure autocertificazione.
- Durante le lezioni non e' consentito uscire dalla scuola se non in caso di reali necessita' e previa autorizzazione dell'insegnante (obbligatorio il permesso d'uscita anticipata). Il prelievo e accompagnamento deve avvenire da parte di un genitore o persona da lui delegata.
- E' consentito portare a scuola solo il materiale didattico e per questo viene richiesta la collaborazione e la sorveglianza della famiglia.
- Non e' consentito agli alunni di portare il cellulare, lettore mp3, smart watch o altri strumenti multimediali in classe e nelle uscite didattiche";
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo = "(sara' prelevato dagli insegnanti e consegnato ai genitori); sara' dato il permesso solo per necessita' concordate preventivamente tra insegnante e famiglia.";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo = "- L'uso del telefono della scuola e' consentito solo per comunicazioni che sono effettuate esclusivamente dall'insegnante o dalla segreteria.
- Nella scuola ogni alunno ha cura del banco, dell'aula, dei servizi e di tutti gli oggetti e spazi comuni; evita quindi di danneggiare qualsiasi cosa, provvede a mantenere in ordine e puliti il giardino e l'aula, riponendo i rifiuti negli appositi cestini (per eventuali danni causati volontariamente sara' richiesto il risarcimento).

";
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo= "PER I GENITORI:";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo = "- Al mattino e' necessario utilizzare velocemente il parcheggio, poiche' non vi e' la capienza necessaria per tutta l'utenza scolastica.
- Gli alunni delle classi elementari, al termine delle lezioni, vengono accompagnati in giardino dall'insegnante di classe; i genitori attendono in giardino, salvo pioggia.
- La Segreteria chiude alle ore 14,30, per consentire le operazioni di chiusura.
- In atrio deve essere mantenuto un tono di voce moderato per consentire lo svolgimento delle lezioni.
- All'interno degli ambienti scolastici non e' consentito fumare.
- Si invitano i genitori a limitare l'uso dei cellulari all'interno delle pertinenze scolastiche.
";
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);
$pdf->Ln(4);

$testo= "Ulteriori specifiche indicazioni di comportamento per gli alunni delle classi 5^- 6^-7^- 8^";
$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);

$testo="In riferimento a quanto scritto nel regolamento di istituto, gli insegnanti delle classi 5^- 6^-7^- 8^ intendono precisare alcune regole per gli studenti di questa fascia di età, al fine di evitare fraintendimenti durante l'anno.
Pertanto viene richiesto che:
- gli alunni non vengano a scuola con smalto e trucco;
- gli indumenti non abbiano immagini volgari o simboli mortiferi (per esempio: teschi);
- le maglie coprano il busto per intero;
- pantaloncini e gonne non siano succinti;
- vengano evitate canottiere con la bretella stretta;
- non portino a scuola e nelle uscite didattiche dispositivi digitali di vario genere, inclusi gli smart-watch (fatto salvo accordi particolari con i maestri);
- evidenziatori, pennarelli e penne colorate non vengano usate e portate a scuola, salvo particolari accordi con i maestri.";
$pdf->SetFont($fontdefault,'',$fontsizedefault);
$testo = utf8_decode($testo);
$pdf->MultiCell(0,$interlinea,$testo);



?>
