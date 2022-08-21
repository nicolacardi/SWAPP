<?php

# Fill our vars and run on cli
# $ php -f db-connect-test.php

$dbname = 'Sql1256175_1';
$dbuser = 'Sql1256175';
$dbpass = '586531rtj5';
$dbhost = "89.46.111.73";



$mysqli_connection = new MySQLi($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli_connection->connect_error) {
   echo "Not connected, error: " . $mysqli_connection->connect_error;
}
else {
   echo "Connected.";
}
?>