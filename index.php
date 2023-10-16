<?php

include 'config/dbCon.php';


// if(isset($_POST['login'])){
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     $password = md5($password);

//     $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

//     $insert = mysqli_query($con, $sql);

//     if($insert){
//         echo "Inserted successfully";
//     }else{
//         echo "Failed to insert";
//     }

// }

if (isset($_SESSION['user_id'])) {
    header("Location: admin/dashboard.php");
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $select = mysqli_query($con, $sql);

    if (mysqli_num_rows($select) != 0) {
        $user = mysqli_fetch_array($select);
        $_SESSION['user_id'] = $user['id'];
        header("Location: admin/dashboard.php");
    } else {
        echo "Failed to login";
    }
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP BASICS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <h1>LOGIN</h1>

    <form action="index.php" method="POST">
        <input type="email" name="email" required autofocus>
        <input type="password" name="password" required autofocus>

        <button type="submit" name="login">login</button>
    </form>




</body>

</html>