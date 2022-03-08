<?

session_start();

$_SESSION['databaseB'] = 'Sql1556573_2';
$_SESSION['databaseA'] = 'Sql1556573_1';
$codscuola="TV";

// Variabili per accesso al database
$username = "Sql1556573";
$password = "TV_mysql_64025";
$database = "Sql1556573_2";
$host = "31.11.39.53";

//$username = 'root';
//$password = '';
//$database = 'swappwaldorfB_treviso';
//$host = 'localhost';

//lavoro in forma procedurale con la libreria mysqli
$mysqli = mysqli_connect($host, $username, $password, $database) or die("Connessione non riuscita: " . mysql_error());
mysqli_set_charset($mysqli, "latin1");
?>
