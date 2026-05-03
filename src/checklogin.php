<?php
class checklogin
{
    function check()
    {
        require_once('../config.php');

        /* Check if login form has been submitted */
        /* isset — Determine if a variable is declared and is different than NULL*/
        if (isset($_POST['Submit'])) {

            /* Check if the form's username and password matches */
            /* these currently check against variable values stored in config.php but later we will see how these can be checked against information in a database*/
            if (($_POST['Username'] == $UsernameT) && ($_POST['Password'] == $PasswordT)) {
                $_SESSION['Username'] = $UsernameT;
                $_SESSION['Active'] = true;
                header("location:index.php");
                exit;
            } else
                echo 'Incorrect Username or Password';
        }
    }

    public function check2()
    {
        if (isset($_POST['Submit'])) {
            try {

                require_once('../config.php');
                $connection = new PDO($dsn, $username, $password, $options);

                $sql = "SELECT firstname, password, role from users where firstname = :USER";
                $statement = $connection->prepare($sql);
                $tmpUser = ($_POST['Username']);
                $statement->bindParam(':USER', $tmpUser, PDO::PARAM_STR);
                $statement->execute();
                $result = $statement->fetchAll();
                foreach($result as $row => $rows)
                {
                    $fname_db = $rows['firstname'];
                    $pwd_db = $rows['password'];

                    if (($_POST['Username'] == $fname_db) && ($_POST['Password'] == $pwd_db))
                        {
                            $_SESSION['Username'] = $fname_db;
                            //add to check role for admin access only
                            $_SESSION['Role'] = $rows['role'];
                            $_SESSION['Active'] = true;
                            header("location:index.php");
                            echo 'Success';
                            exit;
                        }
                    else
                    {
                        echo 'Incorrect Username or Password';
                    }
                }
            }
            catch
                (Exception $e)
                {
                echo '<div class="messages-error">Error Logging in:' . $e->getMessage() . '</div>';
                }
        }
    }
}
?>