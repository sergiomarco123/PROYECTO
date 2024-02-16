<?php
if(isset($_FILES["file"])) {
    $targetDirectory = "uploads/";  // Directorio de destino para subir archivos
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
    $uploadOk = 1;

    // Verificar si el archivo ya existe
    if (file_exists($targetFile)) {
        echo "El archivo ya existe.";
        $uploadOk = 0;
    }

    // Verificar el tamaño del archivo
    if ($_FILES["file"]["size"] > 500000) {
        echo "El archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permitir solo ciertos formatos de archivo
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedFormats)) {
        echo "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $uploadOk = 0;
    }

    // Verificar si $uploadOk está configurado a 0 por un error
    if ($uploadOk == 0) {
        echo "No se pudo subir el archivo.";
    } else {
        // Mover el archivo a la carpeta "uploads"
        $newTargetFile = "uploads/" . basename($_FILES["file"]["name"]);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $newTargetFile)) {
            // Incluir el archivo "guardar.php" desde la carpeta "models"
            include_once("app/models/guardar.php");

            // Lógica adicional según tus necesidades en guardar.php
            // ...

            echo "El archivo " . basename($_FILES["file"]["name"]) . " ha sido subido y guardado correctamente.";
        } else {
            echo "Hubo un error al subir el archivo.";
        }
    }
}
?>

