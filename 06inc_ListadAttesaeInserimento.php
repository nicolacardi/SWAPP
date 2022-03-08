		<!-- ********************************************** TAB LISTA D'ATTESA **********************************************-->
		<div class="tab-pane" id="ListaDAttesaeInserimento">
			<div id="DatiAttesa" style="text-align: center;" >

				<?//************************************************************************** Estraggo lista d'attesa ************************************************
                $sql4 = "SELECT ID_lda, annoscolastico_lda, classe_lda, sezione_lda, notefinali_lda, data0_lda, modalita0_lda, data1_lda, incontrocon1_lda,note1_lda, data2_lda, incontrocon2_lda, note2_lda, data3_lda, incontrocon3_lda, note3_lda, accolto_lda FROM tab_listadattesa WHERE ID_alu_lda = ?";
                $stmt4 = mysqli_prepare($mysqli, $sql4);
                mysqli_stmt_bind_param($stmt4, "i", $ID_alu_det);
                mysqli_stmt_execute($stmt4);
                mysqli_stmt_bind_result($stmt4, $ID_lda, $annoscolastico_lda, $classe_lda, $sezione_lda, $notefinali_lda, $data0_lda, $modalita0_lda, $data1_lda, $incontrocon1_lda, $note1_lda, $data2_lda, $incontrocon2_lda, $note2_lda, $data3_lda, $incontrocon3_lda, $note3_lda, $accolto_lda);
                $k=0;
                while (mysqli_stmt_fetch($stmt4)) {
                $k++;
                }
                //k a questo punto contiene l'indicazione SE ci sia un record di listadattesa o no per l'alunno?>
				<table style="display: inline-block;">
					<tbody>
                        <tr>
							<td colspan="6" style="height: 40px; font-size: 16px;">- PRIMO INSERIMENTO o LISTA D'ATTESA -</td>
						</tr>
                        <tr>
							<td class="w50px">
								
							</td>
							<td class="w100px">
								data
							</td>
                            <td class="w100px">
                                modalità contatto
                            </td>
							<td class="w100px">
                                interesse per anno scolastico
							</td>
							<td class="w100px">
								interesse per classe
							</td>
							<td class="w50px">
                                sezione
							</td>

						</tr>
						<tr>
							<td>
                                <img title="Elimina i dati di questo primo inserimento"  class="iconaStd" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteIter();">
							</td>
                            <td>
                                <input class="tablecell3 dpd center w100px" type="text" name="dataStep00" id="dataStep00" value ="<? echo(timestamp_to_ggmmaaaa($data0_lda))?>">
   							</td>
							<td>
                            <select id="selectModalita0_lda" class="w100">
									<option value="telefonica" <?if ($modalita0_lda="telefonica") {echo ('selected');}?>>telefonica</option>
									<option value="email" <?if ($modalita0_lda="telefonica") {echo ('selected');}?>>e-mail</option>
									<option value="porteAperte" <?if ($modalita0_lda="porteAperte") {echo ('selected');}?>>Porte Aperte</option>
									<option value="bazar" <?if ($modalita0_lda="bazar") {echo ('selected');}?>>Bazar</option>
									<option value="altro" <?if ($modalita0_lda="altro") {echo ('selected');}?>>altra</option>
								</select>
   							</td>
							<td>
								<select name="selectannoscolastico_lda"  class="w100" id="selectannoscolastico_lda">
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

							<td>
								<select name="selectclasse_lda"  class="w100" style="height: 25px; font-size:12px;" id="selectclasse_lda">
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

							<td >
								<select name="selectsezione_lda"  class="w100" id="selectsezione_lda">
									<option value="A" <?if ($sezione_lda == 'A') { echo ("selected");}?>>A</option>
									<option value="B" <?if ($sezione_lda == 'B') { echo ("selected");}?>>B</option>
									<option value="C" <?if ($sezione_lda == 'C') { echo ("selected");}?>>C</option>
								</select>
							</td>
						</tr>
                        <tr>
							<td colspan="6" style="height: 20px;"></td>
						</tr>
                        <tr style="height: 30px; border: solid grey 1px">
                            <td>
                            </td>
							<td>
								Accolto<br><input type="radio" id="accolto" name="accolto" value="1" <? if ($accolto_lda == 1){echo ("checked");}?>/>
							</td>
							<td>
								Non Accolto<br><input type="radio" id="nonaccolto" name="accolto" value="2" <? if ($accolto_lda == 2){echo ("checked");}?> <? if ($accolto_lda == 1){echo ("disabled");}?>/>
							</td>
							<td>
								In lista di attesa<br><input type="radio" id="listaattesa" name="accolto" value="3" <? if ($accolto_lda == 3) {echo ("checked");}?> <? if ($accolto_lda == 1){echo ("disabled");}?>/>
							</td>
							<td>
								Solo in anagrafica<br><input type="radio" id="soloanagrafica" name="accolto" value="4" <? if (($accolto_lda == NULL) || ($accolto_lda == 4)) {echo ("checked");}?> <? if ($accolto_lda == 1){echo ("disabled");}?>/>
							</td>
                            <td>
                            </td>
						</tr>
                        <tr>
							<td colspan="6" style="height: 30px; font-size: 14px;">- Note su primo contatto / inserimento -</td>
						</tr>
						<tr >
							<td colspan="6" >
								<textarea class="tablecell" style="font-size: 10px; width: 100%; height: 40px;" type="text" name="Notefinali" id="Notefinali"><?=$notefinali_lda?></textarea>
							</td>
						</tr>




                        <tr>
							<td colspan = "6" >
								<button class="btnBlu mb5" style=" width: 70%;" onclick="salvaIterEInserimento();">Salva Iter Inserimento</button>
							</td>
						</tr>

					</tbody>
				</table>
                
			</div>
		</div>
