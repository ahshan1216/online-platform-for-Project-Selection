<?php
include '../database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $student_id = $_POST['student_id'];
    $semester = $_POST['semester'];
    $teacher_id = $_POST['teacher_id'];
    $session1 = $_POST['session1'];
    $session12 = $_POST['session12'];

    // Extract file names
    $student_id_photo = isset($_FILES['student_id_photo']['name']) ? $_FILES['student_id_photo']['name'] : "";
    $student_profile_picture = isset($_FILES['student_profile_picture']['name']) ? $_FILES['student_profile_picture']['name'] : "";
    $teacher_id_photo = isset($_FILES['teacher_id_photo']['name']) ? $_FILES['teacher_id_photo']['name'] : "";
    $teacher_profile_picture = isset($_FILES['teacher_profile_picture']['name']) ? $_FILES['teacher_profile_picture']['name'] : "";
    

    $file_name_student_id_photo = $_FILES['student_id_photo']['name'];
    $file_tmp_student_id_photo = $_FILES['student_id_photo']['tmp_name'];
    $file_extension_student_id_photo = strtolower(pathinfo($file_name_student_id_photo, PATHINFO_EXTENSION));
    $filename_with_student_id_photo = $student_id . "_id_photo." . $file_extension_student_id_photo;


    $file_name_student_profile_picture = $_FILES['student_profile_picture']['name'];
    $file_tmp_student_profile_picture = $_FILES['student_profile_picture']['tmp_name'];
    $file_extension_student_profile_picture = strtolower(pathinfo($file_name_student_profile_picture, PATHINFO_EXTENSION));
    $filename_with_student_profile_photo = $student_id . "_profile." . $file_extension_student_profile_picture;


    $file_name_teacher_id_photo = $_FILES['teacher_id_photo']['name'];
    $file_tmp_teacher_id_photo = $_FILES['teacher_id_photo']['tmp_name'];
    $file_extension_teacher_id_photo = strtolower(pathinfo($file_name_teacher_id_photo, PATHINFO_EXTENSION));
    $filename_with_teacher_id_photo = $teacher_id . "_id_photo." . $file_extension_teacher_id_photo;

    $file_name_teacher_picture = $_FILES['teacher_profile_picture']['name'];
    $file_tmp_teacher_picture = $_FILES['teacher_profile_picture']['tmp_name'];
    $file_extension_teacher_picture = strtolower(pathinfo($file_name_teacher_picture, PATHINFO_EXTENSION));
    $filename_with_teacher_profile_photo = $teacher_id . "_profile." . $file_extension_teacher_picture;

// Set the maximum file size (in bytes)
$max_file_size = 1024 * 1024 * 15; // 15 MB

if($role == 'student')
{
    // Check if the user already exists in the database based on their email
$check_user_sql = "SELECT * FROM users WHERE email = '$email' AND student_id='$student_id'";
$result567 = $connection->query($check_user_sql);

if ($result567->num_rows > 0) {
    // If the user already exists, echo a message and stop the script execution
    echo "User_already_exists";
    exit();
} else {
    // Extract the file extension
$file_extension = pathinfo($filename_with_student_id_photo, PATHINFO_EXTENSION);
// Rename the file with a .webp extension
$filename_with_webp_extension = str_replace($file_extension, 'webp', $filename_with_student_id_photo);

$file_extension2 = pathinfo($filename_with_student_profile_photo, PATHINFO_EXTENSION);
// Rename the file with a .webp extension
$filename_with_webp_extension2 = str_replace($file_extension2, 'webp', $filename_with_student_profile_photo);

 // Prepare SQL statement to insert data into users table
 $sql = "INSERT INTO users (name, email, password, role, student_id, teacher_id, semester, id_photo, profile_picture,session,created_at) 
 VALUES ('$name', '$email', '$password', '$role', '$student_id', NULL , '$semester', '$filename_with_webp_extension', '$filename_with_webp_extension2', '$session1',NOW())";

$upload_dir = '../uploads/students/';

// The path to store the uploaded file
$target_path_student_id_photo = $upload_dir . basename($filename_with_student_id_photo);
$target_path_student_profile_photo = $upload_dir . basename($filename_with_student_profile_photo);

  // Get the file size
  $file_size_student_id_photo = $_FILES['student_id_photo']['size'];

   // Get the file size
   $file_size_student_profile_photo = $_FILES['student_profile_picture']['size'];

   
   if ($file_size_student_id_photo > $max_file_size && $file_size_student_profile_photo > $max_file_size ) {
    // Handle the case where the file size exceeds the limit
    echo "Error: Student Id photo size exceeds the maximum limit (15 MB).";
    exit();
}

// Attempt to move the uploaded files to the specified directory
if (!move_uploaded_file($file_tmp_student_id_photo, $target_path_student_id_photo) || !move_uploaded_file($file_tmp_student_profile_picture, $target_path_student_profile_photo)) {
    // Handle the case where the file could not be moved
    echo "Error: Failed to move the uploaded files.";
    exit();
}

// Convert images to WebP format
if (!convertToWebP($target_path_student_id_photo)) {
    echo "Error: Failed to convert student ID photo to WebP format.";
    exit();
}
if (!convertToWebP($target_path_student_profile_photo)) {
    echo "Error: Failed to convert student profile picture to WebP format.";
    exit();
}
}

}

