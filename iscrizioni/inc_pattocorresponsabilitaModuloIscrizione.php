<?

   	if ($codscuola =='AR') {
        $pdf->AddPage();
        $pdf->SetFont('TitilliumWeb-SemiBold','',16);
        $pdf->Cell(0,8,"PATTO EDUCATIVO DI CORRESPONSABILITA' ".$annoscolastico, 0,1, 'C');
        $pdf->SetFont($fontdefault,'',14);


        $fontsizedefault = 11;
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
        <n>
        Promuovere la corresponsabilità educativa significa riconoscere che l'educazione dei giovani compete tanto all'istituzione, cui essi sono affidati, quanto agli stessi genitori, in un concorso di reciproca responsabilità, al cui raggiungimento contribuiscono un dialogo costante e una profonda condivisione dei valori di riferimento a cui è ispirato il Progetto Educativo-Didattico (PED). Affinché si formi una comunità educante, luogo di cooperazione tra docenti, genitori e studenti, volta a promuovere lo sviluppo armonico delle facoltà del giovane, viene chiesto alle famiglie di prendere visione del PED, che sarà pubblicato nel sito web dell'ente gestore, e di stipulare il seguente patto di corresponsabilità, con il quale:
        </n>
        <h1>
        IL COLLEGIO DOCENTI SI IMPEGNA A
        </h1>
        <bul>Organizzare e gestire le attività in un clima di dialogo e collaborazione che consenta di poter lavorare al meglio alla realizzazione degli obiettivi educativi e culturali del PED;</bul>
        <bul>Favorire attività di coinvolgimento nell'azione educativa delle istituzioni politiche, sociali e culturali del territorio;</bul>
        <bul>Essere disponibile al dialogo con studenti e genitori, favorendo le soluzioni più opportune;</bul>
        <bul>Offrire una formazione culturale qualificata, critica, e aperta alle problematiche del presente;</bul>
        <bul>Valorizzare l'individualità degli studenti promuovendone la crescita personale e culturale, con particolare attenzione sia alle situazioni di difficoltà sia alla presenza di particolari eccellenze;</bul>
        <bul>Favorire l'integrazione, l'accoglienza e il rispetto, adoperandosi per la formazione di esseri umani consapevoli;</bul>
        <bul>Favorire la cooperazione con gli studenti e le famiglie offrendo adeguate occasioni di comunicazione sull'andamento didattico-disciplinare;</bul>
        <bul>Operare una valutazione trasparente e tempestiva, in esplicito riferimento a criteri condivisi in sede di Dipartimento disciplinare e pubblicati nel PED.</bul>

        <h1>
        GLI STUDENTI SI IMPEGNANO A
        </h1>
        <bul>Assolvere con impegno i propri compiti, partecipando in modo attivo e assiduo alle lezioni, osservando la puntualità e collaborando con compagni e docenti;</bul>
        <bul>Rispettare e valorizzare la propria e l'altrui personalità, per crescere come esseri umani liberi, attivi e responsabili;</bul>
        <bul>Maturare la riflessione sul proprio metodo di studio e sul valore della partecipazione attiva;</bul>
        <bul>Affrontare qualsiasi prova con lealtà;</bul>
        <bul>Osservare il Regolamento Scolastico, in particolare per quanto riguarda l'uso dei telefoni cellulari e di altre apparecchiature elettroniche, rispettando le norme della convivenza civile e avendo cura dei materiali didattici e degli ambienti;</bul>
        <bul>Evitare qualsiasi forma di condivisione di commenti irrispettosi, immagini o riprese audio/video che riguardino i compagni e/o attività formative in genere, senza espressa autorizzazione.</bul>

        <h1>
        I GENITORI SI IMPEGNANO A
        </h1>
        <bul>Partecipare in clima di collaborazione costruttiva al Progetto educativo e didattico, nel rispetto delle scelte dei docenti;</bul>
        <bul>Mirare alla coerenza dello stile educativo famigliare con il progetto educativo dell'Istituto;</bul>
        <bul>Promuovere interventi finalizzati al benessere psico-fisico degli alunni, garantendo che il progetto formativo abbia applicazione tanto nella vita scolastica quanto in quella famigliare;</bul>
        <bul>Promuovere la cultura del dialogo ed educare alla cittadinanza attiva prevenendo e contrastando il bullismo e la violenza;</bul>
        <bul>Promuovere stili di vita che prevengano le dipendenze e le patologie comportamentali ad esse correlate;</bul>
        <bul>Facilitare atteggiamenti di apertura, comprensione e rispetto delle diversità;</bul>
        <bul>Educare al rispetto dell'ambiente per una migliore qualità della vita;</bul>
        <bul>Promuovere il corretto utilizzo delle nuove tecnologie nel rispetto delle tappe evolutive degli alunni/figli;</bul>
        <bul>Controllare l'assiduità e la qualità della partecipazione scolastica, educando alla responsabilità e al rispetto di tutti;</bul>
        <bul>Prendere conoscenza del PED, delle iniziative extracurricolari e dei progetti d'Istituto, favorendo la partecipazione degli studenti interessati, al fine di ampliare le possibilità della costruzione di sé.</bul>
        <n>
        Il presente patto di corresponsabilità, elaborato dal Collegio docenti, viene sottoscritto dal Coordinatore didattico e dal Presidente dell'ente gestore e ha validità per tutto il percorso, salvo successive modifiche da concordare tra le parti. Il mancato rispetto del patto comporta la facoltà da parte di entrambe le parti di interrompere il rapporto.
        </n>



     
        ";
        $pdf->WriteTag(0,6,utf8_decode($txt),"","J",0,0);




        $pdf->Ln(8);
        $pdf->SetFont($fontdefault,'',10);
        $pdf->Cell(60,5,"Per la Soc. Coop. ARCA Educazione - Il Presidente",0,0,'C');
        $pdf->Cell(5,5,"",0,0,'C');
        $pdf->Cell(60,5,"Il Coordinatore Didattico",0,0,'C');
        $pdf->Cell(5,5,"",0,0,'C');
        $pdf->Cell(60,5,"Data e luogo",0,1,'C');

        $pdf->SetFont($fontdefault,'',8);
        $pdf->Cell(60,5,"(Nicola Cardi))",0,0,'C');
        $pdf->Cell(5,5,"",0,0,'C');
        $pdf->Cell(60,5,"(Prof. Carlo Gazzola)",0,1,'C');

        $pdf->Ln(4);
        $pdf->SetFont($fontdefault,'',8);
        $pdf->Cell(60,5,"","B",0,'C');
        $pdf->Cell(5,5,"","",0,'C');
        $pdf->Cell(60,5,"","B",0,'C');
        $pdf->Cell(5,5,"","",0,'C');
        $pdf->Cell(60,5,"","B",0,'C');


        $pdf->Ln(16);
        $pdf->SetFont($fontdefault,'',10);
        $pdf->Cell(60,5,"Firma del padre/tutore* (leggibile)",0,0,'C');
        $pdf->Cell(5,5,"",0,0,'C');
        $pdf->Cell(60,5,"Firma della madre/tutrice* (leggibile)",0,0,'C');
        $pdf->Cell(5,5,"",0,0,'C');
        $pdf->Cell(60,5,"L'alunno/a",0,1,'C');

        $pdf->SetFont($fontdefault,'',8);
        $pdf->Cell(60,5,"(* ove presente)",0,0,'C');
        $pdf->Cell(5,5,"",0,0,'C');
        $pdf->Cell(60,5,"(* ove presente)",0,1,'C');

        $pdf->Ln(4);
        $pdf->SetFont($fontdefault,'',8);
        $pdf->Cell(60,5,"","B",0,'C');
        $pdf->Cell(5,5,"","",0,'C');
        $pdf->Cell(60,5,"","B",0,'C');
        $pdf->Cell(5,5,"","",0,'C');
        $pdf->Cell(60,5,"","B",0,'C');
        
        $pdf->Image('../assets/img/Icone/frecciafirmablack.png', $pdf->GetX()-200, $pdf->GetY()-18, 20);
        $pdf->Image('../assets/img/Icone/frecciafirmablack.png', $pdf->GetX()-135, $pdf->GetY()-18, 20);
        $pdf->Image('../assets/img/Icone/frecciafirmablack.png', $pdf->GetX()-60, $pdf->GetY()-18, 20);
        
    }

    if ($codscuola =='PD') {
        $pdf->AddPage();
        $pdf->SetFont('TitilliumWeb-SemiBold','',16);
        $pdf->Cell(0,8,"PATTO EDUCATIVO DI CORRESPONSABILITA' ".$annoscolastico, 0,1, 'C');
        $pdf->SetFont($fontdefault,'',14);


        $fontsizedefault = 11;
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
        <n>La Soc. Coop. Steiner Waldorf Padova ritiene fondamentale che i genitori degli alunni iscritti siano a conoscenza sia dei principi alla base del percorso pedagogico proposto sia dei principi che regolano il corretto funzionamento dell'organismo sociale in cui si trovano come soci della Cooperativa.</n>
        <n>A tal fine, premesso che:</n>
        <bul>''La Cooperativa Sociale non ha scopo di lucro. Essa persegue l'interesse generale della comunità alla promozione umana e all'integrazione sociale dei cittadini...(omissis) (art 3 statuto)''</bul>
        <bul>''La direzione pedagogica è affidata dal Consiglio di Amministrazione al Collegio degli Insegnanti, i quali adottano l'indirizzo pedagogico steineriano, con assoluta libertà ed indipendenza delle scelte di carattere pedagogico'' (art 25 statuto).</bul>
        <n>Si richiede la comprensione e la condivisione da parte dei genitori degli alunni iscritti, di alcuni aspetti fondamentali:</n>
        <bul>del piano di studi e dell'approccio educativo/pedagogico proposto, ispirato al pensiero di Rudolf Steiner.</bul>
        <bul>delle scelte e valutazioni pedagogiche attuate dal Collegio degli Insegnanti in accordo col Medico scolastico.</bul>
        <bul>dell'importanza di una continuità didattico-pedagogica dalla I all'VIII classe, necessaria per uno sviluppo armonico dell'alunno.</bul>
        <bul>dell'importanza di avvicinarsi alla conoscenza e alla comprensione dei principi che sono alla base del pensiero di R. Steiner relativamente all'essere umano nella sua triplice attività di Pensare Sentire e Volere come fondamento della struttura della Scuola Waldorf, in modo tale che all'interno della Scuola intesa come organismo, ciascuno possa trovare il proprio ruolo nella chiarezza e nel rispetto dei compiti che Steiner assegna al Collegio degli Insegnanti, al Consiglio di Amministrazione e ai Genitori, per una sana e corretta partecipazione alla vita della comunità scolastica.</bul>
        <bul>dell'importanza di partecipare, soprattutto nei primi anni, alle conferenze che la Scuola ogni anno propone al fine di comprendere i principi che regolano il percorso pedagogico.</bul>
        <n>Promuovere la corresponsabilità educativa significa riconoscere che l'educazione compete tanto all'istituzione, cui essi sono affidati, quanto agli stessi genitori, in un concorso di reciproca responsabilità, alla cui realizzazione contribuiscono un dialogo costante e una profonda condivisione dei valori di riferimento a cui è ispirato il Piano Triennale dell'offerta formativa (PTOF). Affinché si formi una comunità educante, luogo di cooperazione tra docenti, genitori e studenti, volta a promuovere lo sviluppo armonico delle facoltà del giovane, viene chiesto alle famiglie di prendere visione del PTOF, che sarà pubblicato nel sito web dell'ente gestore, e di stipulare il seguente patto di corresponsabilità, con il quale:</n>
        
        <h1>IL COLLEGIO DOCENTI SI IMPEGNA A</h1>
        <bul>dell'importanza di partecipare, soprattutto nei primi anni, alle conferenze che la Scuola ogni anno propone al fine di comprendere i principi che regolano il percorso pedagogico.</bul>
        <bul>Organizzare e gestire le attività in un clima di dialogo e collaborazione che consenta di poter lavorare al meglio alla realizzazione degli obiettivi educativi e culturali del PTOF;</bul>
        <bul>Favorire attività di coinvolgimento nell'azione educativa delle istituzioni politiche, sociali e culturali del territorio;</bul>
        <bul>Essere disponibile al dialogo con alunni e genitori, favorendo le soluzioni più opportune;</bul>
        <bul>Valorizzare l'individualità degli alunni promuovendone la crescita personale e culturale, ponendo attenzione sia alle situazioni di difficoltà che alla presenza di particolari talenti;</bul>
        <bul>Favorire l'integrazione, l'accoglienza e il rispetto, adoperandosi per la formazione di individui consapevoli;</bul>
        <bul>Favorire l'incontro con gli alunni e le famiglie offrendo adeguate occasioni di comunicazione sull'andamento didattico-disciplinare;</bul>
        <bul>Operare una valutazione trasparente e tempestiva, sulla base dei criteri condivisi in sede di Collegio e pubblicati nel PTOF.</bul>

        <h1>GLI ALUNNI SI IMPEGNANO A</h1>

        <bul>Avere particolare cura degli spazi, degli ambienti e dei materiali scolastici, nel rispetto delle norme della convivenza civile;</bul>
        <bul>Osservare il Regolamento Scolastico, in particolare per quanto riguarda l'uso dei telefoni cellulari e di altre apparecchiature elettroniche.</bul>
        <bul>Evitare qualsiasi forma di condivisione di commenti irrispettosi, immagini o riprese audio/video che riguardino i compagni e/o attività formative in genere.</bul>

        <h1>I GENITORI SI IMPEGNANO A</h1>
        <bul>Partecipare in clima di collaborazione costruttiva al Progetto educativo e didattico, nel rispetto delle valutazioni pedagogiche attuate dal Collegio degli Insegnanti riguardanti sia l'idoneità alla scolarizzazione (valutazione della maturità scolare dell'alunno/a per l'ingresso alla prima classe) sia l'accoglienza di allievi provenienti da scuole esterne.</bul>
        <bul>Seguire e condividere le indicazioni degli insegnanti e del medico scolastico, sempre volte a sostenere un sano ed equilibrato sviluppo dell'alunno. Nell'ambito di tali scelte, nel caso fosse ritenuto necessario, potrebbero essere proposti dei percorsi, individuali o in piccoli gruppi, di euritmia, massaggio ritmico, laboratori artistici. Tali attività sono parte integrante della pedagogia steineriana ed è quindi necessario che i genitori supportino e condividano il percorso pedagogico nella sua completezza, sapendo che, in caso contrario, tale percorso sarebbe mancante di un aspetto fondamentale.</bul>
        <bul>Ricorrere, in caso di specifica richiesta da parte del Collegio, alla consulenza esterna in ambito pedagogico, per una valutazione psico-cognitiva dell'alunno (da effettuarsi presso enti preposti). La più stretta collaborazione tra Famiglia, Collegio degli Insegnanti e Medico Scolastico, sono presupposti fondamentali per poter lavorare al meglio ed eventualmente tutelare, anche con una certificazione, l'alunno, al momento dell'esame di licenza media.</bul>
        <bul>Curare uno stile educativo familiare coerente con il progetto educativo della Scuola;</bul>
        <bul>Promuovere interventi finalizzati al benessere psico-fisico degli alunni, garantendo che il progetto formativo abbia applicazione tanto nella vita scolastica quanto in quella familiare;</bul>

        <bul>Sostenere la cultura del dialogo ed educare alla cittadinanza attiva prevenendo e contrastando il bullismo e la violenza;</bul>
        <bul>Adottare stili di vita che prevengano le dipendenze e le patologie comportamentali ad esse correlate;</bul>
        <bul>Facilitare atteggiamenti di apertura, comprensione e rispetto delle diversità, valorizzando la propria e l'altrui personalità per favorire la crescita di individui liberi, attivi e responsabili.</bul>
        <bul>Educare al rispetto dell'ambiente per una migliore qualità della vita;</bul>
        <bul>Acquisire una sempre maggiore consapevolezza sul corretto utilizzo delle nuove tecnologie nel rispetto delle tappe evolutive degli alunni/figli;</bul>
        <bul>Assicurare l'assiduità e la qualità della partecipazione scolastica, educando alla responsabilità e al rispetto di tutti, alla partecipazione attiva e assidua alle lezioni, alla puntualità e alla collaborazione con compagni e insegnanti;</bul>
        <bul>Portare a coscienza i contenuti del PTOF, le iniziative extracurricolari e i progetti della Scuola;</bul>
        <bul>Contribuire fattivamente e regolarmente alla vita pratica e alla cura dell'ambiente scolastico;</bul>
        <bul>Sostenere attivamente e concretamente la buona economia della Scuola.</bul>

        <n>
        Nella Scuola Sophia Steiner Waldorf di Padova vengono accolte famiglie ed alunni che accettano consapevolmente di convivere rispettando le altrui scelte, siano esse di pensiero, religiose o terapeutiche. Chi chiede di entrare a farne parte è cosciente che questo comporta accogliere responsabilmente posizioni ed orientamenti di segno differenti dai propri, nella reciproca libertà, e si fa carico in ogni circostanza, delle conseguenze di questa presa di responsabilità.
        Il presente patto di corresponsabilità, elaborato dal Collegio docenti, viene sottoscritto dal Coordinatore didattico e dal Presidente dell'ente gestore e ha validità per tutto il percorso, salvo successive modifiche da concordare tra le parti. 
        Il mancato rispetto del patto comporta la facoltà da parte di entrambe le parti di interrompere il rapporto.
        </n>
        ";
        $pdf->WriteTag(0,6,utf8_decode($txt),"","J",0,0);

        $pdf->Ln(8);
        $pdf->SetFont($fontdefault,'',10);
        $pdf->Cell(60,5,"Per la Steiner Waldorf Sophia - Il Presidente",0,0,'C');
        $pdf->Cell(5,5,"",0,0,'C');
        $pdf->Cell(60,5,"Il Coordinatore Didattico",0,0,'C');
        $pdf->Cell(5,5,"",0,0,'C');
        $pdf->Cell(60,5,"Data e luogo",0,1,'C');

        $pdf->SetFont($fontdefault,'',8);
        $pdf->Cell(60,5,"(Enrica Salvatori))",0,0,'C');
        $pdf->Cell(5,5,"",0,0,'C');
        $pdf->Cell(60,5,"(Edith Sagrillo)",0,1,'C');

        $pdf->Ln(4);
        $pdf->SetFont($fontdefault,'',8);
        $pdf->Cell(60,5,"","B",0,'C');
        $pdf->Cell(5,5,"","",0,'C');
        $pdf->Cell(60,5,"","B",0,'C');
        $pdf->Cell(5,5,"","",0,'C');
        $pdf->Cell(60,5,"","B",0,'C');


        $pdf->Ln(16);
        $pdf->SetFont($fontdefault,'',10);
        $pdf->Cell(60,5,"Firma del padre/tutore* (leggibile)",0,0,'C');
        $pdf->Cell(5,5,"",0,0,'C');
        $pdf->Cell(60,5,"Firma della madre/tutrice* (leggibile)",0,0,'C');
        $pdf->Cell(5,5,"",0,1,'C');
        //$pdf->Cell(60,5,"L'alunno/a",0,1,'C');

        $pdf->SetFont($fontdefault,'',8);
        $pdf->Cell(60,5,"(* ove presente)",0,0,'C');
        $pdf->Cell(5,5,"",0,0,'C');
        $pdf->Cell(60,5,"(* ove presente)",0,1,'C');

        $pdf->Ln(4);
        $pdf->SetFont($fontdefault,'',8);
        $pdf->Cell(60,5,"","B",0,'C');
        $pdf->Cell(5,5,"","",0,'C');
        $pdf->Cell(60,5,"","B",0,'C');
        $pdf->Cell(5,5,"","",0,'C');
        //$pdf->Cell(60,5,"","B",0,'C');
        
        $pdf->Image('../assets/img/Icone/frecciafirmablack.png', $pdf->GetX()-200, $pdf->GetY()-18, 20);
        $pdf->Image('../assets/img/Icone/frecciafirmablack.png', $pdf->GetX()-135, $pdf->GetY()-18, 20);
        //$pdf->Image('../assets/img/Icone/frecciafirmablack.png', $pdf->GetX()-60, $pdf->GetY()-18, 20);
        
    }

    if ($codscuola =='VR') {
        //if (1==1) {
        if ($primaosesta) {
            $pdf->AddPage();

            $fontsizedefault = 10;
            $fontsizeminidefault = 8;
            $pdf->SetFont('TitilliumWeb-SemiBold','',16);
            $pdf->Cell(0,8,"PATTO EDUCATIVO DI CORRESPONSABILITA' ".$annoscolastico, 0,1, 'C');
            $pdf->SetFont($fontdefault,'',$fontsizedefault);

            $h = 5;
            $h1 = 5;
            //$testo = "ALUNNO ".strtoupper($nome_alu)." ".strtoupper($cognome_alu)." iscritto al".$classi[$classe_cla];
            //$pdf->Cell(0,$h,$testo, 0,1, 'C');
            $testo = "D.P.R. n. 249 del 24 giugno 1998 e D.P.R. n. 235 del 21 novembre 2007";
            $pdf->Cell(0,$h,$testo, 0,1, 'C');

            $pdf->SetFont($fontdefault,'',$fontsizedefault);

            $testo = "La realizzazione del progetto educativo della nostra scuola, così come la prevenzione dell'insorgere di situazioni di difficoltà, avviene attraverso il dialogo e la partecipazione responsabile di tutte le componenti della comunità scolastica ed è fondata sulla continua ricerca di una sana relazione, collaborazione e sostegno reciproco tra insegnanti e genitori.";
            $pdf->MultiCell(0,$h1,utf8_decode($testo));

            $testo = "La normativa vigente richiamata sopra prevede che all'atto di iscrizione dell'alunno vengano esplicitati ed accolti gli impegni che a tal fine competono ad ogni soggetto attivo nel processo educativo, ivi compresi, nella Scuola Secondaria di 1° grado, gli alunni.";
            $pdf->MultiCell(0,$h1,utf8_decode($testo));

            $testo = "In concordanza con i contenuti del Piano dell'Offerta Formativa (POF), del Progetto Educativo di Istituto (PEI) e del Regolamento,";
            $pdf->MultiCell(0,$h1,utf8_decode($testo));

            $pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
            $testo = " - la scuola, tramite i suoi organi, si impegna a:";
            $pdf->MultiCell(0,$h1,utf8_decode($testo));

            $pdf->SetFont($fontdefault,'',$fontsizedefault);

            $blt['bullet'] = chr(149);
            $blt['margin'] = ' ';
            $blt['indent'] = 4;
            $blt['spacer'] = 0;
            $blt['text'] = array();
            $blt['text'][0] = utf8_decode("far conoscere le proprie proposte educative e didattiche;");
            $blt['text'][1] = utf8_decode("garantire e favorire l'attuazione dell'Offerta Formativa e del Progetto di Istituto, ponendo alunni, genitori, insegnanti, personale non docente e tutti gli adulti attivi nella comunità scolastica nella condizione di esprimere al meglio il proprio ruolo e di poter offrire i propri talenti e le proprie professionalità al servizio dello sviluppo della scuola;");
            $blt['text'][2] = utf8_decode("cogliere i bisogni formativi degli alunni e della comunità in cui opera la scuola, per cercare risposte adeguate;");
            $blt['text'][3] = utf8_decode("garantire a ogni componente della vita scolastica la possibilità di esprimere, valorizzare e sviluppare le proprie potenzialità;");
            $blt['text'][4] = utf8_decode("avere cura dei rapporti sociali tra tutti i soggetti della comunità scolastica, creando occasioni di incontro, dì dialogo e di collaborazione;");
            $blt['text'][5] = utf8_decode("far rispettare le norme di sicurezza;");

            $pdf->MultiCellBltArray(190,$h1,$blt);

            $pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
            $testo = " - gli insegnanti si impegnano a:";
            $pdf->MultiCell(0,$h1,utf8_decode($testo));

            $pdf->SetFont($fontdefault,'',$fontsizedefault);

            $blt['text'] = array();
            $blt['text'][0] = utf8_decode("garantire competenza e professionalità nella realizzazione dell'Offerta Formativa attraverso l'impegno comune e condiviso;");
            $blt['text'][1] = utf8_decode("rispettare l'orario scolastico e garantire la propria presenza all'interno delle classi/sezioni;");
            $blt['text'][2] = utf8_decode("curare l'adeguatezza, la sicurezza e la salubrità degli ambienti scolastici in collaborazione con i genitori;");
            $blt['text'][3] = utf8_decode("predisporre un clima educativo sereno e favorire positive relazioni interpersonali tra alunni ed adulti;");
            $blt['text'][4] = utf8_decode("favorire l'integrazione e l'acquisizione, da parte degli alunni, di una progressiva autonomia e sicurezza nella gestione della propria vita e dei rapporti sociali, ponendo le basi volitive, emotive e cognitive necessarie per una partecipazione consapevole e costruttiva alla vita sociale e culturale;");
            $blt['text'][5] = utf8_decode("cercare strategie utili a rimuovere eventuali situazioni di emarginazione, disagio, difficoltà, demotivazione o scarso impegno;");
            $blt['text'][6] = utf8_decode("promuovere tramite la pedagogia Steiner-Waldorf la motivazione positiva all'apprendimento;");
            $blt['text'][7] = utf8_decode("rendere consapevoli gli alunni delle proprie capacità, dei percorsi da sviluppare e degli obiettivi da raggiungere, destando in loro gradualmente la facoltà dell'autovalutazione;");
            $blt['text'][8] = utf8_decode("verificare i percorsi formativi e didattici elaborati, e valutare i risultati raggiunti dagli alunni, tenendo conto delle capacità e dei processi di sviluppo assolutamente individuali di ogni alunno e valorizzandone le competenze in tutti gli ambiti di apprendimento;");
            $blt['text'][9] = utf8_decode("somministrare, qualora si renda necessario, provvedimenti disciplinari commisurati alla gravità del fatto avvenuto, sempre con finalità educative,tendendo al rafforzamento del senso di responsabilità e al ripristino di rapporti corretti all'interno della comunità scolastica;");
            $blt['text'][10] = utf8_decode("rendere partecipi i genitori del percorso didattico e formativo della classe, attraverso regolari riunioni;");
            $blt['text'][11] = utf8_decode("tenere informate le famiglie, tramite colloqui individuali, in relazione agli apprendimenti e ai comportamenti dei loro figli;");

            $pdf->MultiCellBltArray(190,$h1,$blt);

            $pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
            $testo = " - gli alunni si impegnano a:";
            $pdf->MultiCell(0,$h1,utf8_decode($testo));

            $pdf->SetFont($fontdefault,'',$fontsizedefault);

            $blt['text'] = array();
            $blt['text'][0] = utf8_decode("rispettare le regole convenute dalla comunità scolastica (vedi Regolamento) per lo studio ed il comportamento;");
            $blt['text'][1] = utf8_decode("partecipare alle attività scolastiche in modo attivo e responsabile;");
            $blt['text'][2] = utf8_decode("rispettare tutti gli adulti che si occupano della loro educazione;");
            $blt['text'][3] = utf8_decode("rispettare, accettare ed aiutare i compagni e tutti gli alunni della scuola, anche i più piccoli;");
            $blt['text'][4] = utf8_decode("imparare ad ascoltare per poter accogliere quanto viene impartito durante le lezioni e per poter mettere in pratica i suggerimenti degli insegnanti;");
            $blt['text'][5] = utf8_decode("avere cura dei propri materiali didattici e strumenti di lavoro;");
            $blt['text'][6] = utf8_decode("svolgere i compiti assegnati a casa;");
            $blt['text'][7] = utf8_decode("avere attenzione e cura nell'uso degli spazi, delle strutture, degli arredi e dei cortili esterni e del giardino;");
            $blt['text'][8] = utf8_decode("informare le famiglie sui vari aspetti della vita scolastica e recapitare le comunicazioni;");

            $pdf->MultiCellBltArray(190,$h1,$blt);

            $pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
            $testo = " - i genitori si impegnano a:";
            $pdf->MultiCell(0,$h1,utf8_decode($testo));

            $pdf->SetFont($fontdefault,'',$fontsizedefault);

            $blt['text'] = array();
            $blt['text'][0] = utf8_decode("riconoscere il valore educativo della scuola e conoscerne il Piano dell'Offerta Formativa e il Progetto Educativo di Istituto;");
            $blt['text'][1] = utf8_decode("collaborare con gli insegnanti per favorire lo sviluppo formativo dei propri figli, condividendo atteggiamenti educativi in armonia con quelli della scuola;");
            $blt['text'][2] = utf8_decode("partecipare attivamente al percorso scolastico dei propri figli attraverso la presenza alle riunioni di classe e ai colloqui individuali con gli insegnanti;");
            $blt['text'][3] = utf8_decode("conoscere e rispettare le regole della scuola (vedi Regolamento);");
            $blt['text'][4] = utf8_decode("far frequentare con regolarità i propri figli;");
            $blt['text'][5] = utf8_decode("giustificare le assenze;");
            $blt['text'][6] = utf8_decode("controllare quotidianamente il diario e il libretto personale dell'alunno, ove adottati, e firmare le comunicazioni;");
            $blt['text'][7] = utf8_decode("curare l'adeguatezza, la sicurezza e la salubrità degli ambienti scolastici in collaborazione con gli insegnanti;");
            $blt['text'][8] = utf8_decode("risarcire o riparare eventuali danni provocati dagli alunni;");
            $blt['text'][9] = utf8_decode("collaborare alle iniziative della scuola per la loro realizzazione sul piano operativo;");

            $pdf->MultiCellBltArray(190,$h1,$blt);

            
            $pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
            $testo = " - il personale non docente si impegna a:";
            $pdf->MultiCell(0,$h1,utf8_decode($testo));

            $pdf->SetFont($fontdefault,'',$fontsizedefault);

            $blt['text'] = array();
            $blt['text'][0] = utf8_decode("essere puntuale e svolgere con precisione le mansioni assegnate;");
            $blt['text'][1] = utf8_decode("conoscere l'Offerta Formativa della scuola e collaborare a realizzarla, per quanto di competenza;");
            $blt['text'][2] = utf8_decode("conoscere, rispettare e far rispettare le regole della scuola (vedi Regolamento);");
            $blt['text'][3] = utf8_decode("favorire un clima di collaborazione e rispetto tra tutti i soggetti della comunità scolastica (loro stessi, insegnanti, genitori, alunni);");
            $blt['text'][4] = utf8_decode("segnalare al Collegio Insegnanti e/o al Consiglio Direttivo eventuali problemi rilevati nell'ambito delle proprie funzioni.");

            $pdf->MultiCellBltArray(190,$h1,$blt);

                        //SECONDA PAGINA
                        // $pdf->AddPage();



                        // $pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizeminidefault);

                        // $testo = "SPUNTI E RIFLESSIONI SUL PATTO DI CORRESPONSABILITÀ EDUCATIVA";
                        // $pdf->Cell(0,8,utf8_decode($testo), 0,1, 'C');
                        // $pdf->SetFont($fontdefault,'',$fontsizeminidefault);

                        // $testo = "La normativa (DPR 24 giugno 1998, n. 249, modificato dal DPR n. 235 del 21 novembre 2007-art. 5-bis) prevede che “Contestualmente all'iscrizione alla singola istituzione scolastica, è richiesta la sottoscrizione da parte dei genitori e degli studenti di un Patto educativo di Corresponsabilità, finalizzato a definire in maniera dettagliata e condivisa diritti e doveri nel rapporto tra istituzione scolastica autonoma, studenti e famiglie”.";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));

                        // $testo = "Per le scuole Steiner-Waldorf il patto di corresponsabilità educativa ha anche la valenza, insieme al PTOF, al Progetto Educativo e al regolamento d'Istituto, di evidenziare l'identità della scuola oltre agli aspetti di diritti e doveri dei genitori/allievi/insegnanti.";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));

                        // $testo = "Fra le indicazioni per far fronte all'emergenza sanitaria da SARS-CoV-2 il Piano Scuola prevede l'aggiornamento del “Patto Educativo di Corresponsabilità”, documento di natura contrattuale finalizzato all'assunzione dell'impegno da parte delle famiglie a rispettare le “precondizioni” per la presenza a scuola degli allievi.";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));

                        // $testo = "Anche nel caso del Patto di corresponsabilità educativa, come per tutte le indicazioni riguardo la riapertura delle attività didattiche, la normativa parla sempre di “attività scolastiche, educative e formative in tutte le Istituzioni del Sistema nazionale di Istruzione”. Di tale sistema siamo parte integrante anche noi come scuola Waldorf di Verona.";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));

                        // $testo = "A fronte di una essenzialità del Patto sia dal punto di vista giuridico, sia dal punto di vista sociale, lo vogliamo accompagnare con un documento (Vademecum - protocollo organizzativo) che riprenda la varie voci dei documenti di indirizzo del Ministero all'Istruzione e delle Regioni ma con contenuti coerenti con la pedagogia Steiner- Waldorf. Questo documento può essere esplicitamente richiamato nel patto di corresponsabilità laddove si parla di informazione ai genitori e rispetto delle indicazioni ricevute.";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));

                        // $testo = "L'ente gestore STEINER-WALDORF VERONA COOPERATIVA SOCIALE ONLUS della Scuola Primaria paritaria, Secondaria di primo grado non paritaria e del servizio all'infanzia STEINER WALDORF VERONA nella persona del suo Legale Rappresentante sig.ra DANZI ROSELLA";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));

                        // $pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizeminidefault);
                        // $pdf->Cell(0,8,"STIPULA", 0,1, 'C');

                        // $testo = "il presente Patto di Corresponsabilità circa le misure organizzative, igienico-sanitarie e ai comportamenti individuali volti al contenimento della diffusione del contagio da COVID-19 - A.S. 2023-2024";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));
                        // $pdf->SetFont($fontdefault,'',$fontsizeminidefault);

                        // $testo = "Nella ripartenza delle attività educative (scolastiche) in relazione al contenimento del rischio derivante dalla presenza del Sars-Cov-2, è elemento essenziale l'individuazione e l'applicazione di soluzioni che mettendo al centro il bambino/l'allievo ne perseguano il sano sviluppo e garantiscano alle famiglie la continuità del progetto educativo al quale hanno aderito. In tal senso il patto concerne alla dimensione educativa e alla necessaria connessione tra protocolli di sicurezza e qualità delle esperienze dei bambini.";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));

                        // $testo = "L'alleanza fra gestore, insegnanti e genitori, per la corresponsabilità educativa, sociale ed economica che condividono, gioca un ruolo fondamentale al fine di permettere il normale svolgimento delle attività, incentivare percorsi di salutogenesi all'interno della comunità e garantire il rispetto delle previste condizioni di sicurezza nella reciproca consapevolezza che anche a fronte di tutte le misure adottate, il rischio di contagio non può essere azzerato per la peculiarità delle attività svolte.";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));

                        // $pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizeminidefault);
                        // $testo = " - Il gestore si impegna a:";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));

                        // $pdf->SetFont($fontdefault,'',$fontsizeminidefault);

                        // $blt['text'] = array();
                        // $blt['text'][0] = utf8_decode("Realizzare tutti gli interventi di carattere organizzativo, nei limiti delle proprie competenze e con le risorse a disposizione, nel rispetto della normativa vigente e delle linee guida emanate dal Ministero della Salute e dalle altre autorità competenti, finalizzate alla mitigazione del rischio di diffusione del SARS-CoV-2;");
                        // $blt['text'][1] = utf8_decode("avvalersi di personale adeguatamente formato su tutti gli aspetti riferibili alle vigenti normative e sulle procedure igienico sanitarie di contrasto alla diffusione del contagio;");
                        // $blt['text'][2] = utf8_decode("fornire alle famiglie puntuale informazione, sulle misure organizzative dell'attività e di quanto attivato per contenere la diffusione del contagio e permettere l'ottimale svolgimento delle attività;");
                        // $blt['text'][3] = utf8_decode("comunicare tempestivamente eventuali nuove disposizioni;");
                        // $blt['text'][4] = utf8_decode("coinvolgere le famiglie in un percorso educativo che vede la salute del bambino e del ragazzo in primo piano, sia in senso fisico, sia in senso psichico e volto allo sviluppo di processi di salutogenesi.");

                        // $pdf->MultiCellBltArray(190,$h1,$blt);

                        // $pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizeminidefault);
                        // $testo = " - I sottoscritti genitori si impegnano a:";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));

                        // $pdf->SetFont($fontdefault,'',$fontsizeminidefault);

                        // $blt['text'] = array();
                        // $blt['text'][0] = utf8_decode("rispettare le indicazioni ricevute dall'ente gestore relativamente alle misure organizzative;");
                        // $blt['text'][1] = utf8_decode("trattenere il/la proprio/a figlio/a al domicilio se presenta temperatura corporea superiore ai 37,5 °C e/o altri sintomi riconducibili a sintomatologia sospetta di Covid 19;");
                        // $blt['text'][2] = utf8_decode("quando contattato, recarsi immediatamente a scuola e riprendere il/la proprio/a figlio/a in caso di manifestazione improvvisa di sintomatologia riferibile a COVID-19;");
                        // $blt['text'][3] = utf8_decode("sostenere processi di salutogenesi ovvero attuare azioni che portano forze di salute al bambino quali:");
                        // $pdf->MultiCellBltArray(190,$h1,$blt);

                        // $testo = "- alimentazione corretta, sana ed equilibrata;";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));
                        // $testo = "- rispetto dei ritmi di sonno-veglia in base all'età del bambino/ragazzo;";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));
                        // $testo = "- alimentazione corretta, sana ed equilibrata;";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));
                        // $testo = "- organizzazione ritmica della giornata che veda un giusto tempo dedicato alle attività all'aperto, agli impegni scolastici ed extra scolastici, ecc.";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));
                        // $testo = "- uso sensato della tecnologia, adeguato alla crescita e allo sviluppo delle facoltà fondamentali del bambino.";
                        // $pdf->MultiCell(0,$h1,utf8_decode($testo));



            // $testo = "La realizzazione del progetto educativo della nostra scuola, così come la prevenzione dell'insorgere di situazioni di difficoltà, avviene attraverso il dialogo e la partecipazione responsabile di tutte le componenti della comunità scolastica ed è fondata sulla continua ricerca di una sana relazione, collaborazione e sostegno reciproco tra insegnanti e genitori.";
            // $pdf->MultiCell(0,$h1,utf8_decode($testo))

            // $testo = "";
            // $pdf->MultiCell(0,$h1,utf8_decode($testo));

            $pdf->Ln(25);

            include("firmepadremadreluogo.php");

            $pdf->Ln(5);

            include("firmarappresentantelegale.php");


            //SAREBBE MOLTO PIU' FACILE con WriteTag MA NON SI RIESCE A GOVERNARE LO SPAZIO SALTATO NELL'A CAPO RIGA: NE SALTA TROPPO!
            //MI SEMBRA SALTI "mezza altezza di riga"
            //E NON SI CAPISCE COME RIDURLO
            // $pdf->AddPage();

            // // Stylesheet
            // // $pdf->SetStyle("TAG","FONTTYPE","N/B/I/U o combinazioni","fontsize 10/12/28", "color 0,0,255", "indent", "bullet");
            // $pdf->SetStyleWriteTag("h1",    "TitilliumWeb-SemiBold",    "N",    $fontsizeminidefault,   0, 0);
            // $pdf->SetStyleWriteTag("n",     $fontdefault,               "N",    $fontsizeminidefault,   0, 0);
            // $pdf->SetStyleWriteTag("bu",     "TitilliumWeb-SemiBold",   "U",    $fontsizeminidefault,   0);
            // $pdf->SetStyleWriteTag("b",     "TitilliumWeb-SemiBold",    "N",    $fontsizeminidefault,   0);
            // $pdf->SetStyleWriteTag("a",     $fontdefault,               "BU",   $fontsizeminidefault,   "0,0,255");
            // $pdf->SetStyleWriteTag("bul",   $fontdefault,               "N",    $fontsizeminidefault,   0, 3, chr(149));

            // $txt="
            // <n>La realizzazione del progetto educativo della nostra scuola, così come la prevenzione dell'insorgere di situazioni di difficoltà, avviene attraverso il dialogo e la partecipazione responsabile di tutte le componenti della comunità scolastica ed è fondata sulla continua ricerca di una sana relazione, collaborazione e sostegno reciproco tra insegnanti e genitori.</br>
            // La normativa vigente richiamata sopra prevede che all'atto di iscrizione dell'alunno vengano esplicitati ed accolti gli impegni che a tal fine competono ad ogni soggetto attivo nel processo educativo, ivi compresi, nella Scuola Secondaria di 1° grado, gli alunni.</br>
            // In concordanza con i contenuti del Piano dell'Offerta Formativa (POF), del Progetto Educativo di Istituto (PEI) e del Regolamento,</n>
            // <b>la scuola, tramite i suoi organi, si impegna a:</b></br>
            // <bul>far conoscere le proprie proposte educative e didattiche;</bul>
            // <bul>garantire e favorire l'attuazione dell'Offerta Formativa e del Progetto di Istituto, ponendo alunni, genitori, insegnanti, personale non docente e tutti gli adulti attivi nella comunità scolastica nella condizione di esprimere al meglio il proprio ruolo e di poter offrire i propri talenti e le proprie professionalità al servizio dello sviluppo della scuola;</bul>
            // <bul>cogliere i bisogni formativi degli alunni e della comunità in cui opera la scuola, per cercare risposte adeguate;</bul>
            // <bul>garantire a ogni componente della vita scolastica la possibilità di esprimere, valorizzare e sviluppare le proprie potenzialità;</bul>
            // <bul>avere cura dei rapporti sociali tra tutti i soggetti della comunità scolastica, creando occasioni di incontro, dì dialogo e di collaborazione;</bul>
            // <bul>far rispettare le norme di sicurezza;</bul>
            // <b>gli insegnanti si impegnano a:</b></br>
            // <bul>garantire competenza e professionalità nella realizzazione dell'Offerta Formativa attraverso l'impegno comune e condiviso;</bul>
            // <bul>rispettare l'orario scolastico e garantire la propria presenza all'interno delle classi/sezioni;</bul>
            // <bul>curare l'adeguatezza, la sicurezza e la salubrità degli ambienti scolastici in collaborazione con i genitori;</bul>
            // <bul>predisporre un clima educativo sereno e favorire positive relazioni interpersonali tra alunni ed adulti;</bul>
            // <bul>favorire l'integrazione e l'acquisizione, da parte degli alunni, di una progressiva autonomia e sicurezza nella gestione della propria vita e dei rapporti sociali, ponendo le basi volitive, emotive e cognitive necessarie per una partecipazione consapevole e costruttiva alla vita sociale e culturale;</bul>
            // <bul>cercare strategie utili a rimuovere eventuali situazioni di emarginazione, disagio, difficoltà, demotivazione o scarso impegno;</bul>
            // <bul>promuovere tramite la pedagogia Steiner-Waldorf la motivazione positiva all'apprendimento;</bul>
            // <bul>rendere consapevoli gli alunni delle proprie capacità, dei percorsi da sviluppare e degli obiettivi da raggiungere, destando in loro gradualmente la facoltà dell'autovalutazione;</bul>
            // <bul>verificare i percorsi formativi e didattici elaborati, e valutare i risultati raggiunti dagli alunni, tenendo conto delle capacità e dei processi di sviluppo assolutamente individuali di ogni alunno e valorizzandone le competenze in tutti gli ambiti di apprendimento;</bul>
            // <bul>somministrare, qualora si renda necessario, provvedimenti disciplinari commisurati alla gravità del fatto avvenuto, sempre con finalità educative, tendendo al rafforzamento del senso di responsabilità e al ripristino di rapporti corretti all'interno della comunità scolastica;</bul>
            // <bul>rendere partecipi i genitori del percorso didattico e formativo della classe, attraverso regolari riunioni;</bul>
            // <bul>tenere informate le famiglie, tramite colloqui individuali, in relazione agli apprendimenti e ai comportamenti dei loro figli;</bul>
            // <b>gli alunni si impegnano a:</b></br>
            // <bul>rispettare le regole convenute dalla comunità scolastica (vedi Regolamento) per lo studio ed il comportamento;</bul>
            // <bul>partecipare alle attività scolastiche in modo attivo e responsabile;</bul>
            // <bul>rispettare tutti gli adulti che si occupano della loro educazione;</bul>
            // <bul>rispettare, accettare ed aiutare i compagni e tutti gli alunni della scuola, anche i più piccoli;</bul>
            // <bul>imparare ad ascoltare per poter accogliere quanto viene impartito durante le lezioni e per poter mettere in pratica i suggerimenti degli insegnanti;</bul>
            // <bul>avere cura dei propri materiali didattici e strumenti di lavoro;</bul>
            // <bul>svolgere i compiti assegnati a casa;</bul>
            // <bul>evitare di creare occasione di disturbo, durante le attività sia didattiche sia ricreative;</bul>
            // <bul>avere attenzione e cura nell'uso degli spazi, delle strutture, degli arredi e dei cortili esterni e del giardino;</bul>
            // <bul>informare le famiglie sui vari aspetti della vita scolastica e recapitare le comunicazioni;</bul>
            // <b>i genitori si impegnano a:</b></br>
            // <bul>riconoscere il valore educativo della scuola e conoscerne il Piano dell'Offerta Formativa e il Progetto Educativo di Istituto;</bul>
            // <bul>collaborare con gli insegnanti per favorire lo sviluppo formativo dei propri figli, condividendo atteggiamenti educativi in armonia con quelli della scuola;</bul>
            // <bul>partecipare attivamente al percorso scolastico dei propri figli attraverso la presenza alle riunioni di classe e ai colloqui individuali con gli insegnanti;</bul>
            // <bul>conoscere e rispettare le regole della scuola (vedi Regolamento);</bul>
            // <bul>far frequentare con regolarità i propri figli;</bul>
            // <bul>giustificare le assenze;</bul>
            // <bul>controllare quotidianamente il diario e il libretto personale dell'alunno, ove adottati, e firmare le comunicazioni;</bul>
            // <bul>curare l'adeguatezza, la sicurezza e la salubrità degli ambienti scolastici in collaborazione con gli insegnanti;</bul>
            // <bul>risarcire o riparare eventuali danni provocati dagli alunni;</bul>
            // <bul>collaborare alle iniziative della scuola per la loro realizzazione sul piano operativo;</bul>
            // <b>il personale non docente si impegna a:</b></br>
            // <bul>essere puntuale e svolgere con precisione le mansioni assegnate;</bul>
            // <bul>conoscere l'Offerta Formativa della scuola e collaborare a realizzarla, per quanto di competenza;</bul>
            // <bul>conoscere, rispettare e far rispettare le regole della scuola (vedi Regolamento);</bul>
            // <bul>favorire un clima di collaborazione e rispetto tra tutti i soggetti della comunità scolastica (loro stessi, insegnanti, genitori, alunni);</bul>

            // ";

            // $pdf->WriteTag(0,$h1,utf8_decode($txt),"","J",0,0);
        }
    }

    
?>