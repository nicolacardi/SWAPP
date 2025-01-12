<?
include_once("database/databaseii.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ID_alu_doc = $_POST['ID_alu_doc'];
    $titolo_doc = $_POST['titolo_doc'];
    $tipo_doc = $_POST['tipo_doc'];
    $contenuto_doc = $_POST['contenuto_doc'];
    $data_doc = $_POST['data_doc'];
	$descrizione_doc = $_POST['descrizione_doc'];


    // Verifica che i parametri siano presenti
    if (!$titolo_doc || !$contenuto_doc || !$data_doc) {
        http_response_code(400);
        echo json_encode(['error' => 'Parametri mancanti.']);
        exit;
    }

    // Salva i dati nel database
    $sql = "INSERT INTO tab_documenti (ID_alu_doc, titolo_doc, tipo_doc, contenuto_doc, data_doc, descrizione_doc) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($mysqli, $sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Errore nella preparazione della query.']);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "isisss", $ID_alu_doc, $titolo_doc, $tipo_doc, $contenuto_doc, $data_doc, $descrizione_doc);
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['test' => 'File caricato correttamente.']);
        $return['msg'] = "File Caricato correttamente";
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Errore nell\'esecuzione della query.']);
    }

    mysqli_stmt_close($stmt);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Metodo non consentito.']);
}
?>
