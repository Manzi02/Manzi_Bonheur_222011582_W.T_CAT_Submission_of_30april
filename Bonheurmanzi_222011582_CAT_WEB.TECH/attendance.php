<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Attendance table</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;

      background-color: darkcyan;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1300px; /* Adjust this value as needed */

      padding: 8px;
     
    }
  </style>
  <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>
  
<header>
   

</head>

<body bgcolor="skyblue">
  <form class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
    <img src="./Images/4.jpg" width="90" height="60" alt="Logo">
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./HOME.html">HOME</a>
    <li style="display: inline; margin-right: 10px;"><a href="./ABOUT US.html">ABOUT US</a>
      <li style="display: inline; margin-right: 10px;"><a href="./CONTACT US.html">CONTACT US</a>
    <li style="display: inline; margin-right: 10px;"><a href="./attendance.php">Attendance</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./classschedule.php">Classschedule</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./equipment.php">Equipment</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./member.php">member</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./payment.php">Payment</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./trainer.php">Trainer</a>
  </li>
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color:darkgreen; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Change Acount</a>
        <a href="logout.php">Logout</a>
      </div>
    </li><br><br>
    
    
    
  </ul>

</header>
<section>
<h1>Attendance Form</h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="AttendanceID">AttendanceID:</label>
        <input type="number" id="atid" name="atid"><br><br>

        <label for="MemberID">MemberID:</label>
        <input type="number" id="mbrid" name="mbrid" required><br><br>

        <label for="Date">Date:</label>
        <input type="date" id="dt" name="dt" required><br><br>

        <label for="CheckInTime">CheckInTime:</label>
        <input type="time" id="cht" name="cht" required><br><br>

        <label for="CheckOutTime">CheckOutTime:</label>
        <input type="time" id="chtt" name="chtt" required><br><br>

        <label for="TrainerID">TrainerID:</label>
        <textarea id="number" name="trid" required></textarea><br><br>

        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    // Connection details
    include('db_connection.php');

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters with appropriate data types
        $stmt = $connection->prepare("INSERT INTO attendance (AttendanceID, MemberID, Date, CheckInTime, CheckOutTime,TrainerID) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $AttendanceID, $MemberID, $Date, $CheckInTime, $CheckOutTime, $TrainerID);

        // Set parameters from POST data with validation (optional)
        $AttendanceID = intval($_POST['atid']); // Ensure integer for ID
        $MemberID = htmlspecialchars($_POST['mbrid']); // Prevent XSS
        $Date = htmlspecialchars($_POST['dt']); // Prevent XSS
        $CheckInTime = filter_var($_POST['cht'], FILTER_SANITIZE_EMAIL); // Validate email
        $CheckOutTime = filter_var($_POST['chtt'], FILTER_SANITIZE_NUMBER_INT);
        $TrainerID = filter_var($_POST['trid'], FILTER_SANITIZE_NUMBER_INT);
         // Sanitize phone number
        // Execute prepared statement with error handling
        if ($stmt->execute()) {
            echo "New record has been added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $connection->close();
    ?>

<?php
// Connection details
   include('db_connection.php');
  
// SQL query to fetch data from attendance table
$sql = "SELECT * FROM attendance";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of APPLICANT-INFO</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>Table of Attendance</h2></center>
    <table border="5">
        <tr>
            <th>AttendanceID</th>
            <th>MemberID</th>
            <th>Date</th>
            <th>CheckInTime</th>
            <th>CheckOutTime</th>
            <th>TrainerID</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Define connection parameters
        // Connection details
    include('db_connection.php');

        // Prepare SQL query to retrieve all attendance
        $sql = "SELECT * FROM attendance";
        $result = $connection->query($sql);

        // Check if there are any products
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $appid = $row['AttendanceID']; // Fetch the AttendanceID
                echo "<tr>
                    <td>" . $row['AttendanceID'] . "</td>
                    <td>" . $row['MemberID'] . "</td>
                    <td>" . $row['Date'] . "</td>
                    <td>" . $row['CheckInTime'] . "</td>
                    <td>" . $row['CheckOutTime'] . "</td>
                    <td>" . $row['TrainerID'] . "</td>
                    <td><a style='padding:4px' href='delete_attendance.php?AttendanceID=$appid'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_attendance.php?AttendanceID=$appid'>Update</a></td> 
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
  </body>
    </section>

  
<footer>
  <center> 
     <b><h2>2024, Designed by: @Bonheur Manzi </h2></b>>
  </center>
</footer>
</body>
</html>