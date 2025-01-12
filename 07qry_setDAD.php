<?include_once("database/databaseii.php");

$data_ora = $_POST['data'];
$ora_ora = $_POST['ora'];
$classe_ora = $_POST['classe'];
$sezione_ora = $_POST['sezione'];

//quantiDAD può essere All, None o Some 
//All: sono già tutti in DAD -> devo togliere a tutti la DAD
//Some: alcuni sono in DAD -> devo mettere a tutti la DAD
//None: nessuno in DAD -> devo amettere a tutti la DAD
$quantiDAD = $_POST['quantiDAD']; 

//devo inserire in tab_assenze un record per ogni alunno a condizione che non sia già assente in quell'ora

//estraggo l'anno scolastico di pertinenza
    $sql = "SELECT annoscolastico_asc FROM tab_anniscolastici WHERE datainizio_asc <= ? AND datafine_asc >= ?";
        
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $data_ora, $data_ora);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $annoscolastico_asc );
    while (mysqli_stmt_fetch($stmt)) {
    }

//estraggo tutti gli alunni della classe / ora e li metto in un array

    $ID_aluA = array();

    $sql = "SELECT ID_alu_cla FROM tab_classialunni WHERE ritirato_cla = 0 AND listaattesa_cla = 0 AND annoscolastico_cla =  ? AND classe_cla = ? AND sezione_cla = ? ";
    
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $annoscolastico_asc, $classe_ora, $sezione_ora);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu_cla );
	while (mysqli_stmt_fetch($stmt)) {
        array_push($ID_aluA, $ID_alu_cla);
	}

//per ciascuno verifico se non è assente o se non è già in DAD e se non lo è lo inserisco come "in DAD" (tipo_ass = 2)




    if ($quantiDAD == 'All') { 
        //Se tutti sono in DAD quelli non assenti significa che voglio togliere la DAD
        //allora eseguo la cancellazione di tutte le sole DAD di ogni alunno in quella data e ora
        foreach ($ID_aluA as $ID_alu) {
            $sql2 = "DELETE FROM tab_assenze 
            WHERE
            tipo_ass = 2
            AND ID_alu_ass = ? 
            AND data_ass = ?
            AND ora_ass = ? ";
            $stmt2 = mysqli_prepare($mysqli, $sql2);
            mysqli_stmt_bind_param($stmt2, "isi", $ID_alu, $data_ora, $ora_ora);	
            mysqli_stmt_execute($stmt2);
        }        
    }



    if ($quantiDAD != 'All') { 
        //Se non tutti sono in DAD significa che voglio inserire la DAD, per tutti i non assenti che non siano già in DAD

        foreach ($ID_aluA as $ID_alu) {

                $sql = "SELECT ID_ass FROM tab_assenze 
                WHERE  

                ID_alu_ass = ?
                AND data_ass = ? 
                AND ora_ass = ? ";
                $stmt = mysqli_prepare($mysqli, $sql);
                mysqli_stmt_bind_param($stmt, "isi", $ID_alu, $data_ora, $ora_ora);	
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $ID_ass );
                $assODAD = 0;
                while (mysqli_stmt_fetch($stmt)) {
                    $assODAD = 1;
                }

                if ($assODAD == 0) {
                    $sql1 = "INSERT INTO tab_assenze 
                    SET 
                    tipo_ass = 2,
                    ID_alu_ass = ".$ID_alu.", 
                    data_ass = '".$data_ora."', 
                    ora_ass = ".$ora_ora;
                    $stmt1 = mysqli_prepare($mysqli, $sql1);
                    //mysqli_stmt_bind_param($stmt1, "isi", $ID_alu, $data_ora, $ora_ora);	
                    mysqli_stmt_execute($stmt1);
                }

            
        }
           
    }



$return['test'] = '';
echo json_encode($return);
?>
