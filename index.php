<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Add new donor
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $blood = $_POST['blood_group'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];

    $insert = "INSERT INTO donors (name, email, blood_group, age, contact)
               VALUES ('$name','$email','$blood','$age','$contact')";
    mysqli_query($conn, $insert);
}

// Search donors
$search_query = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $search_query = "WHERE name LIKE '%$search%' OR blood_group LIKE '%$search%'";
}

$result = mysqli_query($conn, "SELECT * FROM donors $search_query");
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Blood Donation Management System</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>🩸 Blood Donation Management System</h1>
    <a href="logout.php" class="logout-btn">Logout</a>

    <!-- Add Donor Form -->
    <form method="POST" action="" class="add-donor-form">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="blood_group" placeholder="Blood Group" required>
        <input type="number" name="age" placeholder="Age" required>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <button type="submit" name="submit">Add Donor</button>
    </form>

    <!-- Search Donor -->
    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Search by name or blood group"
               value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Search</button>
        <a href="index.php" class="reset">Reset</a>
    </form>

    <!-- Donor Table -->
    <h2>Registered Donors</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Blood Group</th>
            <th>Age</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>".$row['id']."</td>
                        <td>".$row['name']."</td>
                        <td>".$row['blood_group']."</td>
                        <td>".$row['age']."</td>
                        <td>".$row['email']."</td>
                        <td>".$row['contact']."</td>
                        <td>
                            <a class='edit-btn' href='edit.php?id=".$row['id']."'>Edit</a>
                            <a class='delete-btn' href='delete.php?id=".$row['id']."' onclick=\"return confirm('Are you sure you want to delete this donor?');\">Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No donors found</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>