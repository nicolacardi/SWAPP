<?	include_once("database/databaseii.php");
$tipo = $_POST['tipo'];
$sottotipo = $_POST['sottotipo'];

$sql = "SELECT ID_scu, sottotipo_scu FROM tab_scuole WHERE tiposcuola_scu = ? ORDER BY ord_scu";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "s", $tipo);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_scu, $sottotipo_scu);
?>

<div style="text-align: center; font-size: 14px; color: #3c3c3c;" >
    <select id="selectSottoTipo"  style="margin-left: 0px" >
        <option value="0">-</option>
        <?
        $k = 0 ;
        while (mysqli_stmt_fetch($stmt)) {?>
            <option value="<?=$sottotipo_scu?>" <? if($sottotipo==$sottotipo_scu) {echo ('selected');}?>><?=$sottotipo_scu?></option>
            <?  $k++;
        }?>			
	</select>
</div>
