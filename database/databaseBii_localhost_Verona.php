<?

session_start();

$_SESSION['databaseB'] = 'swappwaldorfB_verona';
$_SESSION['databaseA'] = 'swappwaldorf_verona';
$codscuola="VR";

// Variabili per accesso al database
//$username = "Sql1506443";
//$password = "g18b474580";
//$database = "Sql1506443_2";
//$host = "89.46.111.90";

$username = 'root';
$password = 'root';
$database = 'swappwaldorfB_verona';
$host = 'localhost';

//lavoro in forma procedurale con la libreria mysqli
$mysqli = mysqli_connect($host, $username, $password, $database) or die("Connessione non riuscita: " . mysql_error());
mysqli_set_charset($mysqli, "latin1");
?>