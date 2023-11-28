<?

session_start();

$_SESSION['databaseB'] = 'swappwaldorfB_treviso';
$_SESSION['databaseA'] = 'swappwaldorf_treviso';
$codscuola="TV";

// Variabili per accesso al database
// $username = "Sql1556573";
// $password = "TV_mysql_64025";
// $database = "Sql1556573_1";
// $host = "31.11.39.53";

$username = 'root';
$password = 'root';
$database = 'swappwaldorf_treviso';
$host = 'localhost';

//lavoro in forma procedurale con la libreria mysqli
$mysqli = mysqli_connect($host, $username, $password, $database) or die("Connessione non riuscita: " . mysql_error());
mysqli_set_charset($mysqli, "latin1");
?>