<?php
include('db_connection.php');

// Check if member_Id is set
if (isset($_REQUEST['MemberID'])) {
  $memberId = $_REQUEST['MemberID'];
//member (MemberID, Name, Address, Phone, Email,DateOfBirth,PaymentInformation
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM member WHERE MemberID=?");
  $stmt->bind_param("i", $memberId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $x = $row['MemberID'];
    $y = $row['Name'];
    $z = $row['Address'];
    $w = $row['Phone'];
    $v = $row['Email'];
    $t = $row['DateOfBirth'];
    $r = $row['PaymentInformation'];
  } else {
    echo "member not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update member</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update member form -->
    <h2><u>Update Form of member</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="M_name">Name:</label>
    <input type="text" name="M_name" value="<?php echo isset($y) ? $y : ''; ?>">
    <br><br>

    <label for="M_address">Address:</label>
    <input type="text" name="M_address" value="<?php echo isset($z) ? $z : ''; ?>">
    <br><br>

    <label for="M_phone">Phone:</label>
    <input type="text" name="M_phone" value="<?php echo isset($w) ? $w : ''; ?>">
    <br><br>

    <label for="M_email">Email:</label>
    <input type="email" name="M_email" value="<?php echo isset($v) ? $v : ''; ?>">
    <br><br>

    <label for="M_dob">DateOfBirth:</label>
    <input type="date" name="M_dob" value="<?php echo isset($t) ? $t : ''; ?>">
    <br><br>

    <label for="pay_info">PaymentInformation:</label>
    <input type="text" name="pay_info" value="<?php echo isset($r) ? $r : ''; ?>">
    <br><br>


    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $member_name = $_POST['M_name'];
  $member_address = $_POST['M_address'];
  $member_phone = $_POST['M_phone'];
  $member_email = $_POST['M_email'];
  $member_dob = $_POST['M_dob'];
  $payment_information = $_POST['pay_info'];
//member (MemberID, Name, Address, Phone, Email,DateOfBirth,PaymentInformation
  // Update the member in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE member SET Name=?, Address=?, Phone=?, Email=?, DateOfBirth=?, PaymentInformation=? WHERE MemberID=?");
  $stmt->bind_param("ssssssi", $member_name, $member_address, $member_phone, $member_email, $member_dob, $payment_information, $memberId);
  $stmt->execute();

  // Redirect to member.php
  header('Location: member.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