else
{
// Check if the user already exists in the database based on their email
$check_user_sql = "SELECT * FROM users WHERE email = '$email' AND teacher_id='$teacher_id' ";
$result567 = $connection->query($check_user_sql);

if ($result567->num_rows > 0) {
    // If the user already exists, echo a message and stop the script execution
    echo "User_already_exists";
    exit();
} else {

       // Extract the file extension
$file_extension = pathinfo($filename_with_teacher_id_photo, PATHINFO_EXTENSION);
// Rename the file with a .webp extension
$filename_with_webp_extension = str_replace($file_extension, 'webp', $filename_with_teacher_id_photo);

$file_extension2 = pathinfo($filename_with_teacher_profile_photo, PATHINFO_EXTENSION);
// Rename the file with a .webp extension
$filename_with_webp_extension2 = str_replace($file_extension2, 'webp', $filename_with_teacher_profile_photo);
// Prepare SQL statement to insert data into users table
$sql = "INSERT INTO users (name, email, password, role, student_id, teacher_id,session, semester, id_photo, profile_picture, created_at) 
VALUES ('$name', '$email', '$password', '$role', 0, '$teacher_id' ,'$session12', NULL, '$filename_with_webp_extension', '$filename_with_webp_extension2', NOW())";


 $upload_dir = '../uploads/teachers/';
 
 // The path to store the uploaded file
 $target_path_teacher_id_photo = $upload_dir . basename($filename_with_teacher_id_photo);
 $target_path_teacher_profile_picture = $upload_dir . basename($filename_with_teacher_profile_photo);
 
   // Get the file size
   $file_size_teacher_id_photo = $_FILES['teacher_id_photo']['size'];
 
    // Get the file size
    $file_size_teacher_profile_picture = $_FILES['teacher_profile_picture']['size'];
 
    
    if ($file_size_teacher_id_photo > $max_file_size && $file_size_teacher_profile_picture > $max_file_size ) {
     // Handle the case where the file size exceeds the limit
     echo "Error: Student Id photo size exceeds the maximum limit (15 MB).";
     exit();
 }
 
 // Attempt to move the uploaded files to the specified directory
 if (!move_uploaded_file($file_tmp_teacher_id_photo, $target_path_teacher_id_photo) || !move_uploaded_file($file_tmp_teacher_picture, $target_path_teacher_profile_picture)) {
     // Handle the case where the file could not be moved
     echo "Error: Failed to move the uploaded files.";
     exit();
 }
 
 // Convert images to WebP format
 if (!convertToWebP($target_path_teacher_id_photo)) {
     echo "Error: Failed to convert student ID photo to WebP format.";
     exit();
 }
 if (!convertToWebP($target_path_teacher_profile_picture)) {
     echo "Error: Failed to convert student profile picture to WebP format.";
     exit();
 }


}
}

    // Execute SQL statement
    if ($connection->query($sql) === TRUE) {
        echo "New_record_created_successfully";
    } else {
        echo "User_already_exists";
    }

    // Close database connection
    $connection->close();
} else {
    // If the form is not submitted, redirect the user to the registration page
    header("Location: registration.php");
}




// Function to convert image to WebP format
function convertToWebP($imagePath)
{
    // Get image extension
    $imageExtension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

    // Check if the image is jpg, jpeg, or png
    if (in_array($imageExtension, ['jpg', 'jpeg', 'png'])) {
        // Load image
        $image = imagecreatefromstring(file_get_contents($imagePath));

        // Create WebP image
        $webpPath = pathinfo($imagePath, PATHINFO_DIRNAME) . '/' . pathinfo($imagePath, PATHINFO_FILENAME) . '.webp';
        if (!imagewebp($image, $webpPath, 85)) { // 85 is the quality, you can adjust as needed
            return false;
        }

        // Free up memory
        imagedestroy($image);

        // Remove the original image
        unlink($imagePath);

        return true;
    }

    return false;
}
?>
