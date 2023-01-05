<?php

if (!isset($_GET['token'])) {
    header("location: login.php");
    exit();
}

session_start();

if(isset($_SESSION["email"])){
    header("location: home.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Tutorials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
        <form action="includes/reset.php" method="POST">
            <h2>Reset Password</h2>
            <?php
                if (isset($_GET['error'])) { ?>
                    <p class="text-danger"><?php echo $_GET['error']; ?></p>
            <?php
                }
            ?>
            <input type="text" name="token" hidden value="<?php echo $_GET['token']?>" class="form-control">
            <input type="email" name="email" hidden value="<?php echo $_GET['email']?>" class="form-control">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Confirm Password</label>
                <input type="password" name="cpassword" class="form-control">
            </div>
            <button class="btn btn-primary" name="submit" type="submit">Reset</button>
        </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>