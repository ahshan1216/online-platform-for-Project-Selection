<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Record</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Add custom styles here */
    .form-group {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Edit Record</h2>
    <?php
    // Include the database connection file
    include '../database.php';

    // Check if the table name and ID are provided in the URL
    if (isset($_GET['table']) && isset($_GET['id'])) {
        // Sanitize the inputs to prevent SQL injection
        $table = mysqli_real_escape_string($connection, $_GET['table']);
        $id = mysqli_real_escape_string($connection, $_GET['id']);

        // Fetch the data of the specified row
        $select_query = "SELECT * FROM $table WHERE id = $id";
        $result = mysqli_query($connection, $select_query);

        // Check if the row exists
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <form method="post" action="update.php">
              <?php
              foreach ($row as $field_name => $value) {
                  // Render input fields for each column
                  echo "<div class='form-group'>";
                  echo "<label for='$field_name'>$field_name:</label>";
                  echo "<input type='text' class='form-control' id='$field_name' name='$field_name' value='$value'>";
                  echo "</div>";
              }
              ?>
              <input type="hidden" name="table" value="<?php echo $table; ?>">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <button type="submit" class="btn btn-primary">Update</button>
            </form>
            <?php
        } else {
            echo "Row not found";
        }
    } else {
        echo "Table name and ID not provided";
    }

    // Close connection
    mysqli_close($connection);
    ?>
  </div>
</body>
</html>
