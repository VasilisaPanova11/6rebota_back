<?php
require_once 'helper.php';
require_once 'session_handler.php';

header("Content-Type: application/json");
$mysqli = openMysqli();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $mysqli->prepare('SELECT * FROM users WHERE ID = ?');
            $stmt->bind_param('i', $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            echo json_encode($result);
        } else {
            $result = $mysqli->query('SELECT * FROM users');
            $users = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($users);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $mysqli->prepare('INSERT INTO users (name, password) VALUES (?, ?)');
        $stmt->bind_param('ss', $data['name'], $data['password']);
        $stmt->execute();
        echo json_encode(["id" => $mysqli->insert_id]);
        if ($user && password_verify($data['password'], $user['password'])) {
            $_SESSION['username'] = $user['name'];
            $_SESSION['theme'] = 'dark';
            $_SESSION['language'] = 'ru'; 
            echo json_encode(['message' => 'Добро пожаловать, ' . $user['name']]);
        } else {
            echo json_encode(['error' => 'Неверные данные']);
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $mysqli->prepare('UPDATE users SET name = ?, password = ? WHERE ID = ?');
        $stmt->bind_param('ssi', $data['name'], $data['password'], $data['id']);
        $stmt->execute();
        echo json_encode(["updated" => $stmt->affected_rows]);
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $mysqli->prepare('DELETE FROM users WHERE ID = ?');
        $stmt->bind_param('i', $data['id']);
        $stmt->execute();
        echo json_encode(["deleted" => $stmt->affected_rows]);
        break;
}

$mysqli->close();
?>