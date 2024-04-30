<?php
include('db_connection.php');

// Check if ClassID is set
if (isset($_REQUEST['ClassID'])) {
  $clsid = $_REQUEST['ClassID'];
//classschedule (ClassID, TrainerID, Time, ClassType,Duration
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM classschedule WHERE ClassID=?");
  $stmt->bind_param("i", $clsid);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $x = $row['ClassID'];
    $y = $row['TrainerID'];
    $z = $row['Time'];
    $w = $row['ClassType'];
    $t = $row['Duration'];
    
  } else {
    echo "classschedule not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update classschedule</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update classschedule form -->
    <h2><u>Update Form of classschedule</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="trainId">TrainerID:</label>
    <input type="number" name="trainId" value="<?php echo isset($y) ? $y : ''; ?>">
    <br><br>

    <label for="clstime">Time:</label>
    <input type="time" name="clstime" value="<?php echo isset($z) ? $z : ''; ?>">
    <br><br>

    <label for="clstype">ClassType:</label>
    <input type="text" name="clstype" value="<?php echo isset($w) ? $w : ''; ?>">
    <br><br>

    <label for="durat">Duration:</label>
    <input type="time" name="durat" value="<?php echo isset($t) ? $t : ''; ?>">
    <br><br>

    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $trainer_id = $_POST['trainId'];
  $classTime = $_POST['clstime'];
  $classType = $_POST['clstype'];
  $classDuration = $_POST['durat'];
  
//classschedule (ClassID, TrainerID, Time, ClassType,Duration
  // Update the classschedule in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE classschedule SET TrainerID=?, Time=?, ClassType=?, Duration=? WHERE ClassID=?");
  $stmt->bind_param("isssi", $trainer_id, $classTime, $classType, $classDuration, $clsid);
  $stmt->execute();

  // Redirect to classschedule.php
  header('Location: classschedule.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>