<?$codscuola = $_SESSION['codscuola'];

switch ($codscuola) {
    case 'AR':
        $nickscuola = "Scuola Arca";
        $shortnameScuola = "Arca";
        $citta= "Padova";
        $li= "Padova";
        $nomescuola = "Iniziativa ARCA Padova";
        $nomecittascuola = "Iniziativa ARCA di Padova - programma di supporto alla didattica";
        $footerpagella = "Percorso Educativo ADRIANO OLIVETTI - ARCA EDUCAZIONE Cooperativa sociale";
        $indirizzoscuola = "Via T.Aspetti 248 - Padova - PD";
        $indirizzocompletoscuola= "Via T.Aspetti, 248 - 35133 - Padova - tel.346 2245653 - segreteria@arcascuola.it";
        $datiscuola = "C.F. e P.IVA 05484330286 - iscrizione albo nazionale società cooperative n° C138857";
        $cfscuola = "05484330286";
        $ragionesocialescuola = "Cooperativa Sociale ARCA Educazione";
        $titolaretrattamentoTitolo = "il presidente pro-tempore di ARCA Educazione Cooperativa Sociale";
        $titolaretrattamento = "Nicola cardi";
        $linkPTOF = "https://www.arcascuola.it/img/PEDprimobiennio-LES.pdf";
        $scadpagamenti ="entro il giorno 5 di ciascun mese";
        $quotaiscrizione = "50 per ciascun/a alunno/a iscritto/a";
        $scadrientromodulo = "30/01/";                  
        $scadrientromodulolett = "30 gennaio ";       
        $scadiscrizione = "30/01/";                   
        $scadiscrizionelett = "30 gennaio ";        
        $scadfrase1 = "";
        $scadfrase2 = "sottoscriverli dove indicato e consegnarli in Segreteria <br>entro la scadenza del ";
        $scadrataunicaDDMM = "30/09/";
        $scadrataunica = "30 settembre";
        $scad3rate = "---";
        $scadrata1trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata2trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata3trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata2duerate ="10/02/";
        $scad2rate = "10 Settembre + 10 Febbraio";
        $scadrata1duerate ="10/09/";
        $scadrata2duerate ="10/02/";
        $formagiuridica = "cooperativa";
        $emailscuola= "segreteria@arcascuola.it";
        $emailamministrazionescuola= "segreteria@arcascuola.it ";


        $swapp = "www.arcascuola.it/swapp";
        $fraseAllegatoC= "le norme igienico sanitarie";
        $fraseAllegatoCALL= "NORME IGIENICO SANITARIE";
        $titoloPagColonnaVoti = "Giudizio Descrittivo";

        //per pagelle
        $TipoVoto = "Livello di Apprendimento";
        $codIdentificativo = "XXXXXXXXXXXXXXXXX";

        //per richiesta adesione socio
        $intestazione1 = "Cooperativa Sociale";
        $intestazione2 = "ARCA Educazione";

        $titolocontratto = "CONTRATTO DI PRESTAZIONE DI SUPPORTO ALLA DIDATTICA";
        $titoloiscrizione = "DOMANDA DI ADESIONE";
        $sottotitoloiscrizione = "ai servizi educativi della ".$ragionesocialescuola;
        $titolorichiesta= "L'ADESIONE AI SERVIZI EDUCATIVI";


        $testoarticolomensa = "";

        $modalitaPagSDD = "con mandato per addebito diretto SEPA-SDD Core (ex RID)";
        $modalitaPagBonifico = "con bonifico";
        $POF_PTOF_PSD = "PED"; //Piano di supporto alla didattica
        $POF_PTOF_PSDext = "Progetto Educativo-Didattico";
        $istituzione_supporto =" programma di supporto alla didattica ";

        $sottoTitoloDocValutazione = "";

        $attestazioneAmmissione = false;
        break;

    case 'PD':
        $nickscuola = "Scuola Waldorf PD";
        $shortnameScuola = "Sophia";
        $citta= "Padova";
        $li= "Padova";
        $nomescuola = "Scuola Waldorf Sophia Padova";
        $nomecittascuola = "Scuola Waldorf Sophia di Padova";
        $footerpagella = "";

        $indirizzoscuola = "Via Retrone 20 - Padova - PD";
        $indirizzocompletoscuola= "Via Retrone, 20 - 35135 - Padova - tel.049/61.95.10 - fax 049/88.94.39 - segreteria@waldorfpadova.it";
        $datiscuola = "C.F. 92106210286 - P.IVA 03577600285 - c.c.i.a.a. n. 416913 iscrizione albo nazionale società cooperative n° A23118";
        $cfscuola = "92106210286";
        $ragionesocialescuola = "Soc. Coop. Steiner Waldorf Padova";
        $titolaretrattamentoTitolo = "il presidente pro-tempore della Società Cooperativa Sociale Steiner Waldorf Padova";
        $titolaretrattamento = "Enrica Salvatori";
        $linkPTOF = "https://www.waldorfpadova.it/cms/wp-content/uploads/2023/01/PTOF-SCUOLA-WALDORF-SOPHIA-ANNI-2022-2025.pdf";
        $scadpagamenti ="entro il giorno 5 di ciascun mese";
        $quotaiscrizione = "85 per ciascun/a figlio/a iscritto/a";
        $scadrientromodulo = "28/01/";
        $scadrientromodulolett = "28 gennaio ";
        $scadiscrizione = "28/01/";
        $scadiscrizionelett = "28 gennaio ";
        $scadfrase1 = "";
        $scadfrase2 = "sottoscriverli dove indicato e consegnarli in Segreteria <br>entro la scadenza del ";
        $scadrataunicaDDMM = "30/09/";
        $scadrataunica = "30 settembre";
        $scad3rate = "---";
        $scadrata1trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata2trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata3trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scad2rate = "---";
        $scadrata1duerate ="---/";
        $scadrata2duerate ="---";
        $formagiuridica = "cooperativa";
        $emailscuola= "segreteria@waldorfpadova.edu.it";
        $emailamministrazionescuola= "segreteria@waldorfpadova.edu.it ";


        $swapp = "www.steinerwaldorfpadova.it";
        $fraseAllegatoC= "l Regolamento Pediatrico";
        $fraseAllegatoCALL= "REGOLAMENTO PEDIATRICO";

        $titoloPagColonnaVoti = "Giudizio Descrittivo";

        //per pagelle
        $TipoVoto = "Livello di Apprendimento";
        $codIdentificativo = "XXXXXXXXXXXXXXXXX";

        //per richiesta adesione socio
        $intestazione1 = "Società Cooperativa Sociale";
        $intestazione2 = "Steiner Waldorf Padova";

        $titolocontratto = "ACCORDO DI DIRITTO PRIVATO";
        $titoloiscrizione = "DOMANDA DI ADESIONE";
        $sottotitoloiscrizione = "ai servizi educativi della ".$ragionesocialescuola;
        $titolorichiesta= "L'ADESIONE AI SERVIZI EDUCATIVI";

        $testoarticolomensa = "";

        $modalitaPagSDD = "con mandato per addebito diretto SEPA-SDD Core (ex RID)";
        $modalitaPagBonifico = "con bonifico";

        $POF_PTOF_PSD = "PTOF"; //Piano di supporto alla didattica
        $POF_PTOF_PSDext = "Piano Triennale dell'Offerta Formativa";
        $istituzione_supporto ="l'istituzione scolastica ";

        $sottoTitoloDocValutazione = "- AD USO INTERNO -";

        $attestazioneAmmissione = true;

        break;
    case 'CI':
        $nickscuola = "Sc. Waldorf Cittadella";
        $shortnameScuola = "Aurora";
        $citta= "Cittadella";
        $li= "Cittadella";
        $nomescuola = "Scuola Steiner Waldorf Aurora";
        $nomecittascuola = "Scuola Aurora di Cittadella";
        $footerpagella = "";

        $indirizzoscuola = "Via Casaretta 103 - Cittadella - PD";
        $indirizzocompletoscuola= "Via Casaretta 103 - Cittadella - PD - tel.049/ 940 1303 - info@aurorascuola.it";
        $datiscuola = "Codice Fiscale e Partita IVA: 03431790280";
        $cfscuola = "03431790280";
        $ragionesocialescuola = "Cooperativa Sociale Aurora";
        $titolaretrattamentoTitolo = "il presidente pro-tempore della Società Cooperativa Sociale Aurora";
        $titolaretrattamento = "Alessandra Toniolo";
        $linkPTOF = "https://www.aurorascuola.it/aurora/wp-content/uploads/2020/11/PTOF-2019-22-Versione-n.-2-Settembre-2020.pdf";
        $scadpagamenti ="entro il giorno 5 di ciascun mese";
        $quotaiscrizione = "100 per ciascun/a alunno/a iscritto/a";
        $scadrientromodulo = "20/01/";
        $scadrientromodulolett = "20 gennaio ";
        $scadiscrizione = "27/01/";
        $scadiscrizionelett = "27 gennaio ";
        $scadfrase1 = "sottoscriverli entro il ".$scadrientromodulolett;
        $scadfrase2 = "<br>e consegnarli in segreteria o inviarli via mail<br>dovutamente sottoscritti entro il ";
        $scadrataunicaDDMM = "05/09/";
        $scadrataunica = "5 settembre";
        $scad3rate = "10 Ottobre + 10 Gennaio + 10 Aprile";
        $scadrata1trerate ="10/10/";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata2trerate ="10/01/";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata3trerate ="10/04/";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scad2rate = "---";
        $scadrata1duerate ="---";
        $scadrata2duerate ="---";
        $formagiuridica = "associazione";
        $emailscuola= "info@aurorascuola.it";
        $emailamministrazionescuola= "info@aurorascuola.it ";

        $swapp = "www.steinerwaldorfcittadella.it";
        $fraseAllegatoC= "l documento: 'Indicazioni per il Controllo e Prevenzione delle Malattie Infettive'";
        $fraseAllegatoCALL= "INDICAZIONI PER IL CONTROLLO E LA PREVENZIONE DELLE MALATTIE INFETTIVE";

        $titoloPagColonnaVoti = "Giudizio Descrittivo";

        //per pagelle
        $TipoVoto = "Giudizio Descrittivo";
        $codIdentificativo = "XXXXXXXXXXXXXXXXX";

        //per richiesta adesione socio
        $intestazione1 = "Associazione Pedagogica Aurora";
        $intestazione2 = "";

        $titolocontratto = "IMPEGNO ECONOMICO";
        $titoloiscrizione = "DOMANDA DI ADESIONE";
        $sottotitoloiscrizione = "ai servizi educativi della ".$ragionesocialescuola;
        $titolorichiesta= "L'ADESIONE AI SERVIZI EDUCATIVI";


        $testoarticolomensa = "";

        $modalitaPagSDD = "con mandato per addebito diretto SEPA-SDD Core (ex RID)";
        $modalitaPagBonifico = "con bonifico";

        $POF_PTOF_PSD = "PTOF"; //Piano di supporto alla didattica
        $POF_PTOF_PSDext = "Piano Triennale dell'Offerta Formativa";
        $istituzione_supporto ="l'istituzione scolastica ";

        $sottoTitoloDocValutazione = "- AD USO INTERNO -";

        $attestazioneAmmissione = true;


        break;
    case "VR":
        $nickscuola = "Scuola Waldorf VR";
        $shortnameScuola = "Waldorf VR";
        $citta= "Verona";
        $li= "Mozzecane";
        $nomescuola = "Scuola Steiner Waldorf Verona";
        $nomecittascuola = "Scuola Steiner Waldorf Verona";
        $footerpagella = "";

        $indirizzoscuola = "Via Tione, 25 - 37069 Villafranca di Verona (VR) ";
        $indirizzocompletoscuola = "Via Tione, 25 - 37069 Villafranca di Verona (VR) ";
        $ragionesocialescuola = "Steiner Waldorf Verona Cooperativa Sociale";
        $datiscuola = "C.F. e P.IVA: 04028200238 - N. REA VR 385885 - iscrizione albo nazionale società cooperative n° A212808";
        $cfscuola = "04028200238";
        $titolaretrattamentoTitolo = "il presidente pro-tempore della Steiner Waldorf Verona Cooperativa Sociale";
        $titolaretrattamento = "Rosella Danzi";
        $linkPTOF = "http://www.scuolawaldorfverona.it/media/pei-e-ptof-scuola-waldorf-vero-3ef.pdf";  
        $scadpagamenti ="entro il giorno 5 di ciascun mese";
        $quotaiscrizione = "330 per ciascun/a alunno/a iscritto/a";
        $scadrientromodulo = "28/01/";
        $scadrientromodulolett = "28 gennaio ";
        $scadiscrizione = "28/01/";
        $scadiscrizionelett = "28 gennaio ";
        $scadfrase1 = "";
        $scadfrase2 = "sottoscriverli dove indicato e consegnarli in Segreteria <br>entro la scadenza del ";
        $scadrataunicaDDMM = "05/09/";
        $scadrataunica = "5 settembre";
        $scad3rate = "---";
        $scadrata1trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata2trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata3trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scad2rate = "---";
        $scadrata1duerate ="---";
        $scadrata2duerate ="---";
        $formagiuridica = "cooperativa";
        $emailscuola= "segreteria@scuolawaldorfverona.it";
        $emailamministrazionescuola= "amministrazione@scuolawaldorfverona.it ";

        $swapp = "www.steinerwaldorfverona.it";
        $fraseAllegatoC= "l Regolamento Pediatrico";
        $fraseAllegatoCALL= "REGOLAMENTO PEDIATRICO";

        $titoloPagColonnaVoti = "Giudizio Descrittivo";
        
        //per pagelle
        $TipoVoto = "Livello di Apprendimento";
        $codIdentificativo = "IT780010000004028200238";

        //per richiesta adesione socio
        $intestazione1 = "Cooperativa Sociale";
        $intestazione2 = "Steiner Waldorf Verona";

        $titolocontratto = "CONTRATTO DI PRESTAZIONE SCOLASTICA";
        $titoloiscrizione = "DOMANDA DI ADESIONE";
        $sottotitoloiscrizione = "ai servizi educativi della ".$ragionesocialescuola;
        $titolorichiesta= "L'ADESIONE AI SERVIZI EDUCATIVI";


        $testoarticolomensa = "";

        $modalitaPagSDD = "con mandato per addebito diretto SEPA-SDD Core (ex RID)";
        $modalitaPagBonifico = "con bonifico (per iscrizione e/o pagamento dell'intera retta in unica soluzione)";

        $POF_PTOF_PSD = "PTOF"; //Piano di supporto alla didattica
        $POF_PTOF_PSDext = "Piano Triennale dell'Offerta Formativa";
        $istituzione_supporto ="l'istituzione scolastica ";


        $sottoTitoloDocValutazione = "- AD USO INTERNO -";

        $attestazioneAmmissione = true;


        break;
    case "TV":
        $nickscuola = "Scuola Waldorf TV";
        $shortnameScuola = "Michael";
        $citta= "Treviso";
        $li= "Treviso";
        $nomescuola = "Scuola Steiner Waldorf Treviso";
        $nomecittascuola = "Scuola Steiner Waldorf di Treviso";
        $footerpagella = "";

        $indirizzoscuola = "Via S. Ambrogio di Fiera 60 - Treviso";
        $indirizzocompletoscuola= "Via S. Ambrogio di Fiera 60 - 31100 - Treviso";
        $ragionesocialescuola = "Associazione Michael APS per la pedagogia steineriana ETS ";
        $datiscuola = "---";
        $cfscuola = "---";
        $titolaretrattamentoTitolo = "---";
        $titolaretrattamento = "---";
        $linkPTOF = "---";
        $scadpagamenti ="---";
        $quotaiscrizione = 85;
        $scadrientromodulo = "28/01/";
        $scadrientromodulolett = "28 gennaio ";
        $scadiscrizione = "28/01/";
        $scadiscrizionelett = "28 gennaio ";
        $scadfrase1 = "";
        $scadfrase2 = "sottoscriverli dove indicato e consegnarli in Segreteria <br>entro la scadenza del ";
        $scadrataunicaDDMM = "05/09/";
        $scadrataunica = "5 settembre";
        $scad3rate = "---";
        $scadrata1trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata2trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata3trerate ="---";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scad2rate = "---";
        $scadrata1duerate ="---";
        $scadrata2duerate ="---";
        $formagiuridica = "associazione";
        $emailscuola= "amministrazione@scuolawaldorftreviso.it";
        $emailamministrazionescuola= "amministrazione@scuolawaldorftreviso.it ";

        $swapp = "www.scuolawaldorftreviso.it";
        $fraseAllegatoC= "l Regolamento Pediatrico";
        $fraseAllegatoCALL= "REGOLAMENTO PEDIATRICO";

        $titoloPagColonnaVoti = "Giudizio Descrittivo";
        
        //per pagelle
        $TipoVoto = "Livello di Apprendimento";
        $codIdentificativo = "XXXXXXXXXXXXXXXXX";

        //per richiesta adesione socio
        $intestazione1 = "Associazione per la";
        $intestazione2 = "Pedagogia Steineriana Michael";

        $titolocontratto = "CONTRATTO DI PRESTAZIONE SCOLASTICA";
        $titoloiscrizione = "DOMANDA DI ADESIONE";
        $sottotitoloiscrizione = "ai servizi educativi della ".$ragionesocialescuola;
        $titolorichiesta= "L'ADESIONE AI SERVIZI EDUCATIVI";


        $testoarticolomensa = "";

        $modalitaPagSDD = "con mandato per addebito diretto SEPA-SDD Core (ex RID)";
        $modalitaPagBonifico = "con bonifico";

        $POF_PTOF_PSD = "PTOF"; //Piano di supporto alla didattica
        $POF_PTOF_PSDext = "Piano Triennale dell'Offerta Formativa";
        $istituzione_supporto ="l'istituzione scolastica ";

        $sottoTitoloDocValutazione = "- AD USO INTERNO -";

        $attestazioneAmmissione = true;

        break;
    case "TN":
        $nickscuola = "Scuola Waldorf TN";
        $shortnameScuola = "Waldorf TN";
        $citta= "Trento";
        $li= "Trento";
        $nomescuola = "Scuola Steiner Waldorf Trento";
        $nomecittascuola = "Scuola Steiner Waldorf di Trento";
        $footerpagella = "";

        $indirizzoscuola = "Via E. Conci 86 - Trento";
        $indirizzocompletoscuola= "Via E. Conci 86 - 38123 - Trento - tel.0461 930658 - segreteria@scuolasteiner-trento.it";
        $ragionesocialescuola = "Associazione Pedagogica Steineriana";
        $datiscuola = "C.F. 96014820227 - P.IVA 02183250220 - c.c.i.a.a. di Trento Numero REA TN - 159747";
        $cfscuola = "96014820227";
        $titolaretrattamentoTitolo = "l'Associazione Pedagogica Steineriana di Trento";
        $titolaretrattamento = "Associazione Pedagogica Steineriana - TRENTO, Via Conci 86 - associazione@pec.scuolasteiner-trento.it";
        $linkPTOF = "http://www.scuolasteiner-trento.it/media/pof-2020-2021-996.pdf";
        $scadpagamenti ="entro il giorno 15 di ciascun mese";
        $quotaiscrizione = "150 per ciascun/a alunno/a iscritto/a";
        $scadrientromodulo = "28/01/";
        $scadrientromodulolett = "28 gennaio ";
        $scadiscrizione = "28/01/";
        $scadiscrizionelett = "28 gennaio ";
        $scadfrase1 = "";
        $scadfrase2 = "sottoscriverli dove indicato e consegnarli in Segreteria <br>entro la scadenza del ";
        $scadrataunicaDDMM = "15/12/";
        $scadrataunica = "15 dicembre";
        $scad3rate = "15 Settembre + 15 Dicembre + 15 Aprile";
        $scadrata1trerate ="15/09/";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata2trerate ="15/12/";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scadrata3trerate ="15/04/";//in verità non viene usata nei contesti in cui ci sono le tre rate: si usa $dilazione
        $scad2rate = "---";
        $scadrata1duerate ="---";
        $scadrata2duerate ="---";
        $formagiuridica = "associazione";
        $emailscuola= "segreteria@scuolasteiner-trento.it ";
        $emailamministrazionescuola= "amministrazione@scuolasteiner-trento.it ";

        $swapp = "www.steinertn.it";
        $fraseAllegatoC= "l Regolamento Pediatrico";
        $fraseAllegatoCALL= "REGOLAMENTO PEDIATRICO";

        $titoloPagColonnaVoti = "Giudizio Descrittivo";
        
        //per pagelle
        $TipoVoto = "Livello di Apprendimento";
        $codIdentificativo = "XXXXXXXXXXXXXXXXX";

        //per richiesta adesione socio
        $intestazione1 = "Associazione";
        $intestazione2 = "Pedagogica Steineriana";

        $titolocontratto = "CONTRATTO DI PRESTAZIONE SCOLASTICA";
        $titoloiscrizione = "DOMANDA DI ISCRIZIONE";
        $sottotitoloiscrizione = "alla ".$nomecittascuola;
        $titolorichiesta= "L'ISCRIZIONE";

        $testoarticolomensa = " come definito nell'articolo 72 legge provinciale n.5 del 7 agosto 2006 e specificato nell'articolo 4 del Decreto del Presidente della Provincia n.24 del 5 novembre 2007 ";
        
        $modalitaPagSDD = "con mandato per addebito diretto SEPA-SDD Core (ex RID)";
        $modalitaPagBonifico = "con bonifico";

        $POF_PTOF_PSD = "PTOF"; //Piano di supporto alla didattica
        $POF_PTOF_PSDext = "Piano Triennale dell'Offerta Formativa";
        $istituzione_supporto ="l'istituzione scolastica ";
        
        $sottoTitoloDocValutazione = "- AD USO INTERNO -";

        $attestazioneAmmissione = true;

        break;
    default:
        break;
}
?>
