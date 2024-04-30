<?php
include('db_connection.php');

// Check if AttendanceID is set
if (isset($_REQUEST['AttendanceID'])) {
  $attid = $_REQUEST['AttendanceID'];
//attendance (AttendanceID, MemberID, Date, CheckInTime, CheckOutTime,TrainerID
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM attendance WHERE AttendanceID=?");
  $stmt->bind_param("i", $attid);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $x = $row['AttendanceID'];
    $y = $row['MemberID'];
    $z = $row['Date'];
    $w = $row['CheckInTime'];
    $t = $row['CheckOutTime'];
    $r = $row['TrainerID'];
  } else {
    echo "attendance not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update attendance</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update attendance form -->
    <h2><u>Update Form of attendance</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="attmemberId">MemberID:</label>
    <input type="number" name="attmemberId" value="<?php echo isset($y) ? $y : ''; ?>">
    <br><br>

    <label for="attendDate">Date:</label>
    <input type="date" name="attendDate" value="<?php echo isset($z) ? $z : ''; ?>">
    <br><br>

    <label for="CheckInTime"> CheckInTime:</label>
    <input type="time" name="CheckInTime" value="<?php echo isset($w) ? $w : ''; ?>">
    <br><br>

    <label for="CheckOutTime">CheckOutTime:</label>
    <input type="time" name="CheckOutTime" value="<?php echo isset($t) ? $t : ''; ?>">
    <br><br>

    <label for="trainerId">TrainerID:</label>
    <input type="number" name="trainerId" value="<?php echo isset($r) ? $r : ''; ?>">
    <br><br>
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $member_id = $_POST['attmemberId'];
  $attdate = $_POST['attendDate'];
  $check_InT = $_POST['CheckInTime'];
  $check_OutT = $_POST['CheckOutTime'];
  $trainer_id = $_POST['trainerId'];
//attendance (AttendanceID, MemberID, Date, CheckInTime, CheckOutTime,TrainerID
  // Update the attendance in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE attendance SET MemberID=?, Date=?, CheckInTime=?, CheckOutTime=?,TrainerID=? WHERE AttendanceID=?");
  $stmt->bind_param("issssi", $member_id, $attdate, $check_InT, $check_OutT, $trainer_id, $attid);
  $stmt->execute();

  // Redirect to attendance.php
  header('Location: attendance.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>