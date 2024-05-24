<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OCR System</title>
</head>
<body>

<h2>OCR System</h2>

<form action="extract_text.php" method="post" enctype="multipart/form-data">
    <input type="file" name="imageFile" accept="image/*">
    <input type="submit" value="Perform OCR">
</form>

</body>
</html>
