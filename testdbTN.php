<?php

# Fill our vars and run on cli
# $ php -f db-connect-test.php

$dbname = 'Sql1592916_1';
$dbuser = 'Sql1592916';
$dbpass = 'LUR$YkgD76';
$dbhost = '31.11.39.64';


$mysqli_connection = new MySQLi($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli_connection->connect_error) {
   echo "Not connected, error: " . $mysqli_connection->connect_error;
}
else {
   echo "Connected.";
}
?>