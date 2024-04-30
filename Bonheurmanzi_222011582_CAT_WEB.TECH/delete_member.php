<?php
// Connection details
include('db_connection.php');

// Check if MemberID is set and is a valid integer
if (isset($_REQUEST['MemberID']) && is_numeric($_REQUEST['MemberID'])) {
    $pid = $_REQUEST['MemberID'];

    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM member WHERE MemberID=?");
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
        echo "<a href='member.php'>OK</a>";
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
    echo "Invalid or missing MemberID.";
}

$connection->close();
?>
