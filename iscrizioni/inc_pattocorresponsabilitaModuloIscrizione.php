<?
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
        

?>