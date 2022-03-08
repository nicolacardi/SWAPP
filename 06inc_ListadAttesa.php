		<!-- ********************************************** TAB LISTA D'ATTESA **********************************************-->
		<div class="tab-pane" id="ListaDAttesa">
			<div id="DatiAttesa" style="text-align: center;" >
				<div class="row mt5 mb5" style="text-align: center; font-size: 16px;">	
					- PRIMO INSERIMENTO PER LA CLASSE... -
				</div>
				<?//************************************************************************** Estraggo lista d'attesa ************************************************
					$sql4 = "SELECT ID_lda, annoscolastico_lda, classe_lda, sezione_lda, notefinali_lda, data0_lda, modalita0_lda, data1_lda, incontrocon1_lda,note1_lda, data2_lda, incontrocon2_lda, note2_lda, data3_lda, incontrocon3_lda, note3_lda, accolto_lda FROM tab_listadattesa WHERE ID_alu_lda = ?";
					$stmt4 = mysqli_prepare($mysqli, $sql4);
					mysqli_stmt_bind_param($stmt4, "i", $ID_alu_det);
					mysqli_stmt_execute($stmt4);
					mysqli_stmt_bind_result($stmt4, $ID_lda, $annoscolastico_lda, $classe_lda, $sezione_lda, $notefinali_lda, $data0_lda, $modalita0_lda, $data1_lda, $incontrocon1_lda, $note1_lda, $data2_lda, $incontrocon2_lda, $note2_lda, $data3_lda, $incontrocon3_lda, $note3_lda, $accolto_lda);
					$k=0;
					while (mysqli_stmt_fetch($stmt4)) {
					$k++;
					}?>
				<table style="display: inline-block;">
					<tbody>
						<tr>
							<td>
								<img title="Elimina i dati di questo primo inserimento"  class="iconaStd" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteIter();">
							</td>
							<td>
								anno scolastico
							</td>
							<td>
								<select name="selectannoscolastico_lda"  style="margin-left: 0px"  id="selectannoscolastico_lda">
									<? $sql = "SELECT DISTINCT annoscolastico_asc, anno1_asc FROM tab_anniscolastici ORDER BY anno1_asc ";
										$stmt = mysqli_prepare($mysqli, $sql);
										mysqli_stmt_execute($stmt);
										mysqli_stmt_bind_result($stmt, $annoscolastico_asc, $anno1_asc);
										while (mysqli_stmt_fetch($stmt)) {
										?>
										<option value="<?=$annoscolastico_asc?>" <?if (($k!=0) && ($annoscolastico_asc == $annoscolastico_lda)) { echo ("selected");} if (($k==0) && ($annoscolastico_asc == $_SESSION['anno_prossimo'])) { echo ("selected");}?>><?=$annoscolastico_asc?></option><?
										}?>
								</select>
							</td>
							<td style="padding-left: 20px;">
								classe
							</td>
							<td>
								<select name="selectclasse_lda"  style="margin-left: 0px"  id="selectclasse_lda">
									<? $sql = "SELECT id_cls, classe_cls, desc_cls FROM tab_classi ORDER BY id_cls ";
										$stmt = mysqli_prepare($mysqli, $sql);
										mysqli_stmt_execute($stmt);
										mysqli_stmt_bind_result($stmt, $id_cls, $classe_cls, $desc_cls);
										while (mysqli_stmt_fetch($stmt)) {
										?>
										<option value="<?=$classe_cls?>" <?if ($classe_cls == $classe_lda) { echo ("selected");}?>><?=$desc_cls?></option><?
										}?>
								</select>
							</td>
							<td style="padding-left: 20px;">
								sezione
								<select name="selectsezione_lda"  style="margin-left: 0px"  id="selectsezione_lda">
									<option value="A" <?if ($sezione_lda == 'A') { echo ("selected");}?>>A</option>
									<option value="B" <?if ($sezione_lda == 'B') { echo ("selected");}?>>B</option>
									<option value="C" <?if ($sezione_lda == 'C') { echo ("selected");}?>>C</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="6" style="height: 20px; "></td>
						</tr>
						<tr>
							<td colspan="6">
								- ITER di inserimento -
							</td>
						</tr>
						<tr>
							<td colspan="6" style="height: 1px; border-top: 1px solid grey"></td>
						</tr>
						<tr>
							<td>
								step
							</td>
							<td colspan = "2">
								data
							</td>
							<td colspan = "2">
								per la scuola presenti
							</td>
							<td style="padding-left: 20px; width: 200px;">
								note/modalità contatto
							</td>
						</tr>
						<tr>
							<td>
								1^ Contatto
							</td>
							<td style="padding-left: 20px;" colspan = "2">
								<input class="tablecell3 dpd" style="text-align: center;" type="text" name="dataStep0" id="dataStep0" value ="<? echo(timestamp_to_ggmmaaaa($data0_lda))?>">
							</td>
							<td colspan = "2">
								
							</td>
							<td style="padding-left: 20px;">
								<select id="selectModalita0_lda">
									<option value="telefonica" <?if ($modalita0_lda="telefonica") {echo ('selected');}?>>telefonica</option>
									<option value="email" <?if ($modalita0_lda="telefonica") {echo ('selected');}?>>e-mail</option>
									<option value="porteAperte" <?if ($modalita0_lda="porteAperte") {echo ('selected');}?>>Porte Aperte</option>
									<option value="bazar" <?if ($modalita0_lda="bazar") {echo ('selected');}?>>Bazar</option>
									<option value="altro" <?if ($modalita0_lda="altro") {echo ('selected');}?>>altra</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="6" style="height: 10px; border-bottom: 1px dotted grey"></td>
						</tr>
						<tr>
							<td colspan="6" style="height: 10px; border-top: 1px solid grey"></td>
						</tr>
						<tr>
							<td>
								Coll. Informativo
							</td>
							<td style="padding-left: 20px;" colspan = "2">
								<input class="tablecell3 dpd" style="text-align: center;" type="text" name="dataStep1" id="dataStep1" value ="<? echo(timestamp_to_ggmmaaaa($data1_lda))?>">
							</td>
							<td style="padding-left: 20px;" colspan = "2">
								<input id="hidden_incontrocon1" value="<?=$incontrocon1_lda?>" hidden>
								<div id="PersonalePresenteContainer1">
									
								</div>
							</td>
							<td style="padding-left: 20px;">
								<textarea class="tablecell7" style="font-size: 10px; width: 100%;" type="text" name="NoteStep1" id="NoteStep1"><?=$note1_lda?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="6" style="height: 5px; border-top: 1px solid grey"></td>
						</tr>
						<tr>
							<td>
								Coll. Pedagogico
							</td>
							<td style="padding-left: 20px;" colspan = "2">
								<input class="tablecell3 dpd" style="text-align: center;" type="text" name="dataStep2" id="dataStep2" value ="<? echo(timestamp_to_ggmmaaaa($data2_lda))?>">
							</td>
							<td style="padding-left: 20px;" colspan = "2">
								<input id="hidden_incontrocon2" value="<?=$incontrocon2_lda?>" hidden>
								<div id="PersonalePresenteContainer2">
									
								</div>
							</td>
							<td style="padding-left: 20px;">
								<textarea class="tablecell" style="font-size: 10px; width: 100%;" type="text" name="NoteSte2" id="NoteStep2"><?=$note2_lda?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="6" style="height: 5px; border-top: 1px solid grey"></td>
						</tr>
						<tr>
							<td>
								Coll. Amministrativo
							</td>
							<td style="padding-left: 20px;" colspan = "2">
								<input class="tablecell3 dpd" style="text-align: center;" type="text" name="dataStep3" id="dataStep3" value ="<? echo(timestamp_to_ggmmaaaa($data3_lda))?>">
							</td>
							<td style="padding-left: 20px;" colspan = "2">
								<input id="hidden_incontrocon3" value="<?=$incontrocon3_lda?>" hidden>
								<div id="PersonalePresenteContainer3">
									
								</div>
							</td>
							<td style="padding-left: 20px;">
								<textarea class="tablecell" style="font-size: 10px; width: 100%;" type="text" name="NoteStep3" id="NoteStep3"><?=$note3_lda?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="6" style="height: 20px; border-top: 1px solid grey"></td>
						</tr>
						<tr>
							<td>
								Accolto <input type="radio" id="accolto" name="accolto" value="1" <? if ($accolto_lda == 1){echo ("checked");}?>/>
							</td>
							<td colspan="2">
								Non Accolto <input type="radio" id="nonaccolto" name="accolto" value="2" <? if ($accolto_lda == 2){echo ("checked");}?> <? if ($accolto_lda == 1){echo ("disabled");}?>/>
							</td>
							<td colspan="2">
								In lista di attesa  <input type="radio" id="listaattesa" name="accolto" value="3" <? if ($accolto_lda == 3) {echo ("checked");}?> <? if ($accolto_lda == 1){echo ("disabled");}?>/>
							</td>
							<td>
								Solo in anagrafica  <input type="radio" id="soloanagrafica" name="accolto" value="4" <? if (($accolto_lda == NULL) || ($accolto_lda == 4)) {echo ("checked");}?> <? if ($accolto_lda == 1){echo ("disabled");}?>/>
							</td>

						</tr>
						<tr >
							<td colspan="6" style="padding-top: 10px;">
								<textarea class="tablecell" style="font-size: 10px; width: 100%; height: 40px;" type="text" name="Notefinali" id="Notefinali"><?=$notefinali_lda?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="6" style="height: 50px;"></td>
						</tr>
						<tr>
							<td colspan = "6" >
								<button class="btnBlu mb5" style=" width: 70%;" onclick="salvaIter();">Salva Iter Inserimento</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>