<?php

require_once("include/connection.php");

session_start();

if (isset($_GET["token"]) && mysqli_num_rows(mysqli_query($conn, "SELECT * FROM login_user WHERE verification_token = '{$_GET["token"]}'")) > 0) {
    date_default_timezone_set("asia/manila");
    $date = date("M-d-Y h:i A", strtotime("+0 HOURS"));

    $token = $_GET["token"];

    // $pass=sha1($pass1);
    // $salt="a1Bz20ydqelm8m1nel";
    // $pass1=$salt.$pass;

    $query = mysqli_query($conn, "SELECT * FROM  login_user WHERE verification_token = '$token'") or die(mysqli_error($conn));
    $row = mysqli_fetch_array($query);
    $id = $row['id'];
    $user = $row['email_address'];

    $_SESSION["user_no"] = $row["id"];
    $_SESSION["email_address"] = $row["email_address"];

    $counter = mysqli_num_rows($query);

    if ($counter == 0) {
        echo "<script type='text/javascript'>alert('Invalid Verification Link, Please try again!');
				  document.location='../login.html'</script>";
    } else {
        $_SESSION['email_address'] = $id;

        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);


        $remarks = "Has LoggedIn the system at";

        mysqli_query($conn, "INSERT INTO history_log(id,email_address,action,ip,host,login_time) VALUES('$id','$user','$remarks','$ip','$host','$date')") or die(mysqli_error($conn));

        mysqli_query($conn, "UPDATE login_user SET verification_token = '' WHERE verification_token = '$token'");

        echo "<script type='text/javascript'>document.location='private_user/home.php'</script>";   
    }
}