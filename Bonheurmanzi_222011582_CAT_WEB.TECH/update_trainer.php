<?php
include('db_connection.php');

// Check if Trainer_Id is set
if (isset($_REQUEST['TrainerID'])) {
  $trnid = $_REQUEST['TrainerID'];
//trainer (TrainerID, Name, Specialization, ContactInformation
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM trainer WHERE TrainerID=?");
  $stmt->bind_param("i", $trnid);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $x = $row['TrainerID'];
    $y = $row['Name'];
    $z = $row['Specialization'];
    $w = $row['ContactInformation'];
  } else {
    echo "trainer not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update trainer</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update trainer form -->
    <h2><u>Update Form of trainer</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="trn_name">Name:</label>
    <input type="text" name="trn_name" value="<?php echo isset($y) ? $y : ''; ?>">
    <br><br>

    <label for="special">Specialization:</label>
    <input type="text" name="special" value="<?php echo isset($z) ? $z : ''; ?>">
    <br><br>

    <label for="cont_info">ContactInformation:</label>
    <input type="text" name="cont_info" value="<?php echo isset($w) ? $w : ''; ?>">
    <br><br>
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $trainer_name = $_POST['trn_name'];
  $specialize = $_POST['special'];
  $contact_info = $_POST['cont_info'];
//trainer (TrainerID, Name, Specialization, ContactInformation
  // Update the trainer in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE trainer SET Name=?, Specialization=?, ContactInformation=? WHERE TrainerID=?");
  $stmt->bind_param("sssi", $trainer_name, $specialize, $contact_info, $trnid);
  $stmt->execute();

  // Redirect to trainer.php
  header('Location: trainer.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>