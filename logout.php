<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Out</title>
<script>
// Clear cache
///window.location.reload(true);

// Clear local storage
localStorage.clear();
</script>
</head>
<body>
<p>You have been successfully signed out. Redirecting...</p>

<script>
window.location.href = "credential/signin.php";

//exit(); // Make sure to stop the script execution after redirection

</script>
</body>
</html>
