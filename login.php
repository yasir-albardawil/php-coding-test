<?php
include 'inc/header.php';
include "config/gconfig.php";
Session::CheckLogin();
$logMsg = Session::get('logMsg');
if (isset($logMsg)) {
    echo $logMsg;
}
?>


<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $userLog = $users->userLoginAuthotication($_POST);
}
if (isset($userLog)) {
    echo $userLog;
}

$logout = Session::get('logout');
if (isset($logout)) {
    echo $logout;
}


?>

<div class="card ">
    <div class="card-header">
        <h3 class='text-center'><i class="fas fa-sign-in-alt mr-2"></i>User login</h3>
    </div>
    <div class="card-body">


        <div style="width:450px; margin:0px auto">

            <form class="" action="" method="post">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" name="login" class="btn btn-success">Login</button>
                </div>


            </form>
        </div>

        <div class="text-center">OR</div>
        <div class="container">
            <br/>
            <br/>
            <div class="panel panel-default">
                <?php
                if (!isset($_SESSION['access_token'])) {
                    //Create a URL to obtain user authorization
                    $google_login_btn = '<a href="' . $google_client->createAuthUrl() . '"><img src="assets/sign-in-with-google.png" /></a>';
                } else {
                    header("Location: login.php");
                }
                echo '<div align="center">' . $google_login_btn . '</div>';
                ?>
            </div>
        </div>
    </div>


    <?php
    include 'inc/footer.php';

    ?>
