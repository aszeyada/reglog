<?php
    
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
    </head>
    <body>
        <div id="wrapper">
            <form action="core.php" method="POST">
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
