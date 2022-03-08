<?
			$metodo_cor = "";
			$interesse_cor = "";
			$sql = "SELECT metodo_cor, interesse_cor, data_cor, ";
			
			for ($i = 1; $i<=11; ++$i) {
				$sql = $sql."area".$i."_cor, ";
			}
			for ($i = 1; $i<=4; ++$i) {
				$sql = $sql."scuola".$i."_cor, ";
			}
			for ($i = 1; $i<=4; ++$i) {
				$sql = $sql."tiposcuola".$i."_cor, ";
			}
			
			$sql = $sql ." attitudini_cor FROM tab_consorientativo ".
			"WHERE ID_alu_cor = ? AND annoscolastico_cor = ?";
			
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "is", $ID_alu, $annoscolastico_cla);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $metodo_cor, $interesse_cor, $data_cor, $area1_cor, $area2_cor, $area3_cor, $area4_cor, $area5_cor, $area6_cor, $area7_cor, $area8_cor, $area9_cor, $area10_cor, $area11_cor, $scuola1_cor, $scuola2_cor, $scuola3_cor, $scuola4_cor, $tiposcuola1_cor, $tiposcuola2_cor, $tiposcuola3_cor, $tiposcuola4_cor, $attitudini_cor);
			mysqli_stmt_store_result($stmt);
			$k = 0;
			while (mysqli_stmt_fetch($stmt)) {
				$k=1;
			}
			?>
			
			<!-- ********************************************** TAB CONS ORIENTATIVO **********************************************-->
			<div class="tab-pane" id="ConsOrientativo">
				<form id="form_ConsOrientativo" method="post">
					<table id="tabellaConsOrientativo" style="width:80%; margin-top: 5px;margin-left: 35px;">
						<tbody style="">
							<tr>
								<td style="width: 15%">
									<button class="btnBlu w100" onclick="showModalSalvaConOri(event);">Salva</button>
								</td>
								<td style="width: 25%">
									<button class="btnBlu" style="width: 100%; margin-left: 10px; " id="ConsOrientativo" onclick="scaricaPagellaPOST(event, <?=$ID_alu;?>, '<?=$annoscolastico_cla;?>', '<?=$classe_cla;?>', '<?=$sezione_cla;?>', 2, 'ConOri');" title="Cons.Orientativo->Excel">Cons.Orientativo</button>	
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
	
							<tr>
								<td colspan="3">
									<textarea class="tablecell6 voti materia ta" type="text" style="padding-left: 30px; text-align: left; height: 40px; font-size: 12px;" disabled>L’alunno/a mostra un metodo di lavoro*: </textarea>
								</td>
								<td>
									
								</td>
								<td>
									<select id="selectMetodo_cor"  style="margin-left: 0px; width: 300px;" name="selectMetodo_cor" onchange="requery();">
										<option value="" <? if($metodo_cor=="") {echo ('selected');} ?>>-</option>
										<option value="efficace e autonomo"<? if($metodo_cor=="efficace e autonomo") {echo ('selected');} ?>>efficace e autonomo</option>
										<option value="autonomo"<? if($metodo_cor=="autonomo") {echo ('selected');} ?>>autonomo</option>
										<option value="non ancora autonomo"<? if($metodo_cor=="non ancora autonomo") {echo ('selected');} ?>>non ancora autonomo</option>
										<option value="non sempre produttivo"<? if($metodo_cor=="non sempre produttivo") {echo ('selected');} ?>>non sempre produttivo</option>
										<option value="con buone competenze di manualità"<? if($metodo_cor=="con buone competenze di manualità") {echo ('selected');} ?>>con buone competenze di manualità</option>
										<option value="creativo e capace di suggerire soluzioni proprie"<? if($metodo_cor=="creativo e capace di suggerire soluzioni proprie") {echo ('selected');} ?>>creativo e capace di suggerire soluzioni proprie</option>
										<option value="collaborativo e capace di lavorare nel gruppo"<? if($metodo_cor=="collaborativo e capace di lavorare nel gruppo") {echo ('selected');} ?>>collaborativo e capace di lavorare nel gruppo</option>
									</select>
								</td>
							</tr>
							
							<tr>
								<td colspan="3">
									<textarea class="tablecell6 voti materia ta" type="text" style="padding-left: 30px; text-align: left; height: 40px; font-size: 12px;" disabled>L’alunno/a ha mostrato interesse e impegno&#13nelle attività scolastiche in modo*:  </textarea>
								</td>
								<td>
									
								</td>
								<td>
									<select id="selectInteresse_cor"  name="selectInteresse_cor" style=" margin-left: 0px; width: 300px;"  onchange="requery();">
										<option value="" <? if($interesse_cor=="") {echo ('selected');} ?>>-</option>
										<option value="costante"<? if($interesse_cor=="costante") {echo ('selected');} ?>>costante</option>
										<option value="responsabile"<? if($interesse_cor=="responsabile") {echo ('selected');} ?>>responsabile</option>
										<option value="settoriale"<? if($interesse_cor=="settoriale") {echo ('selected');} ?>>settoriale</option>
										<option value="incostante"<? if($interesse_cor=="incostante") {echo ('selected');} ?>>incostante</option>
										<option value="superficiale"<? if($interesse_cor=="superficiale") {echo ('selected');} ?>>superficiale</option>
										<option value="scarso"<? if($interesse_cor=="scarso") {echo ('selected');} ?>>scarso</option>
									</select>
								</td>
							</tr>
							
							<tr>
								<td colspan="5">
									<textarea class="tablecell6 voti materia ta" type="text" style="padding-left: 30px; text-align: left; height: 30px; font-size: 12px;" disabled>L’alunno/a ha mostrato preferenze nelle seguenti aree di apprendimento**:   </textarea>
								</td>
							</tr>
							<tr>
								
								<td colspan="2">
									<input type="checkbox" id="area1_cor" name="area1_cor" <?if ($area1_cor == 1) { echo "checked";}?>> artistico<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area2_cor" name="area2_cor" <?if ($area2_cor == 1) { echo "checked";}?>> tecnico<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area3_cor" name="area3_cor" <?if ($area3_cor == 1) { echo "checked";}?>> scientifico<br>
								</td>
							<tr>
								
								<td colspan="2">
									<input type="checkbox" id="area4_cor" name="area4_cor" <?if ($area4_cor == 1) { echo "checked";}?>> sociale<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area5_cor" name="area5_cor" <?if ($area5_cor == 1) { echo "checked";}?>> agro ambientale<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area6_cor" name="area6_cor" <?if ($area6_cor == 1) { echo "checked";}?>> educativo<br>
								</td>
							</tr>
							<tr>
								
								<td colspan="2">
									<input type="checkbox" id="area7_cor" name="area7_cor" <?if ($area7_cor == 1) { echo "checked";}?>> economico<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area8_cor" name="area8_cor" <?if ($area8_cor == 1) { echo "checked";}?>> artigianale<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area9_cor" name="area9_cor" <?if ($area9_cor == 1) { echo "checked";}?>> umanistico<br>
								</td>
							</tr>
							</tr>
								<td colspan="2">
									<input type="checkbox" id="area10_cor" name="area10_cor" <?if ($area10_cor == 1) { echo "checked";}?>> linguistico<br>
								</td>
								<td colspan="2">
									<input type="checkbox" id="area11_cor" name="area11_cor" <?if ($area11_cor == 1) { echo "checked";}?>> musicale<br>
								</td>
							</tr>
							<tr>
								<td colspan="5">
									<textarea class="tablecell6 voti materia ta" type="text" style="margin-top: 5px; height: 40px; font-size: 12px;" disabled>L’alunno ha mostrato specifiche attitudini, ottenendo prestazioni particolarmente positive, nelle aree disciplinari*: </textarea>
								</td>
							</tr>
							<tr>
								<td colspan="5">
									<textarea class="tablecell6 voti" id="attitudini_cor" name="attitudini_cor" type="text" style="height: 50px; font-size: 12px;" maxlength="255" ><?=$attitudini_cor;?></textarea>
								</td>
							</tr>
							<tr>
								<td colspan="5">
									<textarea class="tablecell6 voti materia ta" type="text" style="padding-left: 30px; text-align: left; height: 50px; font-size: 12px;" disabled>In base a quanto sopra evidenziato, al percorso formativo compiuto dall’alunno/a nell’arco del triennio, al rendimento scolastico globale e alle competenze evidenziate, il Consiglio di Classe formula il seguente consiglio orientativo**:   </textarea>
								</td>
							</tr>
							<tr>
								
								<td colspan="2">
									<input type="checkbox" name="scuola1_cor" <?if ($scuola1_cor == 1) { echo "checked";}?>> un Liceo<br>
								</td>
								<td>
									Tipologia:
								</td>
								<td colspan="3">
									<input class="tablecell3" type="text" style= "margin-top: 10px; width: 350px;" name="tiposcuola1_cor" <?echo (" value = '".$tiposcuola1_cor."'");?> >
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="checkbox" name="scuola2_cor" <?if ($scuola2_cor == 1) { echo "checked";}?>> un Istituto Professionale<br>
								</td>
								<td>
									Tipologia:
								</td>
								<td colspan="3">
									<input class="tablecell3" type="text" style= "margin-top: 10px; width: 350px;" name="tiposcuola2_cor" <?echo (" value = '".$tiposcuola2_cor."'");?>>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="checkbox" name="scuola3_cor" <?if ($scuola3_cor == 1) { echo "checked";}?>> un Istituto Tecnico<br>
								</td>
								<td>
									Tipologia:
								</td>
								<td colspan="3">
									<input class="tablecell3" type="text" style= "margin-top: 10px; width: 350px;" name="tiposcuola3_cor" <?echo (" value = '".$tiposcuola3_cor."'");?>>
								</td>
							</tr>
							<tr>
							<td colspan="2">
									<input type="checkbox" name="scuola4_cor" <?if ($scuola4_cor == 1) { echo "checked";}?>> istr./formazione professionale<br>
								</td>
								<td>
									Tipologia:
								</td>
								<td colspan="3">
									<input class="tablecell3" type="text" style= "margin-top: 10px; width: 350px;" name="tiposcuola4_cor" <?echo (" value = '".$tiposcuola4_cor."'");?>>
								</td>
							</tr>
							<tr >
								
								<td colspan= "5" >
									<br><span style="margin-top: 30px; font-size: small;">(* scelta OBBLIGATORIA singola - ** scelta OBBLIGATORIA anche multipla)</span>
									
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			