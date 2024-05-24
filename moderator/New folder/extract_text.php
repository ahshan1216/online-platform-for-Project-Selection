<?php
        // Perform OCR using Google Cloud Vision API
        require 'vendor/autoload.php'; // Include Google Cloud client library

// Import the required classes
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
// Check if form is submitted and file is uploaded
// Set the path to your service account key file
$keyFilePath = 'c.json';

// Set the GOOGLE_APPLICATION_CREDENTIALS environment variable
putenv("GOOGLE_APPLICATION_CREDENTIALS=$keyFilePath");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imageFile"])) {
    // Process uploaded file
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["imageFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
    if ($check !== false) {
        // File is an image - proceed with OCR
        move_uploaded_file($_FILES["imageFile"]["tmp_name"], $targetFile);



        // Create an ImageAnnotatorClient
        $imageAnnotator = new ImageAnnotatorClient();

        // Read the image file into a string
        $imageContent = file_get_contents($targetFile);

        // Call the text detection API
        $response = $imageAnnotator->textDetection($imageContent);

        // Get the text annotations from the response
        $annotations = $response->getTextAnnotations();

        // Extract text from annotations
        $extractedText = '';
        foreach ($annotations as $annotation) {
            $extractedText .= $annotation->getDescription() . ' ';
        }

        // Clean up
        $imageAnnotator->close();

        // Display extracted text
        echo "<h2>Extracted Text</h2>";
        echo "<pre>$extractedText</pre>";
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
} else {
    // If form is not submitted, redirect to the index page
    header("Location: index.html");
}
?>
