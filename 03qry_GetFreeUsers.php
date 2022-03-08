<?include_once("database/databaseii.php");?>
<select name="selectlogin"  style="margin-left: 0px; font-size: 13px;"  id="selectlogin">
    <option value="0">Selezionare tra gli utenti liberi</option>
    <?$sql2 = "SELECT ID_usr, login_usr FROM tab_users WHERE ID_usr NOT IN (SELECT ID_usr_mae FROM tab_anagraficamaestri) AND ID_usr <> 1;";
    $stmt2 = mysqli_prepare($mysqli, $sql2);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $ID_usr, $login_usr);
    while (mysqli_stmt_fetch($stmt2)) {
        ?><option value="<?=$ID_usr?>"><?=$login_usr?></option>
    <?}?>
</select>