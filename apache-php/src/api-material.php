<?php
require_once 'helper.php';

header("Content-Type: application/json");
$mysqli = openMysqli();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $mysqli->prepare('SELECT * FROM material WHERE ID = ?');
            $stmt->bind_param('i', $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            echo json_encode($result);
        } else {
            $result = $mysqli->query('SELECT * FROM material');
            $materials = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($materials);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $mysqli->prepare('INSERT INTO material (title, discription, cost) VALUES (?, ?, ?)');
        $stmt->bind_param('ssi', $data['title'], $data['discription'], $data['cost']);
        $stmt->execute();
        echo json_encode(["id" => $mysqli->insert_id]);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $mysqli->prepare('UPDATE material SET title = ?, discription = ?, cost = ? WHERE ID = ?');
        $stmt->bind_param('ssii', $data['title'], $data['discription'], $data['cost'], $data['id']);
        $stmt->execute();
        echo json_encode(["updated" => $stmt->affected_rows]);
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $mysqli->prepare('DELETE FROM material WHERE ID = ?');
        $stmt->bind_param('i', $data['id']);
        $stmt->execute();
        echo json_encode(["deleted" => $stmt->affected_rows]);
        break;
}

$mysqli->close();
?>