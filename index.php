<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location:./login.html");
    exit;
}
require_once('./DBConnection.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
if($_SESSION['type'] != 1 && in_array($page,array('maintenance','admin','manage_admin'))){
    header("Location:./");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="dashboard.css" rel="stylesheet">
    <title><?php echo ucwords(str_replace('_', ' ', $page)); ?> | Task.</title>
</head>
<body>
    <nav class="navbar navbar-fixed-top">
        <a class="navbar-brand">Task.</a>
        <ul class="nav navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo ($page == 'home') ? 'active' : ''; ?>" href="./?page=home" aria-current="page">
                    <span class="glyphicon glyphicon-home"></span> HOME
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($page == 'create_tasks') ? 'active' : ''; ?>" href="./?page=create_tasks" aria-current="page">
                    <span class="glyphicon glyphicon-tasks"></span> CREATE TASK
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($page == 'completed') ? 'active' : ''; ?>" href="./?page=completed" aria-current="page">
                    <span class="glyphicon glyphicon-ok"></span> COMPLETED
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($page == 'pending') ? 'active' : ''; ?>" href="./?page=pending" aria-current="page">
                    <span class="glyphicon glyphicon-exclamation-sign"></span> PENDING
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($page == 'notification') ? 'active' : ''; ?>" href="./?page=notification" aria-current="page">
                    <span class="glyphicon glyphicon-bell"></span> NOTIFICATION
                </a>
            </li>
        </ul>
    </nav>
</body>
</html>
