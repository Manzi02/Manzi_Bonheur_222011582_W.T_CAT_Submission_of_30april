<?php
// Connection details
include('db_connection.php');

// Check if TrainerID is set and is a valid integer
if (isset($_REQUEST['TrainerID']) && is_numeric($_REQUEST['TrainerID'])) {
    $pid = $_REQUEST['TrainerID'];

    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM trainer WHERE trainer=?");
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
        echo "<a href='trainer.php'>OK</a>";
    } else {
        echo "Error deleting data: " . $stmt->error;
    }
}
?>
</body>
<?php

    $stmt->close();
} else {
    echo "Invalid or missing TrainerID.";
}

$connection->close();
?>