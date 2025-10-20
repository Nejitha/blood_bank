<?php
include 'db.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM donors WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
}

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $blood = $_POST['blood_group'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];

    $update = "UPDATE donors SET 
               name='$name', email='$email', blood_group='$blood', age='$age', contact='$contact'
               WHERE id=$id";
    mysqli_query($conn, $update);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Donor</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>✏️ Edit Donor Details</h1>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
        <input type="text" name="blood_group" value="<?php echo $row['blood_group']; ?>" required>
        <input type="number" name="age" value="<?php echo $row['age']; ?>" required>
        <input type="text" name="contact" value="<?php echo $row['contact']; ?>" required>
        <button type="submit" name="update">Update Donor</button>
        <a href="index.php" class="reset">Cancel</a>
    </form>
</div>
</body>
</html>