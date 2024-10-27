<?php
session_start(); // Start session to track logged-in user
include("connect.php"); // Include database connection

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
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
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <link rel="stylesheet" href="studentpage.css">
</head>

<body>
    <div style="text-align:center; padding:15%;">
    <a href="logout.php"><button id = "logoutbutton">Log out</button></a>
        <p style="font-size:50px; font-weight:bold;">
            Welcome student
            <?php
            if (isset($_SESSION['userName'])) {
                $userName = $_SESSION['userName'];

                // Get the logged-in student's details
                $query = mysqli_query($conn, "SELECT * FROM `users` WHERE userName = '$userName' AND role = 'student'");
                $user = mysqli_fetch_array($query);

                // If the user is found, display their name
                if ($user) {
                    $userGroup = $user['group']; // Store the student's group
                    echo $user['firstName'] . ' ' . $user['lastName'];
                } else {
                    // If the user is not a student, redirect or show an error (optional handling)
                    echo "Unauthorized access.";
                    exit;
                }
            }
            ?>
        </p>

        <h2>User Information Table</h2>

        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Group</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to fetch only students from the same group, excluding teachers
                $groupQuery = mysqli_query($conn, "SELECT * FROM `users` 
                                                 WHERE `group` = '$userGroup' 
                                                 AND role = 'student' 
                                                 AND userName != '$userName'");

                // Check if there are any other students in the group
                if (mysqli_num_rows($groupQuery) > 0) {
                    // Loop through and display each student in the same group
                    while ($teammate = mysqli_fetch_array($groupQuery)) {
                        echo "<tr>";
                        echo "<td>" . $teammate['studentid'] . "</td>";
                        echo "<td>" . $teammate['firstName'] . "</td>";
                        echo "<td>" . $teammate['lastName'] . "</td>";
                        echo "<td>" . $teammate['group'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Display message if no teammates are found
                    echo "<tr><td colspan='4' style='text-align:center;'>You have no teammates in your group</td></tr>";
                }
                ?>
            </tbody>
        </table>

        //------------------------------------------------------------------------------------------------------------------------
        <div class="peer-evaluation" style="text-align:center; padding:20px;">
    <h2>Peer Evaluation</h2>
    <form method="POST" action="submit_evaluation.php">
        <label for="studentid"><strong>Select Student:</strong></label>
        <select name="studentid" required>
            <?php
            // Populate the dropdown with students in the same group
            mysqli_data_seek($groupQuery, 0); // Reset the pointer of the result set
            while ($teammate = mysqli_fetch_array($groupQuery)) {
                echo "<option value='" . $teammate['studentid'] . "'>" . $teammate['firstName'] . " " . $teammate['lastName'] . "</option>";
            }
            ?>
        </select>
        <br><br>

        <div class="evaluation-section" id="cooperation-section">
            <label><strong>Cooperation:</strong></label>
            <div class="card">
                <br />
                <span onclick="givestars(1, 'cooperation-section')" class="star">★</span>
                <span onclick="givestars(2, 'cooperation-section')" class="star">★</span>
                <span onclick="givestars(3, 'cooperation-section')" class="star">★</span>
                <span onclick="givestars(4, 'cooperation-section')" class="star">★</span>
                <span onclick="givestars(5, 'cooperation-section')" class="star">★</span>
                <h3 id="output-cooperation">Rating is: 0/5</h3>
            </div>
            <select name="rating" required>
                <option value="">Select Rating</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <textarea name="comment" placeholder="Optional comments for Cooperation" rows="4" style="width: 100%;"></textarea>
        </div>

        <div class="evaluation-section" id="contribution-section">
            <label><strong>Conceptual Contribution:</strong></label>
            <div class="card">
                <br />
                <span onclick="givestars(1, 'contribution-section')" class="star">★</span>
                <span onclick="givestars(2, 'contribution-section')" class="star">★</span>
                <span onclick="givestars(3, 'contribution-section')" class="star">★</span>
                <span onclick="givestars(4, 'contribution-section')" class="star">★</span>
                <span onclick="givestars(5, 'contribution-section')" class="star">★</span>
                <h3 id="output-contribution">Rating is: 0/5</h3>
            </div>
            <select name="rating1" required>
                <option value="">Select Rating</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <textarea name="comment1" placeholder="Optional comments for Conceptual Contribution" rows="4" style="width: 100%;"></textarea>
        </div>

        <div class="evaluation-section" id="practical-section">
            <label><strong>Practical Contribution:</strong></label>
            <div class="card">
                <br />
                <span onclick="givestars(1, 'practical-section')" class="star">★</span>
                <span onclick="givestars(2, 'practical-section')" class="star">★</span>
                <span onclick="givestars(3, 'practical-section')" class="star">★</span>
                <span onclick="givestars(4, 'practical-section')" class="star">★</span>
                <span onclick="givestars(5, 'practical-section')" class="star">★</span>
                <h3 id="output-practical">Rating is: 0/5</h3>
            </div>
            <select name="rating2" required>
                <option value="">Select Rating</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <textarea name="comment2" placeholder="Optional comments for Practical Contribution" rows="4" style="width: 100%;"></textarea>
        </div>

        <div class="evaluation-section" id="workethic-section">
            <label><strong>Work Ethic:</strong></label>
            <div class="card">
                <br />
                <span onclick="givestars(1, 'workethic-section')" class="star">★</span>
                <span onclick="givestars(2, 'workethic-section')" class="star">★</span>
                <span onclick="givestars(3, 'workethic-section')" class="star">★</span>
                <span onclick="givestars(4, 'workethic-section')" class="star">★</span>
                <span onclick="givestars(5, 'workethic-section')" class="star">★</span>
                <h3 id="output-workethic">Rating is: 0/5</h3>
            </div>
            <select name="rating3" required>
                <option value="">Select Rating</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <textarea name="comment3" placeholder="Optional comments for Work Ethic" rows="4" style="width: 100%;"></textarea>
        </div>

        <input type="submit" name="evalu" value="Submit Evaluation">
    </form>
</div>

        //------------------------------------------------------------------------------------------------------------------------


    </div>
    <script src="studentpage.js"></script>
</body>

</html>