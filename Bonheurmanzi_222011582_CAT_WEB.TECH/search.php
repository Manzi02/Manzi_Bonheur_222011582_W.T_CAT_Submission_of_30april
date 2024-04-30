<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {
    // Connection details
    include('db_connection.php');
    
    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);
   //attendance (AttendanceID, MemberID, Date, CheckInTime, CheckOutTime,TrainerID
    // Queries for different tables
    $queries = [
        'attendance' => "SELECT AttendanceID FROM attendance WHERE AttendanceID LIKE '%$searchTerm%'",
        'classschedule' => "SELECT ClassID FROM classschedule WHERE ClassID LIKE '%$searchTerm%'",
        'equipment' => "SELECT EquipmentID FROM equipment WHERE EquipmentID LIKE '%$searchTerm%'",
        'member' => "SELECT Name FROM member WHERE Name LIKE '%$searchTerm%'",
        'payment' => "SELECT PaymentMethod FROM payment WHERE PaymentMethod LIKE '%$searchTerm%'",
        'trainer' => "SELECT Name FROM trainer WHERE Name LIKE '%$searchTerm%'"
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
