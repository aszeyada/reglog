<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once './db_con.php';

$id = '';
$firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
//$val_email = trim(filter_var($email, FILTER_VALIDATE_EMAIL));
$password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$password2 = trim(filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

$errs = array();

#firstname
    if ( empty($firstname) ) {
        $errs[] = "Please enter your first name.";
    }
    
#lastname
    if ( empty($lastname) ) {
        $errs[] = "Please enter your last name.";
    }
    
#email
    if ( empty($email) ) {
        $errs[] = "Please enter your E-mail.";
    }
#email validation
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        $errs[] = "Please enter a valid E-mail.";
    }
#check if email exist
    if ( email_exists($email,$connection) ) {
        $errs[] = "Your E-mail already exists.";
    }
    
#password    
    if ( empty($password) ) {
        $errs[] = "Please enter your password.";
    } elseif (strlen($password) < 6) {
        $errs[] = "Your password must have  at least 6 characters.";
}
#confirm-password    
    if ( empty($password2) ) {
        $errs[] = "Please confirm your password.";
    } else {
#matching-passwords        
        if ( $password !== $password2 ) {
            $errs[] = "Password didn't match.";
        }
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






#functions

function email_exists($email,$connection) {
    
    $stmt = $connection->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows_count = $result->num_rows;
    
    if ( $rows_count >= 1 ) {
        return TRUE;
    }
    
    $stmt->close();
}  
