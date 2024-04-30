<?php
include('db_connection.php');

// Check if EquipmentID is set
if (isset($_REQUEST['EquipmentID'])) {
  $equip_id = $_REQUEST['EquipmentID'];
//equipment (EquipmentID, Name, Type, Quantity, PurchaseDate
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM equipment WHERE EquipmentID=?");
  $stmt->bind_param("i", $equip_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $x = $row['EquipmentID'];
    $y = $row['Name'];
    $z = $row['Type'];
    $w = $row['Quantity'];
    $t = $row['PurchaseDate'];
    
  } else {
    echo "equipment  not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update equipment </title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update equipment  form -->
    <h2><u>Update Form of equipment </u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo isset($y) ? $y : ''; ?>">
    <br><br>

    <label for="type">Type:</label>
    <input type="text" name="Type" value="<?php echo isset($z) ? $z : ''; ?>">
    <br><br>

    <label for="equip_qty"> Quantity:</label>
    <input type="number" name="equip_qty" value="<?php echo isset($w) ? $w : ''; ?>">
    <br><br>

    <label for="purchDate"> PurchaseDate:</label>
    <input type="date" name="purchDate" value="<?php echo isset($t) ? $t : ''; ?>">
    <br><br>

    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $equip_name = $_POST['name'];
  $equip_type = $_POST['type'];
  $equip_quantity = $_POST['equip_qty'];
  $equip_purchDate = $_POST['purchDate'];
  
//equipment (EquipmentID, Name, Type, Quantity, PurchaseDate
  // Update the equipment in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE equipment SET Name=?, Type=?, Quantity=?, PurchaseDate=? WHERE EquipmentID=?");
  $stmt->bind_param("issssi", $equip_name, $equip_type, $equip_quantity, $equip_purchDate, $equip_id);
  $stmt->execute();

  // Redirect to equipment.php
  header('Location: equipment.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>