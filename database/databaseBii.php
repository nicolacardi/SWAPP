<?

session_start();

$_SESSION['databaseB'] = 'swappwaldorfB';
$_SESSION['databaseA'] = 'swappwaldorf';
$codscuola="PD";

// Variabili per accesso al database
//$username = "Sql1256175";
//$password = "586531rtj5";
//$database = "Sql1256175_2";
//$host = "89.46.111.73";

$username = 'root';
$password = 'root';
$database = 'swappwaldorfB';
$host = 'localhost';

//lavoro in forma procedurale con la libreria mysqli
$mysqli = mysqli_connect($host, $username, $password, $database) or die("Connessione non riuscita: " . mysql_error());
mysqli_set_charset($mysqli, "latin1");
?>