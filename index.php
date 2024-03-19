<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <style>
        .remove-btn {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
    
<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'todolist';
$conn = mysqli_connect($host, $username, $password, $database);

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "INSERT INTO todoitems (Title, Description) VALUES ('$title', '$description')";
    mysqli_query($conn, $sql);
}

if(isset($_GET['remove'])) {
    $itemNum = $_GET['remove'];

    $sql = "DELETE FROM todoitems WHERE ItemNum = $itemNum";
    mysqli_query($conn, $sql);
}

$sql = "SELECT * FROM todoitems";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)){
        $itemNum = $row['ItemNum'];
        $title = $row['Title'];
        $description = $row['Description'];
        echo "<p>$title: $description <span class='remove-btn' onclick=\"window.location.href='index.php?remove=$itemNum'\">X</span></p>";
    }
} else {
    echo "No to-do list items exist yet.";
}

mysqli_close($conn);
?>

<h2>Add Item</h2>
<form method="POST" action="index.php">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required maxlength="20"><br><br>
    <label for="description">Description:</label>
    <input type="text" id="description" name="description" required maxlength="50"><br><br>
    <input type="submit" value="Add">
</form>

</body>
</html>
