<?

include_once("database/databaseBii.php");


// Get All Table Names From the Database
$tables = array();
$sql = "SHOW TABLES";
$result = mysqli_query($mysqli, $sql);

while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

foreach ($tables as $table) {
    $query = "TRUNCATE $table";
    $result = mysqli_query($mysqli, $query);
}

echo json_encode($return);

?>