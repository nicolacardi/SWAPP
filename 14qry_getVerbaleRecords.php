<?	include_once("database/databaseii.php");
	$num_ver = $_POST['num_ver'];
	$sql2 = "SELECT ID_ver, argnum_ver, argomento_ver, tematiche_ver, decisioni_ver FROM tab_verbali WHERE num_ver = ? ; ";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "i", $num_ver);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_ver, $argnum_ver, $argomento_ver, $tematiche_ver, $decisioni_ver);
	mysqli_stmt_store_result($stmt2);
	$i=1;
	while (mysqli_stmt_fetch($stmt2)) {?>
		<div class="row">
			<div class="col-md-1" style="width: 40px; margin-left: 50px; ">
				<?if ($i !=1 ) {?>
					<img title="Elimina Argomento" class="iconaStd" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteArgomento(<?=$ID_ver?>);">
				<?}?>
			</div>
			<div class="col-md-3" style="width: 280px; text-align: center;" id="selecttipoargomentoContainer<?=$i?>">
				<select style="font-size: 11px;" name="argnum_ver_new<?=$i?>"  id="argnum_ver_new<?=$i?>" onchange="MostraNascondiAltro(<?=$i?>);">
					<?
					$sqlx = "SELECT numtipo_tip, desctipo_tip FROM tab_tipiargomentoverbali ORDER BY numtipo_tip";
					$stmtx = mysqli_prepare($mysqli, $sqlx);
					mysqli_stmt_execute($stmtx);
					mysqli_stmt_bind_result($stmtx, $numtipo_tipx, $desctipo_tipx);
					while (mysqli_stmt_fetch($stmtx)) {?>
						<option value="<?=$numtipo_tipx?>" <? if ($numtipo_tipx == $argnum_ver) {echo ("selected");}?>><?=$desctipo_tipx;?></option>
					<?}?>
				</select>
				<input style="width: 85%; margin-top: 5px; text-align: left; <?if($argnum_ver!=9) {echo('display:none;');}?> " class="tablecell5" type="text"  id="argomentoaltro_ver<?=$i?>" name="argomentoaltro_ver<?=$i?>" placeholder="...prego specificare" <?if($argnum_ver==9) {echo("value='".stripslashes($argomento_ver)."';"); }?>>
			</div>
			<div class="col-md-3 w300px">
				<textarea style="text-align: left; font-size: 11px; height: 60px;" class="tablecell5" id="tematiche_new<?=$i?>"><?=stripslashes($tematiche_ver)?></textarea>
			</div>
			<div class="col-md-4 w300px">
				<textarea style="text-align: left; font-size: 11px; height: 60px;" class="tablecell5" id="decisioni_new<?=$i?>"><?=stripslashes($decisioni_ver)?></textarea>
				<input type="text" id="IDcontainer<?=$i?>" value ="<?=$ID_ver?>"hidden>
			</div>
		</div>
    <?
	$i++;
	}?>
	<input id="numeroRecords" type="text" value ="<?=($i-1)?>" hidden>
