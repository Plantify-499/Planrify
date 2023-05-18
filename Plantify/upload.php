<?php
$title = 'Uploads Page';
require_once 'template/header.php';

$uploadDir = 'uploads/'; // Directory to save uploaded photos
$allowedExtensions = array('jpg', 'jpeg', 'png'); // Allowed file extensions
$maxFileSize = 5 * 1024 * 1024; // Max file size in bytes (5MB)

// Check if "uploads" directory exists, create it if not
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Check if a file was uploaded
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Get file details
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // Get file extension
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check if the file extension is allowed
    if (in_array($fileExtension, $allowedExtensions)) {
        // Check if file size is within the allowed limit
        if ($fileSize <= $maxFileSize) {
            // Generate a unique file name starting with userID_
            $newFileName = $_SESSION['user_id']."_".uniqid('', true) . '.' . $fileExtension;

            // Move the uploaded file to the upload directory
            if (move_uploaded_file($fileTmpName, $uploadDir . $newFileName)) {
                echo "File Uploaded Successfuly";
            } else {
                echo 'Failed to upload file. Please try again.';
            }
        } else {
            echo 'File size exceeds the allowed limit. Max file size is 5MB.';
        }
    } else {
        echo 'Invalid file type. Allowed file types are JPG, JPEG, and PNG.';
    }
}


?>
