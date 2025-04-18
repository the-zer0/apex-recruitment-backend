<?php
function uploadResume($file) {
    $target_dir = __DIR__ . '/../assets/uploads/';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($file["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($fileType !== "pdf") return false;

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return 'assets/uploads/' . basename($file["name"]);
    }

    return false;
}
?>
