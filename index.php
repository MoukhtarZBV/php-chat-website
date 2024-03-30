<?php
$showCreated = isset($_GET['created']) ? $_GET['created'] : false;
$wrongPass = isset($_GET['passlogin']) ? $_GET['passlogin'] : null;
?>

<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script defer src="https://use.fontawesome.com/releases/v6.4.2/js/all.js"></script>
</head>
<html>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <body>
        <div class="account-created" <?php if(!$showCreated) { echo 'style="display: none;"'; }?> >
            <i></i>
            <p>Your account has been created.</p>
        </div>
        <form method="get" action="php/loginOrRegister.php"  class="form-container form-login">
            <label for="login">Login</label>
            <input type="text" class="login" id="login" name="login" placeholder="FruitsEnjoyer" required>

            <label for="password">Password</label>
            <div class="passwordDivs" id="passwordDiv">
                <input type="password" id="password" name="password" placeholder="Eat5Fruits!" required>
                <button type="button" class="hide-password" id="hide-password"><i class="fa-solid fa-eye"></i></button>
            </div>
            <label class="secure-password-and-bad-password" <?php if($wrongPass === null) { echo 'style="display: none;"'; }?> >Incorrect login or password.</label>

            <input type="submit" value="Login">

            <div class="separator"></div>
            <p class="already-account">Don't have an account ? <a href="register.html">Register now</a></p>
        </form>
        <script src="js/login.js"></script>
        <script src="js/redirectLoggedUser.js"></script>
    </body>
</html>