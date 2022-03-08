<!--******************************************* TAB PRESENZE-ASSENZE *********************************************************-->
<div class="tab-pane" id="Assenze">
    <?/*
    $ID_mae = $_SESSION['ID_mae_default'];
    //se l'utente è un maestro allora ne trovo nome e cognome
    if ($_SESSION ["role_usr"] > 1) {
        $sql = "SELECT ID_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri WHERE tipo_per = 0 AND ID_usr_mae = ? ORDER BY cognome_mae";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID_usr']);	
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ID_mae, $nome_mae, $cognome_mae);
        while (mysqli_stmt_fetch($stmt)) {
        }
    }*/
    ?>
    <div style="text-align: center; font-size: 14px; color: #3c3c3c;" >		
    </div>
    <div class="col-md-12" style="text-align: center; margin-top: 35px; ">
        <table id="tabellaOrario" class="center">
            <thead>
                <tr>
                    <th >
                        <input class="tablecell3" type='text' id='weeklyDatePicker' placeholder="Seleziona la settimana" style="text-align: center;">
                    </th>
                    <th >
                        <input class="tablecell3" style="width:110px; text-align: center" id="data1Show" type="text" value = "" disabled>
                        <input class="tablecell3" style="width:110px; text-align: center" id="data1" type="text" value = "" hidden>
                    </th>
                    <th >
                        <input class="tablecell3" style="width:110px; text-align: center" id="data2Show" type="text" value = "" disabled>
                        <input class="tablecell3" style="width:110px; text-align: center" id="data2" type="text" value = "" hidden>
                    </th>
                    <th >
                        <input class="tablecell3" style="width:110px; text-align: center" id="data3Show" type="text" value = "" disabled>
                        <input class="tablecell3" style="width:110px; text-align: center" id="data3" type="text" value = "" hidden>
                    </th>
                    <th >
                        <input class="tablecell3" style="width:110px; text-align: center" id="data4Show" type="text" value = "" disabled>
                        <input class="tablecell3" style="width:110px; text-align: center" id="data4" type="text" value = "" hidden>
                    </th>
                    <th >
                        <input class="tablecell3" style="width:110px; text-align: center" id="data5Show" type="text" value = "" disabled>
                        <input class="tablecell3" style="width:110px; text-align: center" id="data5" type="text" value = "" hidden>
                    </th>
                </tr>
                <tr>
                    <th>
                    </th>
                    <th>
                        <input class="tablelabel0" style="width:110px;" type="text" value = "LUNEDI" disabled>
                    </th>
                    <th>
                        <input class="tablelabel0" style="width:110px;" type="text" value = "MARTEDI" disabled>
                    </th>
                    <th>
                        <input class="tablelabel0" style="width:110px;" type="text" value = "MERCOLEDI" disabled>
                    </th>
                    <th>
                        <input class="tablelabel0" style="width:110px;" type="text" value = "GIOVEDI" disabled>
                    </th>
                    <th>
                        <input class="tablelabel0" style="width:110px;" type="text" value = "VENERDI" disabled>
                    </th>
                </tr>
            </thead>
            <tbody id="maintableAssenze">	
            </tbody>
        </table>
    </div>
</div>