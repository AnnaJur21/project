<?php session_start(); ?>
    
    
    <?php require_once('../template/header_login.php');?>
    <link rel="stylesheet" type="text/css" href="../css/signin.css">
        <title>Sign in</title>
    </head>

    <body>
    <div class="container">
        <form action="" method="post" name="Login_Form" class="form-signin">
            <h2 class="form-signin-heading">Please sign in</h2>
            <label for="inputUsername">Username</label>
            <input name="Username" type="text" id="inputUsername"
                   class="form-control" placeholder="Username" required autofocus>
            <label for="inputPassword">Password</label>
            <input name="Password" type="password" id="inputPassword"
                   class="form-control" placeholder="Password" required>
            <button name="Submit" value="Login" class="button" type="submit">Sign in</button>
        </form>
        <p><a href="register.php">No account? Register here</a></p>
    </div>

    <?php
     require_once('../src/checklogin.php');
     $check = new checklogin();
     $check->check2();
    ?>

    </body>
    </html>