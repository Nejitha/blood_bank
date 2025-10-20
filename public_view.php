<?php
// --- Database Connection ---
include('db.php'); // make sure this file defines $conn = mysqli_connect(...)

// --- Search feature ---
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM donors 
            WHERE name LIKE '%$search%' 
               OR blood_group LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM donors";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Donors List</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: #fdf6f6;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .header {
            background: crimson;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .container {
            width: 85%;
            margin: 30px auto;
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        th {
            background: crimson;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        tr:hover {
            background: #ffeaea;
        }
        .search-bar {
            margin-top: 15px;
        }
        input[type="text"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 40%;
        }
        button {
            background: crimson;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: darkred;
        }
        .reset {
            background: #555;
            color: #fff;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <h2>🩸 Blood Donors List</h2>
    <a href="login.php">🏥 Hospital Login</a>
</div>

<div class="container">
    <!-- Search -->
    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Search by Name or Blood Group" 
               value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
        <a href="public_view.php" class="reset">Reset</a>
    </form>

    <!-- Donor Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Blood Group</th>
            <th>Age</th>
            <th>Email</th>
            <th>Contact</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['blood_group']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['contact']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No donors found</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>