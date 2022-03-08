<?include_once("database/databaseii.php");
include_once("assets/functions/functions.php");

	$ID_mae_ora = $_POST['ID_mae_ora'];
	$dateFrom = $_POST['dateFrom'];


	$todaydate = date("Y-m-d");
	$yesterdaydate = date('Y-m-d', strtotime("-1 days"));
	$sql = "SELECT nome_mae, cognome_mae, classe_ora, sezione_ora, descmateria_mtt, data_ora, ora_ora, assente_ora, supplente_ora FROM (tab_orario LEFT JOIN tab_anagraficamaestri ON ID_mae_ora = ID_mae) LEFT JOIN tab_materie ON codmat_ora = codmat_mtt WHERE ID_mae_ora = ? AND firma_mae_ora = 0 AND (data_ora BETWEEN ? AND ?)ORDER BY data_ora; ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "iss", $ID_mae_ora, $dateFrom, $yesterdaydate);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $nome_mae, $cognome_mae, $classe_ora, $sezione_ora, $descmateria_mtt, $data_ora, $ora_ora, $assente_ora, $supplente_ora);
	$k=0;?>
	<table id="tabellaWarning" style="display: inline-block;">
		<thead>
			<tr style="border: none;">
				<th class="tablelabel3 w100px">
					DATA
				</th>
				<th class="tablelabel3 w100px">
					ORA
				</th>
				<th class="tablelabel3 w100px">
					CLASSE
				</th>
				<th class="tablelabel3" style="width: 180px; ">
					MATERIA
				</th>
			</tr>
		</thead>
		<tbody>		
			<?while (mysqli_stmt_fetch($stmt)) {
				?><tr>
					<td >
						<?=timestamp_to_ggmmaaaa($data_ora)?>
					</td>
					<td >
						<?=$ora_ora?>^
					</td>
					<td >
						<?=$classe_ora?>
					</td>
					<td >
						<?=$descmateria_mtt?>
					</td>
				</tr>
				<?
				$k++;
			}
		?></tbody>
	</table>
	<div><input id="hiddenNumeroArretrati" value="<?=$k?>" hidden></div>