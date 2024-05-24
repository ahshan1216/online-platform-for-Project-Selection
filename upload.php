<?php

include 'database.php';
session_start();
$student_id = $_SESSION['student_id'];


$targetDir = "uploads/students/"; // Change this to your desired upload directory

// Check if the file parameter exists and the file is successfully uploaded
if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
    $tempFileName = $_FILES["file"]["tmp_name"];
    $originalFileName = basename($_FILES["file"]["name"]);
    $file_name = pathinfo($student_id, PATHINFO_FILENAME); // Extract the filename without extension
    $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION)); // Extract the file extension
    $webpFile = $targetDir . $file_name . '_profile.webp'; // Construct the target filename with .webp extension
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($webpFile)) {
        unlink($webpFile);
        echo "Existing file deleted. ";
    }

    // Check file size (you can adjust this)
    if ($_FILES["file"]["size"] >  20000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats (you can adjust this)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Convert image to WebP format
        $image = null;
        switch ($imageFileType) {
            case "jpg":
            case "jpeg":
                $image = imagecreatefromjpeg($tempFileName);
                break;
            case "png":
                $image = imagecreatefrompng($tempFileName);
                break;
            case "gif":
                $image = imagecreatefromgif($tempFileName);
                break;
        }

        if ($image !== false) {
            if (imagewebp($image, $webpFile)) {
                echo "The file " . htmlspecialchars($originalFileName) . " has been uploaded and converted to WebP.";
            } else {
                echo "Sorry, there was an error converting your file to WebP.";
            }
            imagedestroy($image);
        } else {
            echo "Sorry, there was an error processing your file.";
        }
    }
} else {
    echo "No file uploaded or an error occurred during upload.";
}
?>
