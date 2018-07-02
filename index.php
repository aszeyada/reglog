<?php
session_start();
if ( isset($_SESSION) ) {
    echo "Wlcome ".$_SESSION['email'];
}

