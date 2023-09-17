<?php
include '../config/dbCon.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
}


if (isset($_GET['log'])) {
    if ($_GET['log'] == 'true') {
        session_destroy();
        header("Location: ../index.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Dashboard</h1>
    <a href="dashboard.php?log=true">Logout</a>

</body>

</html>