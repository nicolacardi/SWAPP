<?	include_once("database/databaseii.php");

    $ID_fam_mae = $_POST['ID_fam_mae']; //uso la stessa variabile sia che qui si stia arrivando inserendo un padre/madre che un maestro, ecco perchè si chiama così
    $dataiscrizione_soc = $_POST['dataiscrizione_soc'];
    $datadisiscrizione_soc = $_POST['datadisiscrizione_soc'];
    $pm = $_POST['padremadre']; //nel caso di maestro il valore è proprio "maestro"

	if ($dataiscrizione_soc != '') {
		$dataiscrizione_soc = date('Y-m-d', strtotime(str_replace('/','-', $dataiscrizione_soc)));
	} else {
		$dataiscrizione_soc = NULL;
	}


	if ($datadisiscrizione_soc != '') {
		$datadisiscrizione_soc = date('Y-m-d', strtotime(str_replace('/','-', $datadisiscrizione_soc)));
	} else {
		$datadisiscrizione_soc = NULL;
	}

    if ($pm == "maestro") {

        //TO DO : altrotelpadre_fam e altrotelefono_mae: andrebbero uniformati
        //citta_alu, citta_mae ma comunepadre_fam e comunemadre_fam
        $sql = "INSERT INTO tab_anagraficasoci (
            mf_soc,
            nome_soc, 
            cognome_soc, 
            indirizzo_soc, 
            comune_soc,
            CAP_soc,
            prov_soc,
            paese_soc,
            cf_soc,
            datanascita_soc,
            comunenascita_soc,
            provnascita_soc,
            paesenascita_soc,
            telefono_soc,
            altrotel_soc,
            email_soc,
            note_soc,
            img_soc,
            iban_soc,
    
            ID_mae_soc,

            dataiscrizione_soc,
            datadisiscrizione_soc)
            SELECT 
            mf_mae,
            nome_mae,
            cognome_mae,
            indirizzo_mae,
            citta_mae,
            CAP_mae,
            prov_mae,
            paese_mae,
            cf_mae,
            datanascita_mae,
            comunenascita_mae,
            provnascita_mae,
            paesenascita_mae,
            telefono_mae,
            altrotelefono_mae,
            email_mae,
            note_mae,
            img_mae,
            iban_mae,

            ? AS ID_mae,

            ? AS dataiscrizione,
            ? AS datadisiscrizione
    
            FROM tab_anagraficamaestri
            WHERE ID_mae = ?;";
    
    
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, "issi", $ID_fam_mae, $dataiscrizione_soc, $datadisiscrizione_soc, $ID_fam_mae);
            mysqli_stmt_execute($stmt);
            
            //devo anche inserire il flag in tab-famiglie in sociopadre o sociomadre
        
            $sql1 = "UPDATE tab_anagraficamaestri SET socio_mae = 1 WHERE ID_mae = ?;";
            $stmt1 = mysqli_prepare($mysqli, $sql1);
            mysqli_stmt_bind_param($stmt1, "i", $ID_fam_mae);
            mysqli_stmt_execute($stmt1);

    } else {
        if ($pm == "padre") {$sex = "M";} else {$sex = "F";}
        $sql = "INSERT INTO tab_anagraficasoci (
        mf_soc,
        nome_soc, 
        cognome_soc, 
        indirizzo_soc, 
        comune_soc,
        CAP_soc,
        prov_soc,
        paese_soc,
        cf_soc,
        datanascita_soc,
        comunenascita_soc,
        provnascita_soc,
        paesenascita_soc,
        telefono_soc,
        altrotel_soc,
        email_soc,
        note_soc,
        img_soc,
        iban_soc,

        ID_fam_soc,
        padremadre_soc,
        dataiscrizione_soc,
        datadisiscrizione_soc)
        SELECT 
        '".$sex."' AS sex,
        nome".$pm."_fam,
        cognome".$pm."_fam,
        indirizzo".$pm."_fam,
        comune".$pm."_fam,
        CAP".$pm."_fam,
        prov".$pm."_fam,
        paese".$pm."_fam,
        cf".$pm."_fam,
        datanascita".$pm."_fam,
        comunenascita".$pm."_fam,
        provnascita".$pm."_fam,
        paesenascita".$pm."_fam,
        telefono".$pm."_fam,
        altrotel".$pm."_fam,
        email".$pm."_fam,
        note".$pm."_fam,
        img".$pm."_fam,
        iban".$pm."_fam,

        ? AS ID_fam,
        ? AS padremadre,
        ? AS dataiscrizione,
        ? AS datadisiscrizione

        FROM tab_famiglie
        WHERE ID_fam = ?;";


        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "isssi", $ID_fam_mae, $pm, $dataiscrizione_soc, $datadisiscrizione_soc, $ID_fam_mae);
        mysqli_stmt_execute($stmt);
        
        //devo anche inserire il flag in tab-famiglie in sociopadre o sociomadre
    
        $sql1 = "UPDATE tab_famiglie SET socio".$pm."_fam = 1 WHERE ID_fam = ?;";
        $stmt1 = mysqli_prepare($mysqli, $sql1);
        mysqli_stmt_bind_param($stmt1, "i", $ID_fam_mae);
        mysqli_stmt_execute($stmt1);

        
        $sql2 = "UPDATE ".$_SESSION['databaseB'].".tab_famiglie SET socio".$pm."_fam = 1 WHERE ID_fam = ?;";
        $stmt2 = mysqli_prepare($mysqli, $sql2);
        mysqli_stmt_bind_param($stmt2, "i", $ID_fam_mae);
        mysqli_stmt_execute($stmt2);
    }

	$return['msg'] = "Affiliazione socio/a registrata";
	$return['test'] = $sql;		
	echo json_encode($return);
?>
