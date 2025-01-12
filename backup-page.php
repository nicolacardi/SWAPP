<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup Scuola</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Backup Database</h1>
    <button onclick="backupScuola('AR', 'Arca','A')">Backup Arca</button>
    <button onclick="backupScuola('PD','Padova','A')">Backup Padova</button>
    <button onclick="backupScuola('CI','Cittadella','A')">Backup Cittadella</button>
    <button onclick="backupScuola('TN','Trento','A')">Backup Trento</button>
    <button onclick="backupScuola('TV','Treviso','A')">Backup Treviso</button>
    <button onclick="backupScuola('VR','Verona','A')">Backup Verona</button>
    <h1>Database Iscrizioni</h1>
    <button onclick="backupScuola('AR','Arca', 'B')">Backup Arca</button>
    <button onclick="backupScuola('PD','Padova', 'B')">Backup Padova</button>
    <button onclick="backupScuola('CI','Cittadella', 'B')">Backup Cittadella</button>
    <button onclick="backupScuola('TN','Trento', 'B')">Backup Trento</button>
    <button onclick="backupScuola('TV','Treviso', 'B')">Backup Treviso</button>
    <button onclick="backupScuola('VR','Verona', 'B')">Backup Verona</button>
</body>
</html>
<script>
// function backupScuolaPOST(database, BB) {
//     //NON SI PUO' FARE CON UNA CHIAMATA AJAX - POST
//     console.log(`Inizio backup per il codice: ${database} ${BB}`);
//     postData = { database: database, BB: BB };
//     console.log('backup-page2.php - postData a backup-handler.php - postData');
//     console.log (postData);
//     $.ajax({
//         type: 'POST',
//         url: "backupTEST.php",
//         data: postData,
//         dataType: 'json',
//         success: function(data){
//             // console.log ("file: "+data.file);
//             // console.log("test1: "+data.test1);
//             // console.log("host: "+data.host)
//             // console.log("script: "+data.script);
//             // console.log("backup_file_name: "+data.backup_file_name);
//             // console.log("headerssent: "+data.headerssent);
//             // console.log("obendtoclean: "+data.obendtoclean);
//             // console.log("filereadable: "+data.filereadable);
//             // console.log("testx: "+data.testx);
//             // console.log("ob_get_length: "+data.ob_get_length);

//         },
//         error: function(){
//             alert("Errore durante la comunicazione con il server."); 
//         }
//     });
// }


function backupScuola(cod, scuola, BB) {
    console.log(`Inizio backup per il codice: ${cod} ${scuola} ${BB}`);
    const url = `backup-handler.php?cod=${encodeURIComponent(cod)}&scuola=${encodeURIComponent(scuola)}&BB=${encodeURIComponent(BB)}`;
    window.location.href = url; // Reindirizza al file PHP per avviare il download
}
</script>