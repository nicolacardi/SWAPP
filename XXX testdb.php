<?php

# Fill our vars and run on cli
# $ php -f db-connect-test.php

$dbname = 'swappwaldorf';
$dbuser = 'root';
$dbpass = 'root';
$dbhost = "localhost";



$mysqli_connection = new MySQLi($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli_connection->connect_error) {
   echo "Not connected, error: " . $mysqli_connection->connect_error;
}
else {
   echo "Connected.";
}
?>