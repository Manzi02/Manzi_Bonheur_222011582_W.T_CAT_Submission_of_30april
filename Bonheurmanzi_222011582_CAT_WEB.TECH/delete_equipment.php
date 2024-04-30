<?php
// Connection details
include('db_connection.php');

// Check if EquipmentID is set and is a valid integer
if (isset($_REQUEST['EquipmentID']) && is_numeric($_REQUEST['EquipmentID'])) {
    $pid = $_REQUEST['EquipmentID'];

    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM equipment WHERE EquipmentID=?");
    $stmt->bind_param("i", $pid);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this record?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="pid" value="<?php echo $pid; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br>";
        echo "<a href='equipment.php'>OK</a>";
    } else {
        echo "Error deleting data: " . $stmt->error;
    }
}
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Invalid or missing EquipmentID.";
}

$connection->close();
?>
