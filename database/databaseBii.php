<?

session_start();

$_SESSION['databaseB'] = 'swappwaldorfB_cittadella';
$_SESSION['databaseA'] = 'swappwaldorf_cittadella';
$codscuola="CI";

// Variabili per accesso al database
//$username = "Sql1461883";
//$password = "820ub834wr";
//$database = "Sql1461883_2";
//$host = "89.46.111.24";

$username = 'root';
$password = 'root';
$database = 'swappwaldorfB_cittadella';
$host = 'localhost';

//lavoro in forma procedurale con la libreria mysqli
$mysqli = mysqli_connect($host, $username, $password, $database) or die("Connessione non riuscita: " . mysql_error());
mysqli_set_charset($mysqli, "latin1");
?>