<?
	include_once("database/databaseii.php");
	include_once("classi/alunni.php");
?>
<!-- 
			<tr>
			<td>
				<?//echo(json_encode($_POST['campo']))?>
				<?//echo(GetAlunni($_POST['campo'], $_POST['ord'], $_POST['fil']));?>
			</td>
		</tr> -->
	<?

	$riga =  0;
	foreach (GetAlunni ($_POST['campo'], $_POST['ord'], $_POST['fil']) as $alunno) {
		$riga++;
		?>
		<tr>
			<td class="w25px">
				<img title="Elimina alunno" class="iconaStd" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteThisRecord(<?=$alunno->ID_alu?>, '<?=$alunno->nome_alu?>', '<?=$alunno->cognome_alu?>');">
			</td>
			<td style="width:30px;">
				<button  id="goto<?=$alunno->ID_alu?>" ondblclick="postToSchedaAlunno(<?=$alunno->ID_alu?>, '<?=addslashes($alunno->nome_alu)?>', '<?=addslashes($alunno->cognome_alu)?>');" onclick="coloraRighe(<?=$alunno->ID_alu?>);" style="width: 90%; font-size:12px;"><?=$riga?></button>
			</td>
			<td style="width:139px;">
				<input class="tablecell6 disab val<?=$alunno->ID_alu?>" type="text"  id="nome_alu" name="nome_alu" value = "<?=$alunno->nome_alu?>">
			</td>
			<td style="width:139px;">
				<input class="tablecell6 disab val<?=$alunno->ID_alu?>" type="text" id="cognome_alu" name="cognome_alu" value = "<?=$alunno->cognome_alu?>" disabled>
			</td>
			<td style="width:145px;">
				<input class="tablecell6 disab val<?=$alunno->ID_alu?>" type="text" value = "<?=$alunno->{$_POST['campo'][3]}?>" disabled>
			</td>
			<td style="width:145px;">
				<input class="tablecell6 disab val<?=$alunno->ID_alu?>" type="text" value = "<?=$alunno->{$_POST['campo'][4]}?>" disabled>
			</td>
			<td style="width:145px;">
				<input class="tablecell6 disab val<?=$alunno->ID_alu?>" type="text" value = "<?=$alunno->{$_POST['campo'][5]}?>" disabled>
			</td>
			<td style="width:145px;">
				<input class="tablecell6 disab val<?=$alunno->ID_alu?>" type="text" value = "<?=$alunno->{$_POST['campo'][6]}?>" disabled>
			</td>
			<td style="width:145px;">
				<input class="tablecell6 disab val<?=$alunno->ID_alu?>" type="text" value = "<?=$alunno->{$_POST['campo'][7]}?>" disabled>
			</td>
			<td style="width:145px;">
				<input class="tablecell6 disab val<?=$alunno->ID_alu?>" type="text" value = "<?=$alunno->{$_POST['campo'][8]}?>" disabled>
			</td>
			<td style="width:145px;">
				<input class="tablecell6 disab val<?=$alunno->ID_alu?>" type="text" value = "<?=$alunno->{$_POST['campo'][9]}?>" disabled>
			</td>
		</tr>
	<?}?>
	<tr>
		<td>
			<!--scrivo in un'input nascosta quanti record ho estratto, da qui poi pescherò il valore tramite Jscript per scriverlo in alto-->
			<input id="contarecord_hidden" value = "<?=$riga?>" hidden>
		</td>
	</tr>
