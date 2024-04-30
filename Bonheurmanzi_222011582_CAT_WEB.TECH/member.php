<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Member table</title>
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
<h1>Member Form</h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="MemberID">MemberID:</label>
        <input type="text" id="mbr" name="mbr"><br><br>

        <label for="Name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="Address">Address:</label>
        <input type="text" id="v" name="v" required><br><br>

        <label for="Phone">Phone:</label>
        <input type="number" id="phn" name="phn" required><br><br>

        <label for="Email">Email:</label>
        <input type="email" id="eml" name="eml" required><br><br>

        <label for="DateOfBirth">DateOfBirth:</label>
        <input type="date" id="dbth" name="dbth" required><br><br>

        <label for="PaymentInformation">PaymentInformation:</label>
        <input type="text" id="pinf" name="pinf" required><br><br>


        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    // Connection details
    include('db_connection.php');

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters with appropriate data types
        $stmt = $connection->prepare("INSERT INTO member (MemberID, Name, Address, Phone, Email,DateOfBirth,PaymentInformation) VALUES (?, ?, ?, ?, ?,?,?)");
        $stmt->bind_param("issssss", $MemberID, $Name, $Address, $Phone, $Email,$DateOfBirth,$PaymentInformation);

        // Set parameters from POST data with validation (optional)
        $MemberID = ($_POST['mbr']); // Ensure integer for ID
        $Name = ($_POST['name']); 
        $Address = ($_POST['v']); 
        $Phone = filter_var($_POST['phn']); 
        $Email = ($_POST['eml']); 
        $DateOfBirth = ($_POST['dbth']);
       $PaymentInformation = ($_POST['pinf']);  
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

// SQL query to fetch data from member
$sql = "SELECT * FROM member";
$result = $connection->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Member</title>
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
    <center><h2>Table of Member</h2></center>
    <table border="5">
        <tr>
            <th>MemberID</th>
            <th>Name </th>
            <th>Address</th>
            <th>Phone</th>
            <th>Email</th>
            <th>DateOfBirth</th>
            <th>PaymentInformation</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
       
        // Define connection parameters
        // Connection details
    include('db_connection.php');
 
        // Prepare SQL query to retrieve all member
        $sql = "SELECT * FROM member";
        $result = $connection->query($sql);

        // Check if there are any member
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $mjid = $row['MemberID']; // Fetch the MemberID
                echo "<tr>
                    <td>" . $row['MemberID'] . "</td>
                    <td>" . $row['Name'] . "</td>
                    <td>" . $row['Address'] . "</td>
                    <td>" . $row['Phone'] . "</td>
                    <td>" . $row['Email'] . "</td>
                    <td>" . $row['DateOfBirth'] . "</td>
                    <td>" . $row['PaymentInformation'] . "</td>
                    <td><a style='padding:4px' href='delete_member.php?MemberID=$mjid'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_member.php?MemberID=$mjid'>Update</a></td> 
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
    <b><h2>2024, Designed by: @Bonheur Manzi</h2></b>
  </center>
</footer>
</body>
</html>