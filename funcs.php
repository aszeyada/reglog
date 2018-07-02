<?php
function email_exists($email,$connection) {    
    $stmt = $connection->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows_count = $result->num_rows;   
    if ( $rows_count === 1 ) {
        return TRUE;
    }   
    $stmt->close();
}