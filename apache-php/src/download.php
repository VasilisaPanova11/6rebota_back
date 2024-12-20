<?php
if (isset($_GET['file'])) {
    $file = __DIR__ . '/uploads/' . basename($_GET['file']);
    
    if (file_exists($file)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        readfile($file);
    } else {
        echo json_encode(['error' => 'Файл не найден']);
    }
}
?>
