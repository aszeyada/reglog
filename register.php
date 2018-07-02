<?php
require_once './db_con.php';
require_once './funcs.php';
if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = '';
    $firstname = trim(filter_input(INPUT_POST, 'firstname'));
    $lastname = trim(filter_input(INPUT_POST, 'lastname'));
    $email = trim(filter_input(INPUT_POST, 'email'));
    $password = trim(filter_input(INPUT_POST, 'password'));
    $password2 = trim(filter_input(INPUT_POST, 'password2'));
    $errs = array();
    if ( empty($firstname) ) {
        $errs[] = "Please enter your first name.";
    }
    if ( empty($lastname) ) {
        $errs[] = "Please enter your last name.";
    }
    if ( empty($email) ) {
        $errs[] = "Please enter your E-mail.";
    } elseif ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        $errs[] = "Please enter a valid E-mail.";
    } elseif ( email_exists($email,$connection) ) {
        $errs[] = "Your E-mail already exists.";
    }  
    if ( empty($password) ) {
        $errs[] = "Please enter your password.";
    } elseif (strlen($password) < 6) {
        $errs[] = "Your password must have  at least 6 characters.";
    } elseif ( empty($password2) ) {
        $errs[] = "Please confirm your password.";
    } elseif ( $password !== $password2 ) {                 
        $errs[] = "Password didn't match.";
    }     
    if ( !empty( $errs ) )  {
        foreach ($errs as $err) {
            echo $err.'</br >';
        }    
    } else {  
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);    
        $stmt = $connection->prepare("INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $id, $firstname, $lastname, $email, $hashed_password);
        if ( !($stmt->execute()) ) {
            echo "There was a problem, Try again.";
        } else {
            echo "You are registered now.";
        }   
        $stmt->close();
    }    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
    </head>
    <body>
        <div id="wrapper">
            <form action="#" method="POST">
                <p><label>First Name</label><input type="text" name="firstname" value="" /></p>
                <p><label>Last Name</label><input type="text" name="lastname" value="" /></p>
                <p><label>E-mail</label><input type="text" name="email" value="" /></p>
                <p><label>Password</label><input type="password" name="password" value="" /></p>
                <p><label>Confirm Password</label><input type="password" name="password2" value="" /></p>
                <p><input type="submit" name="Submit" value="Submit" /></p>
            </form>    
        </div>
    </body>
</html>