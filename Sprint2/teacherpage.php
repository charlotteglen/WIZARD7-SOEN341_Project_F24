<?php
// Start the session
session_start();
// Include the database connection file
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        /* Style for the table */
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            text-align: left;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            /* Border for table cells */
        }

        th {
            background-color: #f2f2f2;
            /* Header background color */
        }
    </style>
    <link rel="stylesheet" href="teacherpage.css"> <!-- Link to external CSS -->
</head>

<body>
    <div style="text-align:center; padding:15%;">
        <p style="font-size:50px; font-weight:bold;">
            Welcome Teacher
            <?php
            // Check if the user is logged in
            if (isset($_SESSION['userName'])) {
                $userName = $_SESSION['userName'];
                // Fetch user details from the database
                $query = mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.userName='$userName'");
                while ($row = mysqli_fetch_array($query)) {
                    // Display the teacher's full name
                    echo $row['firstName'] . ' ' . $row['lastName'];
                }
            }
            ?>
            !
        </p>
        <h2>User Information Table</h2>

        <table>
            <thead>
                <tr>
                    <!-- Table headers -->
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Role</th>
                    <th>Group</th>
                    <th>Cooperation Dimension</th>
                    <th>Conceptual Contribution</th> <!-- Added this column -->
                    <th>Practical Contribution</th>
                    <th>Work Ethic</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch only students from the database
                $allUsersQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE role='student'");

                // Loop through the results and display them in the table
                while ($user = mysqli_fetch_array($allUsersQuery)) {
                    echo "<tr>";
                    echo "<td>" . $user['studentid'] . "</td>"; // Display Student ID
                    echo "<td>" . $user['firstName'] . "</td>"; // Display First Name
                    echo "<td>" . $user['lastName'] . "</td>"; // Display Last Name
                    echo "<td>" . $user['role'] . "</td>"; // Display Role
                    echo "<td>" . $user['group'] . "</td>"; // Display Group
                    echo "<td>" . $user['evalu'] . "</td>"; // Display Cooperation Dimension
                    echo "<td>" . $user['evalu1'] . "</td>"; // Display Conceptual Contribution
                    echo "<td>" . $user['evalu2'] . "</td>"; // Display Practical Contribution
                    echo "<td>" . $user['evalu3'] . "</td>"; // Display Work Ethic
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="logout.php">Logout</a> <!-- Logout link -->
    </div>

    <div class="container" id="change">
        <h1 class="form-title">Assigning a student to a Group:</h1>
        <form method="post" action="register.php">
            <div class="input-group">
                <label for="studentid">Enter the Student ID:</label>
                <i class="fas fa-user"></i>
                <input type="text" name="studentid" id="studentid" placeholder="Student Id" required>
            </div>
            <div class="input-group">
                <label for="userName">Enter the Student's group:</label>
                <i class="fas fa-user"></i>
                <input type="text" name="group" id="group" placeholder="User Group" required>
            </div>
            <input type="submit" class="btn" value="Change" name="change"> <!-- Submit button -->
        </form>
    </div>
</body>

</html> 