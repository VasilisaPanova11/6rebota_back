<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] == 0) {
        // Путь 
        $uploadDir = 'uploads/';
        
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir);
        }

        
        $uploadFile = $uploadDir . basename($_FILES['pdfFile']['name']);
        
        if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $uploadFile)) {
            echo "Файл успешно загружен.";
        } else {
            echo "Ошибка при загрузке файла.";
        }
    } else {
        echo "Ошибка: " . $_FILES['pdfFile']['error'];
    }
}


if (isset($_GET['file'])) {
    $filePath = 'uploads/' . basename($_GET['file']); 

    if (file_exists($filePath)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        readfile($filePath);
        exit;
    } else {
        echo "Файл не найден.";
    }
}
?>


<!DOCTYPE html>
<html lang="ru">
<body>
<button onclick="window.location.replace('/index.html')">На главную</button>
    
    <h1>Загрузка PDF файла</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Выберите PDF файл для загрузки:
        <input type="file" name="pdfFile" accept="application/pdf" required>
        <input type="submit" value="Загрузить">
    </form>

</body>
</html>