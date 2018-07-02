<?php
session_start();
require_once './db_con.php';
require_once './funcs.php';
if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(filter_input(INPUT_POST, 'email'));
    $password = trim(filter_input(INPUT_POST, 'password'));
    $errs = array();
    if ( empty($email) ) {
        $errs[] = "Please enter your E-mail.";
    } elseif ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        $errs[] = "Please enter a valid E-mail.";
    }  
    if ( empty($password) ) {
        $errs[] = "Please enter your password.";
    } elseif (strlen($password) < 6) {
        $errs[] = "Your password must have  at least 6 characters.";
    }
    if ( !empty( $errs ) )  {
        foreach ($errs as $err) {
            echo $err.'</br >';
        }    
    } else {
        $stmt = $connection->prepare("SELECT `password` FROM `users` WHERE `email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows_count = $result->num_rows;   
        if ( $rows_count === 1 ) {
            $row = $result->fetch_row();
            $hash = $row[0];
            if ( password_verify($password, $hash) ) {
                $_SESSION['email'] = $email;
                header('Location: index.php');
            } else {
                echo "Password is wrong.";
            }
        } else {
            echo "register.";
        }
        $stmt->close();
        }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div id="wrapper">
            <form action="#" method="POST">
                <p><label>Enter Your E-mail: </label><input type="text" name="email" value="" /></p>
                <p><label>Enter Your Password: </label><input type="password" name="password" value="" /></p>
                <p><input type="submit" value="Log now" /></p>
            </form>
        </div>
    </body>
</html>