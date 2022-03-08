<?	
include_once("database/databaseii.php");
$aselme_cls = $_POST['aselme'];
?>
<select name="select_classe"  style="width: 100%; margin-left: 0px; font-size: 13px;"  id="select_classe">
        <?
        $sql = "SELECT ID_cls, classe_cls, desc_cls, aselme_cls FROM tab_classi WHERE aselme_cls = ? ORDER BY ord_cls ";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "s", $aselme_cls);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ID_cls, $classe_cls, $desc_cls, $aselme_cls);
        while (mysqli_stmt_fetch($stmt)) {?>
                <option value="<?=$classe_cls?>"><?=$desc_cls?></option><?
        }?>
</select>
