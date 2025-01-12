<option value="tab_classialunni.classe_cla" <?if ($sel == 1){echo ('selected');}?>>Classi Frequentate</option>
<option value="tab_classialunni.sezione_cla" <?if ($sel == 2){echo ('selected');}?>>Sezione</option>
<option value="tab_classialunni.aselme_cla" <?if ($sel == 3){echo ('selected');}?>>Livello Classe</option>
<option value="tab_classialunni.annoscolastico_cla" <?if ($sel == 4){echo ('selected');}?>>Anno scolastico</option>
<option disabled>──────────</option>
<option value="mf_alu" <?if ($sel == 5){echo ('selected');}?>>Genere</option>
<option value="indirizzo_alu" <?if ($sel == 6){echo ('selected');}?>>Indirizzo Residenza</option>
<option value="citta_alu" <?if ($sel == 7){echo ('selected');}?>>Comune Residenza</option>
<option value="CAP_alu" <?if ($sel == 8){echo ('selected');}?>>CAP Residenza</option>
<option value="prov_alu" <?if ($sel == 9){echo ('selected');}?>>Prov Residenza</option>
<option value="cf_alu" <?if ($sel ==10){echo("selected");}?>>Codice Fiscale</option>
<option value="datanascita_alu" <?if ($sel == 11){echo ('selected');}?>>Data di Nascita</option>
<option value="comunenascita_alu" <?if ($sel == 12){echo ('selected');}?>>Comune di Nascita</option>
<option disabled>──────────</option>
<option value="ckautfoto_alu" <?if ($sel ==17){echo("selected");}?>>Aut. Foto/Video</option>
<option value="ckautmateriale_alu" <?if ($sel ==18){echo("selected");}?>>Aut. Uso materiale</option>
<option value="ckautuscite_alu" <?if ($sel ==19){echo("selected");}?>>Aut. Uscite</option>
<option disabled>──────────</option>
<option value="nomemadre_fam" <?if ($sel == 13){echo ('selected');}?>>Nome Mamma</option>
<option value="cognomemadre_fam" <?if ($sel == 14){echo ('selected');}?>>Cognome Mamma</option>
<option value="telefonomadre_fam" <?if ($sel ==20){echo("selected");}?>>Tel Mamma</option>
<option value="altrotelmadre_fam" <?if ($sel ==22){echo("selected");}?>>Tel2 Mamma</option>
<option value="emailmadre_fam" <?if ($sel ==24){echo("selected");}?>>email Mamma</option>
<option disabled>──────────</option>
<option value="nomepadre_fam" <?if ($sel == 15){echo ('selected');}?>>Nome Papà</option>
<option value="cognomepadre_fam" <?if ($sel == 16){echo ('selected');}?>>Cognome Papà</option>
<option value="telefonopadre_fam" <?if ($sel ==21){echo("selected");}?>>Tel Papà</option>
<option value="altrotelpadre_fam" <?if ($sel ==23){echo("selected");}?>>Tel2 Papà</option>
<option value="emailpadre_fam" <?if ($sel ==25){echo("selected");}?>>email Papà</option>
<option disabled>──────────</option>
<option value="sociomadre_fam" <?if ($sel ==26){echo("selected");}?>>socio Mamma</option>
<option value="sociopadre_fam" <?if ($sel ==27){echo("selected");}?>>socio Papà</option>
<option disabled>──────────</option>
<option value="tab_listadattesa.data1_lda" <?if ($sel == 28){echo ('selected');}?>>Data Coll.Info</option>
<option value="data2_lda" <?if ($sel == 29){echo ('selected');}?>>Data Coll.Ped.</option>
<option value="data3_lda" <?if ($sel == 30){echo ('selected');}?>>Data Coll.Amm.</option>
<option value="accolto_lda" <?if ($sel == 31){echo ('selected');}?>>Lista d'attesa</option>
<option value="tab_listadattesa.data0_lda" <?if ($sel == 32){echo ('selected');}?>>Data L.Attesa</option>
<option disabled>──────────</option>
<option value="tab_classialunni.ritirato_cla" <?if ($sel == 33){echo ('selected');}?>>Ritirato</option>

<!-- STRANAMENTE classeprec_cla non funziona bene: non si può filtrare: eppure nella sql c'è proprio una AS classeprec_cla 
e quindi la filsql che ne risulta dovrebbe funzionare....intanto la tolgo 
sembra legato al fatto che tab_classialunni.classeprec_cla funziona per mostrare a video ma non funziona per filtrare...in quel caso servirebbe tab_classialunniprec.classe_cla-->
<!-- <option value="tab_classialunniprec.classe_cla" <?//if ($sel == 34){echo ('selected');}?>>Classe Precedente</option> -->

