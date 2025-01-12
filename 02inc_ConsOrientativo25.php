<?

			$sql = "SELECT ";
			
			for ($i = 1; $i<=8; ++$i) {
				$sql = $sql."area".$i."_cor, ";
			}

			for ($i = 1; $i<=5; ++$i) {
				$sql = $sql."atti".$i."_cor, ";
			}
			$sql = $sql."altreatti_cor, ";

			for ($i = 1; $i<=3; ++$i) {
				$sql = $sql."certi".$i."_cor, ";
			}
			$sql = $sql."altrecerti_cor, ";

			for ($i = 1; $i<=4; ++$i) {
				$sql = $sql."scuola".$i."_cor, ";
			}
			for ($i = 1; $i<=4; ++$i) {
				$sql = $sql."tiposcuola".$i."_cor, ";
			}
			
			$sql = $sql ." data_cor FROM tab_consorientativo25 ".
			"WHERE ID_alu_cor = ? AND annoscolastico_cor = ?";
			

			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "is", $ID_alu, $annoscolastico_cla);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $area1_cor, $area2_cor, $area3_cor, $area4_cor, $area5_cor, $area6_cor, $area7_cor, $area8_cor, $atti1_cor, $atti2_cor, $atti3_cor, $atti4_cor, $atti5_cor, $altreatti_cor, $certi1_cor, $certi2_cor, $certi3_cor, $altrecerti_cor, $scuola1_cor, $scuola2_cor, $scuola3_cor, $scuola4_cor, $tiposcuola1_cor, $tiposcuola2_cor, $tiposcuola3_cor, $tiposcuola4_cor, $data_cor);
			mysqli_stmt_store_result($stmt);
			$k = 0;
			while (mysqli_stmt_fetch($stmt)) {
				$k=1;
			}
			?>
			
			<!-- ********************************************** TAB CONS ORIENTATIVO **********************************************-->
			<div class="tab-pane" id="ConsOrientativo25">
				<form id="form_ConsOrientativo25" method="post">
					<table id="tabellaConsOrientativo25" style="width:80%; margin-top: 5px;margin-left: 35px;">
						<tbody style="">
							<tr>
								<td style="width: 15%">
									<button class="btnBlu w100" onclick="showModalSalvaConOri25(event);">Salva</button>
								</td>
								<td style="width: 25%">
									<button class="btnBlu" style="width: 100%; margin-left: 10px; " id="ConsOrientativo" onclick="scaricaPagellaPOST(event, <?=$ID_alu;?>, '<?=$annoscolastico_cla;?>', '<?=$classe_cla;?>', '<?=$sezione_cla;?>', 2, 'ConOri25');" title="Cons.Orientativo->Excel">Cons.Orientativo</button>	
								</td>
								<td style="width: 25%">
								</td>
								<td style="width: 5%">
								</td>
								<td style="width: 10%">
								</td>
							</tr>
							<tr>
								<td>
									&nbsp;
								</td>
							</tr>
							<!-- <tr>
								<td>
								<?//=$ID_alu?> <?//=$sql?>
								</td>	
							</tr> -->
							<tr>
								<td colspan="5">
									
									<textarea class="tablecell6 voti materia ta" type="text" style="padding-left: 30px; text-align: left; height: 30px; font-size: 12px;" disabled>L’alunno/a ha mostrato particolare interesse per le seguenti aree* ***:   </textarea>
								</td>
							</tr>
							<tr>
								
								<td colspan="2">
									<input type="checkbox" id="area1_cor" name="area1_cor" <?if ($area1_cor == 1) { echo "checked";}?>> umanistica<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area2_cor" name="area2_cor" <?if ($area2_cor == 1) { echo "checked";}?>> linguistica<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area3_cor" name="area3_cor" <?if ($area3_cor == 1) { echo "checked";}?>> matematico-scientifico-tecnologica<br>
								</td>
							<tr>
								
								<td colspan="2">
									<input type="checkbox" id="area4_cor" name="area4_cor" <?if ($area4_cor == 1) { echo "checked";}?>> tecnico-pratica<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area5_cor" name="area5_cor" <?if ($area5_cor == 1) { echo "checked";}?>> digitale<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area6_cor" name="area6_cor" <?if ($area6_cor == 1) { echo "checked";}?>> artistico-espressiva<br>
								</td>
							</tr>
							<tr>
								
								<td colspan="2">
									<input type="checkbox" id="area7_cor" name="area7_cor" <?if ($area7_cor == 1) { echo "checked";}?>> musicale<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area8_cor" name="area8_cor" <?if ($area8_cor == 1) { echo "checked";}?>> sportivo-motoria<br>
								</td>
							</tr>

							<tr>
								<td colspan="5">
									<textarea class="tablecell6 voti materia ta" type="text" style="padding-left: 30px; text-align: left; height: 45px; font-size: 12px;" disabled>L’alunno/a ha avuto modo di sviluppare specifiche competenze grazie allo svolgimento di attività extrascolastiche attinenti ai seguenti ambiti* ***:   </textarea>
								</td>
							</tr>
							<tr>
								
								<td colspan="2">
									<input type="checkbox" id="atti1_cor" name="atti1_cor" <?if ($atti1_cor == 1) { echo "checked";}?>> att. culturali e artistiche<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="atti2_cor" name="atti2_cor" <?if ($atti2_cor == 1) { echo "checked";}?>> att. musicali<br>
								</td>

							<tr>
								<td colspan="2">
									<input type="checkbox" id="atti3_cor" name="atti3_cor" <?if ($atti3_cor == 1) { echo "checked";}?>> att. sportive<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="atti4_cor" name="atti4_cor" <?if ($atti4_cor == 1) { echo "checked";}?>> att. di cittadinanza attiva e volontariato<br>
								</td>
							</tr>

							<tr>
								<td colspan="2">
									<input type="checkbox" id="atti5_cor" name="atti5_cor" <?if ($atti5_cor == 1) { echo "checked";}?>> altre attività<br>
								</td>
								<td>
									Tipo attività:
								</td>
								<td colspan="3">
									<input class="tablecell3" type="text" style= "margin-top: 10px; width: 350px;" name="altreatti_cor" value="<?=htmlspecialchars($altreatti_cor, ENT_QUOTES, 'UTF-8')?>" >
								</td>
							</tr>

							<tr>
								<td colspan="5">
									<textarea class="tablecell6 voti materia ta" type="text" style="padding-left: 30px; text-align: left; height: 30px; font-size: 12px;" disabled>L’alunn_ ha conseguito fino alla data di espressione del presente consiglio di orientamento le seguenti certificazioni***:   </textarea>
								</td>
							</tr>

							<tr>
								<td colspan="2">
									<input type="checkbox" name="certi1_cor" <?if ($certi1_cor == 1) { echo "checked";}?>> linguistica<br>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="checkbox" name="certi2_cor" <?if ($certi2_cor == 1) { echo "checked";}?>> informatica<br>
								</td>
							</tr>

							<tr>
								<td colspan="2">
									<input type="checkbox" name="certi3_cor" <?if ($certi3_cor == 1) { echo "checked";}?>> di altro tipo<br>
								</td>
								<td>
									Tipo certificazione:
								</td>
								<td colspan="3">
									<input class="tablecell3" type="text" style= "margin-top: 10px; width: 350px;" name="altrecerti_cor" value="<?=$altrecerti_cor?>" >
								</td>

							</tr>

							<tr>
								<td colspan="5">
									<textarea class="tablecell6 voti materia ta" type="text" style="padding-left: 30px; text-align: left; height: 60px; font-size: 12px;" disabled>Tenendo conto di quanto sopra, del percorso di studi realizzato, degli interessi e delle attitudini dimostrate, delle competenze acquisite nei percorsi scolastici ed extrascolastici, si consiglia per la prosecuzione degli studi l'iscrizione al seguente percorso scolastico e formativo* ***:   </textarea>
								</td>
							</tr>
							<tr>
								
								<td colspan="2">
									<input type="checkbox" name="scuola1_cor" <?if ($scuola1_cor == 1) { echo "checked";}?>> istruzione Liceale<br>
								</td>
								<td>
									Indirizzo**:
								</td>
								<td colspan="3">
									<input class="tablecell3" type="text" style= "margin-top: 10px; width: 350px;" name="tiposcuola1_cor" value="<?=$tiposcuola1_cor?>" >
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="checkbox" name="scuola2_cor" <?if ($scuola2_cor == 1) { echo "checked";}?>> istruzione Professionale<br>
								</td>
								<td>
									Indirizzo**:
								</td>
								<td colspan="3">
									<input class="tablecell3" type="text" style= "margin-top: 10px; width: 350px;" name="tiposcuola2_cor" value="<?=$tiposcuola2_cor?>">
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="checkbox" name="scuola3_cor" <?if ($scuola3_cor == 1) { echo "checked";}?>> istruzione Tecnica<br>
								</td>
								<td>
									Indirizzo**:
								</td>
								<td colspan="3">
									<input class="tablecell3" type="text" style= "margin-top: 10px; width: 350px;" name="tiposcuola3_cor" value="<?=$tiposcuola3_cor?>">
								</td>
							</tr>
							<tr>
							<td colspan="2">
									<input type="checkbox" name="scuola4_cor" <?if ($scuola4_cor == 1) { echo "checked";}?>> istr./formazione Professionale regionale<br>
								</td>
								<td>
									Indirizzo**:
								</td>
								<td colspan="3">
									<input class="tablecell3" type="text" style= "margin-top: 10px; width: 350px;" name="tiposcuola4_cor" value="<?=$tiposcuola4_cor?>">
								</td>
							</tr>
							<tr >
								
								<td colspan= "5" >
									<br><span style="margin-top: 30px; font-size: small;">(* indicazione OBBLIGATORIA - ** indicazione facoltativa - ***scelta anche MULTIPLA)</span>
									
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			