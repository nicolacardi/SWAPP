<?
//ATTENZIONE: QUESTO COMPARE SIA NEGLI ALLEGATI (come allegato D) sia nel modulo di iscrizione: a rigore questo non va bene

$pdf->AddPage();
$pdf->SetLink($link5);
$pdf->SetFont('TitilliumWeb-SemiBold','',16);
$pdf->Cell(0,8,utf8_decode("ALLEGATO D"), 0,1, 'C');
    


        $pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,"CONDIZIONI ECONOMICHE", 0,1, 'C');
		$pdf->Ln(2);

		$fontsizedefault = 10;
		$interlinea = 4.7;
		$dopoparagrafo = 1;

		$testo= "''Il denaro non è un mezzo malvagio, è anzi un mezzo utile e necessario, 
		ma bisogna compenetrarlo di coscienza, 
		non dormire credendo che se ci sono i soldi è tutto sistemato. 
		Ciò che importa è gestirlo con coscienza, 
		conoscerne la provenienza, la destinazione, 
		così che la direzione interiore non è determinata dal denaro stesso 
		ma dalle persone che lo gestiscono.'' 
		(Jorgen Smit)";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "C");
		$pdf->Ln($dopoparagrafo);

		$testo= "Il Consiglio Unitario Scolastico (C.U.S) si occupa di definire l'importo del contributo di frequenza e d'iscrizione, che vengono determinati e comunicati di anno in anno mediante il modulo di iscrizione e conferma d'iscrizione. Per offrire i servizi dell'Asilo e della Scuola, l'Associazione fruisce delle diverse entrate provenienti da: contributi provinciali, di frequenza, d'iscrizione, dalle iniziative ''Raccolta fondi'', e dalle donazioni ed erogazioni liberali.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, "T", "J");
		$pdf->Ln($dopoparagrafo);

		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$pdf->Cell(0,6,"Iscrizioni e Conferma Iscrizione", 0,1, 'L');

		$testo= "Le iscrizioni vanno presentate nel periodo di gennaio, per permettere all'organo Collegio di programmare le classi ed elaborare l'organico, e comunque non oltre la data definita dal MIUR e dal Dipartimento Istruzione Provincia Autonoma di Trento per le iscrizioni, versando contestualmente la quota d'iscrizione.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "Con l'iscrizione o la conferma d'iscrizione e relativa sottoscrizione dell'accordo economico i genitori si impegnano a versare interamente la quota di frequenza, o quanto concordato nell'accordo economico.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "Il contributo d'iscrizione copre una parte delle spese amministrative, la quota per anno scolastico della Federazione delle Scuole Steiner-Waldorf in Italia, un primo rifornimento di materiale didattico, bloken, cere, stiften, matitoni, quaderni, materiali da pittura, mentre non comprende i flauti, le scarpette per l'euritmia, i grembiuli, la stilografica, libri, (per la scuola).";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "Non è mai previsto il rimborso del contributo d'iscrizione, ed è esclusa la quota associativa.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$pdf->Ln($dopoparagrafo);


		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$pdf->Cell(0,6,utf8_decode("Modalità di pagamento"), 0,1, 'L');

		$testo= "La quota di iscrizione deve essere pagata contestualmente alla consegna dei moduli di iscrizione e conferma.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "Si richiede la massima puntualità nei pagamenti per garantire una responsabile gestione della liquidità dell'Associazione per il pagamento regolare degli stipendi dei maestri e collaboratori e dei fornitori.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "Per il pagamento del contributo di frequenza dell'anno scolastico si prevedono tre modalità:
		-	12 rate mensili da settembre ad agosto;
		-	3 rate con scadenza 15 settembre, 15 dicembre e 15 aprile;
		-	Versamento in un'unica soluzione entro il 15 dicembre.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "Modalità di pagamento diverse potranno essere definite attraverso un colloquio, da svolgersi entro l'iscrizione con l'amministrazione a seguito del quale verrà compilato un accordo economico che andrà allegato all'iscrizione.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$pdf->Ln($dopoparagrafo);

		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$pdf->Cell(0,6,utf8_decode("Difficoltà economiche"), 0,1, 'L');

		$testo= "Nell'ambito della collaborazione e del dialogo che contraddistingue la nostra realtà, il C.U.S. chiede il massimo rispetto nella puntualità dei pagamenti delle rate.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "Per ottimizzare il lavoro della segreteria amministrativa si richiede di segnalare sempre e tempestivamente, i ritardi nei pagamenti e le eventuali difficoltà economiche per poter avviare con l'amministrazione possibili soluzioni.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$pdf->Ln($dopoparagrafo);

		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$pdf->Cell(0,6,utf8_decode("Mancato pagamento"), 0,1, 'L');

		$testo= "In caso di mancato assolvimento delle rate, il C.U.S. si riserva di valutare la situazione e potrà decidere di non accettare l'iscrizione per l'anno scolastico successivo.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$pdf->Ln($dopoparagrafo);

		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$pdf->Cell(0,6,utf8_decode("Ritiro Anticipato"), 0,1, 'L');

		$testo= "Il pagamento della quota di frequenza rimane invariato anche nei casi di ritiro dalla scuola o dall'asilo prima della conclusione dell'anno scolastico salvo che il ritiro avvenga prima del 31 dicembre dell'anno scolastico di riferimento. In quest'ultimo caso è prevista una riduzione della quota di frequenza del 50%.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$pdf->Ln($dopoparagrafo);

		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$pdf->Cell(0,6,utf8_decode("Iscrizione tardiva"), 0,1, 'L');

		$testo= "Nel caso di iscrizione ad anno scolastico già avviato, attraverso un colloquio con l'amministrazione può essere definito un contributo di frequenza ridotto (indicativamente proporzionato al periodo di iscrizione al servizio).";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "L'allievo verrà ammesso, per ragioni di assicurazione e di sicurezza, solo dopo il completamento delle pratiche amministrative e la consegna in segreteria del modulo di iscrizione, del nulla-osta, e della ricevuta del versamento dell'iscrizione.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$pdf->Ln($dopoparagrafo);

		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$pdf->Cell(0,6,utf8_decode("Assegni di Studio"), 0,1, 'L');

		$testo= "La Provincia prevede la concessione di assegni di studio agli studenti frequentanti le scuole paritarie di cui all'articolo 76 della legge provinciale 7 agosto 2006, n.5.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "La segreteria informa e invita tutti i genitori a fissare un appuntamento per poter inserire la domanda dell'assegno, indicativamente entro il mese di dicembre. Nel mese di aprile solitamente viene emanata la determina della PAT per la concessione degli assegni di studio per l'anno in corso. Viene quindi data comunicazione alla famiglia per poter decurtare l'importo dell'assegno dalla quota di aprile, provvedere ad un pari rimborso delle quote già versate se la quota è stata versata per intero o in altro modo concordato con la famiglia. Al momento della domanda si richiede di indicare il genitore al quale dovrà essere riconosciuto l'assegno e un conto corrente su cui poter eventualmente versare l'importo.		";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$pdf->Ln($dopoparagrafo);

		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$pdf->Cell(0,6,utf8_decode("Principio di Solidarietà"), 0,1, 'L');

		$testo= "Lo Statuto dell'Associazione prevede il principio di solidarietà economica. In base a tale principio le famiglie che non riescono a sostenere l'intera quota di frequenza possono chiedere, attraverso un colloquio, di accedere al Fondo Aiuto Famiglie (F.A.F). ";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "Annualmente il C.U.S. delibera un importo destinato al F.A.F. nel bilancio annuale. Il F.A.F. potrà essere incrementato attraverso iniziative di ''raccolta fondi'' o donazioni specifiche.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "Per l'accesso al contributo F.A.F.  il C.U.S. stabilisce dei criteri: 
		-	partecipare attivamente ai gruppi per le iniziative di ''raccolta fondi'' promosse dall'organo dei genitori attivi, 
		-	possedere i requisiti necessari per l'ottenimento del 100% dell'assegno di studio provinciale;";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$testo= "Il C.U.S. si riserva di valutare eventuali situazioni molto particolari o di emergenza. La definizione degli importi verrà stabilita con colloquio e riportata nell'accordo economico.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$pdf->Ln($dopoparagrafo);

		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$pdf->Cell(0,6,utf8_decode("Medico scolastico ed euritmia individuale"), 0,1, 'L');

		$testo= "La pedagogia Steiner-Waldorf prevede la presenza del medico scolastico e l'euritmia individuale, come sostegno all'attività dei maestri e degli alunni. A carico dell'associazione le classi di asilo e scuola possono beneficiare della presenza del medico scolastico così come delle visite previste per la maturità scolare per l'accesso alla prima classe. In base alla situazione in classe, il medico potrà richiedere una visita individuale per l'allievo, sarà cura del maestro di classe informare la famiglia e invitarla a fissare l'appuntamento.  Inoltre, il medico scolastico potrà prevedere un percorso di euritmia individuale. Per gli allievi che beneficiano del sostegno in pedagogia dinamica le visite con il medico scolastico sono minimo 2 annuali oltre a 2 cicli di euritmia individuale. La prestazione del medico scolastico per le visite individuali è a carico della famiglia e dovrà essere pagata al medico direttamente al momento della visita. Per i cicli di euritmia individuale viene richiesto un contributo mentre il restante costo rimane a carico della scuola, tale contributo viene definito annualmente con delibera del C.U.S. 
		Il contributo per Euritmia Individuale verrà comunicato dalla segreteria, secondo modalità sostenute anche dal collegio dei maestri, e potrà essere versata sia in contanti, pos o bonifico.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$pdf->Ln($dopoparagrafo);

		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$pdf->Cell(0,6,utf8_decode("Servizi facoltativi"), 0,1, 'L');

		$testo= "I servizi aggiuntivi facoltativi, (pomeriggi facoltativi scolastici, pomeriggi in asilo, corsi, seminari...) devono essere pagati anticipatamente e secondo la modalità prevista nel progetto del servizio.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "J");
		$pdf->Ln($dopoparagrafo);

?>
