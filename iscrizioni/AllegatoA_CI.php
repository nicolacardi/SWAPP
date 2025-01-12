<?//I PRINCIPI PEDAGOGICI DELLA SCUOLA STEINER WALDORF ************************************************************************************************************************************



$pdf->AddPage();
$pdf->SetLink($link2);


$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,8,utf8_decode("ALLEGATO A"), 0,1, 'C');
$pdf->SetFont('TitilliumWeb-SemiBold','',12);
$pdf->Cell(0,6,utf8_decode("I PRINCIPI PEDAGOGICI DELLA SCUOLA STEINER WALDORF"), 0,1, 'C');
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


// Title
$txt="
<h1>
LA PEDAGOGIA STEINER-WALDORF
</h1>
<n>
Attualmente è la pedagogia laica più diffusa al mondo: ad un secolo dalla fondazione della prima scuola Waldorf (Stoccarda, 1919) è ancora oggi in continua espansione in tutti e cinque in continenti. (<a href='https://scuolasteiner-ticino.ch/waldorf-nel-mondo/'>https://scuolasteiner-ticino.ch/waldorf-nel-mondo/</a>).
</n>
<n>
Le scuole Steiner-Waldorf si fondano sulle indicazioni raccolte nelle opere pedagogiche di Rudolf Steiner, nonché sugli importanti approfondimenti elaborati nel corso degli ultimi cent' anni dai pedagoghi e dagli insegnanti che hanno portato avanti il suo impulso (per un riferimento bibliografico, sebbene non esaustivo, si veda <a href='https://www.rudolfsteiner.it/shop/libri/pedagogia/999/'>https://www.rudolfsteiner.it/shop/libri/pedagogia/999/</a> ).
</n>
<n>In estrema sintesi, il punto di partenza di Steiner è una visione dell'essere umano articolato nelle sue <bu>tre facoltà fondamentali: volere, sentire e pensare</bu>. Tali facoltà non sono tutte ugualmente presenti fin dalla nascita, ma si manifestano caratterizzando in modo importante e decisivo le prime tre fasi di sviluppo dell'essere umano, il cui percorso di vita è considerato secondo una suddivisione che procede -grossomodo- per settenni.</n>

- <b>0-7 anni</b><n> è la fascia d'età in cui si manifesta la <b>volontà</b><n>; il bambino piccolo impara a utilizzare principalmente i suoi arti, che permettono l'espressione diretta, immediata e salutare di tale facoltà, la quale è il motore principale dell'apprendimento mediante imitazione: una forza innata che lo spinge a imitare ciò che lo circonda in quanto <bu>''buono''</bu>;
</n>
<n>
- <b>7-14 anni</b> è la fascia d'età in cui si manifesta <b>il sentire</b><n>, facoltà attraverso la quale si coglie il mondo nella misura in cui esso risuona nella sfera dei sentimenti e delle emozioni. Il bambino viene accompagnato dall'educatore a ''intonarsi'' con ciò che è <bu>''bello''</bu><n>. Importantissime in questa fase di sviluppo sono le attività di natura artistica, che diventano il veicolo primario dei contenuti didattici e dell'educazione in generale;
</n>
<n>
- <b>14-21 anni</b> è l'arco di tempo (in linea di massima a partire dalla pubertà) in cui sorgono progressivamente <b>il pensiero astratto</b><n>, quello causale e più in generale le risorse interiori che sostengono la capacità di giudizio. In questa fase l'adolescente realizza di possedere strumenti attraverso i quali è in grado di decodificare e di elaborare i fenomeni del mondo che lo circonda, di farne astrazione e di estrapolare i nessi e le leggi che lo governano, giungendo infine a cogliere il <bu>''vero''</bu>.
</n>
<h1>
STRUMENTI E FINALITÀ EDUCATIVE
</h1>
<n>
Così come indicato da Steiner, l'apprendimento avviene principalmente sotto forma di esperienza, utilizzando la manualità, il movimento, l'arte, il racconto, il confronto diretto con i fenomeni. Tali modalità per avere una reale efficacia non devono essere fisse e prestabilite: la consapevolezza antropologico/pedagogica e la conoscenza della materia devono essere un punto di partenza per un coinvolgimento attivo delle risorse creative dell'insegnante, secondo quella che Steiner stesso definisce ''configurazione artistica dell'insegnamento''.
</n>
<n>
Sulla base delle caratteristiche che le varie fasi di sviluppo presentano, l'insegnante mira quindi a far emergere, attraverso l'atto dell'educare (da ex-ducere, cioè trarre fuori) i talenti e le potenzialità di ogni singolo allievo: l'emergere di tali potenzialità diventa importante anche per la costruzione armonica di ogni gruppo-classe, all'interno del quale gli allievi imparano a conoscersi e relazionarsi a partire dalla piena manifestazione di ognuno.
</n>
<n>
Nel piano di studi le materie sono dunque disposte al fine di sviluppare appieno e in maniera armoniosa le facoltà del volere, del sentire e del pensare, che in età adulta saranno alla base della salute fisica e psichica e della capacità di porsi nel mondo.
</n>
<n>
In conclusione -e sempre sommariamente- i principali obiettivi della pedagogia Steiner-Waldorf sono:
</n>
<bul>
far crescere l'essere umano in modo sano e armonico;
</bul>
<bul>
sviluppare le potenzialità, valorizzando i talenti individuali;
</bul>
<bul>
sviluppare l'attitudine ad imparare in modo attivo dalle esperienze della vita;
</bul>
<bul>
mantenere vivi -attraverso un'esperienza scolastica armoniosa e positiva- curiosità, interesse e amore per i propri simili e per il mondo;
</bul>
<bul>
sviluppare individualità libere da condizionamenti che sappiano mettere a disposizione le proprie capacità per il bene della società;
</bul>
<bul>
saper individuare ed affinare le capacità oggettivamente necessarie per affermarsi come individuo nella società, sempre nel rispetto della propria individualità, degli altri esseri umani e dell'ambiente.
</bul>

<h1>
I PRINCIPI ORGANIZZATIVI DELLA SCUOLA STEINER WALDORF - LA ''TRIARTICOLAZIONE SOCIALE''
</h1>
<n>Secondo la visione di Rudolf Steiner, nell'ambito della vita sociale tre sono i piani principali entro i quali si dispiegano le attività umane: il piano economico, il piano culturale/spirituale ed il piano giuridico-statale (<b>TRIARTICOLAZIONE SOCIALE</b><n>).
</n>
<n>
Sul <bu>piano economico</bu><n> la produzione, la distribuzione, il consumo e la gestione di beni, per svilupparsi in modo sano e produttivo richiedono un'ampia libertà di manovra da parte di tutti i soggetti coinvolti, i quali -per operare con tale necessaria libertà e in armonia tra di loro- devono essere accomunati da uno spirito di <b>fraternità</b><n>.
</n>
<n>
Sul piano <bu>culturale/spirituale</bu><n> le attività che hanno a che fare con le doti specificatamente individuali dell'uomo, le sue capacità inventive, artistiche, culturali (e quindi anche l'insegnamento, l'educazione, la pedagogia) necessitano per esplicarsi di una piena <b>libertà</b><n>.
</n>
<n>
Sul piano <bu>giuridico</bu><n>, necessario all'interno dell'organismo sociale per mediare tra l'aspetto economico e quello culturale\spirituale, il principio fondamentale è <b>l'uguaglianza</b><n>.
</n>
<n>
Tale visione sociale si sviluppa ben al di là di una sua applicazione in ambito pedagogico, e chiaramente all'interno di una comunità scolastica Steiner si individuano con chiarezza questi tre piani e le loro caratteristiche.
</n>
<n>
Sul piano economico i <b>genitori</b><n> costituiscono il sostegno materiale, poiché partecipano concretamente al sostentamento economico e alla vita pratica della scuola. L'insieme dei genitori costituisce il corpo, su cui poggia l'intero ''edificio'' scolastico. Esso deve costituire una base sicura e tranquilla, in modo che amministratori ed insegnanti possano adempiere con serenità alle loro mansioni.
</n>
<n>
Sul piano culturale\spirituale operano gli <b>insegnanti in collaborazione con il medico scolastico</b><n>, riuniti nel <bu>Collegio</bu><n>, i quali, oltre ad occuparsi dei più svariati aspetti dell'attività educativa, mantengono un contatto attivo con i principi che ispirano tutto l'operare della scuola, facendo chiarezza sul cammino da percorrere e sulle sue mete. Al Collegio spetta stabilire quali siano le scelte e gli scenari ideali dal punto di vista pedagogico e dell'identità della scuola: dall'offerta formativa, ai metodi di insegnamento, alla valutazione dei singoli insegnanti e degli allievi, alle attività culturali che la scuola può ospitare e proporre.
</n>
<n>
Per quanto riguarda l'ambito giuridico, se ne occupa il <bu>Consiglio di Amministrazione</bu><n>, formato da <b>genitori, insegnanti e soci</b><n>, eletti dall'Assemblea: esso, oltre a gestire tutto ciò che concerne gli aspetti finanziari, è l'organo di riferimento per le incombenze giuridiche e amministrative della Scuola. Si occupa inoltre delle relazioni tra genitori e insegnanti e con gli organismi regionali e nazionali.
</n>
<n>
Per una sana vita scolastica è vitale che le attività di questi tre organi siano in dialogo armonico ed in equilibrio tra di loro e che ognuno di essi funzioni pienamente, animato dai principi (vedi sopra: fraternità, libertà, uguaglianza) che Steiner indica come fondamentali per i relativi piani di appartenenza.
</n>
<n>
L'esperienza con questo tipo di pedagogia risulta significativa e arricchente anche per i genitori, i quali hanno la possibilità di partecipare in modo importante alla vita della scuola: tale partecipazione -dal punto di vista pedagogico- è una base importantissima per un'azione educativa solida e coerente che la comunità di adulti offre agli allievi di una scuola Waldorf.
</n>
<h1>
FORMAZIONE DEGLI INSEGNANTI E IMPORTANZA DEL LAVORO DEL COLLEGIO
</h1>
<n>
Per essere abilitati all'insegnamento nelle scuole Steiner-Waldorf gli insegnanti devono aver completato un percorso formativo specifico, riconosciuto dalla Federazione delle Scuole Steiner-Waldorf. Esistono diversi corsi di formazione: alcuni, i più diffusi e frequentati, offrono una preparazione a tutto tondo sulla pedagogia e sul piano di studi, altri, più specifici, sono rivolti agli insegnamenti di specifiche materie (musica, lingue straniere, ginnastica Bothmer etc). Un riferimento importante per la formazione è l'Accademia Aldo Bargero di Oriago, da cui proviene il maggior numero di insegnanti delle scuole Steiner-Waldorf del Veneto (<a href='https://www.accademiaaldobargero.com/'>https://www.accademiaaldobargero.com/</a>).
</n>
<n>
Il corso propone un biennio a tempo pieno, oppure -in alternativa- un equivalente triennio che procede con la cadenza di due fine settimana al mese, più un periodo intensivo conclusivo, da svolgersi nel periodo estivo. A fine percorso viene rilasciato un diploma, a fronte della presentazione di una tesi e dello svolgimento completo di un percorso di tirocinio: requisiti necessari per l'abilitazione all'insegnamento. 
</n>
<n>
Durante il percorso formativo, gli insegnamenti impartiti partono da un approfondimento dalle basi antropologiche sulla quale si fonda la pedagogia. Per quanto riguarda la parte pedagogica, accanto all'approfondimento del piano di studi, una parte fondamentale del corso è costituita da una pratica diretta e costantemente approfondita delle diverse esperienze artistiche che vengono proposte agli allievi nelle scuole Waldorf. Altrettanto importante è l'apprendimento delle norme che regolano la vita della scuola, a partire da un approfondimento della triarticolazione sociale sopra menzionata: conoscenze necessarie per entrare a far parte in modo cosciente e attivo di un organismo sociale autoregolato quali sono le nostre scuole. 
</n>
<n>
E' infatti una loro peculiarità che i processi decisionali siano di natura collegiale: il Collegio degli insegnanti si occupa non solo delle necessità di natura didattica e dell'orientamento pedagogico, ma anche di scelte pratiche importanti e delicate come l'individuazione delle figure del corpo docenti. 
</n>
<n>
Il Collegio -come già evidenziato- è il centro culturale/spirituale della scuola. Si incontra ogni settimana ed è formato da tutti gli insegnanti in carica.";
$pdf->WriteTag(0,4,utf8_decode($txt),"","J",0,0);


    
    
        
    






?>
