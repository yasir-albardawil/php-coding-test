<?php
include 'inc/header.php';
//Include Google Configuration File
include('config/gconfig.php');

//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if (isset($_GET["code"])) {
//It will Attempt to exchange a code for an valid authentication token.
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

//This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
    if (!isset($token['error'])) {
        //Set the access token used for requests
        $google_client->setAccessToken($token['access_token']);

        //Create Object of Google Service OAuth 2 class
        $google_service = new Google_Service_Oauth2($google_client);

        //Get user profile data from google
        $data = $google_service->userinfo->get();
        $user = [];
        //Below you can find Get profile data and store into $_SESSION variable

        $user['name'] = $data['name'];
        $user['username'] = strtolower($data['given_name']);
        $user['email'] = $data['email'];
        $user['mobile'] = '';
        $user['roleid'] = 3;
        $user['password'] = rand();

        $check = $users->checkExistEmail($data['email']);
        if (!$check) {
            //Store "access_token" value in $_SESSION variable for future use.
            $_SESSION['access_token'] = $token['access_token'];

            $users->google_oauth2_register($user);
            $res = $users->getUserInfoByEmail($data['email']);
            Session::set('id', $res->id);
            Session::set('roleid', 3);
            Session::set('name', $user['name']);
            Session::set('username', $user['username']);
            Session::set('email', $user['email']);
            Session::set('logMsg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> You are Logged In Successfully !</div>');
            echo "<script>location.href='index.php';</script>";
            header("Location: index.php");
        } else {
            $res = $users->getUserInfoByEmail($data['email']);
            $chkActive = $users->CheckActiveUser($data['email']);
            if ($chkActive == TRUE) {
                Session::set('logMsg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Sorry, Your account is Deactivated, Contact with Admin !</div>');
                echo "<script>location.href='login.php';</script>";
                header("Location: login.php");
            } else {
                //Store "access_token" value in $_SESSION variable for future use.
                $_SESSION['access_token'] = $token['access_token'];

                Session::set('id', $res->id);
                Session::set('roleid', $res->roleid);
                Session::set('name', $res->name);
                Session::set('username', $res->username);
                Session::set('email', $res->email);
                Session::set('logMsg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> You are Logged In Successfully !</div>');
                echo "<script>location.href='index.php';</script>";
                header("Location: index.php");
            }
        }
    }
}

?>
