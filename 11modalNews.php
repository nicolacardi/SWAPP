<!--***************************************NOVITA' DI SWAPP **************************************************-->
<div class="modal" id="modalNews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="font-size:14px; width: 50%: margin: auto;">
        <div class="modal-content">
            <div class="modal-body white">           
                <form id="form_News" method="post">
                    <span class="titoloModal">Novità di SWAPP - Dicembre 2024</span><br>
                    <img style="width: 80px; text-align: center;" src="assets/img/Icone/Megafono.svg">
                    <div id="remove-content" style="text-align: justify; margin-top: 5px; margin-left: 80px; margin-right: 80px;"> <!-- START REMOVE CONTENT -->
                        PER I MAESTRI<br>
                        <br>
                        - Aggiornamento del modello del Consiglio orientativo al modello 2024-25 ministeriale
                        <br>
                        - Nella pagina degli alunni è disponibile una scheda "File Upload" utile per caricare file (.pdf o .p7m) come certificazioni BES, DSA PDP, PEI. Il limite è di 2 Mb.
                        <!-- - A questo scopo è disponibile un nuovo video specifico nella sezione  <a href ="./17Tutorials.php">Tutorials</a> -->
                        <br><br>
                        PER LE SEGRETERIE<br>
                        <br>
                        - Aggiunta la possibilità di calcolare codici fiscali anche per nati all'estero. Basta indicare nel campo comune il paese stesso
                        <br><br>
                        BUG FIX
                        <br>
                        - Sistemata la possibilità di caricare foto nel profilo di alunni con caratteri accentati nel nome
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