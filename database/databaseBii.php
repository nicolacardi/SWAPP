<?

session_start();

$_SESSION['databaseB'] = 'swappwaldorfB_arca';
$_SESSION['databaseA'] = 'swappwaldorf_arca';
$codscuola="AR";

// Variabili per accesso al database
//$username = "Sql1639091";
//$password = "NickCards2!";
//$database = "Sql1639091_3";
//$host = "89.46.111.235";

$username = 'root';
$password = 'root';
$database = 'swappwaldorfB_arca';
$host = 'localhost';

//lavoro in forma procedurale con la libreria mysqli
$mysqli = mysqli_connect($host, $username, $password, $database) or die("Connessione non riuscita: " . mysql_error());
mysqli_set_charset($mysqli, "latin1");
?>