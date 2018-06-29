<?php
require_once './db_con.php';
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
} 
if ( empty($password2) ) {
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