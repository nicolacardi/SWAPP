<?//include_once("database/databaseii.php");
include_once("database/databaseii.php");  
//Non sono sicuro sia da includere....potrebbe essere una ripetizione in quanto OVUNQUE ci sia ifloggedin, prima c'è la include del database
//l'unico dubbio ce l'ho sul fatto che il file database ha dentro una session_start che potrebbe essere necessario

if (!loggedin()) {
echo "
<link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet'>
<link href='assets/css/style.css' rel='stylesheet' type='text/css'/>
<body style='background: lightblue url(\"./assets/img/background1.jpg\"); background-size: cover; '>
<div style='text-align: center'>
    <img style='width: 600px' src=\"./assets/img/oopsOutline.svg\">
<div>
<div style='text-align:center;'>
non si può accedere direttamente a questa pagina
<br>
<br>
<a href='index.php' style='text-align: center; border-radius: 10px; padding:6px 12px; background: #2389bc; color: #FFF; font-size: 1.1em; border: 2px solid white;'>Vai alla pagina di Login di SWAPP</a>
<div>
</body>";
die();
}
?>