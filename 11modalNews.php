<!--***************************************NOVITA' DI SWAPP **************************************************-->
<div class="modal" id="modalNews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="font-size:14px; width: 50%: margin: auto;">
        <div class="modal-content">
            <div class="modal-body white">           
                <form id="form_News" method="post">
                    <span class="titoloModal">Novità di SWAPP - Giugno 2023</span><br>
                    <img style="width: 80px; text-align: center;" src="assets/img/Icone/Megafono.svg">
                    <div id="remove-content" style="text-align: justify; margin-top: 5px; margin-left: 80px; margin-right: 80px;"> <!-- START REMOVE CONTENT -->
                        PER I MAESTRI<br>
                        <br>
                        - Nell'inserimento dei voti per i compiti e le interrogazioni <br>non serve più premere SALVA VOTI:<br>
                        ogni singolo voto viene salvato automaticamente<br>ogni volta che viene modificato
                        <!-- - A questo scopo è disponibile un nuovo video specifico nella sezione  <a href ="./17Tutorials.php">Tutorials</a> -->
                        <br><br>
                        
                    </div> <!-- END REMOVE CONTENT -->
                    <span style="font-size: 11px;"><input type="checkbox" id="cknonmostrarepiu_usr" name="cknonmostrarepiu_usr">&nbsp;nascondi questo popup fino alle prossime novità</span>
                    <div class="modal-footer" >
                        <button type="button" id="btn_cancelNews" class="btnBlu" style="width:25%;" data-dismiss="modal" onclick="SalvaNonMostrarePiu();">Chiudi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>