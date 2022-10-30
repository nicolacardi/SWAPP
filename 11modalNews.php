<!--***************************************NOVITA' DI SWAPP **************************************************-->
<div class="modal" id="modalNews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="font-size:14px; width: 50%: margin: auto;">
        <div class="modal-content">
            <div class="modal-body white">           
                <form id="form_News" method="post">
                    <span class="titoloModal">Novità di SWAPP - Ottobre 2022</span><br>
                    <img style="width: 80px; text-align: center;" src="assets/img/Icone/Megafono.svg">
                    <div id="remove-content" style="text-align: justify; margin-top: 5px; margin-left: 80px; margin-right: 80px;"> <!-- START REMOVE CONTENT -->
                        PER I MAESTRI<br>
                        <br>
                        - E' ora possibile inserire nell'orario anche le uscite didattiche (senza l'indicazione di un maestro]<br>
                        - E' ora possibile impostare la DAD sia individualmente per un singolo alunno che per una classe intera<br>
                        - A questo scopo è disponibile un nuovo video specifico nella sezione  <a href ="./17Tutorials.php">Tutorials</a>
                        <br><br>
                        PER LA SEGRETERIA<br>
                        <br>
                        -E' stata introdotta una nuova sezione relativa ai soci!
                        <br>
                        -I genitori soci vengono automaticamente copiati nel libro soci, così come i maestri soci
                        <br>
                        -E' possibile stampare il libro soci e l'anagrafica dei soci
                        <br>
                        -E' possibile inserire soci che non siano nè genitori nè insegnanti
                        <br>
                        ATTENZIONE: SI TRATTA DI UNA SEZIONE SPERIMENTALE, IN FASE DI TEST
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