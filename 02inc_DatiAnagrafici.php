<div class="tab-pane active" id="DatiAnagrafici">
    <?
    $sql = "SELECT DISTINCT ID_alu, nome_alu, cognome_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, cf_alu, indirizzo_alu, citta_alu, prov_alu, paese_alu, CAP_alu, commento_alu, img_alu, tiposcuolasucc_alu, sottotiposcuolasucc_alu, nomescuolasucc_alu, votoesamiVIII_alu, nomemadre_fam, cognomemadre_fam, nomepadre_fam, cognomepadre_fam, telefonomadre_fam, telefonopadre_fam, emailmadre_fam, emailpadre_fam, sociomadre_fam, sociopadre_fam FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) ".
    "LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) WHERE ID_alu = ? ;";
    $stmt = mysqli_prepare ($mysqli, $sql);
    mysqli_stmt_bind_param ($stmt, "i", $ID_alu);
    mysqli_stmt_execute ($stmt);
    mysqli_stmt_bind_result ($stmt, $ID_alu_det, $nome_alu_det, $cognome_alu_det, $datanascita_alu_det, $comunenascita_alu_det, $provnascita_alu_det, $paesenascita_alu_det, $cf_alu_det, $indirizzo_alu_det, $citta_alu_det, $prov_alu_det, $paese_alu_det, $CAP_alu_det, $commento_alu_det, $img_alu, $tiposcuolasucc_alu, $sottotiposcuolasucc_alu, $nomescuolasucc_alu, $votoesamiVIII_alu, $nomemadre_fam_det, $cognomemadre_fam_det, $nomepadre_fam_det, $cognomepadre_fam_det, $telefonomadre_fam_det, $telefonopadre_fam_det, $emailmadre_fam_det, $emailpadre_fam_det, $sociomadre_fam_det, $sociopadre_fam_det );
    $emailtotale = "";
    while (mysqli_stmt_fetch($stmt)) {
    ?>			
        <br>
        <div class="row">
            <div class="col-sm-12" style="text-align: center;" id="divImgContainer">
                <img id="imgContainer1" style=" <? if ($img_alu=="") { echo ("display: none;");} ?> margin-top: 15px; border-radius: 8px; border 1px, black;" width="120" height="120" alt="" src="assets/photos/imgs/<?=$img_alu;?>">
                <!-- data-src="assets/photos/imgs/<?//=$img_alu;?>"
                data-src-retina="assets/photos/imgs/<?//=$img_alu;?>"-->
            </div>
            <div class="col-sm-1" style="margin-left:50px;">
            </div>
            <div class="col-sm-2 celladet_imiealunni">
                il
            </div>
            <div class="col-md-2 celladet_imiealunni">
                comune
            </div>
            <div class="col-md-2 celladet_imiealunni">
                prov
            </div>
            <div class="col-md-2 celladet_imiealunni">
                paese
            </div>
            <div class="col-md-2 celladet_imiealunni">
                C.F.
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1" style="margin-left:50px;">
                Nato/a
            </div>
            <div class="col-sm-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="datanascita_alu_det" name="datanascita_alu_det" value = "<?echo(timestamp_to_ggmmaaaa($datanascita_alu_det)) ?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="comunenascita_alu_det" name="comunenascita_alu_det" value = "<?=$comunenascita_alu_det?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 20%" class="tablecell disab" type="text"  id="provnascita_alu_det" name="provnascita_alu_det" value = "<?=$provnascita_alu_det?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="paesenascita_alu_det" name="paesenascita_alu_det" value = "<?=$paesenascita_alu_det?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 80%; font-size: 12px; " class="tablecell disab" type="text"  id="cf_alu_det" name="cf_alu_det" value = "<?=$cf_alu_det?>" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1" style="margin-left:50px;">
            </div>
            <div class="col-sm-2 celladet_imiealunni">
                via
            </div>
            <div class="col-md-2 celladet_imiealunni">
                comune
            </div>
            <div class="col-md-2 celladet_imiealunni">
                prov
            </div>
            <div class="col-md-2 celladet_imiealunni">
                paese
            </div>
            <div class="col-md-2 celladet_imiealunni">
                CAP
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1" style="margin-left:50px;">
                Residenza
            </div>
            <div class="col-sm-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="indirizzo_alu_det" name="indirizzo_alu_det" value = "<?=$indirizzo_alu_det?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="citta_alu_det" name="citta_alu_det" value = "<?=$citta_alu_det?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 20%" class="tablecell disab" type="text"  id="prov_alu_det" name="prov_alu_det" value = "<?=$prov_alu_det?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="paese_alu_det" name="paese_alu_det" value = "<?=$paese_alu_det?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="CAP_alu_det" name="CAP_alu_det" value = "<?=$CAP_alu_det?>" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1 celladet_imiealunni" style="margin-left:50px;">
            </div>
            <div class="col-sm-2 celladet_imiealunni">
                nome
            </div>
            <div class="col-md-2 celladet_imiealunni">
                cognome
            </div>
            <div class="col-md-2 celladet_imiealunni">
                tel
            </div>
            <div class="col-md-4 celladet_imiealunni">
                email
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1" style="margin-left:50px;">
                mamma
            </div>
            <div class="col-sm-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="nomemadre_fam_det" name="nomemadre_fam_det" value = "<?=$nomemadre_fam_det?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="cognomemadre_fam_det" name="cognomemadre_fam_det" value = "<?=$cognomemadre_fam_det?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="telefonomadre_fam_det" name="telefonomadre_fam_det" value = "<?=$telefonomadre_fam_det?>" disabled>
            </div>
            <div class="col-md-4 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="emailmadre_fam_det" name="emailmadre_fam_det" value = "<?=$emailmadre_fam_det?>" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1" style="margin-left:50px;">
            </div>
            <div class="col-sm-2 celladet_imiealunni">
                nome
            </div>
            <div class="col-md-2 celladet_imiealunni">
                cognome
            </div>
            <div class="col-md-2 celladet_imiealunni">
                tel
            </div>
            <div class="col-md-4 celladet_imiealunni">
                email
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1" style="margin-left:50px;">
                papà
            </div>
            <div class="col-sm-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="nomepadre_fam_det" name="nomepadre_fam_det" value = "<?=$nomepadre_fam_det?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="cognomepadre_fam_det" name="cognomepadre_fam_det" value = "<?=$cognomepadre_fam_det?>" disabled>
            </div>
            <div class="col-md-2 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="telefonopadre_fam_det" name="telefonopadre_fam_det" value = "<?=$telefonopadre_fam_det?>" disabled>
            </div>
            <div class="col-md-4 celladet_imiealunni">
                <input style="width: 80%" class="tablecell disab" type="text"  id="emailpadre_fam_det" name="emailpadre_fam_det" value = "<?=$emailpadre_fam_det?>" disabled>
            </div>
        </div>


        <div class="row"  style="margin-top:20px;">
            <div class="col-sm-12" style="text-align: center;">
                Commento Generale del Collegio (max 2000 char)
            </div>
            <div class="col-sm-12" style="margin-left:50px;">
                <textarea maxlength="2000" style="width: 92%; height: 100px; margin-top:10px;" id="commento_alu" ><?=$commento_alu_det?></textarea>
            </div>
            <div class="col-sm-12" style="text-align: center;">
                <button class="btnBlu w100px" onclick="salvaCommento();">Salva</button>
            </div>
        </div>
        <div style="text-align: center;">
            <div class="alert alert-success" id="alertModificaCommento" style="display: none; width: 500px; height: 55px; text-align: center; margin-top:10px; position: absolute; margin-left: -250px; left: 50% ">
                Commento salvato con successo!
            </div>
        </div>
    <?
    } ?>
</div>