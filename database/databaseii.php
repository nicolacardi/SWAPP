<?

session_start();

$_SESSION['databaseB'] = 'swappwaldorfB_trento';
$_SESSION['databaseA'] = 'swappwaldorf_trento';
$codscuola="TN";

// Variabili per accesso al database
//$username = "Sql1592916";
//$password = "LUR$YkgD76";
//$database = "Sql1592916_1";
//$host = "31.11.39.64";

$username = 'root';
$password = 'root';
$database = 'swappwaldorf_trento';
$host = 'localhost';

//lavoro in forma procedurale con la libreria mysqli
$mysqli = mysqli_connect($host, $username, $password, $database) or die("Connessione non riuscita: " . mysql_error());
mysqli_set_charset($mysqli, "latin1");
?>