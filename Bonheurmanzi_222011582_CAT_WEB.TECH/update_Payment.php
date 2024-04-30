<?php
include('db_connection.php');

// Check if Payment_Id is set
if (isset($_REQUEST['PaymentID'])) {
  $payid = $_REQUEST['PaymentID'];
//payment (PaymentID, MemberID, Date, Amount, PaymentMethod,TransactionID
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM payment WHERE PaymentID=?");
  $stmt->bind_param("i", $payid);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $x = $row['PaymentID'];
    $y = $row['MemberID'];
    $z = $row['Date'];
    $w = $row['Amount'];
    $t = $row['PaymentMethod'];
    $h = $row['TransactionID'];
  } else {
    echo "payment not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update payment</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update payment form -->
    <h2><u>Update Form of payment</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="Member_id">MemberID:</label>
    <input type="number" name="Member_id" value="<?php echo isset($y) ? $y : ''; ?>">
    <br><br>

    <label for="payDt">Date:</label>
    <input type="date" name="payDt" value="<?php echo isset($z) ? $z : ''; ?>">
    <br><br>

    <label for="payAmnt">Amount:</label>
    <input type="number" name="payAmnt" value="<?php echo isset($w) ? $w : ''; ?>">
    <br><br>

    <label for="payMthd">PaymentMethod:</label>
    <input type="text" name="payMthd" value="<?php echo isset($t) ? $t : ''; ?>">
    <br><br>

    <label for="trans_id">TransactionID:</label>
    <input type="number" name="trans_id" value="<?php echo isset($h) ? $h : ''; ?>">
    <br><br>
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $memb_id = $_POST['Member_id'];
  $paymntDate = $_POST['payDt'];
  $paymntAmount = $_POST['payAmnt'];
  $paymntMethod = $_POST['payMthd'];
  $transact_id = $_POST['trans_id'];
//payment (PaymentID, MemberID, Date, Amount, PaymentMethod,TransactionID
  // Update the payment in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE payment SET MemberID=?, Date=?, Amount=?, PaymentMethod=?,TransactionID=? WHERE PaymentID=?");
  $stmt->bind_param("issssi", $memb_id, $paymntDate, $paymntAmount, $paymntMethod, $transact_id, $payid);
  $stmt->execute();

  // Redirect to payment.php
  header('Location: payment.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>