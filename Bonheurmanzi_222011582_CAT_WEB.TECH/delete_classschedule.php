<?php
    // Connection details
    db_connection.php
    
// Check if applicant_info_Id is set
if(isset($_REQUEST['applicant_info_id'])) {
    $apid = $_REQUEST['applicant_info_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM applicant_info WHERE applicant_info_id=?");
    $stmt->bind_param("i", $apid);
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
            <input type="hidden" name="apid" value="<?php echo $apid; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br>echo 
             <a href='APPLICANT-INFO.php'>OK</a>";
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
    echo "applicant_info_id is not set.";
}

$connection->close();
?>
