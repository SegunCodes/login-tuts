<?php

require_once('connection.php');

if (isset($_POST['submit'])) {
    $email = $_POST["email"];
    $token = $_POST["token"];
    $password = $_POST["password"];
    $cpass = $_POST["cpassword"];

    if(empty($email) || empty($token) || empty($password) || empty($cpass)){
        $error = 'All fields are required';
        header("location: ../reset.php?token=$token&email=$email&error=$error");
        die();
    }elseif (strlen($password) < 6) {
        $error = 'short password';
        header("location: ../reset.php?token=$token&email=$email&error=$error");
        die();
    }elseif ($password != $cpass) {
        $error = 'Passwords do not match';
        header("location: ../reset.php?token=$token&email=$email&error=$error");
        die();
    }else{
        //mysql operations
        //Check if the email and the token actually exist
        $sql = "SELECT * FROM users WHERE email = ? AND token = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, 'ss', $email, $token);
        }
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                //bind result variables
                mysqli_stmt_bind_result($stmt, $id, $email, $hashPassword, $expiry_date, $token);
                if(mysqli_stmt_fetch($stmt)){
                    //check if token has expired
                    $current_time = time();
                    if($current_time >= $expiry_date){
                        $error = 'Token has expired';
                        header("location: ../reset.php?token=$token&email=$email&error=$error");
                        die();
                    }else{
                        $token = '';
                        $expiry_date = '';
                        $sql = "UPDATE users SET password = ?, token = ?, expiry_date = ? WHERE email = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        if($stmt){
                            //hash new password
                            $newPassword = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, 'ssss', $newPassword , $token, $expiry_date, $email);
                            if(mysqli_stmt_execute($stmt)){
                                // redirect to login
                                $msg = 'password successfully reset';
                                header("location: ../login.php?msg=$msg");
                                die();
                            }
                        }
                    }
                }

            }else{
                $error = 'Invalid email or token';
                header("location: ../reset.php?token=$token&email=$email&error=$error");
                die();
            }
        }
    }
}

?>